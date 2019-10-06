<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\TravelCategory;
use Illuminate\Http\Request;
use Image;
use File;

class TravelCategoryController extends Controller
{

    private $directory = 'images/travel_categories';

    public function TravelCategoriesSelect()
    {
        $travel_categories = TravelCategory::select(['id', 'name'])->get();
        return response(['travel_categories' => $travel_categories]);
    }

    public function index(Request $request)
    {
        $length = $request->length;
        $sortBy = $request->sortBy;
        $dir = $request->dir;
        $draw = $request->draw;
        $searchValue = $request->search;
        $trashed = $request->trashed;
        $travel_program_id = $request->travel_program_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $query = TravelCategory::select('*')->orderBy($sortBy, $dir)->with(['user', 'travel_program']);

        if ($trashed == 0) {
            $query->onlyTrashed();
        } else if ($trashed == 2) {
            $query->withTrashed();
        }

        if ($travel_program_id != '' && $travel_program_id != null) {
            $query->where('travel_program_id', $travel_program_id);
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
                    ->orWhere('id', $searchValue);
                });
            }
        }

        $travel_categories = $query->paginate($length);
        return response(['data' => $travel_categories, 'draw' => $draw, 'sortBy' => $sortBy, 'dir' => $dir]);
    }


    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required|string|between:2,180',
            'image' => 'required|string',
            'order' => 'nullable|integer|min:1',
            'travel_program_id' => 'required|exists:travel_programs,id',
        ]);

        $data = $request->toArray();

        // handel image
        $directory = $this->directory;
        if (strpos($data['image'], 'data:image/') === 0) {
            $get_ext = explode(';', explode('/', $data['image'])[1])[0];
            $ext = $get_ext == 'jpeg' ? 'jpg' : $get_ext;
            $imageNewName =  uniqid('travel-category-image-') . '.' . $ext;
            $imagePath = $directory . '/' . $imageNewName;
            if (!is_dir(public_path($directory))) {
                File::makeDirectory(public_path($directory), 0777, true);
            }
            Image::make($data['image'])->save(public_path($imagePath));
            $data['image'] = $imagePath;
        }
        /****************************************************************************/

        // add to DB

        $data['user_id'] = auth()->id();
        TravelCategory::create($data);
        return response(['message' => 'Travel category has been created.']);
    }


    public function show($id)
    {
        $travel_category = TravelCategory::find($id);
        return response(['travel_category' => $travel_category]);
    }


    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'name' => 'required|string|between:2,180',
            'image' => 'required|string',
            'order' => 'nullable|integer|min:1',
            'travel_program_id' => 'required|exists:travel_programs,id',
        ]);

        $travel_category = TravelCategory::find($id);
        $data = $request->toArray();

        // save image is exists
        $directory = $this->directory;
        if (strpos($data['image'], 'data:image/') === 0) {
            $get_ext = explode(';', explode('/', $data['image'])[1])[0];
            $ext = $get_ext == 'jpeg' ? 'jpg' : $get_ext;
            $imageNewName =  uniqid('travel-category-image-') . '.' . $ext;
            $imagePath = $directory . '/' . $imageNewName;

            // delete old image if exists
            if ($travel_category->image !== null) {
                if (file_exists(public_path($travel_category->image))) {
                    unlink(public_path($travel_category->image));
                }
            }
            /*================================================*/
            Image::make($data['image'])->save(public_path($imagePath));
            $data['image'] = $imagePath;
        }
        /****************************************************************************/

        $travel_category->update($data);
        $updatedTravelCategory = TravelCategory::find($id);
        return response(['message' => 'Travel category has been updated.', 'travel_category' => $updatedTravelCategory]);
    }


    public function destroy($id)
    {
        $travel_category = TravelCategory::withTrashed()->where('id', $id)->first();
        if ($travel_category->trashed()) {
            // delete image
            if (file_exists(public_path($travel_category->image))) {
                unlink(public_path($travel_category->image));
            }
            $travel_category->forceDelete();
        } else {
            $travel_category->delete();
        }
        return response(['status' => true]);
    }


    public function restoreTravelCategory($id)
    {
        $travel_category_deleted = TravelCategory::onlyTrashed()->where('id', $id)->first();
        $travel_category_deleted->restore();
        return response(['status' => true]);
    }


    public function deleteRestoreMulti(Request $request)
    {
        $ids = $request->ids;
        $action = $request->action;

        if ($action == 'delete') {
            TravelCategory::destroy($ids);
        } else if ($action == 'force_delete') {
            $travel_categories = TravelCategory::onlyTrashed()->whereIn('id', $ids)->get();
            foreach ($travel_categories as $travel_category) {
                if ($travel_category->image !== null) {
                    if (file_exists(public_path($travel_category->image))) {
                        unlink(public_path($travel_category->image));
                    }
                }
            }
            TravelCategory::onlyTrashed()->whereIn('id', $ids)->forceDelete();
        } else if ($action == 'restore') {
            TravelCategory::onlyTrashed()->whereIn('id', $ids)->restore();
        }

        return response(['status' => true]);
    }
}
