<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Image as ImageModel;
use Illuminate\Http\Request;
use Image;
use File;
use Carbon\Carbon;


class ImageController extends Controller
{

    private $directory = 'images/images';

    public function index(Request $request)
    {
        $length = $request->length;
        $sortBy = $request->sortBy;
        $dir = $request->dir;
        $draw = $request->draw;
        $travel_category_id = $request->travel_category_id;
        $display = $request->display;
        $trashed = $request->trashed;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $query = ImageModel::select('*')->orderBy($sortBy, $dir)->with(['user', 'travel_category']);

        if ($travel_category_id != '') {
            $query->where('travel_category_id', $travel_category_id);
        }

        if ($trashed == 0) {
            $query->onlyTrashed();
        } else if ($trashed == 2) {
            $query->withTrashed();
        }

        if ($display != '') {
            $query->where('display', $display);
        }

        if ($from_date != '') {
            $query->whereDate('created_at', '>=', $from_date);
        }

        if ($to_date != '') {
            $query->whereDate('created_at', '<=', $to_date);
        }

        $images = $query->paginate($length);
        return response(['data' => $images, 'draw' => $draw, 'sortBy' => $sortBy, 'dir' => $dir]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'travel_category_id' => 'required|exists:travel_categories,id',
            'display' => 'required|in:0,1',
            'gallery' => 'required|array|max:10',
        ]);

        $directory = $this->directory;
        if (!is_dir(public_path($directory))) {
            File::makeDirectory(public_path($directory), 0777, true);
        }

        $data = [];

        foreach ($request->gallery as $image) {
            $get_ext = explode(';', explode('/', $image['value'])[1])[0];
            $ext = $get_ext == 'jpeg' ? 'jpg' : $get_ext;
            $imageNewName =  uniqid('image-') . '.' . $ext;
            $imagePath = $directory . '/' . $imageNewName;
            if (is_dir(public_path($directory))) {
                Image::make($image['value'])->save(public_path($imagePath));
                $data[] = [
                    'name' => $imagePath,
                    'user_id' => auth()->id(),
                    'display' => $request->display,
                    'travel_category_id' => $request->travel_category_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
        }
        ImageModel::insert($data);
        return response(['message' => 'Images has been created.']);
    }


    public function show($id)
    {
        $image = ImageModel::find($id);
        return response(['image' => $image]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'display' => 'required|in:0,1',
            'image' => 'required|string',
        ]);

        $directory = $this->directory;
        $data = $request->except('image');
        $image = ImageModel::find($id);

        if (strpos($request->image, 'data:image/') === 0) {
            $get_ext = explode(';', explode('/', $request->image)[1])[0];
            $ext = $get_ext == 'jpeg' ? 'jpg' : $get_ext;
            $imageNewName =  uniqid('image-') . '.' . $ext;
            $imagePath = $directory . '/' . $imageNewName;

            // delete old image if exists
            if ($image->name !== null) {
                if (file_exists(public_path($image->name))) {
                    unlink(public_path($image->name));
                }
            }
            /*================================================*/
            Image::make($request->image)->save(public_path($imagePath));
            $data['name'] = $imagePath;
        }
        /****************************************************************************/
        $image->update($data);
        $updatedImage = ImageModel::find($id);
        return response(['message' => 'Image has been updated.', 'image' => $updatedImage]);
    }


    public function destroy($id)
    {
        $image = ImageModel::withTrashed()->where('id', $id)->first();
        if ($image->trashed()) {
            // delete image
            if ($image->name !== null) {
                if (file_exists(public_path($image->name))) {
                    unlink(public_path($image->name));
                }
            }
            $image->forceDelete();
        } else {
            $image->delete();
        }
        return response(['status' => true]);
    }


    public function restoreImage($id)
    {
        $image_deleted = ImageModel::onlyTrashed()->where('id', $id)->first();
        $image_deleted->restore();
        return response(['status' => true]);
    }


    public function deleteRestoreMulti(Request $request)
    {
        $ids = $request->ids;
        $action = $request->action;

        if ($action == 'delete') {
            ImageModel::destroy($ids);
        } else if ($action == 'force_delete') {
            $images = ImageModel::onlyTrashed()->whereIn('id', $ids)->get();
            foreach ($images as $image) {
                if ($image->name !== null) {
                    if (file_exists(public_path($image->name))) {
                        unlink(public_path($image->name));
                    }
                }
            }
            ImageModel::onlyTrashed()->whereIn('id', $ids)->forceDelete();
        } else if ($action == 'restore') {
            ImageModel::onlyTrashed()->whereIn('id', $ids)->restore();
        }

        return response(['status' => true]);
    }



}
