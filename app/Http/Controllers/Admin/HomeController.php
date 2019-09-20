<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Hotel;
use App\Room;
use App\TravelProgram;
use App\TravelCategory;
use App\Travel;
use App\Blog;
use App\Booking;
use App\Image;
use App\MailingList;

class HomeController extends Controller
{

    public function index()
    {
        return view('admin.cp_layout');
    }

    public function modelsCounts() {

        $counts = [
            'users' => User::count(),

            'hotels' => Hotel::count(),

            'rooms' => Room::count(),

            'travel_programs' => TravelProgram::count(),

            'travel_categories' => TravelCategory::count(),

            'travels' => Travel::count(),

            'bookings' => Booking::count(),

            'mailing_list' => MailingList::count(),

            'blogs' => Blog::count(),

            'images' => Image::count(),

        ];


        return response(['counts' => $counts]);
    }

}
