<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{

    protected $fillable = [
        'branch_name',
        'phone_1',
        'phone_2',
        'phone_3',
        'phone_4',
        'address',
        'email',
        'latitude',
        'longitude',
        'display'
    ];

    public function scopeDisplay($query)
    {
        return $query->where('display', 1);
    }
}
