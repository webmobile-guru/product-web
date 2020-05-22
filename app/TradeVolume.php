<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TradeVolume extends Model
{
    protected $table = 'last_month_trade_volume';

    // cols are user_id, coin_pair_id, volume, fees

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function coinPair()
    {
        return $this->belongsTo(CoinPair::class, 'coin_pair_id');
    }
}
