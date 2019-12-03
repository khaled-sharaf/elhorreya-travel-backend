<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{

    private $patternPhone = "/^\+?\d{10,14}$/";

    public function index(Request $request)
    {
        $length = $request->length;
        $sortBy = $request->sortBy;
        $dir = $request->dir;
        $draw = $request->draw;
        $searchValue = $request->search;
        $display = $request->display;
        $query = ContactInfo::select('*')->orderBy($sortBy, $dir);


        if ($display != '') {
            $query->where('display', $display);
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
                    $query->where('branch_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('id', $searchValue)
                    ->orWhere('phone_1', 'like', '%' . $searchValue . '%')
                    ->orWhere('phone_2', 'like', '%' . $searchValue . '%')
                    ->orWhere('phone_3', 'like', '%' . $searchValue . '%')
                    ->orWhere('phone_4', 'like', '%' . $searchValue . '%')
                    ->orWhere('address', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%');
                });
            }
        }

        $Contact_infos = $query->paginate($length);
        return response(['data' => $Contact_infos, 'draw' => $draw, 'sortBy' => $sortBy, 'dir' => $dir]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'branch_name' => 'required|string|between:3,100',
            'phone_1' => 'nullable|regex:' . $this->patternPhone,
            'phone_2' => 'nullable|regex:' . $this->patternPhone,
            'phone_3' => 'nullable|regex:' . $this->patternPhone,
            'phone_4' => 'nullable|regex:' . $this->patternPhone,
            'address' => 'required|string|between:3,190',
            'email' => 'required|email|max:100',
            'latitude' => 'nullable|numeric|required_with:longitude',
            'longitude' => 'nullable|numeric|required_with:latitude',
            'display' => 'required|in:0,1',
        ]);

        ContactInfo::create($request->all());
        return response(['message' => 'Branch has been created.']);
    }

    public function show($id)
    {
        $contact_info = ContactInfo::find($id);
        return response(['contact_info' => $contact_info]);
    }


    public function update(Request $request)
    {
        $request->validate([
            'branch_name' => 'required|string|between:3,100',
            'phone_1' => 'nullable|regex:' . $this->patternPhone,
            'phone_2' => 'nullable|regex:' . $this->patternPhone,
            'phone_3' => 'nullable|regex:' . $this->patternPhone,
            'phone_4' => 'nullable|regex:' . $this->patternPhone,
            'address' => 'required|string|between:3,190',
            'email' => 'required|email|max:100',
            'latitude' => 'nullable|numeric|required_with:longitude',
            'longitude' => 'nullable|numeric|required_with:latitude',
            'display' => 'required|in:0,1',
        ]);

        $contact_info = ContactInfo::find($request->id);

        $contact_info->update($request->all());
        return response(['message' => 'Branch has been updated.']);
    }


    public function destroy($id)
    {
        ContactInfo::destroy($id);
        return response(['status' => true]);
    }


    public function deleteRestoreMulti(Request $request)
    {
        $ids = $request->ids;
        $action = $request->action;

        if ($action == 'delete') {
            ContactInfo::destroy($ids);
        }
        // else if ($action == 'force_delete') {
        //     ContactInfo::onlyTrashed()->whereIn('id', $ids)->forceDelete();
        // } else if ($action == 'restore') {
        //     ContactInfo::onlyTrashed()->whereIn('id', $ids)->restore();
        // }

        return response(['status' => true]);
    }


}
