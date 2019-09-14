<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'content', 'image', 'gallery', 'display', 'user_id'
    ];

    public function scopeDisplay($query)
    {
        return $query->where('display', 1);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
