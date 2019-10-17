<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Hotel;

class HotelController extends Controller
{

    public function getAddressAll() {
        $hotels = Hotel::get();
        return response(['data' => $hotels]);
    }
}
