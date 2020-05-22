<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemTokenWallet extends Model
{
    public $table  = 'system_tokens_wallets';
    public $timestamps = false;
    protected $fillable = [
        'token', 'address', 'private-key'
    ];
}
