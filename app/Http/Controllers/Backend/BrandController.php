<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class BrandController extends Controller
{
    public function brands()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
         return view('admin.brand.index', compact('brands'));
    }

    public function add_brand()
    {
        return view('admin.brand.add-brand');
    }

    public function store_brand(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'logo' => 'mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $logo = $request->file('logo');

        if($logo){
            $file_extention = $request->file('logo')->extension();
            $file_name = Carbon::now()->timestamp. '.' .$file_extention;
            $this->GenerateBrandThumbnailImage($logo, $file_name);
            $brand->logo = $file_name;
        }else{
            return redirect()->back()->with('error', 'Please select a valid image file');
        }

        $brand->save();

        return redirect()->route('admin.brands')->with('success', 'Brand added successfully');
    }

    public function edit_brand($id)
    {
        $brand = Brand::find($id);
        return view('admin.brand.edit-brand', compact('brand'));
    }

    public function update_brand(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,'.$request->id,
            'logo' => 'mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $brand = Brand::find($request->id);
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $logo = $request->file('logo');

        if($logo){
            if($request->hasFile('logo')){
                if(File::exists(public_path('uploads/brands/'.$brand->logo))){
                    File::delete(public_path('uploads/brands/'.$brand->logo));
                }
                $file_extention = $request->file('logo')->extension();
                $file_name = Carbon::now()->timestamp. '.' .$file_extention;
                $this->GenerateBrandThumbnailImage($logo, $file_name);
                $brand->logo = $file_name;
            }
        }

        $brand->save();

        return redirect()->route('admin.brands')->with('success', 'Brand updated successfully');
    }

    public function delete_brand($id)
    {
        $brand = Brand::find($id);
        if(File::exists(public_path('uploads/brands/'.$brand->logo))){
            File::delete(public_path('uploads/brands/'.$brand->logo));
        }
        $brand->delete();
        return redirect()->route('admin.brands')->with('message', 'Brand deleted successfully');
    }

    public function GenerateBrandThumbnailImage($logo, $logo_name)
    {

        $destinationPath = public_path('uploads/brands');
        $img = Image::read($logo->path());
        $img->cover(124, 124,"top");
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath. '/' .$logo_name);
    }

}