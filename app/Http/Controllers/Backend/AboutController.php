<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use Illuminate\Support\Carbon;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Log;

class AboutController extends Controller
{
    public function index()
    {
        $abouts = About::orderBy('id', 'DESC')->paginate(10);
        return view('admin.about.index', compact('abouts'));
    }

    public function create()
    {
        return view('admin.about.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'company_infor' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $about = new About();
        $about->title = request('title');
        $about->description = request('description');
        $about->mission = request('mission');
        $about->vision = request('vision');
        $about->company_infor = request('company_infor');

        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $this->GenerateAboutThumbnailImage($image, $file_name);
        $about->image = $file_name;
        $about->save();
        return redirect()->route('admin.about.index')->with('success', 'About created successfully');

    }

    public function edit(About $about)
    {
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request, About $about)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'company_infor' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $about->title = request('title');
        $about->description = request('description');
        $about->mission = request('mission');
        $about->vision = request('vision');
        $about->company_infor = request('company_infor');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $this->GenerateAboutThumbnailImage($image, $file_name);
            $about->image = $file_name;
        }
        $about->save();
        return redirect()->route('admin.about.index')->with('success', 'About updated successfully');
    }
    public function destroy(About $about)
    {
        if ($about->image) {
            $image_path = public_path('uploads/abouts/' . $about->image);
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        $about->delete();
        return redirect()->route('admin.about.index')->with('message', 'About deleted successfully');
    }
    public function GenerateAboutThumbnailImage($image, $image_name)
    {

        $destinationPath = public_path('uploads/abouts');
        $img = Image::read($image->path());
        $img->cover(1410, 550,"top");
        $img->resize(1410, 550, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath. '/' .$image_name);
    }
}
