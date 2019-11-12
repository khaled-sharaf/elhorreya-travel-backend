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


   public function addVisitor()
   {
       $old_count_visitor = Setting::where('name', 'visitors')->first();
       $old_count_visitor_val = $old_count_visitor->value;
       $old_count_visitor->value = $old_count_visitor_val + 1;
       $old_count_visitor->save();
       return response(['status' => true, 'visitors' => $old_count_visitor->value]);
   }

}
