<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // private $patternPhone = "/^\+?\d{10,14}$/";
    // private $patternPassword = "/^(?=.*\d)(?=.*[a-zA-Z])[a-zA-Z0-9]{6,16}$/";
    private $defaultAvatar = "images/user-avatar/default-avatar.png";


    public function users_id()
    {
        $users = User::orderBy('id', 'desc')->get();
        return response($users);
    }

    public function index(Request $request)
    {
        $sortBy = $request->sortBy;
        $length = $request->length;
        $dir = $request->dir;
        $draw = $request->draw;
        $searchValue = $request->search;
        $trashed = $request->trashed;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $query = User::select('*')->orderBy($sortBy, $dir);

        // handel users trashed and not trashed
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
                    ->orWhere('id', $searchValue)
                    ->orWhere('email', 'like', '%' . $searchValue . '%');
                });
            }
        }
        $users = $query->paginate($length);
        return response(['data' => $users, 'draw' => $draw, 'sortBy' => $sortBy, 'dir' => $dir]);
    }



    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required|string|between:2,180',
            'password' => 'required|string|between:4,16|confirmed',
            'email' => 'required|email|max:180|unique:users',
            'image' => 'nullable|string'
        ]);

        $userData = $request->except(['password_confirmation']);
        $userData['password'] = bcrypt($request->password);

        if (strpos($userData['image'], 'data:image/') === 0) {
            $get_ext = explode(';', explode('/', $userData['image'])[1])[0];
            $ext = $get_ext == 'jpeg' ? 'jpg' : $get_ext;
            $imageNewName = time() . '-' . Str::kebab(strtolower($userData['name'])) . '-avatar.' . $ext;
            $imagePath = 'images/user-avatar/' . $imageNewName;
            Image::make($userData['image'])
            ->resize(150, 150)
            ->save(public_path($imagePath));
            $userData['image'] = $imagePath;
        }
        User::create($userData);
        return response(['message' => 'User has been created.']);
    }


    public function show($id)
    {
        $user = User::find($id);
        return response(['user' => $user]);
    }



    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $this->validate(request(), [
            'name' => 'required|string|between:2,180',
            'password' => 'nullable|string|between:4,16|confirmed',
            'email' => 'required|email|max:180|unique:users,email,'. $id,
            'image' => 'nullable|string'
        ]);
        $userData = $request->except(['password_confirmation']);
        if (array_has($userData, 'password') && $userData['password'] != '') {
            $userData['password'] = bcrypt($userData['password']);
        } else {
            $userData['password'] = $user->password;
        }

        if (strpos($userData['image'], 'data:image/') === 0) {
            $get_ext = explode(';', explode('/', $userData['image'])[1])[0];
            $ext = $get_ext == 'jpeg' ? 'jpg' : $get_ext;
            $imageNewName = time() . '-' . Str::kebab(strtolower($userData['name'])) . '-avatar.' . $ext;
            $imagePath = 'images/user-avatar/' . $imageNewName;

            // delete old image if exists
            if ($user->image != $this->defaultAvatar && $user->image !== null) {
                if (file_exists(public_path($user->image))) {
                    unlink(public_path($user->image));
                }
            }

            // add new image to directory
            Image::make($userData['image'])
            ->resize(150, 150)
            ->save(public_path($imagePath));
            $userData['image'] = $imagePath;


        } else if ($userData['image'] == $this->defaultAvatar && ($user->image != $this->defaultAvatar && $user->image != null)) {
            if (file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }
        }

        $user->update($userData);
        return response(['message' => 'User has been updated.']);
    }



    public function destroy($id)
    {
        if ($id != 1) {
            $user = User::withTrashed()->where('id', $id)->first();
            if ($user->trashed()) {
                // delete image if exists
                if ($user->image != $this->defaultAvatar && $user->image !== null) {
                    if (file_exists(public_path($user->image))) {
                        unlink(public_path($user->image));
                    }
                }
                $user->forceDelete();
            } else {
                $user->delete();
            }
            return response(['status' => true]);
        } else {
            return response(['error' => 'This user can\'t delete it.'], 403);
        }
    }


    public function restoreUser($id)
    {
        $user_deleted = User::onlyTrashed()->where('id', $id)->first();
        $user_deleted->restore();
        return response(['status' => true]);
    }


    public function deleteRestoreMulti(Request $request)
    {
        $ids = $request->ids;
        $action = $request->action;

        if (in_array('1', $ids)) {
            return response(['error' => 'This user can\'t delete it.'], 403);
        }
        if ($action == 'delete') {
            User::destroy($ids);
        } else if ($action == 'force_delete') {
            $users = User::onlyTrashed()->whereIn('id', $ids)->get();
            foreach ($users as $user) {
                if ($user->image != $this->defaultAvatar && $user->image !== null) {
                    if (file_exists(public_path($user->image))) {
                        unlink(public_path($user->image));
                    }
                }
            }
            User::onlyTrashed()->whereIn('id', $ids)->forceDelete();
        } else if ($action == 'restore') {
            User::onlyTrashed()->whereIn('id', $ids)->restore();
        }

        return response(['status' => true]);
    }

}
