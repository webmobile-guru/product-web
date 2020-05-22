<?php

namespace App\Http\Controllers;

use App\Trade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ratchet\ConnectionInterface;
use App\Http\Controllers\Controller;
use Ratchet\MessageComponentInterface;
use Illuminate\Database\Capsule\Manager as DB;
//use App\Repository\Order\SupportLib\SupportLib;

class SocketController extends Controller implements MessageComponentInterface
{
    //use SupportLib;

    protected $clients;
    protected $data;
    protected $dbMode;
    private $users;

    public function __construct($mode) {

        $this->clients = new \SplObjectStorage;
        $this->users = [];

		$this->dbMode = $mode;

        $Capsule = new DB;
        $config = config('database.connections.'.$mode);
        $Capsule->addConnection($config);

        $Capsule->SetAsGlobal();
        DB::connection();

    }

    public function allClients(){
        return $this->clients;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        $this->users[$conn->resourceId] = $conn;
    }

    public function onMessage(ConnectionInterface $from, $msg) 
    {     

		if($msg != '.') {
			foreach ($this->clients as $client) {
				$client->send(json_encode(array(123,"test  1111")));
			}
				
			$msg = json_decode($msg);
            switch ($msg->channel) {
                case 2000:
                  
					
					$tradeHistory = DB::select("select * from `trades` where exists (select * from `coin_pairs` where `trades`.`coin_pair_id` = `coin_pairs`.`id` and `pair_name` = '".$msg->currencyPair."' and `coin_pairs`.`deleted_at` is null) and `status` = 1 and `trades`.type='buy' and `trades`.`deleted_at` is null order by `updated_at` desc LIMIT 0,1"); 

                    $userTrade = [];

                    $userTrade['closed'] = [];
                    $userTrade['ongoing'] = [];

                    ////////////////////////////////////////////////////////////////////////
                    if($msg->params->type=='cancelled'){
                        $tradeId = $msg->params->orderNumber;
                        Trade::destroy($tradeId);
                    }
                    ////////////////////////////////////////////////////////////////////////

                    $data = DB::select('call sp_get_trade_record(?)',[$msg->currencyPair]);

                    foreach($data as $row){

                        if($row->type=='buy') {
							//if($row->toamount > 0){
								$return[0][(string) $row->price] = number_format(floatval($row->toamount),8);
							//}                            
                        }

                        if($row->type=='sell') {
							//if($row->toamount > 0){
								$return[1][(string) $row->price] = number_format(floatval($row->toamount),8);
							//}
                        }
                    }

                    foreach ($this->clients as $client) {
                        $client->send(json_encode(array(114,['o'=>$return, 't'=>$tradeHistory, 'u'=>$userTrade, 'pair'=>$msg->currencyPair])));
                        $client->send(json_encode(array(1200,$this->ticker($msg->currencyPair))));
                    }

                    break;

                case 1000:

                    foreach ($this->clients as $client) {
                        $client->send(json_encode(array(1000,$msg->params)));
                    }

                    break;
				
				case 1230:

                    foreach ($this->clients as $client) {
                        $client->send(json_encode(array(123,"test  1111")));
                    }

                    break;

                default:
					$trade = new Trade();
					$trade->setConnection($this->dbMode);
                    $data = $trade->whereHas('coinPair', function($q) use ($msg){
                        $q->where('pair_name', $msg->currencyPair);
                    })->onLimit()->ongoing()->selectRaw('sum(trades.volume) as volume, trades.type, trades.price')
                        ->groupBy('trades.price', 'trades.type', 'trades.id')->get();

                    $return = [];

                    foreach($data as $row) {
                        if($row->type=='sell')
                            $return[0][(string) $row->price] = number_format(floatval($row->volume),8);

                        if($row->type=='buy')
                            $return[1][(string) $row->price] = number_format(floatval($row->volume),8);
                    }

                    foreach ($this->clients as $client) {
                        $client->send(json_encode(array(115,$return)));
                    }
                   
            }
       }
    }
	
        
    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        Log::error('Error from socket controller '. $e->getMessage());
        $conn->close();
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
		$trade->setConnection($this->dbMode);
        return $trade->lastPrice($pair);
    }


    private function lastPrice($pair)
    {
        $trade = new Trade();
		$trade->setConnection($this->dbMode);
        return $trade->lastPrice($pair);
    }

    private function getLowestPriceForBuy($pair)
    {
        $trade = new Trade();
		$trade->setConnection($this->dbMode);
        return $trade->lowestBuyPrice($pair);
    }

    private function getHighestPriceForSell($pair)
    {
        $trade = new Trade();
		$trade->setConnection($this->dbMode);
        return $trade->highestSellPrice($pair);
    }

    private function getPercentChange($pair)
    {
        $result = DB::select('CALL sp_get_change_percent(?)', [$pair]);
        return isset($result[0]->change_percent)?$result[0]->change_percent:0;
    }

    private function getBaseVolume($pair)
    {
        $trade = new Trade();
		$trade->setConnection($this->dbMode);
        return $trade->baseVolume($pair);
    }

    private function getQuoteVolume($pair)
    {
        $trade = new Trade();
		$trade->setConnection($this->dbMode);
        return $trade->quoteVolume($pair);
    }

    private function getHigh24hr($pair)
    {
        $trade = new Trade();
		$trade->setConnection($this->dbMode);
        return $trade->high24Hour($pair);
    }

    private function getLow24hr($pair)
    {
        $trade = new Trade();
		$trade->setConnection($this->dbMode);
        return $trade->low24Hour($pair);
    }

    private function sellVolume($pair)
    {
        $trade = new Trade();
		$trade->setConnection($this->dbMode);
        return $trade->totalSellVolume($pair);
    }

    private function buyVolume($pair)
    {
        $trade = new Trade();
		$trade->setConnection($this->dbMode);
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
		$trade->setConnection($this->dbMode);
        return $trade->baseVolumeFifty($pair, $type);
    }

    private function getQuote50Volume($pair, $type) 
    {
        $trade = new App\Trade();
		$trade->setConnection($this->dbMode);
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
