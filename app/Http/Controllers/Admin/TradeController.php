<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Trade;
use App\Setting;
use Carbon\Carbon;
use App\Transaction;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class TradeController extends Controller
{
    protected $trade;

    const ADMIN_USER = 1;

    public function __construct(Trade $trade)
    {
        $this->trade = $trade;
    }

    public function index()
    {
        $query = $this->trade->latest();

        $request = request();

        if(strcasecmp($request->get('search'), 'true')==0)
        {
            if($fromDate = $request->get('from_date')) {
				if($fromDate!=''){
					$query = $query->whereDate('created_at', '>=', $fromDate);
				}
            }

            if($toDate = $request->get('to_date')) {
				if($toDate!=''){
					$query = $query->whereDate('created_at', '<=', $toDate);
				}
            }

            if($info = $request->get('user_info')) {
				if($info!=''){
						$query = $query->whereHas('user', function($query) use ($info) {
								$query->whereHas('profile', function($q) use ($info){
									$q->where('profiles.role', 'like', "%".$info."%")
									->orWhere('profiles.phone', 'like', "%".$info."%")
									->orWhere('profiles.country_id', 'like', "%".$info."%");
								})
								->where('users.first_name', 'like', "%".$info."%")
								->orWhere('users.last_name', 'like', "%".$info."%")
								->orWhere('users.email', '=', $info);
						});
				}
            }

            if($cPair = $request->get('coin_pair')) {
				if($cPair!=''){
					$query = $query->where('trades.coin_pair_id', '=', $cPair);
				}
            }

            if($tType = $request->get('trade_type')) {
				if($tType!=''){
					$query = $query->where('trades.type', '=', $tType);
				}
            }

            if($request->has('status') && in_array($request->status, ['ongoing', 'closed', 'cancelled'])) {
                $query = $query->where('trades.status', '=', ['ongoing' => 0, 'closed' => 1, 'cancelled' => 2][$request->status]);
            }

        }

        $trades = $query->paginate(20)->appends($request->query());
        return view('admin.trade.index', compact('trades'));
    }

    public function exploreTrade($id)
    {        
        $query = $this->trade;
        try {
            $id = decrypt($id);

            $query = $query->where('id', $id)->ongoing();
            
            if(!$query->exists()){
                throw new \Exception('Unable to locate trade');
            }

        } catch(\Exception $exception) {
            flash()->error('Error! We were unable to find trade with given id')->important();
            Log::error($exception);
            return redirect()->back();
        }
        
        $trade = $query->first(); 

        return view('admin.trade.explore',compact('trade'));
    }

    public function partialClose(Request $request, $trade)
    {
        $this->validate($request, [
            'volume' => 'required|numeric'
        ]);

        try {
            $order = $this->trade->find(decrypt($trade));

            
            $volume = (double) $request->input('volume');
            
            if(($order->volume - $volume) < 0 ) {
                throw new \Exception('Error! Your volume is higher than available in order. Either click on close button to fully close the order or reduce the volume.');
            }
            
            $orderType = $order->type;

            $base = $order->coinPair->baseCoin->id;
            $pair = $order->coinPair->pairCoin->id;

            $payable = ['buy' => $base, 'sell' => $pair];
            $receive = ['buy' => $pair, 'sell' => $base];

            $fees = Setting::get_percentage_admin($orderType,$order->price, $volume);

            $amountPaid = [
                'buy' => number_format(($volume * $order->price) - $fees, 8),
                'sell' => $volume
            ];

            $amountReceive = [
                'buy' => $volume,
                'sell' => number_format(($volume * $order->price) - $fees, 8)
            ];

            $transactions['admin']['credit'] = [
                'code' => 'PTXN'.str_random(13),
                'user_id' => self::ADMIN_USER,
                'coin_id'=>$payable[$orderType],
                'trade_id' => $order->id,
                'amount'=>$amountPaid[$orderType],
                'source'=>$orderType,
                'type'=>'Credit',
                'description'=>$orderType.' executed by admin',
                'status' => 1
            ];

            $transactions['admin']['debit'] = [
                'code' => 'PTXN'.str_random(13),
                'user_id' => self::ADMIN_USER,
                'coin_id'=>$receive[$orderType],
                'trade_id' => $order->id,
                'amount'=>$amountReceive[$orderType],
                'source'=>$orderType,
                'type'=>'Debit',
                'description'=>$orderType.' executed by admin',
                'status' => 1
            ];

            $transactions['user']['credit'] = [
                'code' => 'PTXN'.str_random(13),
                'user_id' => $order->user_id,
                'coin_id' => $receive[$orderType],
                'trade_id' => $order->id,
                'amount' => $amountReceive[$orderType],
                'source' => $order->type,
                'type' => 'Credit',
                'description' => $orderType.' executed by admin',
                'status' => 1
            ];

            $newOrder = new Trade();

            $newVolume = $order->volume - $volume;            
            $newOrder->coin_pair_id = $order->coin_pair_id;
            $newOrder->user_id = $order->user_id;
            $newOrder->price = $order->price;
            $newOrder->volume = $newVolume;
            $newOrder->fees = Setting::get_percentage_admin($orderType,$order->price, $newVolume);
            $newOrder->type = $orderType;
            $newOrder->created_at = $order->created_at;
        
            $order->volume = $volume;
            $order->fees = $fees;
            $order->status = 1;
    
            DB::transaction(function() use ($transactions, $order, $newOrder) {

                Transaction::create($transactions['admin']['credit']);
                Transaction::create($transactions['admin']['debit']);
                Transaction::create($transactions['user']['credit']);
            
                $newOrder->save();
                
                $order->save();
            });

            flash()->success('Success! Trade has been partially closed');


        } catch (\Exception $exception) {
            flash()->error($exception->getMessage());
        }

        return redirect()->to('admin/trades');
    }

    public function cancelTrade($trade)
    {        
        try {

            $order = $this->trade->find(decrypt($trade));

            $order->status=2;

            DB::transaction(function() use ($order) {
                $order->save();

                $amount = (doubleval($order->total) + doubleval($order->fees));

                if($order->type == 'buy') {
                    $get_coin_id = $order->coinPair->baseCoin->id;
                    Transaction::create([
                        'code' => 'TXN'.str_random(13),
                        'user_id' => $order->user_id,
                        'coin_id'=>$get_coin_id,
                        'amount'=>$amount,
                        'source'=>'buy',
                        'type'=>'Credit',
                        'description'=>'buy cancelled',
                        'status' => 1
                    ]);
                }

                if($order->type == 'sell') {
                    $get_coin_id = $order->coinPair->pairCoin->id;
                    Transaction::create([
                        'code' => 'TXN'.str_random(13),
                        'user_id' => $order->user_id,
                        'coin_id'=>$get_coin_id,
                        'amount'=>$order->volume,
                        'source'=>'sell',
                        'type'=>'Credit',
                        'description'=>'sell cancelled',
                        'status' => 1
                    ]);
                }
            });

            flash()->success('Success! Order Successfully Cancelled');
        }catch (\Exception $exception) {
            Log::error($exception);

            flash()->error('Error! Failed to cancel order');
        }
        return redirect()->to('admin/trades');
    }

    public function closeTrade($trade)
    {
        try {

            $order = $this->trade->find(decrypt($trade));
            $orderType = $order->type;

            $base = $order->coinPair->baseCoin->id;
            $pair = $order->coinPair->pairCoin->id;

            $payable = ['buy' => $base, 'sell' => $pair];
            $receive = ['buy' => $pair, 'sell' => $base];

            $amountPaid = [
                'buy' => number_format(($order->volume * $order->price) - $order->fees, 8),
                'sell' => $order->volume
            ];

            $amountReceive = [
                'buy' => $order->volume,
                'sell' => number_format(($order->volume * $order->price) - $order->fees, 8)
            ];

            $transactions['admin']['credit'] = [
                'code' => 'ATXN'.str_random(13),
                'user_id' => 1,
                'coin_id'=>$payable[$orderType],
                'trade_id' => $order->id,
                'amount'=>$amountPaid[$orderType],
                'source'=>$orderType,
                'type'=>'Credit',
                'description'=>$orderType.' executed by admin',
                'status' => 1
            ];

            $transactions['admin']['debit'] = [
                'code' => 'ATXN'.str_random(13),
                'user_id' => 1,
                'coin_id'=>$receive[$orderType],
                'trade_id' => $order->id,
                'amount'=>$amountReceive[$orderType],
                'source'=>$orderType,
                'type'=>'Debit',
                'description'=>$orderType.' executed by admin',
                'status' => 1
            ];

            $transactions['user']['credit'] = [
                'code' => 'ATXN'.str_random(13),
                'user_id' => $order->user_id,
                'coin_id' => $receive[$orderType],
                'trade_id' => $order->id,
                'amount' => $amountReceive[$orderType],
                'source' => $order->type,
                'type' => 'Credit',
                'description' => $orderType.' executed by admin',
                'status' => 1
            ];

            $order->status = 1;

            DB::transaction(function() use ($transactions, $order) {

                Transaction::create($transactions['admin']['credit']);
                Transaction::create($transactions['admin']['debit']);
                Transaction::create($transactions['user']['credit']);

                $order->save();
            });

            flash()->success('Success! Trade has been closed');
        } catch (\Exception $exception) {
            Log::error($exception);
            flash()->error('Error! Closing of trade has been failed');
        }   

        return redirect()->to('admin/trades');
    }
}
