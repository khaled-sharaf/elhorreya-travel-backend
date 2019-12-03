<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Travel;
use App\TravelDetail;
use App\Scopes\CountsWithTravel;
use App\HomeTab as Tabs;

class TravelController extends Controller
{

    public function getMinMaxPrice()
    {
        return response(['min' => TravelDetail::min('single_price'), 'max' => TravelDetail::max('triple_price')]);
    }

    public function umrahDates()
    {
        return response(['dates' => Travel::withoutGlobalScope(CountsWithTravel::class)
        ->where('umrah_date', '!=', null)
        ->groupBy('umrah_date')
        // ->distinct()
        ->select('umrah_date')->get()->pluck('umrah_date')]);
    }

    public function search(Request $request)
    {

        $search = $request->search;
        $category = $request->category;
        $hotel_address = $request->hotel_address;
        $go_and_back = $request->go_and_back;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $filter_to_price = $request->filter_to_price;
        $filter_from_price = $request->filter_from_price;
        $filter_stars = $request->filter_stars;
        $filter_hotel = $request->filter_hotel;
        $sortBy = $request->sortBy;

        $travelsResult = [];

        if ($search && $search === 'search') {
            $query = Travel::display();

            if ($category != '' && $category != '0') {
                $query->where('travel_category_id', $category);
            }

            if ($hotel_address != '') {
                $query->whereHas('hotel', function ($q) use ($hotel_address) {
                    $q->where('address', 'like', '%' . $hotel_address . '%');
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
                    $q->whereDate('date_to', '<=', $date_to);
                });
            }

            // filter

            if ($filter_from_price != '') {
                $query->whereHas('offers', function ($q) use ($filter_from_price) {
                    $q->where('single_price', '>=', $filter_from_price);
                });
            }

            if ($filter_to_price != '') {
                $query->whereHas('offers', function ($q) use ($filter_to_price) {
                    $q->where('single_price', '<=', $filter_to_price);
                });
            }

            if ($filter_stars != '') {
                $query->whereHas('hotel', function ($q) use ($filter_stars) {
                    $q->where('stars', '<=', $filter_stars);
                });
            }

            if ($filter_hotel != '') {
                $query->where('hotel_id', $filter_hotel);
            }

            $travels = $query->paginateConvert(9);

            if ($sortBy === 'favorite') {
                $query->orderBy('favorite_company', 'desc');
            } else if ($sortBy === 'haram_near') {
                $query->orderBy('haram_distance', 'desc');
            } else if ($sortBy === 'haram_far') {
                $query->orderBy('haram_distance', 'asc');
            }

            if ($sortBy == '') {
                $query->latest();
            }

            $travels = $query->paginateConvert(12);

            if ($sortBy === 'price' || $sortBy === 'days' || $sortBy === 'stars') {
                $itemsTransformed = $travels->getCollection()
                    ->sortBy(function ($travel, $key) use ($sortBy) {
                        if ($sortBy === 'price') {
                            return $travel['offers'][0]['single_price'];
                        } else if ($sortBy === 'days') {
                            return $travel['offers'][0]['time_period'];
                        } else if ($sortBy === 'stars') {
                            return $travel['hotel']['stars'];
                        }
                    })->values()->toArray();
                $travels = paginate_collection($travels, $itemsTransformed);
            }
        }

        return response(['data' => $travels]);
    }


    public function bestTravelsOffer()
    {
        // $travels['pilgrimage_umrah'] = Travel::display()->where('type', 'pilgrimage')
        //                                 ->orWhere('type', 'umrah')
        //                                 ->latest()->take(6)->getConvert();

        // $travels['internal_travel'] = Travel::display()->where('type', 'internal')->latest()->take(6)->getConvert();

        // $travels['honeymoon'] = Travel::display()->whereHas('travel_category', function ($query) {
        //     $query->where('type', 5);
        // })->latest()->take(6)->getConvert();

        $tabs = Tabs::get();
        foreach ($tabs as $tab) {
            $tab->categories = json_decode($tab->categories);
            $tab->travels = count(json_decode($tab->travels)) ? Travel::display()->whereIn('id', json_decode($tab->travels))->orderBy('id', 'desc')->getConvert() : [];
        }

        return response(['tabs' => $tabs]);
    }

    public function getBestTravelsExternal(Request $request) {
        $hotels_addresses = $request->hotels_addresses;
        $travels = [];

        foreach ($hotels_addresses as $address) {
            $travels[] = Travel::display()
            ->whereHas('hotel', function ($query) use ($address) {
                $query->where('address', 'like', '%' . $address . '%');
            })
            ->where('type', 'external')->latest()->take(3)->getConvert();
        }
        $travels = collect($travels)->filter(function ($travel) {
            return count($travel) > 0;
        })->slice(0, 4)->all();

        return response(['travels' => $travels]);
    }


    public function getByCategory(Request $request) {
        $category_id = $request->category_id;
        $hotel_address = $request->hotel_address;
        $filter_name = $request->filter_name;
        $filter_to_price = $request->filter_to_price;
        $filter_from_price = $request->filter_from_price;
        $filter_stars = $request->filter_stars;
        $filter_hotel = $request->filter_hotel;
        $umrah_date = $request->umrah_date;
        $sortBy = $request->sortBy;

        // $column = $category_id == 'external' ? 'type' : 'travel_category_id';
        // $query = Travel::display()->where($column, $category_id);
        $query = Travel::display()->where('travel_category_id', $category_id);

        if ($hotel_address != '') {
            $query->whereHas('hotel', function ($q) use ($hotel_address) {
                $q->where('address', 'like', '%' . $hotel_address . '%');
            });
        }

        if ($filter_from_price != '') {
            $query->whereHas('offers', function ($q) use ($filter_from_price) {
                $q->where('single_price', '>=', $filter_from_price);
            });
        }

        if ($filter_to_price != '') {
            $query->whereHas('offers', function ($q) use ($filter_to_price) {
                $q->where('single_price', '<=', $filter_to_price);
            });
        }

        if ($filter_stars != '') {
            $query->whereHas('hotel', function ($q) use ($filter_stars) {
                $q->where('stars', '<=', $filter_stars);
            });
        }

        if ($filter_name != '') {
            $query->where('name', 'like', '%' . $filter_name . '%');
        }

        if ($filter_hotel != '') {
            $query->where('hotel_id', $filter_hotel);
        }

        if ($umrah_date != '') {
            $query->where('umrah_date', $umrah_date);
        }


        if ($sortBy === 'favorite') {
            $query->orderBy('favorite_company', 'desc');
        } else if ($sortBy === 'haram_near') {
            $query->orderBy('haram_distance', 'desc');
        } else if ($sortBy === 'haram_far') {
            $query->orderBy('haram_distance', 'asc');
        }

        if ($sortBy == '') {
            $query->latest();
        }

        $travels = $query->paginateConvert(12);

        if ($sortBy === 'price' || $sortBy === 'days' || $sortBy === 'stars') {
            $itemsTransformed = $travels->getCollection()
                ->sortBy(function ($travel, $key) use ($sortBy) {
                    if ($sortBy === 'price') {
                        return $travel['offers'][0]['single_price'];
                    } else if ($sortBy === 'days') {
                        return $travel['offers'][0]['time_period'];
                    } else if ($sortBy === 'stars') {
                        return $travel['hotel']['stars'];
                    }
                })->values()->toArray();
            $travels = paginate_collection($travels, $itemsTransformed);
        }
        return response(['travels' => $travels]);
    }



    public function show(Request $request)
    {
        $id = $request->id;
        $travel = travel::display()->findConvert($id);
        $travel_arr = collect($travel)->toArray();
        $travel = key_exists('id', $travel_arr) ? $travel : null;
        return response(['travel' => $travel]);
    }


    public function others(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $type = $request->type;
        $hotel_address = $request->hotel_address;

        $travels = Travel::display()

            ->where('type', $type)
            ->where('id', '!=', $id)
            ->whereHas('hotel', function ($q) use ($hotel_address) {
                $q->orWhere('address', 'like', '%' . $hotel_address . '%');
            })
            ->latest()->take(9)->getConvert();

        return response(['travels' => $travels]);
    }



    public function flightVisas(Request $request) {
        $name = $request->name;
        $value = '';
        if ($name === 'flight') {
            $value = 'external_fly';
        } else if ($name === 'visas') {
            $value = 'external_visa';
        }
        $travels = Travel::display()->where('type', $value)->orderBy('id', 'desc')->paginateConvert(8);
        return response(['travels' => $travels]);
    }

}
