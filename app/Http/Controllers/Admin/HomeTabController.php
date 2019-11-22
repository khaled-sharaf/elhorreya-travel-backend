<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\HomeTab as Tabs;
use App\Travel;
use Illuminate\Http\Request;

class HomeTabController extends Controller
{

    public function index()
    {
        $tabs = Tabs::get();
        foreach ($tabs as $tab) {
            $tab->categories = json_decode($tab->categories);
            $tab->travels = json_decode($tab->travels);
            $tab->original_travels = [];
        }
        return response(['tabs' => $tabs]);
    }

    public function getTravelsByCategories(Request $request) {
        $travels = count($request->categories) ? Travel::display()->whereIn('travel_category_id', $request->categories)->orderBy('id', 'desc')->get() : [];
        return response(['travels' => $travels]);
    }


    public function update(Request $request)
    {
        $request->validate([
            'tabs.*.name' => 'required|string|max:20|min:3',
            'tabs.*.categories' => 'required|array|min:1',
            'tabs.*.travels' => 'required|array|min:1',
        ]);
        $data = $request->toArray();

        foreach ($data['tabs'] as $tab) {
            $tabDB = Tabs::find($tab['id']);
            $tab['categories'] = json_encode($tab['categories']);
            $tab['travels'] = json_encode($tab['travels']);
            $tabDB->update($tab);
        }
        return response(['message' => 'Tabs has been updated.']);
    }

}
