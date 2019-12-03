<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Scopes\ScopesMarketingHotel;

class MarketingHotel extends Model
{
    use SoftDeletes;

    protected $table = 'marketing_hotels';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'address', 'stars', 'info', 'longitude', 'latitude', 'image', 'gallery', 'features', 'display', 'user_id'
    ];

    public function scopeDisplay($query)
    {
        return $query->where('display', 1);
    }

    public function scopePaginateConvert($query, $length)
    {
        $hotels_paginate = $query->paginate($length);
        $itemsTransformed = $hotels_paginate
            ->getCollection()
            ->map(function($item) {
                $data = convert_column_to_array($item, 'gallery');
                $data = convert_column_to_array($data, 'features');
                return $data;
        })->toArray();
        return paginate_collection($hotels_paginate, $itemsTransformed);
    }

    public function scopeGetConvert($query)
    {
        $hotels = $query->get();
        if ($hotels->count() > 0) {
            $hotels = convert_column_to_array($hotels, 'features');
            $hotels = convert_column_to_array($hotels, 'gallery');
        }
        return $hotels;
    }

    public function scopeFindConvert($query, $id)
    {
        $hotel = $query->find($id);
        if ($hotel != null) {
            $hotel = convert_column_to_array($hotel, 'features');
            $hotel = convert_column_to_array($hotel, 'gallery');
        }
        return $hotel;
    }


    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function rooms()
    {
        return $this->hasMany('App\MarketingRoom');
    }

    protected static function boot() {
        parent::boot();

        static::addGlobalScope(new ScopesMarketingHotel);
    }

}
