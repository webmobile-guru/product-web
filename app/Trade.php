<?php

namespace App;

use DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trade extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'coin_pair_id', 'method', 
        'trigger', 'price', 'volume',
    'fees', 'type', 'isLock', 'status', 'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function coinPair()
    {
        return $this->belongsTo(CoinPair::class, 'coin_pair_id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'trade_id');
    }

    public function getTotalAttribute()
    {
        return ($this->price * $this->volume);
    }

    public function getNetAmountAttribute()
    {
        return ($this->total - $this->fees);
    }

    public function scopeOnLimit($query)
    {
        return $query->where('method', 'limit');
    }

    public function scopeOnStopLimit($query)
    {
        return $query->where('method', 'stop-limit');
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 0);
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 1);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 2);
    }

    public function scopeSell($query)
    {
        return $query->whereType('sell');
    }

    public function scopeBuy($query)
    {
        return $query->whereType('buy');
    }

    public function lastPrice($pair)
    {
        $price = $this->whereHas('coinPair', function($q) use ($pair){
            $q->where('pair_name', $pair);
        })->closed()->latest()->pluck('price')->first();

        return doubleval($price);
    }

    public function lowestBuyPrice($pair)
    {
        $price = $this->whereHas('coinPair', function($q) use ($pair){
            $q->where('pair_name', $pair);
        })->sell()->ongoing()->onLimit()
            ->orderBy('price', 'asc')
            ->pluck('price')->first();

        return doubleval($price);
    }

    public function highestSellPrice($pair)
    {
        $price = $this->whereHas('coinPair', function($q) use ($pair){
            $q->where('pair_name', $pair);
        })->buy()->ongoing()->onLimit()
            ->orderBy('price', 'desc')
            ->pluck('price')->first();

        return doubleval($price);
    }

    public function changePercent($pair)
    {
        $result = DB::select('CALL sp_get_change_percent(?)', [$pair]);

        return isset($result[0]->change_percent)?$result[0]->change_percent:0;
    }

    public function baseVolume($pair, $hour = 24)
    {
        $dt = Carbon::now();

        $total = $this->whereHas('coinPair', function($q) use ($pair){
            $q->where('pair_name', $pair);
        })->buy()->closed()
            ->where('updated_at', '>=',$dt->subHours($hour))
            ->select(DB::raw('sum(trades.price * trades.volume) as volume'))
            ->first();

        $volume = (double) $total->volume;
        return $volume;
    }

    public function quoteVolume($pair, $hour = 24)
    {
        return (double) $this->whereHas('coinPair', function($q) use ($pair){
            $q->where('pair_name', $pair);
        })->buy()->closed()
            ->where('updated_at', '>=', Carbon::now()->subHours($hour))
            ->sum('volume');
    }

    public function high24Hour($pair)
    {
        return (double) $this->whereHas('coinPair', function($q) use ($pair){
            $q->where('pair_name', $pair);
        })->buy()->closed()
            ->where('updated_at', '>=', Carbon::now()->subHours(24))
            ->max('price');
    }

    public function low24Hour($pair)
    {
        return (double) $this->whereHas('coinPair', function($q) use ($pair){
            $q->where('pair_name', $pair);
        })->buy()->closed()
            ->where('updated_at', '>=', Carbon::now()->subHours(24))
            ->min('price');
    }

    public function totalSellVolume($pair)
    {
        $total = $this->whereHas('coinPair', function($q) use ($pair){
            $q->where('pair_name', $pair);
        })->sell()->ongoing()        
            ->select(DB::raw('sum(trades.price * trades.volume) as volume'))
            ->first();

        $volume = (double) $total->volume;
        return $volume;
    }

    public function totalBuyVolume($pair)
    {
	    $total = $this->whereHas('coinPair', function($q) use ($pair){
            $q->where('pair_name', $pair);
        })->buy()->ongoing()
            ->select(DB::raw('sum(trades.price * trades.volume) as volume'))
            ->first();

        $volume = (double) $total->volume;
        return $volume;
    }

    public function baseVolumeFifty($pair, $type)
    {
        $price = $this->whereHas('coinPair', function($q) use ($pair){
            $q->where('pair_name', $pair);
        })->closed()->whereType($type)->latest()->take(50)->sum('price');

        $amount = $this->whereHas('coinPair', function($q) use ($pair){
            $q->where('pair_name', $pair);
        })->closed()->whereType($type)->latest()->take(50)->sum('amount');

        return doubleval($price * $amount);
    }

    public function quoteVolumeFifty($pair, $type)
    {
        $amount = $this->whereHas('coinPair', function($q) use ($pair){
            $q->where('pair_name', $pair);
        })->closed()->whereType($type)->latest()->take(50)->sum('amount');

        return doubleval($amount);
    }
}
