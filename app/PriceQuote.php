<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceQuote extends Model
{
    protected $fillable = [
        'symbol','price','status','type'
    ];
}
