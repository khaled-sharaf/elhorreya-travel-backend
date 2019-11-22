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
            'name' => 'required|string|between:2,50',
            'email' => 'nullable|email|string|max:100',
            'phone' => 'required|regex:' . $this->patternPhone,
            'message' => 'nullable|string|max:1000',
            'adults' => 'nullable|integer|max:999',
            'children' => 'nullable|integer|max:999',
            'travel_detail_id' => 'required|exists:travel_details,id'
        ]);
        $offer_number = $request->offer_number;
        $offer = TravelDetail::find($request->travel_detail_id);
        $request->merge(['travel_id' => $offer->travel_id]);
        $booking = Booking::create($request->all());

        // send form to mail
        $email = Setting::getSettings()['email'];
        Mail::to($email)->send(new BookingMail($booking->toArray()));

        return response([
            'status' => true,
            'message' => 'تم إرسال طلبك للعرض ' . $offer_number . ' وسيتم التواصل معك  خلال 24 ساعة.'
        ]);
    }


}
