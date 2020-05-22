<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payback extends Model
{
    protected $fillable = [
        'user_id', 'coin_pair_id', 'volume',
        'revert_type', 'volume_in_usd', 'fees',
        'rate_in_usd', 'usd_to_revert', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function coinPair()
    {
        return $this->belongsTo(CoinPair::class, 'coin_pair_id');
    }
}
