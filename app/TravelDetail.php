<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelDetail extends Model
{

    protected $fillable = [
        'info_offer', 'go_and_back', 'date_from', 'date_to', 'time_period', 'stay_type', 'transport', 'adults', 'children', 'single_price', 'twin_price', 'triple_price', 'display', 'travel_id'
    ];

    public function scopeDisplay($query)
    {
        return $query->where('display', 1);
    }

    public function travel()
    {
        return $this->belongsTo('App\Travel');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }
}
