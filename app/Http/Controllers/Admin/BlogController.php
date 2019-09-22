<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Blog;
use Illuminate\Http\Request;
use Image;
use File;

class BlogController extends Controller
{

    private $directory = 'images/blogs';

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
        $query = Blog::select('*')->orderBy($sortBy, $dir)->with('user');

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
                    $query->where('title', 'like', '%' . $searchValue . '%')
                    ->orWhere('id', $searchValue);
                });
            }
        }

        $blogs = $query->paginateConvert($length);
        return response(['data' => $blogs, 'draw' => $draw, 'sortBy' => $sortBy, 'dir' => $dir]);
    }


    public function store(Request $request)
    {
        $this->validate(request(), [
            'title' => 'required|string|between:5,180',
            'content' => 'required|string|min:5',
            'image' => 'required|string',
            'gallery' => 'nullable|array',
            'display' => 'required|in:0,1'
        ]);

        $data = $request->toArray();

        // handel image
        $directory = $this->directory . '/' . uniqid('blog-');
        if (strpos($data['image'], 'data:image/') === 0) {
            $get_ext = explode(';', explode('/', $data['image'])[1])[0];
            $ext = $get_ext == 'jpeg' ? 'jpg' : $get_ext;
            $imageNewName =  uniqid('blog-default-image-') . '.' . $ext;
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
                $imageNewName =  uniqid('blog-image-') . '.' . $ext;
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
        $blog = Blog::create($data);
        return response(['message' => 'Blog has been created.']);
    }


    public function show($id)
    {
        $blog = Blog::findConvert($id);
        $blog_arr = collect($blog)->toArray();
        $blog = key_exists('id', $blog_arr) ? $blog : null;
        return response(['blog' => $blog]);
    }


    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'title' => 'required|string|between:5,180',
            'content' => 'required|string|min:5',
            'image' => 'required|string',
            'gallery' => 'nullable|array',
            'display' => 'required|in:0,1'
        ]);

        $blog = Blog::find($id);
        $data = $request->except('deletedGallery');


         // handel image
        $directory = $this->directory . '/' . explode('/', $blog->image)[2];
        if (strpos($data['image'], 'data:image/') === 0) {
            $get_ext = explode(';', explode('/', $data['image'])[1])[0];
            $ext = $get_ext == 'jpeg' ? 'jpg' : $get_ext;
            $imageNewName =  uniqid('blog-default-image-') . '.' . $ext;
            $imagePath = $directory . '/' . $imageNewName;

            // delete old image if exists
            if ($blog->image !== null) {
                if (file_exists(public_path($blog->image))) {
                    unlink(public_path($blog->image));
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
                $imageNewName =  uniqid('blog-image-') . '.' . $ext;
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

        $blog->update($data);
        $updatedBlog = Blog::findConvert($id);
        return response(['message' => 'Blog has been updated.', 'blog' => $updatedBlog]);
    }


    public function destroy($id)
    {
        $blog = Blog::withTrashed()->where('id', $id)->first();
        if ($blog->trashed()) {
            // delete image
            $directory = $this->directory . '/' . explode('/', $blog->image)[2];
            \File::deleteDirectory($directory);
            $blog->forceDelete();
        } else {
            $blog->delete();
        }
        return response(['status' => true]);
    }


    public function restoreBlog($id)
    {
        $blog_deleted = Blog::onlyTrashed()->where('id', $id)->first();
        $blog_deleted->restore();
        return response(['status' => true]);
    }
}
