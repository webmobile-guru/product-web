<?php

namespace App\Repository\Order;

use App\Coin;
use App\Trade;
use App\Setting;
use App\CoinPair;
use App\Transaction;

class OrderRepository
{
    private $order;

    public function __construct(Trade $order)
    {
        $this->order = $order;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->order, $method], $args);
    }

    public function openOrder()
    {
        return auth()->user()->trade()->ongoing();
    }

    public function closedOrder()
    {
        return auth()->user()->trade()->closed();
    }

    public function getCoinId($coin)
    {
        return Coin::where('coin', $coin)->pluck('id')->first();
    }

    public function tradepost($rate, $amount, $tradeType, $currencyPair, $userId = null)
    {
        $getType = ($tradeType=='buy')?'sell':'buy';
        $sort = ($getType=='sell') ? 'ASC' : 'DESC';
        $userId = $userId?:auth()->id();
        $activeUser = auth()->user();
        $flag = false;

        //get the Last Price
        $call = $this->order->whereHas('coinPair', function($query) use ($currencyPair) {
            $query->where('pair_name', $currencyPair);
        })->onLimit()->ongoing()->whereType($getType)->whereMethod('limit')->orderBy('price', $sort)->pluck('price')->first();
            
        $coinnames = explode('_',$currencyPair);
        $baseCoin = Coin::where('coin',$coinnames[0])->first();

        if(($tradeType=='buy' && $rate >= $call && $call) || ($tradeType=='sell' && $rate <= $call && $call))
        {
            $sort = ($getType=='sell') ? 'ASC' : 'DESC';
            $opa = ($getType=='sell') ? '<=' : '>=';

            $orderList = $this->order->whereHas('coinPair', function($query) use ($currencyPair) {
                $query->where('pair_name', $currencyPair);
            })->onLimit()->ongoing()->where('type', $getType)->where('price',$opa, $rate)->orderBy('price', $sort)->orderBy('created_at', 'ASC')->get();

            $totalRow = count($orderList);
            foreach($orderList as $key => $row) {
                if($amount > $row->volume){
                        //condition-1
                        $amount = $updateTradeRow = ($amount-$row->volume);
                        $updateTotal = ((float)$row->price*(float)$row->volume);
                        $percentage_taken = Setting::get_percentage_admin($row->type,$row->price,$row->volume);
                        if($this->__CheckUserBalance($currencyPair,$activeUser,$tradeType,$row->price,$amount)){
                            if($this->order->where('id', $row->id)->where('status','=',0)->update(array('status' =>1)))
                            {
                                $coinname = explode('_',$currencyPair);
                                if($getType =='buy'){
                                    $coin = Coin::where('coin',$coinname[1])->first();
                                    Transaction::create([
                                        'code' => 'TXN'.str_random(13),
                                        'user_id' => $row->user_id,
                                        'coin_id'=>$coin->id,
                                        'trade_id' => $row->id,
                                        'amount'=>$row->volume,
                                        'source'=>'buy',
                                        'type'=>'Credit',
                                        'description'=>'buy executed',
                                        'status' => 1
                                    ]);
                                    //pay referral for buy of maker
                                    $this->payDirectSponsorCommission($row->id, $baseCoin->id, $percentage_taken, $row->user->sponsor);
                                    
                                }else if($getType =='sell'){
                                    $coin = Coin::where('coin',$coinname[0])->first();
                                    Transaction::create([
                                        'code' => 'TXN'.str_random(13),
                                        'user_id' => $row->user_id,
                                        'coin_id'=>$coin->id,
                                        'trade_id' => $row->id,
                                        'amount'=>($updateTotal-$percentage_taken),
                                        'source'=>'sell',
                                        'type'=>'Credit',
                                        'description'=>'sell executed',
                                        'status' => 1
                                    ]);   
                                }

                                // Create Trade after matching
                                $newTradeRow = $this->order->create([
                                    'user_id' =>$userId,
                                    'coin_pair_id' =>$row->coin_pair_id,
                                    'price' =>$row->price,
                                    'volume' =>$row->volume,
                                    'fees' =>$percentage_taken,
                                    'type'=>$tradeType,
                                    'status'=>1,
                                    'mainTradeId'=>$row->id
                                ]);

                                if($tradeType =='buy'){
                                    $coin = Coin::where('coin',$coinname[0])->first();
                                    Transaction::create([
                                        'code' => 'TXN'.str_random(13),
                                        'user_id' => $userId,
                                        'coin_id'=>$coin->id,
                                        'trade_id' => $row->id,
                                        'amount'=>($updateTotal + $percentage_taken),
                                        'source'=>'buy',
                                        'type'=>'Debit',
                                        'description'=>'buy request',
                                        'status' => 1
                                    ]);
                                    $coin = Coin::where('coin',$coinname[1])->first();
                                    Transaction::create([
                                        'code' => 'TXN'.str_random(13),
                                        'user_id' => $userId,
                                        'coin_id'=>$coin->id,
                                        'trade_id' => $row->id,
                                        'amount'=>$row->volume,
                                        'source'=>'buy',
                                        'type'=>'Credit',
                                        'description'=>'buy executed',
                                        'status' => 1
                                    ]);
                                    //pay referral for buy of taker
                                    $this->payDirectSponsorCommission($newTradeRow->id, $baseCoin->id, $percentage_taken, $activeUser->sponsor);
                                }else if($tradeType =='sell') {
                                    $coin = Coin::where('coin',$coinname[1])->first();
                                    Transaction::create([
                                        'code' => 'TXN'.str_random(13),
                                        'user_id' => $userId,
                                        'coin_id' => $coin->id,
                                        'trade_id' => $row->id,
                                        'amount' => $row->volume,
                                        'source' => 'sell',
                                        'type' => 'Debit',
                                        'description' => 'sell request',
                                        'status' => 1
                                    ]);
                                    $coin = Coin::where('coin',$coinname[0])->first();
                                    Transaction::create([
                                        'code' => 'TXN'.str_random(13),
                                        'user_id' => $userId,
                                        'coin_id'=>$coin->id,
                                        'trade_id' => $row->id,
                                        'amount'=>($updateTotal-$percentage_taken),
                                        'source'=>'sell',
                                        'type'=>'Credit',
                                        'description'=>'sell executed',
                                        'status' => 1
                                    ]);
                                }
                                if($totalRow==1 && $amount >= 0.00000001){
                                    $updateTotal = ((float) $row->price * (float) $amount);
                                    if($updateTotal >= 0.0001){
                                            $percentage_taken = Setting::get_percentage_admin($row->type, $row->price,$amount);
                                            $this->order->create([
                                                'user_id' =>$userId,
                                                'coin_pair_id' =>$row->coin_pair_id,
                                                'price' =>$row->price,
                                                'volume' =>$amount,
                                                'fees' =>$percentage_taken,
                                                'type'=>$tradeType,
                                            ]);
                                            $coinname = explode('_',$currencyPair);
                                            if($tradeType =='buy'){
                                                $coin = Coin::where('coin',$coinname[0])->first();
                                                Transaction::create([
                                                    'code' => 'TXN'.str_random(13),
                                                    'user_id' => $userId,
                                                    'coin_id'=>$coin->id,
                                                    'trade_id' => $row->id,
                                                    'amount'=>($updateTotal+$percentage_taken),
                                                    'source'=>'buy',
                                                    'type'=>'Debit',
                                                    'description'=>'buy request',
                                                    'status' => 1
                                                ]);
                                            }else if($tradeType =='sell'){
                                                $coin = Coin::where('coin',$coinname[1])->first();
                                                Transaction::create([
                                                    //~ 'code' => 'TXN'.str_random(13),
                                                    'code' => uniqid('REFT').str_random(20),
                                                    'user_id' => $userId,
                                                    'coin_id'=>$coin->id,
                                                    'trade_id' => $row->id,
                                                    'amount'=>$amount,
                                                    'source'=>'sell',
                                                    'type'=>'Debit',
                                                    'description'=>'sell request',
                                                    'status' => 1
                                                ]);
                                            }

                                    }
                                }
                                $flag = true;
                            }
                        }
                    
                }else{
                    //condition 2
                    $updateTradeRow = ($row->volume - $amount);
                    $updateTotal = ((float)$row->price*(float)$amount);
                    $percentage_taken = Setting::get_percentage_admin($row->type,$row->price,$amount);
                    if($this->__CheckUserBalance($currencyPair,$activeUser,$tradeType,$row->price,$amount)){
                        if($this->order->where('id', $row->id)->where('status','=',0)
                            ->update([
                                'volume'=>$amount,
                                'fees'=>$percentage_taken,
                                'status' =>1
                            ])){

                            $coinname = explode('_',$currencyPair);

                            if($getType =='buy'){
                                $coin = Coin::where('coin',$coinname[1])->first();
                                Transaction::create([
                                    'code' => 'TXN'.str_random(13),
                                    'user_id' => $row->user_id,
                                    'coin_id'=>$coin->id,
                                    'trade_id' => $row->id,
                                    'amount'=>$amount,
                                    'source'=>'buy',
                                    'type'=>'Credit',
                                    'description'=>'buy executed',
                                    'status' => 1
                                ]);
                                
                                //pay referral for buy of maker
                                $this->payDirectSponsorCommission($row->id, $baseCoin->id, $percentage_taken, $row->user->sponsor);
                            
                            }else if($getType =='sell'){
                                $coin = Coin::where('coin',$coinname[0])->first();
                                Transaction::create([
                                    'code' => 'TXN'.str_random(13),
                                    'user_id' => $row->user_id,
                                    'coin_id'=>$coin->id,
                                    'trade_id' => $row->id,
                                    'amount'=>($updateTotal-$percentage_taken),
                                    'source'=>'sell',
                                    'type'=>'Credit',
                                    'description'=>'sell executed',
                                    'status' => 1
                                ]);
                            }

                            $percentage_taken = Setting::get_percentage_admin($row->type,$row->price,$amount);
                            
                            $newTradeRow = $this->order->create([
                                'coin_pair_id' =>$row->coin_pair_id,
                                'user_id' =>$userId,
                                'price' => $row->price,
                                'volume' => $amount,
                                'fees' => $percentage_taken,
                                'type' => $tradeType,
                                'status'=>1,
                                'mainTradeId'=>$row->id

                            ]);

                            if($tradeType =='buy') {
                                
                                
                                $coin = Coin::where('coin',$coinname[0])->first();
                                Transaction::create([
                                    'code' => 'TXN'.str_random(13),
                                    'user_id' => $userId,
                                    'coin_id' => $coin->id,
                                    'trade_id' => $row->id,
                                    'amount' => ($updateTotal+$percentage_taken),
                                    'source' => 'buy',
                                    'type' => 'Debit',
                                    'description' => 'buy request',
                                    'status' => 1
                                ]);
                                
                                $coin = Coin::where('coin',$coinname[1])->first();
                                Transaction::create([
                                    'code' => 'TXN'.str_random(13),
                                    'user_id' => $userId,
                                    'coin_id' => $coin->id,
                                    'trade_id' => $row->id,
                                    'amount' => $amount,
                                    'source' => 'buy',
                                    'type' => 'Credit',
                                    'description' => 'buy executed',
                                    'status' => 1
                                ]);

                                //pay referral for buy of taker
                                $this->payDirectSponsorCommission($newTradeRow->id, $baseCoin->id, $percentage_taken, $activeUser->sponsor);

                            }else if($tradeType =='sell'){
                                $coin = Coin::where('coin',$coinname[1])->first();
                                Transaction::create([
                                    'code' => 'TXN'.str_random(13),
                                    'user_id' => $userId,
                                    'coin_id'=>$coin->id,
                                    'trade_id' => $row->id,
                                    'amount'=>$amount,
                                    'source'=>'sell',
                                    'type'=>'Debit',
                                    'description'=>'sell request',
                                    'status' => 1
                                ]);
                                
                                $coin = Coin::where('coin',$coinname[0])->first();
                                Transaction::create([
                                    'code' => 'TXN'.str_random(13),
                                    'user_id' => $userId,
                                    'coin_id'=>$coin->id,
                                    'trade_id' => $row->id,
                                    'amount'=>($updateTotal-$percentage_taken),
                                    'source'=>'sell',
                                    'type'=>'Credit',
                                    'description'=>'sell executed',
                                    'status' => 1
                                ]);
                                

                            }

                            $flag = true;

                            if($updateTradeRow >= 0.00000001){

                                $uTotal = ((float) $row->price * (float) $updateTradeRow);
                                
                                if($uTotal >= 0.0001){
                                    $percentage_taken = Setting::get_percentage_admin($row->type,$row->price,$updateTradeRow);

                                    if($this->order->create([
                                        'coin_pair_id' => $row->coin_pair_id,
                                        'user_id' => $row->user_id,
                                        'price' =>  $row->price,
                                        'volume' => $updateTradeRow,
                                        'fees' => $percentage_taken,
                                        'type' => $row->type,
                                        'created_at' => $row->created_at
                                    ])){
                                        $flag = true;
                                    }
                                }
                                
                            }
                        }
                    }
                    break;
                }
                $totalRow--;
            } // End of foreach
        } else {

            /// insert new trade for buy/sell
            $percentage_taken = Setting::get_percentage_admin($tradeType,$rate,$amount);
            $total_amount = ((float)$rate * (float)$amount);
            $coinPair = CoinPair::where('pair_name', $currencyPair)->first();
            if($this->__CheckUserBalance($currencyPair,$activeUser,$tradeType,$rate,$amount)){
                if($trade = $this->order->create([
                    'coin_pair_id' => $coinPair->id,
                    'user_id' => $userId,
                    'price' => $rate,
                    'volume' => $amount,
                    'fees' => $percentage_taken,
                    'type' => $tradeType
                ])){
                    $transaction = [
                        'code' => 'TXN'.str_random(13),
                        'user_id' => $userId,
                        'trade_id' => $trade->id,
                        'type' => 'Debit',
                        'status' => 1
                    ];
                    if($tradeType =='buy'){
                        $transaction = array_merge($transaction, [
                            'coin_id' => $coinPair->baseCoin->id,
                            'amount' => ($total_amount+$percentage_taken),
                            'source' => 'buy',
                            'description' => 'buy request',
                        ]);

                    } else if($tradeType =='sell') {
                        $transaction = array_merge($transaction, [
                            'coin_id'=>$coinPair->pairCoin->id,
                            'amount'=>$amount,
                            'source'=>'sell',
                            'description'=>'sell request',
                        ]);
                    }
                    Transaction::create($transaction);
                    $flag = true;
                }
            }
        }

        return $flag;
    }

    private function __CheckUserBalance($Rpair,$userObj,$type,$rate,$amount){
            $flag = true;
            $pair = CoinPair::where('pair_name', $Rpair)->first();

            // Get balance of coin
            $balanceOfCoin = [
                'buy' => $pair->baseCoin->coin,
                'sell' => $pair->pairCoin->coin
            ];

            $balance = $userObj->getBalance($balanceOfCoin[$type]);

            // Calculate total
            if($type == 'buy'){
                $fee = (double) Setting::get_percentage_admin('buy', $rate, $amount);
                $total_buy = (((double) $rate) * ((double) $amount));
                $total = ( $total_buy + $fee);
            }else{
                $total = $amount;
            }
            if($balance < $total) {
                $flag = false;
                throw new \Exception ('You don\'t have sufficient '.$balanceOfCoin[$type].' balance'. $total);
            }
        
        return $flag;
    }

    public function stopLimitOrderPost($stop, $rate, $amount, $command, $pair)
    {
        $user = auth()->user(); $flag = false;
        
        $commands = [
            'stopLimitBuy' => 'buy',
            'stopLimitSell' => 'sell'
        ];

        $tradeType = $commands[$command];

        $percentage_taken = Setting::get_percentage_admin($tradeType,$rate,$amount);
        $total_amount = round(((float)$rate * (float)$amount), 8);

        if($trade = $this->order->create([
            'coin_pair_id' => $pair->id,
            'user_id' => $user->id,
            'method' => 'stop-limit',
            'trigger' => $stop,
            'price' => $rate,
            'volume' => $amount,
            'fees' => $percentage_taken,
            'type' => $tradeType
        ])){

            $transaction = [
                'code' => 'TXN'.str_random(13),
                'user_id' => $user->id,
                'trade_id' => $trade->id,
                'type' => 'Debit',
                'status' => 1
            ];

            if($tradeType =='buy') {
                $transaction = array_merge($transaction, [
                    'coin_id' => $pair->baseCoin->id,
                    'amount' => ($total_amount+$percentage_taken),
                    'source' => 'buy',
                    'description' => 'buy request on stop limit',
                ]);

            } else if($tradeType =='sell') {
                $transaction = array_merge($transaction, [
                    'coin_id'=>$pair->pairCoin->id,
                    'amount'=>$amount,
                    'source'=>'sell',
                    'description'=>'sell request on stop limit',
                ]);
            }

            Transaction::create($transaction);

            $flag = true;
        }

        return $flag;
    }

    public function payReferralCommission($row, $coin, $type, $percentageTaken, $sponsor, $loopLevel = 0)
    {
        $maxLevel = Setting::where('key', 'max_referral_level')
            ->pluck('value')
            ->first();

        $level = $row->user->getLevelOf($row->user, $sponsor, true);

        if(($level > 0) && ($level <= $maxLevel) && ($loopLevel < $maxLevel)) {
            $commission = Setting::where('key', 'REFERRAL_LEVEL_'.$level)
                ->pluck('value')
                ->first();

            Transaction::create([
                'code' => uniqid('REF').str_random(20),
                'user_id' => $sponsor->id,
                'coin_id'=>$coin,
                'trade_id' => $row->id,
                'amount'=>$percentageTaken * (doubleval($commission)/100),
                'source'=>'referral',
                'type'=>'Credit',
                'description'=>'Referral income',
                'status' => 1
            ]);

            $this->payReferralCommission($row, $coin, $type, $percentageTaken, $sponsor->sponsor, ++$loopLevel);
        }
    }
    
    public function payDirectSponsorCommission($tradeId, $coinId, $amount, $sponsor)
    {
        if($sponsor) {
            $commission = Setting::where('key', 'REFERRAL_LEVEL_1')
                ->pluck('value')
                ->first();

            Transaction::create([
                'code' => uniqid('REF').str_random(20),
                'user_id' => $sponsor->id,
                'coin_id'=>$coinId,
                'trade_id' => $tradeId,
                'amount'=>$amount * (doubleval($commission)/100),
                'source'=>'referral',
                'type'=>'Credit',
                'description'=>'Referral income',
                'status' => 1
            ]);
        }
    }
}


