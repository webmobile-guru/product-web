<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoinWalletBalance extends Model
{
    protected $fillable = [
        'coin_id', 'balance_available'
    ];

    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }
}
