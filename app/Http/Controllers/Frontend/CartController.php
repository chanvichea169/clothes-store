<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::instance('cart')->content();
        return view('frontend.cart.index', compact('items'));
    }

    public function add_to_cart(Request $request)
    {
        $product = Product::find($request->id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found!');
        }

        $cartItem = Cart::instance('cart')->search(function ($cartItem) use ($request) {
            return $cartItem->id == $request->id;
        })->first();

        $requestedQuantity = $request->quantity;
        if ($cartItem) {
            $requestedQuantity += $cartItem->qty;
        }

        if ($product->quantity < $requestedQuantity) {
            $message = 'Sorry, we only have ' . $product->quantity . ' items in stock.';
            if ($cartItem) {
                $message .= ' You already have ' . $cartItem->qty . ' in your cart.';
            }
            return redirect()->back()->with('error', $message);
        }

        Cart::instance('cart')->add([
            'id' => $request->id,
            'name' => $request->name,
            'qty' => $request->quantity,
            'price' => $request->price,
            'weight' => $request->weight,
            'SKU' => $request->SKU,
            'options' => [
                'image' => $request->image,
                'description' => $request->description,
                'sku' => $request->sku,
                'slug' => $request->slug,
            ],
        ])->associate('App\Models\Product');


        return redirect()->back()->with('success', 'Item added to cart successfully!');
    }

    public function increase_cart_quantity($rowId)
    {
        $cartItem = Cart::instance('cart')->get($rowId);
        $product = Product::find($cartItem->id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found!');
        }

        $newQuantity = $cartItem->qty + 1;

        if ($product->quantity < $newQuantity) {
            return redirect()->back()->with('error',
                'Sorry, we only have ' . $product->quantity . ' items in stock. You already have ' . $cartItem->qty . ' in your cart.');
        }

        Cart::instance('cart')->update($rowId, $newQuantity);
        return redirect()->back()->with('success', 'Quantity updated!');
    }

    public function decrease_cart_quantity($rowId)
    {
        $cartItem = Cart::instance('cart')->get($rowId);
        $newQuantity = $cartItem->qty - 1;

        if ($newQuantity < 1) {
            return redirect()->back()->with('error', 'Quantity cannot be less than 1.');
        }

        Cart::instance('cart')->update($rowId, $newQuantity);
        return redirect()->back()->with('success', 'Quantity updated!');
    }

    public function remove_from_cart($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    public function clear_cart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }
}