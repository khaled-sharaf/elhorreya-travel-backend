<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\TravelProgram;
use Illuminate\Http\Request;
use Image;
use File;

class TravelProgramController extends Controller
{

    private $directory = 'images/travel_programs';

    public function travelProgramsSelect()
    {
        $travel_programs = TravelProgram::select(['id', 'name'])->get();
        return response(['travel_programs' => $travel_programs]);
    }


    public function index(Request $request)
    {
        $length = $request->length;
        $sortBy = $request->sortBy;
        $dir = $request->dir;
        $draw = $request->draw;
        $searchValue = $request->search;
        $trashed = $request->trashed;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $query = TravelProgram::select('*')->orderBy($sortBy, $dir)->with('user');

        if ($trashed == 0) {
            $query->onlyTrashed();
        } else if ($trashed == 2) {
            $query->withTrashed();
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

        $travel_programs = $query->paginate($length);
        return response(['data' => $travel_programs, 'draw' => $draw, 'sortBy' => $sortBy, 'dir' => $dir]);
    }


    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required|string|between:2,180',
            'small_info' => 'nullable|string|min:3',
            'big_info' => 'nullable|string|min:3',
            'image' => 'required|string',
            'order' => 'nullable|integer|min:1',
        ]);

        $data = $request->toArray();

        // handel image
        $directory = $this->directory;
        if (strpos($data['image'], 'data:image/') === 0) {
            $get_ext = explode(';', explode('/', $data['image'])[1])[0];
            $ext = $get_ext == 'jpeg' ? 'jpg' : $get_ext;
            $imageNewName =  uniqid('travel-program-image-') . '.' . $ext;
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
        $travel_program = TravelProgram::create($data);
        return response(['message' => 'Travel program has been created.']);
    }


    public function show($id)
    {
        $travel_program = TravelProgram::find($id);
        return response(['travel_program' => $travel_program]);
    }


    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'name' => 'required|string|between:2,180',
            'small_info' => 'nullable|string|min:3',
            'big_info' => 'nullable|string|min:3',
            'image' => 'required|string',
            'order' => 'nullable|integer|min:1',
        ]);

        $travel_program = TravelProgram::find($id);
        $data = $request->toArray();


        // save image is exists
        $directory = $this->directory;
        if (strpos($data['image'], 'data:image/') === 0) {
            $get_ext = explode(';', explode('/', $data['image'])[1])[0];
            $ext = $get_ext == 'jpeg' ? 'jpg' : $get_ext;
            $imageNewName =  uniqid('travel-program-image-') . '.' . $ext;
            $imagePath = $directory . '/' . $imageNewName;

            // delete old image if exists
            if ($travel_program->image !== null) {
                if (file_exists(public_path($travel_program->image))) {
                    unlink(public_path($travel_program->image));
                }
            }
            /*================================================*/
            Image::make($data['image'])->save(public_path($imagePath));
            $data['image'] = $imagePath;
        }
        /****************************************************************************/

        $travel_program->update($data);
        $updatedTravelProgram = TravelProgram::find($id);
        return response(['message' => 'Travel program has been updated.', 'travel_program' => $updatedTravelProgram]);
    }


    public function destroy($id)
    {
        $travel_program = TravelProgram::withTrashed()->where('id', $id)->first();
        if ($travel_program->trashed()) {
            // delete image
            if (file_exists(public_path($travel_program->image))) {
                unlink(public_path($travel_program->image));
            }
            $travel_program->forceDelete();
        } else {
            $travel_program->delete();
        }
        return response(['status' => true]);
    }


    public function restoreTravelProgram($id)
    {
        $travel_program_deleted = TravelProgram::onlyTrashed()->where('id', $id)->first();
        $travel_program_deleted->restore();
        return response(['status' => true]);
    }
}
