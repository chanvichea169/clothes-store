<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->query('size') ? $request->query('size') : 12;
        $o_column = "";
        $o_order = "";
        $order = $request->query('order') ? $request->query('order') : -1;
        $f_brands = $request->query('brands');
        $f_categories = $request->query('categories');
        $f_colors = $request->query('SKU');
        $min_price = $request->query('min') ? $request->query('min') : 1;
        $max_price = $request->query('max') ? $request->query('max') : 700;

        switch ($order) {
            case 1:
                $o_column = "created_at";
                $o_order = "desc";
                break;
            case 2:
                $o_column = "created_at";
                $o_order = "asc";
                break;
            case 3:
                $o_column = "price";
                $o_order = "asc";
                break;
            case 4:
                $o_column = "price";
                $o_order = "desc";
                break;
            default:
                $o_column = "id";
                $o_order = "desc";
        }

        $categories = Category::orderBy('name', 'asc')->get();
        $brands = Brand::orderBy('name', 'asc')->get();
        $colors = Product::select('SKU')->distinct()->get();

        $products = Product::where('quantity', '>', 0)
                    ->where(function ($query) use ($f_brands) {
                        $query->whereIn('brand_id', explode(',', $f_brands))
                              ->orWhereRaw("'".$f_brands."'=''");
                    })
                    ->where(function ($query) use ($f_categories) {
                        $query->whereIn('category_id', explode(',', $f_categories))
                              ->orWhereRaw("'".$f_categories."'=''");
                    })
                    ->where(function ($query) use ($f_colors) {
                        $query->whereIn('SKU', explode(',', $f_colors))
                              ->orWhereRaw("'".$f_colors."'=''");
                    })
                    ->where(function ($query) use ($min_price, $max_price) {
                        $query->whereBetween('price', [$min_price, $max_price])
                              ->orWhereBetween('cost', [$min_price, $max_price]);
                    })
                    ->orderBy($o_column, $o_order)
                    ->paginate($size);

        return view('frontend.shop.index', compact('products', 'size', 'order', 'brands', 'f_brands', 'categories', 'f_categories', 'min_price', 'max_price', 'f_colors', 'colors'));
    }


    public function product_datails($product_slug)
    {
        $product = Product::where('slug', $product_slug)->first();
        $rproducts = Product::where('slug','<>', $product_slug)->get()->take(8);
        return view('frontend.shop.details', compact('product', 'rproducts'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $size = $request->query('size') ? $request->query('size') : 12;
        $o_column = "";
        $o_order = "";
        $order = $request->query('order') ? $request->query('order') : -1;

        switch ($order) {
            case 1:
                $o_column = "created_at";
                $o_order = "desc";
                break;
            case 2:
                $o_column = "created_at";
                $o_order = "asc";
                break;
            case 3:
                $o_column = "price";
                $o_order = "asc";
                break;
            case 4:
                $o_column = "price";
                $o_order = "desc";
                break;
            default:
                $o_column = "id";
                $o_order = "desc";
        }

        $products = Product::where('name', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->orderBy($o_column, $o_order)
            ->paginate($size);

        return view('frontend.shop.index', compact('products', 'search', 'size', 'order'));
    }


}
