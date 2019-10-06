<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{

    public function index(Request $request)
    {
        $length = $request->length;
        $sortBy = $request->sortBy;
        $dir = $request->dir;
        $draw = $request->draw;
        $searchValue = $request->search;
        $travel_id = $request->travel_id;
        $trashed = $request->trashed;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $query = Booking::select('*')->orderBy($sortBy, $dir)->with(['offer', 'travel']);

        if ($trashed == 0) {
            $query->onlyTrashed();
        } else if ($trashed == 2) {
            $query->withTrashed();
        }

        if ($travel_id != '') {
            $query->where('travel_id', $travel_id);
        }

        if ($from_date != '') {
            $query->whereDate('created_at', '>=', $from_date);
        }

        if ($to_date != '') {
            $query->whereDate('created_at', '<=', $to_date);
        }


        if ($searchValue) {
            if (strpos($searchValue,  ':') != false) {
                $columnSearch = explode(':', $searchValue)[0];
                $valueColumn = explode(':', $searchValue)[1];
                if ($columnSearch != 'id') {
                    $query->where($columnSearch, 'like', '%' . $valueColumn . '%');
                } else {
                    $query->where($columnSearch, $valueColumn);
                }
            } else {
                $query->where(function($query) use ($searchValue) {
                    $query->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', $searchValue)
                    ->orWhere('phone', 'like', '%' . $searchValue . '%');
                });
            }
        }

        $rooms = $query->paginate($length);
        return response(['data' => $rooms, 'draw' => $draw, 'sortBy' => $sortBy, 'dir' => $dir]);
    }


    public function destroy($id)
    {
        $booking = Booking::withTrashed()->where('id', $id)->first();
        if ($booking->trashed()) {
            $booking->forceDelete();
        } else {
            $booking->delete();
        }
        return response(['status' => true]);
    }


    public function restoreBooking($id)
    {
        $booking_deleted = Booking::onlyTrashed()->where('id', $id)->first();
        $booking_deleted->restore();
        return response(['status' => true]);
    }


    public function deleteRestoreMulti(Request $request)
    {
        $ids = $request->ids;
        $action = $request->action;

        if ($action == 'delete') {
            Booking::destroy($ids);
        } else if ($action == 'force_delete') {
            Booking::onlyTrashed()->whereIn('id', $ids)->forceDelete();
        } else if ($action == 'restore') {
            Booking::onlyTrashed()->whereIn('id', $ids)->restore();
        }

        return response(['status' => true]);
    }
}
