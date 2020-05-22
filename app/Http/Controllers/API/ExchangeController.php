<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Chat;
use App\Coin;
use App\Trade;
use App\CoinPair;
use App\Setting;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class ExchangeController extends Controller
{

    protected $conn;

    public function __construct(Request $res)
    {
        $this->conn = $res->conn;
    }
   
    public function returnTrickar($conn){    
        
        $data = array();
        try{
            $CoinPair = new CoinPair;
            $CoinPair->setConnection($conn);
            $results = $CoinPair->pluck('pair_name');
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
        }catch (\Exception $exception) {
            return response()->json(['error'=>'Some Error Ocurred! Please Try again!!']);
        }
        
    }

    public function pairTricker(Request $request){
       // $user = $request->user();
        
        $data = array();
        try{
            $req_data = $request->json()->all();
            $pair = $req_data['pair'];
            $data = array(
                'last' => $this->lastPrice($pair),
                'lowestAsk' =>$this->getLowestPriceForBuy($pair),
                'highestBid' => $this->getHighestPriceForSell($pair),
                'percentChange' => $this->getpercentChange($pair),
                'baseVolume' => $this->getBaseVolume($pair),
                'quoteVolume' =>  $this->getQuoteVolume($pair),
                'isFrozen' => 0,
                'high24hr' => $this->getHigh24hr($pair),
                'low24hr'=>$this->getLow24hr($pair),
                'sellvolumn' => $this->sellVolume($pair),
                'buyvolumn' => $this->buyVolume($pair),
                'currentBuyPrice' => $this->currentPriceByType($pair, 'sell')
            );
            return response()->json($data);
            
        }catch (\Exception $exception) {
            return response()->json(['error'=>'Some Error Ocurred! Please Try again!!']);
        }
        
    }

    public function PrivateInfo(Request $r)
    {
        // if(Auth::guest()) {
        //     response()->json(['msg' => 'Session Expired', 'error' => 1]);
        // }
        try{
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
        }catch (\Exception $exception) {
            return response()->json(['error'=>'Some Error Ocurred! Please Try again!!']);
        }
            
    }



    public function ticker($pair){

        $data = array(
            $pair,
            //~ $this->getLastsellPrice($pair),
            $this->lastPrice($pair),
            $this->getLowestPriceForBuy($pair),
            $this->getHighestPriceForSell($pair),
            $this->getpercentChange($pair),
            $this->getBaseVolume($pair),
            $this->getQuoteVolume($pair),
            0,
            $this->gethigh24hr($pair),
            $this->getlow24hr($pair),
        );
        
        return $data;
    }
    
    private function getLastsellPrice($pair)
    {
        $trade = new Trade();
        return  $this->trade->lastPrice($pair);
    }


    private function lastPrice($pair)
    {
        $trade = new Trade();
        $trade->setConnection($this->conn);
        return $trade->lastPrice($pair);
    }

    private function getLowestPriceForBuy($pair)
    {
        $trade = new Trade();
        $trade->setConnection($this->conn);
        return $trade->lowestBuyPrice($pair);
    }

    private function getHighestPriceForSell($pair)
    {
        $trade = new Trade();
        $trade->setConnection($this->conn);
        return $trade->highestSellPrice($pair);
    }

    private function getPercentChange($pair)
    {
        $result = DB::connection($this->conn)->select('CALL sp_get_change_percent(?)', [$pair]);
        return isset($result[0]->change_percent)?$result[0]->change_percent:0;
    }

    private function getBaseVolume($pair)
    {
        $trade = new Trade();
        $trade->setConnection($this->conn);
        return $trade->baseVolume($pair);
    }

    private function getQuoteVolume($pair)
    {
        $trade = new Trade();
        $trade->setConnection($this->conn);
        return $trade->quoteVolume($pair);
    }

    private function getHigh24hr($pair)
    {
        $trade = new Trade();
        $trade->setConnection($this->conn);
        return $trade->high24Hour($pair);
    }

    private function getLow24hr($pair)
    {
        $trade = new Trade();
        $trade->setConnection($this->conn);
        return $trade->low24Hour($pair);
    }

    private function sellVolume($pair)
    {
        $trade = new Trade();
        $trade->setConnection($this->conn);
        return $trade->totalSellVolume($pair);
    }

    private function buyVolume($pair)
    {
        $trade = new Trade();
        $trade->setConnection($this->conn);
        return $trade->totalBuyVolume($pair);
    }

    public function get24HrTotalVolumn($pair)
    {
        //SELECT trade_type, IFNULL(sum(total),0) as volume FROM `trades` WHERE `pair_id` = 'btc_mce' and status = 'closed' GROUP BY trade_type;
        //return
    }

	private function getBase50Volume($pair, $type)
    {
        $trade = new Trade();
        $trade->setConnection($this->conn);
        return $trade->baseVolumeFifty($pair, $type);
    }

    private function getQuote50Volume($pair, $type) 
    {
        $trade = new Trade();
        $trade->setConnection($this->conn);
        return $trade->quoteVolumeFifty($pair, $type);
    }

    private function currentPriceByType($pair, $type)
    {
        $result = 0 ;
        try {
            $result = round($this->getBase50Volume($pair, $type) / $this->getQuote50Volume($pair, $type), 8);
        } catch (\Exception $exception) {
            $result = 0;
        } finally {
            return round($result, 8);
        }
    }

    
}
