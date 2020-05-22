<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Coin;
use App\CoinTransaction;
use App\DepositAddress;
use App\Repository\User\UserRepository;
use App\Repository\Wallet\Coinpayment;
use App\Repository\Wallet\WalletApp;
use App\Setting;
use App\Withdraw;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use App\Transaction;
use App\Payment;

class AccountController extends Controller
{
    protected $repository;

    const CUSTOM_COIN = 'WCO';

    protected $coins;

    public function __construct(UserRepository $repository, Coin $coin)
    {
        $this->repository = $repository; 

        $this->coins = $coin->pluck('coin')->toArray();
    }

    public function index()
    {
        try{
            $coins = Coin::active()->get(); 
            $user = auth()->user();
            $data= array(
                "coins" => $coins,
                "user" => $user
            );
            return response()->json($data);
        }catch (\Exception $exception) {
            return response()->json(['error'=>'Some Error Ocurred! Please Try again!!']);
        }
        
    }
    
//     public function toggleSwitch()
//     {
//         if(session()->has('mode')) {
//             session()->forget('mode');
//         } else {
//             session()->put('mode', 'demo');
//         }
//         return redirect()->back();
//     }

    public function getDeposit($coin)
    {
        try{
            $user = auth()->user();

            $dbCoin = Coin::where('coin', $coin)->first();

            if($dbCoin->deposit_enabled) {
                if($coin == self::CUSTOM_COIN) {
                    $query = $user->depositAddress()
                        ->whereHas('coin', function($query) use ($coin){
                            $query->whereCoin($coin);
                        });

                    if($query->exists()) {

                        $coinAddress = $query->first();

                    } else {

                        $wallet = new WalletApp();
                        $address = $wallet->getNewAddress();

                        $coin = Coin::whereCoin($coin)->first();

                        $addressData = [
                            'user_id' => $user->id,
                            'coin_id' => $coin->id,
                            'address' => trim($address)
                        ];

                        $user->depositAddress()->save(new DepositAddress($addressData));

                        $coinAddress = $query->first(); $coin = $coin->coin;
                    }
                } elseif ($coin == 'USD') {
                    //return view('front.account.usd',compact('coin'));
                } elseif (in_array($coin, $this->coins)) {
                    $coinAddress = $this->getAddress($coin);
                } else {
                    $coinAddress = null;
                }
            } else {
                $coinAddress = null;
            }

            $data = array(
                'coin' => $coin,
                'coinAddress' => $coinAddress
            );

            return response()->json($data);

        }catch (\Exception $exception) {
            return response()->json(['error'=>'Some Error Ocurred! Please Try again!!']);
        }
            
    }

    private function getAddress($coin)
    {
        $user = auth()->user();

        $query = $user->depositAddress()
            ->whereHas('coin', function($query) use ($coin){
                $query->whereCoin($coin);
            });

        if(!$query->exists()) {

			try{
				$address = \Coinpayments::getCallbackAddress($coin);

				$coin = Coin::whereCoin($coin)->first();

				$addressData = [
					'user_id' => $user->id,
					'coin_id' => $coin->id,
					'address' => trim($address['address']),
					'dest_tag' => isset($address['dest_tag'])?trim($address['dest_tag']):null
				];

				$user->depositAddress()->save(new DepositAddress($addressData));

				$coinAddress = $query->first();
			}catch(\Exception $e){
                Log::error($e);
				$coinAddress = null;
			}

        } else {
            $coinAddress = $query->first();
        }

        return $coinAddress;
    }
    
//     public function getHistory()
//     {
//         $user = auth()->user();
// //dd(session()->all());
//         $deposits = $user->coinTransaction()
//             ->credit()->latest()

//             ->paginate(10, ['*'], 'deposit')
//             ->appends(request()->query());

//         $withdraw = $user->coinTransaction()
//             ->debit()->latest()
//             ->paginate(10, ['*'], 'withdraw')
//             ->appends(request()->query());

// 		return view('front.account.history',compact('deposits','withdraw'));
		
// 	}
	
// 	public function makeDeposit(Request $request, $currency)
//     {
//         switch($currency) {
//             case 'usd' :
//                 return $this->usdDeposit($request);
//             default :
//                 return redirect()->back();
//         }
//     }
    
// 	private function usdDeposit(Request $request)
//     {
//         $this->validate($request, [
//             'payable_currency' => 'required|in:BTC,BCH,XMR,DASH,LTC,ETH,LTCT',
//             'amount' => 'required|numeric'
//         ]);

//         $amount = $request->input('amount');
//         $currencyToPay = $request->input('payable_currency'); 

//         try {
//             $cpTansaction = \Coinpayments::createTransactionSimple($amount, 'USD', $currencyToPay);

//             $coin_id = Coin::where('coin', 'USD')->pluck('id')->first();

//             $transaction = [
//                 'code' => $cpTansaction->txn_id,
//                 'user_id' => auth()->id(),
//                 'coin_id' => $coin_id,
//                 'type' => 'Credit',
//                 'source' => 'Coinpayment',
//                 'amount' => $amount,
//             ];

//             $payment = [
//                 'user_id' => auth()->id(),
//                 'address' => $cpTansaction->address,
//                 'reference_no' => $cpTansaction->txn_id,
//                 'remarks' => 'Deposit usd from coin payment api',
//                 'confirm' => 0
//             ];


//             DB::transaction(function() use ($transaction, $payment) {

//                 $transaction = Transaction::create($transaction);

//                 $payment['transaction_id'] = $transaction->id;

//                 Payment::create($payment);

//             });

//             return view('front.account.usd-deposited', compact('cpTansaction'));

//         } catch (\Exception $exception) {

//             Log::error('Error in creating coin transaction '.$exception->getMessage());

//             return view('front.account.usd-deposited', compact('cpTansaction'));
//         }
//     }

//     public function getWithdraw($coin)
//     {
//         $fees = Coin::where('coin', $coin)
//             ->pluck('withdraw_fees')
//             ->first();
			
// 		$user = auth()->user();
//         $balance = $user->getBalance($coin);

//         if($coin == 'USD') {
//             return view('front.account.usd-withdraw', compact('coin'));
//         }
//         return view('front.account.withdraw', compact('coin', 'fees', 'balance'));
//     }

//     public function makeWithdraw(Request $request, $currency)
//     {
//         return $this->withdrawMoney($request, $currency);
//     }

//     public function withdrawMoney(Request $request, $currency)
//     {
//         //$isUsd = ($currency == 'USD');

//         $coin = Coin::where('coin', $currency)->first();

//         $minAmount = $coin->withdraw_min_amount?:0;

//         $maxAmount = $coin->withdraw_max_amount?:0;

//         /*if($isUsd) {
//             $rules = [
//                 'amount' => 'required|numeric|check_fund:usd|between:'.$minAmount.','.$maxAmount,
//                 'coin' => 'required|in:btc,eth,dash,ltc,bch',
//                 'address' => 'required'
//             ];
//         } else {

//         }*/

//         $rules = [
//             'amount' => 'required|numeric|check_fund:'.$currency.'|between:'.$minAmount.','.$maxAmount,
//             'address' => 'required'
//         ];
		
// 		if(in_array($coin->coin, ['XRP'])){
// 			$rules += [
// 				'dest_tag' => 'required'
// 			];
// 		}

//         $this->validate($request, $rules, [
//             'amount.check_fund' => 'Your wallet doesn\'t have sufficient funds',
//             'dest_tag.required' => 'Destination tag  is a required field',
//         ]);

//         $amount = $request->input('amount');
//         //$coin = $request->input('coin', $currency);
//         $address = $request->input('address');
//         $dest_tag = $request->input('dest_tag');

//         try {

//             $user = auth()->user();
//             $balance = $user->getBalance($currency);

//             if( $amount > $balance ) {
//                 throw new \Exception('Error! You don\'t have sufficient fund');
//             }

//             if(!$coin->withdraw_enabled){
//                 throw new \Exception('Error! Withdraw of coin has been closed temporarily');
//             }

//             $fee = $coin->withdraw_fees?:0;

//             $netAmount = $amount - $fee;
			
// 			$ide_verify=$user->profiles->ide_verify;
// 			if(!$ide_verify){
// 				$wthdrw= $this->withdrawAmountChecking($coin->coin,$amount);
// 				if(!$wthdrw){
// 					$result = ['status' => false, 'message' => 'Error! Your daily withdrawal limit is $10,000. Please complete your profile to increase your limit.'];
// 					return json_encode($result);
// 				}
// 			}

//             $transaction = [
//                 'code' => uniqid('WTH').str_random(10),
//                 'user_id' => $user->id,
//                 'coin_id' => $coin->id,
//                 'source' => 'withdraw',
//                 'type' => 'Debit',
//                 'amount' => $amount,
//                 'description' => 'Withdraw request made',
//                 'status' => 1
//             ];

//             $withdraw = [
//                 'user_id' => $user->id,
//                 'coin_id' => $coin->id,
//                 'address' => $address,
// 				'dest_tag' => $dest_tag,
//                 'amount' => $amount,
//                 'fees' => $fee,
//                 'remarks' => 'Withdraw of '.$coin->coin.' '
//                     .$amount.' in '.$currency.' '.$amount,
//             ];

//             $coinTransaction = [
//                 'user_id' => $user->id,
//                 'coin_id' => $coin->id,
//                 'coin_address' => $address,
// 		        'dest_tag' => $dest_tag,
//                 'amount' => $amount,
//                 'fees' => $fee,
//                 'type' => 'Debit',
//                 'remarks' => 'Withdraw of '.$coin->coin.' '.$amount.' in '.$coin->coin,
//                 'status' => 0
//             ];

//             if($coin->autoWithdraw()) {

//                 if($coin->coin == self::CUSTOM_COIN) { 
//                     $wallet = new WalletApp();
//                     $result = $wallet->sendToAddress($address, $netAmount);
//                     if(is_null($result['hash'])){
//                         throw new \Exception($request['message']);
//                     }
//                     $coinTransaction['reference_no'] = $result['hash'];
//                     $coinTransaction['status'] = 1;
//                 } else { 

//                     $cpRequest = \Coinpayments::createWithdrawal($netAmount, $coin->coin, $address, $dest_tag, true);  
//                     $coinTransaction['reference_no'] = $cpRequest->ref_id;
//                 }

//                 $withdraw['status'] = 1;

//                 DB::transaction(function() use ($transaction, $withdraw, $coinTransaction){

//                     $t = Transaction::create($transaction);
//                     $coinTransaction['transaction_id'] = $t->id;
//                     $ct = CoinTransaction::create($coinTransaction);

//                     $withdraw['coin_transaction_id'] = $ct->id;
//                     $withdraw['transaction_id'] = $t->id;

//                     Withdraw::create($withdraw);

//                 });
//             } else {  
//                 DB::transaction(function() use ($transaction, $withdraw, $coinTransaction){
//                     $t = Transaction::create($transaction);
// 					$coinTransaction['transaction_id'] = $t->id;
// 					$ct = CoinTransaction::create($coinTransaction);

//                     $withdraw['coin_transaction_id'] = $ct->id;
//                     $withdraw['status'] = 0;
//                     $withdraw['transaction_id'] = $t->id;
//                     Withdraw::create($withdraw);
//                 });
//             }
//             $result = ['status' => true, 'message' => 'Success! Withdraw done. Amount will be reflect on address soon'];
//         } catch (QueryException $exception) {
//             Log::error($exception);
//             $result = ['status' => false, 'message' => 'Error! There is an error creating withdraw request'];
//         } catch (\Exception $exception) {
//             Log::error($exception);
//             $result = [
//                 'status' => false,
//                 'message' => 'Error! There is an error creating withdraw request. Please try after sometime.'
//             ];
//         }

//         return json_encode($result);
//     }
    
//     public function withdrawAmountChecking($coin,$amount){
		
// 		//~ $totalwithdrawl=auth()->user()->withdraw->whereDate('created_at','=', Carbon::today())->sum('amount'); dd($totalwithdrawl);
// 		try {
// 			$user=auth()->user();
// 			$totalwithdrawl=Withdraw::whereDate('created_at','=', Carbon::today())->where('user_id',$user->id)->sum('amount'); 
// 			$daily_wihdrawl=$totalwithdrawl+$amount; 
// 			$usd_detail = DB::table('price_quotes')->where('symbol', $coin)->where('status', 1)->latest()->first();
// 			$usd_amount = ($usd_detail->price)*$daily_wihdrawl;  
// 			if($usd_amount <= 10000){
// 				return true;
// 			}else{
// 				return false;
// 			}
// 		}catch(\Exception $exception){
//             return false;
// 		}
// 	}
}
