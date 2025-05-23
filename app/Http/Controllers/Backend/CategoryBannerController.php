<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CategoryBanner;
use Illuminate\Support\Carbon;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryBannerController extends Controller
{
    public function index()
    {
        $banners = CategoryBanner::orderBy('id', 'DESC')->paginate(10);
        return view('admin.category_banner.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.category_banner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'starting_price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'link' => 'nullable|url',
        ]);

        $banner = new CategoryBanner();
        $banner->title = request('title');
        $banner->starting_price = request('starting_price');
        $banner->link = request('link');

        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $this->GenerateSlideThumbnailImage($image, $file_name);
        $banner->image = $file_name;
        $banner->save();


        return redirect()->route('admin.category-banners.index')->with('success', 'Banner created successfully');
    }
    public function edit(CategoryBanner $categoryBanner)
    {
        return view('admin.category_banner.edit', compact('categoryBanner'));
    }
    public function update(Request $request, CategoryBanner $categoryBanner)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'starting_price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'link' => 'nullable|url',
        ]);

        $categoryBanner->title = request('title');
        $categoryBanner->starting_price = request('starting_price');
        $categoryBanner->link = request('link');

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($categoryBanner->image);
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $this->GenerateSlideThumbnailImage($image, $file_name);
            $categoryBanner->image = $file_name;
        }

        $categoryBanner->save();

        return redirect()->route('admin.category-banners.index')->with('success', 'Banner updated successfully');
    }

    public function destroy(CategoryBanner $categoryBanner)
    {
        Storage::disk('public')->delete($categoryBanner->image);
        $categoryBanner->delete();

        return back()->with('success', 'Banner deleted successfully');
    }
    public function GenerateSlideThumbnailImage($image, $image_name)
    {

        $destinationPath = public_path('uploads/category_banners');
        $img = Image::read($image->path());
        $img->cover(690, 665,"top");
        $img->resize(690, 665, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath. '/' .$image_name);
    }
}