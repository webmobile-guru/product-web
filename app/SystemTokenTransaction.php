<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemTokenTransaction extends Model
{
    public $table  = 'system_tokens_transactions';
    public $timestamps = false;
    protected $fillable = [
        'token', 'address', 'txn', 'amount', 'status', 'type'
    ];
}
