<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KycDocument extends Model
{
    protected $fillable = [
        'code', 'user_id', 'first_name', 'middle_name', 
        'last_name', 'pan_card_no', 'pan_doc', 'dob', 'address', 
        'state', 'pin', 'address_proof', 'address_proof_no',
        'address_proof_doc_front', 'address_proof_doc_back', 
        'remarks', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 0);
    }   

    public function getUploadedAtAttribute()
    {
        return $this->user->kyc()
            ->latest()->first()->created_at;
    }

    public function getNoOfUploadAttribute()
    {
        return $this->user->kyc()->count();
    }

}
