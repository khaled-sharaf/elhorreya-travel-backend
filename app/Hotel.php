<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Scopes\RoomsWithHotel;

class Hotel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'address', 'rating', 'stars', 'info', 'longitude', 'latitude', 'image', 'gallery', 'features', 'display', 'user_id'
    ];

    public function scopeDisplay($query)
    {
        return $query->where('display', 1);
    }


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function travels()
    {
        return $this->hasMany('App\Travel');
    }

    public function rooms()
    {
        return $this->hasMany('App\Room');
    }

    protected static function boot() {
        parent::boot();

        static::addGlobalScope(new RoomsWithHotel);
    }

}
