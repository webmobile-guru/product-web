<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdraw extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'coin_id', 'coin_transaction_id',
        'transaction_id', 'address', 'amount', 'fees',
        'remarks', 'status', 'dest_tag'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }

    public function coinTransaction()
    {
        return $this->belongsTo(CoinTransaction::class, 'coin_transaction_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}