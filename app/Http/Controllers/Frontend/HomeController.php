<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::where('status', 1)->get()->take(3);
        $categories = Category::orderBy('name')->get();
        $onSaleProducts = Product::whereNotNull('cost')->where('cost', '<>', '')->inRandomOrder()->take(8)->get();
        $fProducts = Product::where('featured', 1)->take(8)->get();
        return view('index', compact('slides', 'categories', 'onSaleProducts', 'fProducts'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $result = Product::where('name', 'LIKE', "%{$search}%")->get()->take(10);
        return response()->json($result);
    }
}