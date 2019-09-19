<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Hotel;
use App\Room;

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
        ];


        return response(['counts' => $counts]);
    }

}
