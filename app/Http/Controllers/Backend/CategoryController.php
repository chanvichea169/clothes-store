<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function categories()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    public function add_category()
    {
        return view('admin.category.add-category');
    }

    public function store_category(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'image' => 'mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $image = $request->file('image');

        if($image){
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp. '.' .$file_extention;
            $this->GenerateCategoryThumbnailImage( $image, $file_name);
            $category->image = $file_name;
        }else{
            return redirect()->back()->with('error', 'Please select a valid image file');
        }

        $category->save();

        return redirect()->route('admin.categories')->with('success', 'Category added successfully');
    }


    public function edit_category($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit-category', compact('category'));
    }

    public function update_category(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$request->id,
            'image' => 'mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $image = $request->file('image');

        if($image){
            if($request->hasFile('image')){
                if(File::exists(public_path('uploads/brands/'. $category->image))){
                    File::delete(public_path('uploads/brands/'. $category->image));
                }
                $file_extention = $request->file('image')->extension();
                $file_name = Carbon::now()->timestamp. '.' .$file_extention;
                $this->GenerateBrandThumbnailImage($image, $file_name);
                $category->image = $file_name;
            }
        }
        $category->save();

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully');
    }

    public function delete_category($id)
    {
        $category = Category::find($id);
        if(File::exists(public_path('uploads/categories/'.$category->image))){
            File::delete(public_path('uploads/categories/'.$category->image));
        }
        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully');
    }

    public function GenerateCategoryThumbnailImage($image, $image_name)
    {

        $destinationPath = public_path('uploads/categories');
        $img = Image::read($image->path());
        $img->cover(124, 124,"top");
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath. '/' .$image_name);
    }
}