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


    public function scopePaginateConvert($query, $length)
    {
        $blogs_paginate = $query->paginate($length);

        $itemsTransformed = $blogs_paginate
            ->getCollection()
            ->map(function($item) {
                return convert_column_to_array($item, 'gallery');
        })->toArray();
        return paginate_collection($blogs_paginate, $itemsTransformed);
    }

    public function scopeGetConvert($query)
    {
        $blogs = $query->get();
        if ($blogs->count() > 0) {
            $blogs = convert_column_to_array($blogs, 'gallery');
        }
        return $blogs;
    }

    public function scopeFindConvert($query, $id)
    {
        $blog = $query->find($id);
        if ($blog != null) {
            $blog = convert_column_to_array($blog, 'gallery');
        }
        return $blog;
    }

}
