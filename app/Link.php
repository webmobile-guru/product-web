<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'ico_id', 'website', 'whitepaper', 'twitter',
        'slack', 'telegram', 'facebook', 'reddit', 'bitcointalk',
        'medium', 'github', 'discord', 'video', 'airdrop'
    ];

    public function ico()
    {
        return $this->belongsTo(Ico::class, 'ico_id');
    }
}
