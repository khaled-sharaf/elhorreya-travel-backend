<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{


    public function index()
    {
        $blogs = Blog::display()->latest()->paginateConvert(10);
        return response(['blogs' => $blogs]);
    }


    public function show(Request $request)
    {
        $id = $request->id;
        $blog = Blog::display()->findConvert($id);
        $blog_arr = collect($blog)->toArray();
        $blog = key_exists('id', $blog_arr) ? $blog : null;
        return response(['blog' => $blog]);
    }

}
