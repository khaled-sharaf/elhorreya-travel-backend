<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'email', 'phone', 'message', 'travel_id', 'travel_detail_id'
    ];

    public function travel() {
        return $this->belongsTo('App\Travel');
    }

    public function offer() {
        return $this->belongsTo('App\TravelDetail', 'travel_detail_id');
    }
}
