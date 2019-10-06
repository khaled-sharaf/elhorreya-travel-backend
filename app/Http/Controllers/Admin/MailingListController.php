<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\MailingList;
use Illuminate\Http\Request;

class MailingListController extends Controller
{

    public function index(Request $request)
    {
        $length = $request->length;
        $sortBy = $request->sortBy;
        $dir = $request->dir;
        $draw = $request->draw;
        $searchValue = $request->search;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $query = MailingList::select('*')->orderBy($sortBy, $dir);

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
                    $query->where('email', 'like', '%' . $searchValue . '%');
                });
            }
        }

        $rooms = $query->paginate($length);
        return response(['data' => $rooms, 'draw' => $draw, 'sortBy' => $sortBy, 'dir' => $dir]);
    }


    public function destroy($id)
    {
        MailingList::destroy($id);
        return response(['status' => true]);
    }



    public function deleteRestoreMulti(Request $request)
    {
        $ids = $request->ids;
        MailingList::destroy($ids);
        return response(['status' => true]);
    }
}
