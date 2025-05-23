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
        $categories = Category::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        $brands = Brand::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.product.add-product', compact('categories', 'brands'));
    }

    public function store_product(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|unique:products,slug|max:100',
            'description' => 'required|string',
            'status' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
            'cost' => 'required|numeric|min:0.01',
            'SKU' => 'required|string|max:50',
            'stock_status' => 'required|in:instock,outofstock',
            'featured' => 'required|boolean',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery' => 'nullable|array|max:5',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ], [
            'quantity.min' => 'Quantity must be a positive number or zero.',
            'price.min' => 'Price must be greater than zero.',
            'cost.min' => 'Cost must be greater than zero.',
            'gallery.max' => 'You can upload maximum 5 gallery images.',
            'image.max' => 'The image must not be greater than 2MB.',
            'gallery.*.max' => 'Each gallery image must not be greater than 2MB.'
        ]);

        try {
            $product = new Product();
            $product->name = $validated['name'];
            $product->slug = Str::slug($validated['name']);
            $product->description = $validated['description'];
            $product->status = $validated['status'];
            $product->price = $validated['price'];
            $product->cost = $validated['cost'];
            $product->SKU = $validated['SKU'];
            $product->stock_status = $validated['stock_status'];
            $product->featured = $validated['featured'];
            $product->quantity = $validated['quantity'];
            $product->category_id = $validated['category_id'];
            $product->brand_id = $validated['brand_id'];

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
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Product creation failed. ' . $e->getMessage()]);
        }
    }

    public function edit_product($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $categories = Category::select('id', 'name')->orderBy('name', 'asc')->get();

        $brands = Brand::join('products', 'brands.id', '=', 'products.brand_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('categories.name', $product->category->name)
            ->select('brands.id', 'brands.name')
            ->distinct()
            ->orderBy('brands.name', 'asc')
            ->get();

        return view('admin.product.edit-product', compact('product', 'categories', 'brands'));
    }

    public function update_product(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|unique:products,slug,'.$product->id.'|max:100',
            'description' => 'required|string',
            'status' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
            'cost' => 'required|numeric|min:0.01',
            'SKU' => 'required|string|max:50',
            'stock_status' => 'required|in:instock,outofstock',
            'featured' => 'required|boolean',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery' => 'nullable|array|max:5',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ], [
            'quantity.min' => 'Quantity must be a positive number or zero.',
            'price.min' => 'Price must be greater than zero.',
            'cost.min' => 'Cost must be greater than zero.',
            'gallery.max' => 'You can upload maximum 5 gallery images.',
            'image.max' => 'The image must not be greater than 2MB.',
            'gallery.*.max' => 'Each gallery image must not be greater than 2MB.'
        ]);

        try {
            $product->fill($validated);

            $current_timestamp = Carbon::now()->timestamp;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $current_timestamp . '.' . $image->extension();
                $this->GenerateProductThumbnailImage($image, $imageName);
                $product->image = $imageName;
            }

            if ($request->hasFile('gallery')) {
                $gallery_arr = array();
                $counter = 1;
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
                $product->gallery = implode(',', $gallery_arr);
            }

            $product->save();

            return redirect()->route('admin.products')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Update failed. ' . $e->getMessage()]);
        }
    }

    public function delete_product($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
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
