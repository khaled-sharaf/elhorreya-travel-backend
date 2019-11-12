<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\TravelProgram;
use App\Setting;
use Illuminate\Http\Request;

class TravelProgramController extends Controller
{


    public function getMenuAndSettings()
    {
        $menu = TravelProgram::with('categories')->orderBy('order', 'asc')->get();
        return response(['menu' => $menu, 'settings' => Setting::getSettings()]);
    }

}
