<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'ico_id', 'type', 'photo',
        'full_name', 'job_title', 'link'
    ];

    public function ico()
    {
        return $this->belongsTo(Ico::class, 'ico_id');
    }

    public function getPhotoAttribute($value)
    {
        return $value?:'img/nobody_m.original.jpg';
    }

    public function scopeCore($query)
    {
        return $query->where('type', 'core');
    }

    public function scopeAdvisory($query)
    {
        return $query->where('type', 'advisory');
    }
}
