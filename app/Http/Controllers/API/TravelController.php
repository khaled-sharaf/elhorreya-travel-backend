<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Travel;

class TravelController extends Controller
{

    public function search(Request $request) {

        $search = $request->search;
        $category = $request->category;
        $hotel_address = $request->hotel_address;
        $go_and_back = $request->go_and_back;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $adults = $request->adults;
        $children = $request->children;
        $filter_price = $request->filter_price;
        $filter_stars = $request->filter_stars;

        $travelsResult = [];

        if ($search && $search === 'search') {
            $query = Travel::select('*');

            if ($category != '' && $category != '0') {
                $query->where('travel_category_id', $category);
            }

            if ($hotel_address != '') {
                $query->whereHas('hotel', function ($q) use ($hotel_address) {
                    $q->where('address', $hotel_address);
                });
            }

            if ($go_and_back != '') {
                $query->whereHas('offers', function ($q) use ($go_and_back) {
                    $q->where('go_and_back', $go_and_back);
                });
            }

            if ($date_from != '') {
                $query->whereHas('offers', function ($q) use ($date_from) {
                    $q->whereDate('date_from', '>=', $date_from);
                });
            }

            if ($date_to != '') {
                $query->whereHas('offers', function ($q) use ($date_to) {
                    $q->whereDate('date_to', '>=', $date_to);
                });
            }

            if ($adults != '') {
                $query->whereHas('offers', function ($q) use ($adults) {
                    $q->where('adults', $adults);
                });
            }

            if ($children != '') {
                $query->whereHas('offers', function ($q) use ($children) {
                    $q->where('children', $children);
                });
            }

            // filter

            if ($filter_price != '') {
                $query->whereHas('offers', function ($q) use ($filter_price) {
                    $q->where('single_price', '<=', $filter_price)
                      ->orWhere('twin_price', '<=', $filter_price)
                      ->orWhere('triple_price', '<=', $filter_price);
                });
            }

            if ($filter_stars != '') {
                $query->whereHas('hotel', function ($q) use ($filter_stars) {
                    $q->where('stars', '<=', $filter_stars);
                });
            }

            $travelsResult = $query->paginateConvert(2);
        }

        return response(['data' => $travelsResult]);
    }
}
