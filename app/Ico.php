<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Ico extends Model
{
    protected $fillable = [
        'slug', 'title', 'logo', 'short_description', 'ico_start_at',
        'ico_end_at', 'additional_notes', 'airdrop',

        'feature_description','category',

        'whitelist', 'token_sale_hard_cap', 'token_sale_hard_cap_currency',
        'token_sale_soft_cap', 'token_sale_soft_cap_currency', 'presale',
        'presale_start_at', 'presale_end_at',
        'token_symbol', 'token_type_and_platform', 'token_distribution', 
        'price_per_token', 'kyc', 'participation_restriction', 
        'selling_to_us_canada', 'accept_coin', 'listing_exchange',

        'company_name', 'company_info', 'contact_person_name',
        'permissions', 'involvement', 'contact_person_email',
        'contact_person_telegram',

        'marketing_services', 'listing_fee', 'how_you_hear_about_us',
        'publish_status', 'remarks'
    ];

    protected $dates = [
        'publish_at'
    ];

    public function link()
    {
        return $this->hasOne(Link::class, 'ico_id');
    }

    public function team()
    {
        return $this->hasMany(Team::class, 'ico_id');
    }

    public function hasTag($tag)
    {
        return (bool) strpos($this->tag, $tag);
    }

    public function scopeContainTag($query, $tag)
    {
        return $query->where('tag', 'like', '%'.$tag.'%');
    }
    
    /*public function getIcoStartAtAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getIcoEndAtAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getPresaleStartAtAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getPresaleEndAtAttribute($value)
    {
        return Carbon::parse($value);
    }*/

    public function checkJsonExists($property, $value)
    {
        $json = json_decode($this->{$property});

        return in_array($value, (array) $json);
    }

    public function getStatusAttribute()
    {
        if(($this->ico_start_at <= Carbon::now()) && ($this->ico_end_at >= Carbon::now())){
            return 'Active';
        }
        if(($this->ico_start_at >= Carbon::now())){
            return 'Upcoming';
        }
        if($this->ico_end_at < Carbon::now()){
            return 'Past';
        }
    }

    public function scopePre($query)
    {
        return $query->where('presale', 'yes');
    }

    public function scopeAirdrop($query)
    {
        return $query->where('airdrop', 'yes');
    }

    public function scopeActive($query)
    {
        return $query->where('ico_start_at', '<=', Carbon::now())
            ->where('ico_end_at', '>=', Carbon::now());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('ico_start_at', '>', Carbon::now());
    }

    public function scopePast($query)
    {
        return $query->where('ico_end_at', '<', Carbon::now()->toDateString());
    }

    public function scopePublishable($query)
    {
        return $query->where('publish_status', 1)
            ->where('publish_at', '<=', Carbon::now());
    }
}
