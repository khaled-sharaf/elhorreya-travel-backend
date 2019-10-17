<?php

namespace App\Http\Controllers\API;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{


    public function getSettings()
   {
       return response(['settings' => Setting::getSettings()]);
   }

}
