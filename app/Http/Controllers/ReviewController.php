<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function show(Product $product)
     {
        $reviews = Review::where('product_id', $product->id)
            ->where('approved', true)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

            return back()
            ->with('success', 'data fetched successfully')
            ->with('reviews', $reviews)
            ->with('product', $product);

     }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating'     => 'required|integer|min:1|max:5',
            'review'     => 'required|string|max:1000',
            'name'       => 'required_if:user_id,null|string|max:255',
            'email'      => 'required_if:user_id,null|email|max:255',
        ]);

        $user = Auth::user();

        Review::create([
            'user_id'    => $user?->id,
            'product_id' => $validated['product_id'],
            'rating'     => $validated['rating'],
            'comment'    => $validated['review'],
            'name'       => $validated['name'] ?? $user?->name ?? 'Anonymous',
            'email'      => $validated['email'] ?? $user?->email,
            'approved'   => (bool) $user,
        ]);

        return back()->with('success', $user ? 'Review submitted!' : 'Review submitted for approval!');
    }
}