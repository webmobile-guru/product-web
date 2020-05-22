<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'key', 'value'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public static function getFees($key)
    {
        $metaValue = Setting::where('key', $key)->pluck('value')->first();
        $metaValue = ($metaValue)?$metaValue:0;
        return doubleval($metaValue);
    }
    
    public static function get_percentage_admin($type,$rate,$amount)
    {
        if($type=='buy'){
            $fee = self::getFees('taker_fee') / 100;
            $percentage_taken = round((float) ($rate * $amount * $fee), 8);
        }else{
            $fee = self::getFees('maker_fee') / 100 ;
            $percentage_taken = round((float) ($rate * $amount * $fee), 8);
        }

        return $percentage_taken;
    }

    public static function createOrUpdate(array $data)
    {
        foreach ($data as $key => $value) {
            $query = Setting::where('key', $key);
            if($query->exists()) {
                $query->update([
                    'value' => $value
                ]);
            } else {
                Setting::create(['key' => $key, 'value' => $value]);
            }
        }
    }
}
