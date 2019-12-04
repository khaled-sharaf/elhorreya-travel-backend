<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Travel;
use App\Jobs\SendMailingTravel;
use App\MailingList;
use App\Mail\MailingTravel;
use Mail;

use Image;
use File;

class TravelController extends Controller
{

    private $directory = 'images/travels';

    public function travelsSelect()
    {
        $travels = Travel::select(['id', 'name'])->get();
        return response(['travels' => $travels]);
    }


    public function index(Request $request)
    {
        $length = $request->length;
        $sortBy = $request->sortBy;
        $dir = $request->dir;
        $draw = $request->draw;
        $travel_category_id = $request->travel_category_id;
        $hotel_id = $request->hotel_id;
        $searchValue = $request->search;
        $display = $request->display;
        $trashed = $request->trashed;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $query = Travel::select('*')->orderBy($sortBy, $dir);


        if ($travel_category_id != '') {
            $query->where('travel_category_id', $travel_category_id);
        }

        if ($hotel_id != '') {
            $query->where(function($q) use ($hotel_id) {
                $q->orWhere('hotel_id', $hotel_id)->orWhere('hotel_2_id', $hotel_id);
            });
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
                    ->orWhere('address_from', 'like', '%' . $searchValue . '%')
                    ->orWhere('umrah_date', 'like', '%' . $searchValue . '%')
                    ->orWhere('type', 'like', '%' . $searchValue . '%');
                });
            }
        }

        $travels = $query->paginateConvert($length);
        return response(['data' => $travels, 'draw' => $draw, 'sortBy' => $sortBy, 'dir' => $dir]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|between:2,180',
            'address_from' => 'required_if:type,external_fly,external_visa|nullable|string|between:3,180',
            'address_to' => 'required_if:type,external_fly,external_visa|nullable|string|between:3,180',
            'info' => 'nullable|string|min:5',
            'type' => 'required|in:pilgrimage,umrah,internal,external_fly,external_visa',
            'umrah_date' => 'required_if:type,umrah|nullable|string|between:2,50',
            'haram_distance' => 'required_if:type,pilgrimage,umrah|nullable|in:0,1',
            'itinerary_1' => 'required_if:type,pilgrimage,umrah|max:20',
            'itinerary_2' => 'required_if:type,pilgrimage,umrah|max:20',
            'itinerary_3' => 'required_if:type,pilgrimage,umrah|max:20',
            'itinerary_4' => 'nullable|max:20',
            'itinerary_5' => 'nullable|max:20',
            'discount' => 'nullable|integer',
            'favorite_company' => 'nullable|in:0,1',
            'hotel_id' => 'required_unless:type,external_fly,external_visa|nullable|exists:hotels,id',
            'hotel_2_id' => 'nullable|exists:hotels,id',
            'travel_category_id' => 'required_unless:type,external_fly,external_visa|nullable|exists:travel_categories,id',
            'image' => 'required|string',
            'gallery' => 'nullable|array',
            'offers' => 'required_unless:type,external_fly,external_visa|array|min:1',
            'display' => 'required|in:0,1',

            'offers.*.name_offer' => 'required|string|between:2,180',
            'offers.*.info_offer' => 'nullable|string|between:2,180',
            'offers.*.date_from' => 'required_unless:type,external_fly,external_visa|nullable|date|before:offers.*.date_to',
            'offers.*.date_to' => 'required_unless:type,external_fly,external_visa|nullable|date|after:offers.*.date_from',
            'offers.*.hotel_days' => 'required_if:type,umrah,pilgrimage|max:100',
            'offers.*.hotel_2_days' => 'required_if:type,umrah,pilgrimage|max:100',
            'offers.*.stay_type' => 'required_unless:type,external_fly,external_visa|nullable',
            'offers.*.stay_type_2' => 'required_with:hotel_2_id|nullable',
            'offers.*.transport' => 'required_unless:type,external_fly,external_visa|nullable',
            'offers.*.adults' => 'nullable|integer|max:999',
            'offers.*.children' => 'nullable|integer|max:999',
            'offers.*.child_price' => 'nullable|numeric',
            'offers.*.baby_price' => 'nullable|numeric',
            'offers.*.single_price' => 'required_unless:type,external_fly,external_visa|nullable|numeric',
            'offers.*.twin_price' => 'nullable|numeric',
            'offers.*.triple_price' => 'nullable|numeric',
            'offers.*.display' => 'required_unless:type,external_fly,external_visa|nullable|in:0,1',
        ]);
        $data = $request->toArray();

        if ($data['type'] != 'pilgrimage' && $data['type'] != 'umrah') {
            $data['umrah_date'] = null;
            $data['haram_distance'] = null;
        } else if ($data['type'] == 'pilgrimage') {
            $data['umrah_date'] = null;
        }

        // handel image
        $directory = $this->directory . '/' . uniqid('travel-');
        if (strpos($data['image'], 'data:image/') === 0) {
            $get_ext = explode(';', explode('/', $data['image'])[1])[0];
            $ext = $get_ext == 'jpeg' ? 'jpg' : $get_ext;
            $imageNewName =  uniqid('travel-default-image-') . '.' . $ext;
            $imagePath = $directory . '/' . $imageNewName;
            if (!is_dir(public_path($directory))) {
                File::makeDirectory(public_path($directory), 0777, true);
            }
            Image::make($data['image'])->save(public_path($imagePath));
            $data['image'] = $imagePath;
        }
        /****************************************************************************/

        // handel gallery
        if (count($data['gallery']) > 0 && ($data['type'] === 'umrah' || $data['type'] === 'pilgrimage')) {
            $galleryDB = [];
            foreach ($data['gallery'] as $image) {
                $get_ext = explode(';', explode('/', $image['value'])[1])[0];
                $ext = $get_ext == 'jpeg' ? 'jpg' : $get_ext;
                $imageNewName =  uniqid('travel-image-') . '.' . $ext;
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
        $travel = Travel::create($data);

        // create offers
        if ($data['type'] !== 'external_fly' && $data['type'] !== 'external_visa') {
            foreach ($data['offers'] as $index => $offer)
            {
                $date_diff = abs(round((strtotime($offer['date_to']) - strtotime($offer['date_from'])) / 86400));
                $data['offers'][$index]['time_period'] = $date_diff;
            }
            $travel->offers()->createMany($data['offers']);
        }

        $createdTravel = Travel::findConvert($travel->id);

        // send travel to all email in mailing list
        $sendMail = (new SendMailingTravel( json_decode(json_encode($createdTravel->toArray())) ))
        ->delay(now()->addSeconds(3));
        dispatch($sendMail);

        // $emails_count = MailingList::count();
        // $offset = 0;
        // $limit = 200;
        // $all_emails = [];
        // for ($i = 0; $i < ceil($emails_count / $limit); $i++) {
        //     $part_mails = MailingList::select('email')->offset($offset)->limit($limit)->get()->pluck('email');
        //     foreach ($part_mails->all() as $email) {
        //         $all_emails[] = $email;
        //     }
        //     $offset = $offset + $limit;
        // }
        // if (count($all_emails) > 0) {
        //     Mail::to($all_emails)->send(new MailingTravel( json_decode(json_encode($createdTravel->toArray())) ));
        // }

        return response(['message' => 'Travel has been created.', 'data' => $createdTravel]);
    }


    public function show($id)
    {
        $travel = Travel::findConvert($id);
        $travel_arr = collect($travel)->toArray();
        $travel = key_exists('id', $travel_arr) ? $travel : null;
        return response(['travel' => $travel]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|between:2,180',
            'address_from' => 'required_if:type,external_fly,external_visa|nullable|string|between:3,180',
            'address_to' => 'required_if:type,external_fly,external_visa|nullable|string|between:3,180',
            'info' => 'nullable|string|min:5',
            'type' => 'required|in:pilgrimage,umrah,internal,external_fly,external_visa',
            'umrah_date' => 'required_if:type,umrah|nullable|string|between:2,50',
            'haram_distance' => 'required_if:type,pilgrimage,umrah|nullable|in:0,1',
            'itinerary_1' => 'required_if:type,pilgrimage,umrah|max:20',
            'itinerary_2' => 'required_if:type,pilgrimage,umrah|max:20',
            'itinerary_3' => 'required_if:type,pilgrimage,umrah|max:20',
            'itinerary_4' => 'nullable|max:20',
            'itinerary_5' => 'nullable|max:20',
            'discount' => 'nullable|integer',
            'favorite_company' => 'nullable|in:0,1',
            'hotel_id' => 'required_unless:type,external_fly,external_visa|nullable|exists:hotels,id',
            'hotel_2_id' => 'nullable|exists:hotels,id',
            'travel_category_id' => 'required_unless:type,external_fly,external_visa|nullable|exists:travel_categories,id',
            'image' => 'required|string',
            'gallery' => 'nullable|array',
            'offers' => 'required_unless:type,external_fly,external_visa|array|min:1',
            'display' => 'required|in:0,1',

            'offers.*.name_offer' => 'required|string|between:2,180',
            'offers.*.info_offer' => 'nullable|string|between:2,180',
            'offers.*.date_from' => 'required_unless:type,external_fly,external_visa|nullable|date|before:offers.*.date_to',
            'offers.*.date_to' => 'required_unless:type,external_fly,external_visa|nullable|date|after:offers.*.date_from',
            'offers.*.hotel_days' => 'required_if:type,umrah,pilgrimage|max:100',
            'offers.*.hotel_2_days' => 'required_if:type,umrah,pilgrimage|max:100',
            'offers.*.stay_type' => 'required_unless:type,external_fly,external_visa|nullable',
            'offers.*.stay_type_2' => 'required_with:hotel_2_id|nullable',
            'offers.*.transport' => 'required_unless:type,external_fly,external_visa|nullable',
            'offers.*.adults' => 'nullable|integer|max:999',
            'offers.*.children' => 'nullable|integer|max:999',
            'offers.*.child_price' => 'nullable|numeric',
            'offers.*.baby_price' => 'nullable|numeric',
            'offers.*.single_price' => 'required_unless:type,external_fly,external_visa|nullable|numeric',
            'offers.*.twin_price' => 'nullable|numeric',
            'offers.*.triple_price' => 'nullable|numeric',
            'offers.*.display' => 'required_unless:type,external_fly,external_visa|nullable|in:0,1',
        ]);
        $travel = Travel::find($id);
        $keys_except = ['deletedGallery', 'deletedOffers'];
        $data = $request->except($keys_except);

        if ($data['type'] != 'pilgrimage' && $data['type'] != 'umrah') {
            $data['umrah_date'] = null;
            $data['haram_distance'] = null;
        } else if ($data['type'] == 'pilgrimage') {
            $data['umrah_date'] = null;
        }

        // handel image
        $directory = $this->directory . '/' . explode('/', $travel->image)[2];
        if (strpos($data['image'], 'data:image/') === 0) {
            $get_ext = explode(';', explode('/', $data['image'])[1])[0];
            $ext = $get_ext == 'jpeg' ? 'jpg' : $get_ext;
            $imageNewName =  uniqid('travel-default-image-') . '.' . $ext;
            $imagePath = $directory . '/' . $imageNewName;
            // delete old image if exists
            if ($travel->image !== null) {
                if (file_exists(public_path($travel->image))) {
                    unlink(public_path($travel->image));
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
        if ($galllery_new->count() > 0 && ($data['type'] === 'umrah' || $data['type'] === 'pilgrimage')) {
            foreach ($galllery_new as $image) {
                $get_ext = explode(';', explode('/', $image['value'])[1])[0];
                $ext = $get_ext == 'jpeg' ? 'jpg' : $get_ext;
                $imageNewName =  uniqid('travel-image-') . '.' . $ext;
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

        // handel offers

        // delete details [if deleted by user]
        if (count($request->deletedOffers) > 0) {
            $travel->offers()->whereIn('id', $request->deletedOffers)->delete();
        }


        if ($data['type'] !== 'external_fly' && $data['type'] !== 'external_visa') {

            foreach ($data['offers'] as $index => $offer)
            {
                $date_diff = abs(round((strtotime($offer['date_to']) - strtotime($offer['date_from'])) / 86400));
                $data['offers'][$index]['time_period'] = $date_diff;
            }

            // save and craete new offers in database
            if (count($data['offers']) > 0) {
                for ($x = 0; $x < count($data['offers']); $x++) {
                    $travel->offers()->updateOrCreate(
                        [
                            'id' => key_exists('id', $data['offers'][$x]) ? $data['offers'][$x]['id'] : 0
                        ],
                        $data['offers'][$x]
                    );
                }
            }
        }

        /****************************************************************************/

        // add to DB
        $travel->update($data);
        $updatedTravel = Travel::findConvert($travel->id);
        return response(['message' => 'Travel has been updated.', 'data' => $updatedTravel]);
    }


    public function destroy($id)
    {
        $travel = Travel::withTrashed()->where('id', $id)->first();
        if ($travel->trashed()) {
            // delete image
            $directory = $this->directory . '/' . explode('/', $travel->image)[2];
            File::deleteDirectory($directory);
            $travel->forceDelete();
        } else {
            $travel->delete();
        }
        return response(['status' => true]);
    }


    public function restoreTravel($id)
    {
        $travel_deleted = Travel::onlyTrashed()->where('id', $id)->first();
        $travel_deleted->restore();
        return response(['status' => true]);
    }


    public function deleteRestoreMulti(Request $request)
    {
        $ids = $request->ids;
        $action = $request->action;

        if ($action == 'delete') {
            Travel::destroy($ids);
        } else if ($action == 'force_delete') {
            $travels = Travel::onlyTrashed()->whereIn('id', $ids)->get();
            foreach ($travels as $travel) {
                $directory = $this->directory . '/' . explode('/', $travel->image)[2];
                File::deleteDirectory($directory);
            }
            Travel::onlyTrashed()->whereIn('id', $ids)->forceDelete();
        } else if ($action == 'restore') {
            Travel::onlyTrashed()->whereIn('id', $ids)->restore();
        }

        return response(['status' => true]);
    }
}
