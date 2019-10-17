<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\TravelProgram;
use Illuminate\Http\Request;

class TravelProgramController extends Controller
{


    public function getMenu()
    {
        $menu = TravelProgram::with('categories')->orderBy('order', 'asc')->get();
        return response(['menu' => $menu]);
    }

}
