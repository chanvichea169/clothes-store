<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\Laravel\Facades\Image;

class SlideController extends Controller
{
    public function index()
    {
        $slides = Slide::orderBy('id', 'DESC')->paginate(12);
        return view('admin.slide.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.slide.add');
    }

    public function store(Request $request)
    {
        request()->validate([
            'tagline' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'link' => 'required',
            'status' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ]);

        $slide = new Slide();
        $slide->tagline = request('tagline');
        $slide->title = request('title');
        $slide->subtitle = request('subtitle');
        $slide->link = request('link');
        $slide->status = request('status');

        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp. '.' .$file_extention;
        $this->GenerateSlideThumbnailImage( $image, $file_name);
        $slide->image = $file_name;

        $slide->save();

        return redirect()->route('admin.slide.index')->with('success', 'Slide added successfully');
    }

    public function edit($id)
    {
        $slide = Slide::find($id);
        return view('admin.slide.edit', compact('slide'));
    }

    public function update(Request $request, $id)
    {
        $slide = Slide::find($id);
        request()->validate([
            'tagline' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'link' => 'required',
            'status' => 'required',
            'image' => 'mimes:jpeg,png,jpg|max:2048',
        ]);
        $slide->tagline = request('tagline');
        $slide->title = request('title');
        $slide->subtitle = request('subtitle');
        $slide->link = request('link');
        $slide->status = request('status');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp. '.' .$file_extention;
            $this->GenerateSlideThumbnailImage( $image, $file_name);
            $slide->image = $file_name;
        }
        $slide->save();
        return redirect()->route('admin.slide.index')->with('success', 'Slide updated successfully');
    }

    public function destroy($id)
    {
        $slide = Slide::find($id);
        $slide->delete();
        return redirect()->route('admin.slide.index')->with('success', 'Slide deleted successfully');
    }
    public function GenerateSlideThumbnailImage($image, $image_name)
    {

        $destinationPath = public_path('uploads/slides');
        $img = Image::read($image->path());
        $img->cover(400, 690,"top");
        $img->resize(400, 690, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath. '/' .$image_name);
    }
}
