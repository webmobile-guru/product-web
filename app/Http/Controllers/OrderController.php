<?php

namespace App\Http\Controllers;

use App\Coin;
use App\CoinPair;
use App\Repository\Order\OrderRepository;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getOpenOrder()
    {
        $trades = $this->repository->openOrder()->latest()->paginate(10);
		$pastTrades = $this->repository
            ->closedOrder()
            ->latest()
            ->paginate(10);
        return view('front.order.open', compact('trades','pastTrades'));
    }

    public function getHistory()
    {
        $trades = $this->repository
            ->closedOrder()
            ->latest()
            ->paginate(10);
        return view('front.order.history', compact('trades'));
    }
    
    public function cancelOrder(Request $request)
    {
        //return json_encode(['status' => false, 'message' => 'Error! Failed to cancel order']);
		$order = $this->repository->find($request->trade_id);
        try {
            if(auth()->id() != $order->user_id){
                return json_encode(['status' => false, 'message' => 'Error! Failed to cancel order']);
            }
            

            $orderEx = DB::transaction(function() use ($order) {
                
                            if(\App\Trade::where('id', $order->id)->where('status','=',0)->update(array('status' =>2))){
                            
                                $get_coin_id = $order->coinPair->baseCoin->id;
                                $amount = (doubleval($order->total) + doubleval($order->fees));


                                if($order->type == 'buy') {
                                    Transaction::create([
                                        'code' => 'TXN'.str_random(13),
                                        'user_id' => auth()->id(),
                                        'coin_id'=>$get_coin_id,
                                        'trade_id'=>$order->id,
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
                                        'user_id' => auth()->id(),
                                        'coin_id'=>$get_coin_id,
                                        'trade_id'=>$order->id,
                                        'amount'=>$order->volume,
                                        'source'=>'sell',
                                        'type'=>'Credit',
                                        'description'=>'sell cancelled',
                                        'status' => 1
                                    ]);
                                }
                            
                            return true;
                            }

                            return false;

            });
                if($orderEx)
                return json_encode(['status' => true, 'message' => 'Success! Order Successfully Canceled']);
                else
                return json_encode(['status' => false, 'message' => 'Error! Failed to cancel order']);
            
        }catch (\Exception $exception) {
          Log::error('Error from Order controller '.$exception->getMessage());
          return json_encode(['status' => false, 'message' => 'Error! Failed to cancel order']);
        }
	}
}
