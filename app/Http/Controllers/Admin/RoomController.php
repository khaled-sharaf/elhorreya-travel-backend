<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{

    public function index(Request $request)
    {
        $length = $request->length;
        $sortBy = $request->sortBy;
        $dir = $request->dir;
        $draw = $request->draw;
        $searchValue = $request->search;
        $display = $request->display;
        $hotel_id = $request->hotel_id;
        $trashed = $request->trashed;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $query = Room::select('*')->orderBy($sortBy, $dir)->with(['user', 'hotel']);

        if ($trashed == 0) {
            $query->onlyTrashed();
        } else if ($trashed == 2) {
            $query->withTrashed();
        }

        if ($display != '') {
            $query->where('display', $display);
        }

        if ($hotel_id != '') {
            $query->where('hotel_id', $hotel_id);
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
                    $query->where('info', 'like', '%' . $searchValue . '%')
                    ->orWhere('id', $searchValue)
                    ->orWhere('options', 'like', '%' . $searchValue . '%')
                    ->orWhere('price_night', 'like', '%' . $searchValue . '%');
                });
            }
        }

        $rooms = $query->paginate($length);
        return response(['data' => $rooms, 'draw' => $draw, 'sortBy' => $sortBy, 'dir' => $dir]);
    }


    public function store(Request $request)
    {
        $this->validate(request(), [
            'info' => 'required|string|between:5,180',
            'options' => 'required|string',
            'price_night' => 'required|numeric',
            'offer_days' => 'nullable|numeric|required_with:offer_price',
            'offer_price' => 'nullable|numeric|required_with:offer_days',
            'hotel_id' => 'required|exists:hotels,id',
            'display' => 'required|in:0,1',
        ]);
        $request->merge(['user_id' => auth()->id()]);
        Room::create($request->all());
        return response(['message' => 'Room has been created.']);
    }


    public function show($id)
    {
        $room = Room::find($id);
        return response(['room' => $room]);
    }


    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'info' => 'required|string|between:5,180',
            'options' => 'required|string',
            'price_night' => 'required|numeric',
            'offer_days' => 'nullable|numeric|required_with:offer_price',
            'offer_price' => 'nullable|numeric|required_with:offer_days',
            'hotel_id' => 'required|exists:hotels,id',
            'display' => 'required|in:0,1',
        ]);
        $room = Room::find($id);
        $room->update($request->all());
        $room = Room::find($id);
        return response(['room' => $room, 'message' => 'Room has been updated.']);
    }


    public function destroy($id)
    {
        $hotel = Room::withTrashed()->where('id', $id)->first();
        if ($hotel->trashed()) {
            $hotel->forceDelete();
        } else {
            $hotel->delete();
        }
        return response(['status' => true]);
    }


    public function restoreRoom($id)
    {
        $hotel_deleted = Room::onlyTrashed()->where('id', $id)->first();
        $hotel_deleted->restore();
        return response(['status' => true]);
    }
}
