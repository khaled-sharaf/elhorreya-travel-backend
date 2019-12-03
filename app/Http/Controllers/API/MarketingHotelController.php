<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MarketingHotel as Hotel;

class MarketingHotelController extends Controller
{

    public function getAddressAll()
    {
        $hotels = Hotel::display()->latest()->with('travels')->getConvert();
        return response(['data' => $hotels]);
    }


    public function index(Request $request)
    {
        $name = $request->name;
        $city = $request->city;
        $stars = $request->stars;
        $sortBy = $request->sortBy != '' ? $request->sortBy : 'id';

        $query = Hotel::display();

        if ($name != '') {
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($city != '') {
            $query->where('address', 'like', '%' . $city . '%');
        }

        if ($stars != '') {
            $query->where('stars', '<=', $stars);
        }

        $hotels = $query->orderBy($sortBy, 'desc')->paginateConvert(12);

        return response(['hotels' => $hotels]);
    }

    public function show(Request $request)
    {
        $id = $request->id;
        $hotel = Hotel::display()->findConvert($id);
        $hotel_arr = collect($hotel)->toArray();
        $hotel = key_exists('id', $hotel_arr) ? $hotel : null;
        return response(['hotel' => $hotel]);
    }


    public function others(Request $request)
    {
        $id = $request->id;
        $address = $request->address;

        $hotels = Hotel::
            display()
            ->where('address', 'like', '%' . $address . '%')
            ->where('id', '!=', $id)
            ->latest()->take(6)->getConvert();

        return response(['hotels' => $hotels]);
    }

}
