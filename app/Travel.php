<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Travel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'address_from', 'info', 'image', 'gallery', 'type', 'umrah_date', 'haram_distance', 'favorite_company', 'display', 'hotel_id', 'travel_type_id', 'user_id'
    ];

    public function scopeDisplay($query)
    {
        return $query->where('display', 1);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function hotel()
    {
        return $this->belongsTo('App\Hotel');
    }

    public function travel_type()
    {
        return $this->belongsTo('App\TravelType');
    }

    public function travel_details()
    {
        return $this->hassMany('App\TravelDetails');
    }

    public function bookings()
    {
        return $this->hassMany('App\Booking');
    }
}
