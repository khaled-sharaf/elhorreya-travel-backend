<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TravelProgram extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'image', 'small_info', 'big_info', 'order', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function travel_types()
    {
        return $this->hasMany('App\TravelType');
    }
}
