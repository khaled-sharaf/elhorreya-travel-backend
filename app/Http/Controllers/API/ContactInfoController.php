<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{



    public function index(Request $request)
    {
        $branches = ContactInfo::display()->get();
        return response(['branches' => $branches]);
    }

}
