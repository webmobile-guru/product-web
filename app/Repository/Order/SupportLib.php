<?php 

namespace App\Repository\Order\SupportLib;

use App\Trade;
use Illuminate\Support\Facades\DB;

trait SupportLib
{
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
        return $trade->lastPrice($pair);
    }


    private function lastPrice($pair)
    {
        $trade = new Trade();
        return $trade->lastPrice($pair);
    }

    private function getLowestPriceForBuy($pair)
    {
        $trade = new Trade();
        return $trade->lowestBuyPrice($pair);
    }

    private function getHighestPriceForSell($pair)
    {
        $trade = new Trade();
        return $trade->highestSellPrice($pair);
    }

    private function getPercentChange($pair)
    {
        $trade = new Trade();
        return $trade->changePercent($pair);
    }

    private function getBaseVolume($pair)
    {
        $trade = new Trade();
        return $trade->baseVolume($pair);
    }

    private function getQuoteVolume($pair)
    {
        $trade = new Trade();
        return $trade->quoteVolume($pair);
    }

    private function getHigh24hr($pair)
    {
        $trade = new Trade();
        return $trade->high24Hour($pair);
    }

    private function getLow24hr($pair)
    {
        $trade = new Trade();
        return $trade->low24Hour($pair);
    }

    private function sellVolume($pair)
    {
        $trade = new Trade();
        return $trade->totalSellVolume($pair);
    }

    private function buyVolume($pair)
    {
        $trade = new Trade();
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
        return $trade->baseVolumeFifty($pair, $type);
    }

    private function getQuote50Volume($pair, $type) 
    {
        $trade = new Trade();
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
