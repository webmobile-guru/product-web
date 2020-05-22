<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoinForList extends Model
{
    protected $fillable = [
        //basic
        'user_id', 'coin_id', 'contact_email', 'full_name',
        'company_name', 'position_in_company', 'one_sentence_pitch',
        'previously_submited',
        // overview
        'project_name', 'coin_name', 'coin_symbol',
        'website_link', 'whitepaper_link', 'project_nature',
        'project_application', 'target_industry',
        'project_competetor','remarks', 'comment',
        
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }

    public function getProjectNatureAttribute($value)
    {
        $value = array_filter(unserialize($value));
        return implode(', ', $value);
    }

    public function getPositionInCompanyAttribute($value)
    {
        $value = array_filter(unserialize($value));
        return implode(', ', $value);
    }
}
