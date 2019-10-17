<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ContactUs;
use App\Setting;
use App\Mail\ContactUsMail;
use Mail;

class ContactUsController extends Controller
{

    private $patternPhone = "/^\+?\d{10,14}$/";

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|between:3,50',
            'email' => 'required|email|string|max:100',
            'phone' => 'nullable|regex:' . $this->patternPhone,
            'message' => 'required|string|max:5000'
        ]);
        ContactUs::create($request->all());

        // send form to mail
        $email = Setting::getSettings()['email'];
        Mail::to($email)->send(new ContactUsMail($request->toArray()));

        return response(['status' => true, 'message' => 'تم إرسال رسالتك بنجاح.']);
    }
}
