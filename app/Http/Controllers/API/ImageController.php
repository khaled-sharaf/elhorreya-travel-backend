<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Image;
use Illuminate\Http\Request;



class ImageController extends Controller
{


    public function imagesByCategory(Request $request)
    {
        $category_id = $request->category_id;

        $images = Image::display()->where('travel_category_id', $category_id)->with('category')->latest()->paginate(10);

        return response(['images' => $images]);
    }

    public function testimonials() {
        $images = Image::display()->where('travel_category_id', 999999999)->orderBy('id', 'desc')->get();

        return response(['images' => $images]);
    }

}
