<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;

class Profile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'address', 'city', 'state','zip',
        'phone', 'country_id','dob','ide_no',
        'ide_proof_photo','avatar','role',
        'referral_code', 'created_by', 'verification_token',
        'secret_two_fa','ide_verify','withdraw_enable_auto'
    ];

    protected $dates = [
        'verified_at', 'deleted_at', 'dob'
    ];

    protected $casts = [
        'status' => 'boolean',
        'status_two_fa' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
