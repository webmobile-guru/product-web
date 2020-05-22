<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoinPair extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'base_coin_id', 'coin_id', 'listed_by',
        'pair_name','status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function baseCoin()
    {
        return $this->belongsTo(Coin::class, 'base_coin_id');
    }

    public function pairCoin()
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }

    public function listedBy()
    {
        return $this->belongsTo(User::class, 'listed_by');
    }

    public function tradeVolume()
    {
        return $this->hasMany(TradeVolume::class, 'coin_pair_id');
    }

    public function payback()
    {
        return $this->hasMany(Payback::class, 'coin_pair_id');
    }

    public function getBaseCoinIDByPairName($pair, $purchaseType)
    {
        $coin = $this->where('pair_name', $pair)->first();

        if($purchaseType == 'buy') {
            return (isset($coin->base_coin_id)) ? $coin->base_coin_id : 0;
        }else{
            return (isset($coin->coin_id)) ? $coin->coin_id : 0;
        }
    }

    public function scopeActive($query)
    {
        return $query->where('status',1);
    }

    public function scopeInActive($query)
    {
        return $query->where('status',0);
    }

    public function getBaseVolumeFor($hour = 1)
    {
        $trade = new Trade();
        return $trade->baseVolume($this->pair_name, $hour);
    }

    public function getQuoteVolumeFor($hour = 1)
    {
        $trade = new Trade();
        return $trade->quoteVolume($this->pair_name, $hour);
    }

    public function lastPrice()
    {
        $trade = new Trade();
        return $trade->lastPrice($this->pair_name);
    }

    public function getHourlyChangeAttribute()
    {
        $result = DB::select("SELECT fn_get_change_percent('$this->pair_name',1) AS changes");
        return isset($result[0]->changes)?$result[0]->changes:0;
    }

    public function getDailyChangeAttribute()
    {
        $result = DB::select("SELECT fn_get_change_percent('$this->pair_name',24) AS changes");
        return isset($result[0]->changes)?$result[0]->changes:0;
    }

    public function getWeeklyChangeAttribute()
    {
        $result = DB::select("SELECT fn_get_change_percent('$this->pair_name',168) AS changes");
        return isset($result[0]->changes)?$result[0]->changes:0;
    }
}
