<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code', 'user_id', 'coin_id', 'trade_id',
        'source', 'type', 'amount',
        'description', 'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }

    public function trade()
    {
        return $this->belongsTo(Trade::class, 'trade_id');
    }

    public function scopeCredit($query) {
		$query->where('type','Credit');	
	}

	public function scopeDebit($query) {
		$query->where('type','Debit');	
	}

    public function scopeBuy($query) {
        $query->where('source','buy');
    }

    public function scopeSell($query) {
        $query->where('source','sell');
    }
}
