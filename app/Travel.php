<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


use App\Scopes\CountsWithTravel;

class Travel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'address_from',
        'address_to',
        'info',
        'image',
        'gallery',
        'type',
        'umrah_date',
        'haram_distance',
        'itinerary_1',
        'itinerary_2',
        'itinerary_3',
        'itinerary_4',
        'itinerary_5',
        'discount',
        'favorite_company',
        'display',
        'hotel_id',
        'hotel_2_id',
        'travel_category_id',
        'user_id'
    ];

    public function scopeDisplay($query)
    {
        return $query->where('display', 1);
    }

    public function scopePaginateConvert($query, $length)
    {
        $travels_paginate = $query->paginate($length);

        $itemsTransformed = $travels_paginate
            ->getCollection()
            ->map(function($item) {
                return convert_column_to_array($item, 'gallery');
        })->toArray();
        return paginate_collection($travels_paginate, $itemsTransformed);
    }

    public function scopeGetConvert($query)
    {
        $travels = $query->get();
        if ($travels->count() > 0) {
            $travels = convert_column_to_array($travels, 'gallery');
        }
        return $travels;
    }

    public function scopeFindConvert($query, $id)
    {
        $travel = $query->find($id);
        if ($travel != null) {
            $travel = convert_column_to_array($travel, 'gallery');
        }
        return $travel;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function hotel()
    {
        return $this->belongsTo('App\Hotel');
    }

    public function hotel_2()
    {
        return $this->belongsTo('App\Hotel');
    }

    public function travel_category()
    {
        return $this->belongsTo('App\TravelCategory');
    }

    public function offers()
    {
        return $this->hasMany('App\TravelDetail');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    protected static function boot() {
        parent::boot();

        static::addGlobalScope(new CountsWithTravel);
    }
}
