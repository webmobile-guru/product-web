<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Coin;
use App\Trade;
use App\CoinPair;
use App\Repository\Order\OrderRepository;
use App\Repository\Order\SupportLib\SupportLib;
use App\Setting;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class ExchangeController extends Controller
{
    use SupportLib;

    protected $repositoy;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('twofa');
    }

    public function index()
    {
        $coinPairs = CoinPair::active()->pluck('pair_name')->toJson();
        //$coinPairs = implode(',', $coinPairs);

        $availables = Coin::active()->pluck('coin')->toJson();
        //$availables = implode(',', $availables);
		
		$referral_level_commission = Setting::where('key','REFERRAL_LEVEL_1')->pluck('value')->first();

        $coinPairName = Coin::active()->pluck('name', 'coin')->toJson();

        return view('front.exchange.index', compact('coinPairs', 'availables', 'coinPairName', 'referral_level_commission'));
    }

    public function get_tradeHistory(){

        $data = DB::table('trades')
            ->where('status','closed')
            ->orderBy('created_at', 'desc')
            ->skip(0)->take(200)->get();

        $return = ['success'=>1, 'data'=>[]];

        if(!$data->isEmpty()) {
            foreach ($data as $key => $value) {
                $return['data'][$key] = [
                    'date' => $value->updated_at,
                    'rate' => $value->price,
                    'amount' => $value->amount,
                    'total' => ($value->price*$value->amount)
                ];
            }
        }

        return response()->json($return);
    }


    public function orderPost(Request $r)
    {
        $this->validate($r, [
            'currencyPair' => 'required|exists:coin_pairs,pair_name',
            'rate' => 'required|numeric|min:0.00000001',
            'amount' => 'required|numeric|min:0.00000001',
            'command' => 'required|in:buy,sell'
        ], [
            'rate.required' => 'Price is a required field',
            'rate.numeric' => 'Price should be a number',
            'rate.min' => 'Price should be higher than 0',
        ]);

        try {

            if(auth()->guest()) {
                throw new \Exception ('Session has been expired. Login Again.');
            }

            $user = auth()->user();

            //$user = \App\User::find($r->user);
            $pair = CoinPair::where('pair_name', $r->currencyPair)->first();

            // Get balance of coin
            $balanceOfCoin = [
                'buy' => $pair->baseCoin->coin,
                'sell' => $pair->pairCoin->coin
            ];

            $balance = $user->getBalance($balanceOfCoin[$r->command]);

            // Calculate total
            if($r->command == 'buy'){
                $fee = (double) Setting::get_percentage_admin('buy', $r->rate, $r->amount);
                $total_buy = (((double) $r->rate) * ((double) $r->amount));
                $total = ( $total_buy + $fee);
            }else{
                $total = $r->amount;
            }

            if($balance < $total) {
                throw new \Exception ('You don\'t have sufficient '.$balanceOfCoin[$r->command].' balance');
            }

	        $rate = $r->rate;
            $amount = $r->amount;
            $command = $r->command;
            $currencyPair = $r->currencyPair;

            $update = DB::transaction(function() use ($rate, $amount, $command, $currencyPair, $user){
 
                $lastPrice = $this->repository->lastPrice($currencyPair);
				 
                Trade::where('type','buy')
                    ->whereHas('coinPair', function($query) use ($currencyPair) {
                        $query->where('pair_name', $currencyPair);
                    })->onStopLimit()->ongoing()
                    ->where('trigger', '>=' , $lastPrice)->update(['method' => 'limit']);
				
				Trade::where('type','sell')
                    ->whereHas('coinPair', function($query) use ($currencyPair) {
                        $query->where('pair_name', $currencyPair);
                    })->onStopLimit()->ongoing()
                    ->where('trigger', '<=' , $lastPrice)->update(['method' => 'limit']);

               
                return $this->repository->tradepost($rate, $amount, $command, $currencyPair, $user->id);
            });

            if($update) {
                $result = ['msg' => 'Your order has been successfully placed!', 'success'=>1, 'code' => 200];
            } else {
                $result = ['msg' => 'error','success'=>0, 'code' => 412];
            }

        } catch (\Exception $exception) {
            Log::error($exception);
            $result = ['msg' => $exception->getMessage(), 'success'=>0, 'code' => 422];
        }

        return response()->json($result, $result['code']);
    }


    public function stopLimit(Request $r)
    {
        $this->validate($r, [
            'currencyPair' => 'required|exists:coin_pairs,pair_name',
            'rate' => 'required|numeric|min:0.00000001',
            'amount' => 'required|numeric|min:0.00000001',
            'stopRate' => 'required|numeric|min:0.00000001',
            'command' => 'required|in:stopLimitSell,stopLimitBuy'
        ], [
            'stopRate.required' => 'Stop price is required',
            'stopRate.numeric' => 'Stop price is required',
            'stopRate.min' => 'Stop price should be higher than 0',
            'rate.required' => 'Limit is a required field',
            'rate.numeric' => 'Limit should be a number',
            'rate.min' => 'Limit should be higher than 0',
        ]);

        try {

            if(auth()->guest()) {
                throw new \Exception ('Session has been expired. Login Again.');
            }
			
			// Check Condition
            if($r->command == 'stopLimitBuy' and $r->stopRate > $r->rate){
                throw new \Exception ('Wrong Logic for STOP-LIMIT');
            }
			
			if($r->command == 'stopLimitSell' and $r->stopRate < $r->rate){
                throw new \Exception ('Wrong Logic for STOP-LIMIT');
            }

            $user = auth()->user();
            $pair = CoinPair::where('pair_name', $r->currencyPair)->first();

            // Get balance of coin
            $balanceOfCoin = [
                'stopLimitBuy' => $pair->baseCoin->coin,
                'stopLimitSell' => $pair->pairCoin->coin
            ];

            $balance = $user->getBalance($balanceOfCoin[$r->command]);

            // Calculate total
            if($r->command == 'stopLimitBuy'){
                $fee = (double) Setting::get_percentage_admin('buy', $r->rate, $r->amount);
                $total_buy = (((double) $r->rate) * ((double) $r->amount));
                $total = ( $total_buy + $fee);
            }else{
                $total = $r->amount;
            }

            if($balance < $total) {
                throw new \Exception ('You don\'t have sufficient '.$balanceOfCoin[$r->command].' balance');
            }

            $stop = $r->stopRate;
            $rate = $r->rate;
            $amount = $r->amount;
            $command = $r->command;

            $update = DB::transaction(function() use ($stop, $rate, $amount, $command, $pair){
                return $this->repository->stopLimitOrderPost($stop, $rate, $amount, $command, $pair);
            });

            if($update) {
                $result = ['msg' => 'Limit order has been set successfully', 'success'=>1, 'code' => 200];
            } else {
                $result = ['msg' => 'error','success'=>0, 'code' => 412];
            }

        } catch (\Exception $exception) {
            Log::error($exception);
            $result = ['msg' => $exception->getMessage(), 'success'=>0, 'code' => 422];
        }

        return response()->json($result, $result['code']);
    }

    public function postTroll(Request $r)
    {
        try {
            if(auth()->guest()) {
                throw new \Exception('You are not an authorized user.');
            }
            if($r->has('msg') && ($r->msg != 'all')) {
                $user = auth()->user();
                $chat = Chat::create([
                    'user_id' => $user->id,
                    'message' => strip_tags($r->msg)
                ]);

                $result = ['status' => true, 'message' => ['username' => 'DOCH-100'. $user->id, 'msg' => $chat->message]];
            } else {
                $user = auth()->user();
                $chats = Chat::join('users', 'users.id', '=', 'chats.user_id')
                    ->selectRaw('chats.message, 
                    CONCAT_WS("", "DOCH-100", users.id) AS name')
                    ->orderBy('chats.id', 'asc')->get();
                $result = ['status' => true, 'message' => $chats];
            }

        } catch (\Exception $exception) {
            Log::error($exception);
            flash()->error($exception->getMessage());
            $result = ['status'=> false];
        }

        return response()->json($result);
    }

    public function orderTable(Request $r)
    {
        $return = [];
        $data = $this->repository->whereHas('coinPair', function($q) use ($r) {
            $q->where('pair_name', $r->currencyPair);
        })->onLimit()->ongoing()->groupBy('price','type')
            ->select(DB::raw('type, price, sum(volume) as amount'))->get();
		
        if($data){
            foreach($data as $row){
                if($row->type=='buy') {
                    $return['bids'][(string) $row->price] = [$row->price, floatval($row->amount)];
                }

                if($row->type=='sell') {
                    $return['asks'][(string) $row->price] = [$row->price, floatval($row->amount)];
                }
            }

            if(isset($return['asks']))
                sort($return['asks']);

            if(isset($return['bids']))
                rsort($return['bids']);
        }

        return $return;
    }

    public function PrivateInfo(Request $r)
    {
        if(Auth::guest()) {
            response()->json(['msg' => 'Session Expired', 'error' => 1]);
        }
	
        $user = auth()->user();

        $pair = explode('_', $r->currencyPair);

        $primaryBalance = $user->getBalance($pair[0]);

        $secondaryBalance = $user->getBalance($pair[1]);

        $openOrders = $user->getOpenOrders($r->currencyPair);

        $data = [
            'msg'=>'success',
            'error' => 0,
            'primaryBalance'=>$primaryBalance,
            'seconderyBalance'=>$secondaryBalance,
            'openOrders'=>['limit'=>$openOrders]
        ];
        
        return response()->json($data);
    }

    public function UserTradeHistory(Request $r)
    {
        $tradeHistory = [];

        if(Auth::check()){
            $user = auth()->user();

            $tradeHistory = $user->trade()->whereHas('coinPair', function ($query) use ($r) {
                $query->where('pair_name', $r->currencyPair);
            })->ongoing()->latest()->take(200)->get();
        }

        return response()->json($tradeHistory);

    }

    public function UserTradeHistoryFull(Request $r)
    {
        $tradeHistory = [];

        if(Auth::check()) {
            $user = auth()->user();

            $tradeHistory = $user->trade()->whereHas('coinPair', function ($query) use ($r) {
                $query->where('pair_name', $r->currencyPair);
            })->closed()->latest()->take(200)->get();
        }

        return response()->json($tradeHistory);

    }

    public function TradeHistory(Request $r)
    {
        $tradeHistory = $this->repository->whereHas('coinPair', function ($query) use ($r) {
            $query->where('pair_name', $r->currencyPair);
        })->closed()->where('type','buy')->orderBy('trades.updated_at', 'desc')->take(50)->get();

        return response()->json($tradeHistory);
    }

    public function currentPrice(Request $r){

        $return = [];
        $coinPairID = CoinPair::where('pair_name', $r->pair)->pluck('id')->first();

        $results = DB::select('call sp_get_graph_record(?)',[$coinPairID]);
        if(!empty($results)){
            $return = $results;
        }

        return response()->json($return);
    }

    public function daysReport(){

        $now = '2016-12-18 03:04:33';//date("Y-m-d H:m:s");
        $last_time = date("Y-m-d H:m:s", strtotime('+24 hours', time()));
        $results = DB::select( DB::raw("SELECT (SELECT price FROM trades WHERE created_at >= '".$now."' LIMIT 1) as open,
		(SELECT price FROM trades WHERE created_at >= '".$now."' AND created_at <= '".$last_time."' ORDER BY created_at DESC LIMIT 1) as close,
		MAX(price) as high,MIN(price) as low FROM trades WHERE created_at >= :now AND created_at <= :last_time"),
            array('now' => $now,'last_time'=>$last_time));

        print_r($results);

        return response()->json(['data' => $results]);
    }

    public function returnTrickar(){

        $data = array();
        $results = CoinPair::pluck('pair_name');
        foreach ($results as $value) {
            $data[$value] = array(
                'last' => $this->lastPrice($value),
                'lowestAsk' =>$this->getLowestPriceForBuy($value),
                'highestBid' => $this->getHighestPriceForSell($value),
                'percentChange' => $this->getpercentChange($value),
                'baseVolume' => $this->getBaseVolume($value),
                'quoteVolume' =>  $this->getQuoteVolume($value),
                'isFrozen' => 0,
                'high24hr' => $this->getHigh24hr($value),
                'low24hr'=>$this->getLow24hr($value),
                'sellvolumn' => $this->sellVolume($value),
                'buyvolumn' => $this->buyVolume($value),
                'currentBuyPrice' => $this->currentPriceByType($value, 'sell')
            );
        }

        return response()->json($data);
    }
}
