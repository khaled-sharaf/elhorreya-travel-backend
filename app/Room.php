<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'info', 'options', 'price_night', 'offer_price', 'offer_days', 'display', 'hotel_id', 'user_id'
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
}
