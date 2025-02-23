<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.product.index', compact('products'));
    }

    public function add_product()
    {
        $categories = Category::select(
            'id', 'name'
        )->orderBy('name', 'asc')->get();

        $brands = Brand::select(
            'id', 'name'
        )->orderBy('name', 'asc')->get();

        return view('admin.product.add-product' , compact('categories', 'brands'));
    }

    public function store_product(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'description' => 'required',
            'status' => 'required',
            'price' => 'required',
            'cost' => 'required',
            'SKU' => 'required',
            'size' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required',
            'brand_id' => 'required',
            'gallery' => 'array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->status = $request->status;
        $product->price = $request->price;
        $product->cost = $request->cost;
        $product->size = $request->size;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailImage($image, $imageName);
            $product->image = $imageName;
        }

        $gallery_arr = array();
        $gallery_images = "";
        $counter = 1;

        if ($request->hasFile('gallery')) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg', 'gif', 'svg'];
            $files = $request->file('gallery');
            foreach ($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                $gcheck = in_array($gextension, $allowedfileExtension);
                if ($gcheck) {
                    $gfilename = $current_timestamp . "-" . $counter . '.' . $gextension;
                    $this->GenerateProductThumbnailImage($file, $gfilename);
                    array_push($gallery_arr, $gfilename);
                    $counter++;
                }
            }
            $gallery_images = implode(',', $gallery_arr);
        }
        $product->gallery = $gallery_images;
        $product->save();

        return redirect()->route('admin.products')->with('success', 'Product added successfully');
    }

    public function edit_product($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::select(
            'id', 'name'
        )->orderBy('name', 'asc')->get();

        $brands = Brand::select(
            'id', 'name'
        )->orderBy('name', 'asc')->get();

        return view('admin.product.edit-product', compact('product', 'categories', 'brands'));
    }

    public function update_product(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,'.$request->id,
            'description' => 'required',
            'status' => 'required',
            'price' => 'required',
            'cost' => 'required',
            'SKU' => 'required',
            'size' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery' => 'array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);

        $product = Product::findOrFail($request->id);
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->price = $request->price;
        $product->cost = $request->cost;
        $product->SKU = $request->SKU;
        $product->size = $request->size;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->extension();
            $this->GenerateProductThumbnailImage($image, $name);
            $product->image = $name;
        }

        $gallery_images = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $name = time() . '.' . $file->extension();
                $this->GenerateProductThumbnailImage($file, $name);
                $gallery_images[] = $name;
            }
            $product->gallery = implode(',', $gallery_images);
        }

        $product->save();

        return redirect()->route('admin.products')->with('success', 'Product updated successfully');
    }

    public function delete_product($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
    }

    public function GenerateProductThumbnailImage($image, $image_name)
    {
        $destinationPathThumnail = public_path('uploads/products/thumbnails');
        $destinationPath = public_path('uploads/products');
        $img = Image::read($image->path());

        $img->cover(540, 689,"top");
        $img->resize(540, 689, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath. '/' .$image_name);

        $img->resize(104, 104, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPathThumnail. '/' .$image_name);
    }
}