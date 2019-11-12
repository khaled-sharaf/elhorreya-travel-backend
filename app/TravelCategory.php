<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TravelCategory extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'type', 'image', 'discount', 'order', 'travel_program_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function travel_program()
    {
        return $this->belongsTo('App\TravelProgram');
    }

    public function travels()
    {
        return $this->belongsTo('App\Travel');
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }
}
