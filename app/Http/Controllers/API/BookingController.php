<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Booking;
use Illuminate\Http\Request;
use App\TravelDetail;
use App\Setting;
use App\Mail\BookingMail;
use Mail;


class BookingController extends Controller
{
    private $patternPhone = "/^\+?\d{10,14}$/";


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|between:3,50',
            'email' => 'required|email|string|max:100',
            'phone' => 'nullable|regex:' . $this->patternPhone,
            'message' => 'required|string|max:1000',
            'travel_detail_id' => 'required|exists:travel_details,id'
        ]);
        $offer = TravelDetail::find($request->travel_detail_id);
        $request->merge(['travel_id' => $offer->travel_id]);
        Booking::create($request->all());

        // send form to mail
        $email = Setting::getSettings()['email'];
        Mail::to($email)->send(new BookingMail($request->toArray()));

        return response(['status' => true, 'message' => 'تم إرسال طلبك بنجاح.']);
    }


}
