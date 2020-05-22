<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoinTransaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'coin_id', 'transaction_id',
        'reference_no', 'coin_address', 'dest_tag',
        'amount', 'fees', 'type', 'remarks', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function withdraw()
    {
        return $this->hasOne(Withdraw::class, 'coin_transaction_id');
    }

    public function scopeDeposit($query)
    {
        return $query->whereType('Credit');
    }

    public function scopeWithdraw($query)
    {
        return $query->whereType('Debit');
    }

    public function scopeCredit($query)
    {
        return $query->whereType('Credit');
    }

    public function scopeDebit($query)
    {
        return $query->whereType('Debit');
    }

    public function scopeOfCoin($query, $coin)
    {
        return $query->whereHas('coin', function($q) use ($coin){
            $q->where('coin', $coin);
        });
    }

    public function scopePending($query)
    {
        return $query->whereStatus(0);
    }

    public function scopeCompleted($query)
    {
        return $query->whereStatus(1);
    }

    public function scopeRejected($query)
    {
        return $query->whereStatus(2);
    }
}
