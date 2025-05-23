<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryBanner;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::where('status', 1)->get()->take(3);
        $categories = Category::orderBy('name')->get();
        $onSaleProducts = Product::whereNotNull('cost')
                                ->where('cost', '<>', '')
                                ->where('quantity', '>', 0)
                                ->inRandomOrder()
                                ->take(8)
                                ->get();

        $fProducts = Product::where('featured', 1)
                            ->where('quantity', '>', 0)
                            ->paginate(8);

        $categoryBanners = CategoryBanner::all();

        return view('index', compact('slides', 'categories', 'onSaleProducts', 'fProducts', 'categoryBanners'));
    }


    public function search(Request $request)
    {
        $search = $request->input('search');

        // Search products
        $products = Product::where('name', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->paginate(12);


        return view('/frontend/shop', compact('products', 'search'));
    }


}