<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
        $onSaleProducts = Product::whereNotNull('cost')->where('cost', '<>', '')->inRandomOrder()->take(8)->get();
        $fProducts = Product::where('featured', 1)->paginate(8);
        return view('index', compact('slides', 'categories', 'onSaleProducts', 'fProducts'));
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
