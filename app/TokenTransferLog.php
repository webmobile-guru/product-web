<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TokenTransferLog extends Model
{
    public $table  = 'token_transfer_logs';
    public $timestamps = false;
    protected $fillable = [
        'token', 'address', 'from_address', 'txn', 'status', 'initiated_by'
    ];
}
