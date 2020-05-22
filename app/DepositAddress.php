<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepositAddress extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'coin_id', 'address', 'dest_tag','private_key'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }
}
