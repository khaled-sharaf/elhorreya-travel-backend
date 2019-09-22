<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Hotel;
use Illuminate\Http\Request;
use Image;
use File;

class HotelController extends Controller
{

    private $directory = 'images/hotels';


    public function hotelsSelect()
    {
        $hotels = Hotel::select(['id', 'name'])->get();
        return response(['hotels' => $hotels]);
    }



    public function index(Request $request)
    {
        $length = $request->length;
        $sortBy = $request->sortBy;
        $dir = $request->dir;
        $draw = $request->draw;
        $searchValue = $request->search;
        $display = $request->display;
        $trashed = $request->trashed;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $query = Hotel::select('*')->orderBy($sortBy, $dir);

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
                    ->orWhere('id', $searchValue)
                    ->orWhere('address', 'like', '%' . $searchValue . '%');
                });
            }
        }

        $hotels = $query->paginateConvert($length);
        return response(['data' => $hotels, 'draw' => $draw, 'sortBy' => $sortBy, 'dir' => $dir]);
    }


    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required|string|between:5,180',
            'address' => 'required|string|between:3,180',
            'rating' => 'required|integer|between:0,100',
            'stars' => 'required|in:3,4,5,7',
            'info' => 'required|string|min:5',
            'latitude' => 'nullable|numeric|required_with:longitude',
            'longitude' => 'nullable|numeric|required_with:latitude',
            'image' => 'required|string',
            'gallery' => 'nullable|array',
            'features' => 'nullable|array',
            'display' => 'required|in:0,1',
        ]);

        $data = $request->except('features');

        // handel features
        $features_no_null = collect($request->features)->filter(function ($feature) {
            return $feature['value'] != null;
        });
        $features_arr = [];
        foreach ($features_no_null as $row) {
            $features_arr[] = $row['value'];
        }
        $data['features'] = implode(',', array_unique($features_arr));
        /****************************************************************************/

        // handel image
        $directory = $this->directory . '/' . uniqid('hotel-');
        if (strpos($data['image'], 'data:image/') === 0) {
            $get_ext = explode(';', explode('/', $data['image'])[1])[0];
            $ext = $get_ext == 'jpeg' ? 'jpg' : $get_ext;
            $imageNewName =  uniqid('hotel-default-image-') . '.' . $ext;
            $imagePath = $directory . '/' . $imageNewName;
            if (!is_dir(public_path($directory))) {
                File::makeDirectory(public_path($directory), 0777, true);
            }
            Image::make($data['image'])->save(public_path($imagePath));
            $data['image'] = $imagePath;
        }
        /****************************************************************************/

        // handel gallery
        if (count($data['gallery']) > 0) {
            $galleryDB = [];
            foreach ($data['gallery'] as $image) {
                $get_ext = explode(';', explode('/', $image['value'])[1])[0];
                $ext = $get_ext == 'jpeg' ? 'jpg' : $get_ext;
                $imageNewName =  uniqid('hotel-image-') . '.' . $ext;
                $imagePath = $directory . '/' . $imageNewName;
                if (is_dir(public_path($directory))) {
                    Image::make($image['value'])->save(public_path($imagePath));
                    $galleryDB[] = $imagePath;
                }
            }
            $data['gallery'] = implode(',', $galleryDB);
        } else {
            $data['gallery'] = null;
        }
        /****************************************************************************/

        // add to DB

        $data['user_id'] = auth()->id();
        $hotel = Hotel::create($data);
        $createdHotel = Hotel::findConvert($hotel->id);
        return response(['message' => 'Hotel has been created.', 'data' => $createdHotel]);
    }


    public function show($id)
    {
        $hotel = Hotel::findConvert($id);
        $hotel_arr = collect($hotel)->toArray();
        $hotel = key_exists('id', $hotel_arr) ? $hotel : null;
        return response(['hotel' => $hotel]);
    }


    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'name' => 'required|string|between:2,180',
            'address' => 'required|string|between:3,180',
            'rating' => 'required|integer|between:0,100',
            'stars' => 'required|in:3,4,5,7',
            'info' => 'required|string|min:5',
            'latitude' => 'nullable|numeric|required_with:longitude',
            'longitude' => 'nullable|numeric|required_with:latitude',
            'image' => 'required|string',
            'gallery' => 'nullable|array',
            'features' => 'nullable|array',
            'display' => 'required|in:0,1',
        ]);

        $hotel = Hotel::find($id);
        $keys_except = ['features', 'deletedGallery', 'deletedFeatures'];
        $data = $request->except($keys_except);


        // handel features
        $features_no_null = collect($request->features)->filter(function ($feature) {
            return $feature['value'] != null;
        });
        $features_arr = [];
        foreach ($features_no_null as $row) {
            $features_arr[] = $row['value'];
        }
        $data['features'] = implode(',', array_unique($features_arr));

        /****************************************************************************/

         // handel image
        $directory = $this->directory . '/' . explode('/', $hotel->image)[2];
        if (strpos($data['image'], 'data:image/') === 0) {
            $get_ext = explode(';', explode('/', $data['image'])[1])[0];
            $ext = $get_ext == 'jpeg' ? 'jpg' : $get_ext;
            $imageNewName =  uniqid('hotel-default-image-') . '.' . $ext;
            $imagePath = $directory . '/' . $imageNewName;

            // delete old image if exists
            if ($hotel->image !== null) {
                if (file_exists(public_path($hotel->image))) {
                    unlink(public_path($hotel->image));
                }
            }
            /*================================================*/
            Image::make($data['image'])->save(public_path($imagePath));
            $data['image'] = $imagePath;
        }
        /****************************************************************************/


        // handel gallery
        // delete images in array [gallery deleted by user]
         if (count($request->deletedGallery) > 0) {
            foreach ($request->deletedGallery as $image) {
                if (file_exists(public_path($image['value']))) {
                    unlink(public_path($image['value']));
                }
            }
         }

        /*================================================*/
        // save new and old images
         $gallery = collect($request->gallery);
         $galllery_new = $gallery->filter(function ($value) {
            return !key_exists('id', $value);
         });
         $galllery_old = $gallery->filter(function ($value) {
            return key_exists('id', $value);
         });

        /*================================================*/
        $gallery_saved = [];
        // save new image if exists new image
        if ($galllery_new->count() > 0) {
            foreach ($galllery_new as $image) {
                $get_ext = explode(';', explode('/', $image['value'])[1])[0];
                $ext = $get_ext == 'jpeg' ? 'jpg' : $get_ext;
                $imageNewName =  uniqid('hotel-image-') . '.' . $ext;
                $imagePath = $directory . '/' . $imageNewName;
                if (is_dir(public_path($directory))) {
                    Image::make($image['value'])->save(public_path($imagePath));
                    $gallery_saved[] = $imagePath;
                }
            }
        }
        /*================================================*/
        if ($galllery_old->count() > 0) {
            foreach ($galllery_old as $image) {
                $gallery_saved[] = $image['value'];
            }
        }
        if (count($gallery_saved) > 0) {
            $data['gallery'] = implode(',', $gallery_saved);
        } else {
            $data['gallery'] = null;
        }
        /****************************************************************************/

        // save data to db

        $hotel->update($data);
        $updatedHotel = Hotel::findConvert($id);
        return response(['message' => $data['name'] . ' Hotel has been updated.', 'data' => $updatedHotel]);
    }


    public function destroy($id)
    {
        $hotel = Hotel::withTrashed()->where('id', $id)->first();
        if ($hotel->trashed()) {
            // delete image
            $directory = $this->directory . '/' . explode('/', $hotel->image)[2];
            \File::deleteDirectory($directory);
            $hotel->forceDelete();
        } else {
            $hotel->delete();
        }
        return response(['status' => true]);
    }


    public function restoreHotel($id)
    {
        $hotel_deleted = Hotel::onlyTrashed()->where('id', $id)->first();
        $hotel_deleted->restore();
        return response(['status' => true]);
    }
}
