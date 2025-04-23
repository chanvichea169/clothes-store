<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to checkout.');
        }

        $address = Address::where('user_id', Auth::id())->where('isdefault', 1)->first();
        return view('frontend.checkout.index', compact('address'));
    }

    public function place_an_order(Request $request)
    {
        $user_id = Auth::id();
        $address = Address::where('user_id', $user_id)->where('isdefault', true)->first();

        if (!$address) {
            $request->validate([
                'name' => 'required|max:100',
                'phone' => 'required|numeric|digits:10',
                'email' => 'required|email',
                'zip' => 'required|numeric|digits:10',
                'state' => 'required',
                'city' => 'required',
                'address' => 'required',
                'locality' => 'required',
                'landmark' => 'required',
            ]);

            $address = Address::create([
                'user_id' => $user_id,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'zip' => $request->zip,
                'state' => $request->state,
                'city' => $request->city,
                'address' => $request->address,
                'locality' => $request->locality,
                'landmark' => $request->landmark,
                'country' => 'Cambodia',
                'isdefault' => true,
            ]);
        }

        $this->setAmountforCheckout();

        $request->validate([
            'mode' => 'required|in:card,paypal,cod',
        ]);

        if ($request->mode === 'paypal') {
            Session::put('pending_order', [
                'address' => $address->toArray(),
                'checkout' => Session::get('checkout'),
                'cart_content' => Cart::instance('cart')->content()->toArray()
            ]);
            return redirect()->route('paypal.create-order');
        }

        $order = $this->createOrder($address);
        $this->createOrderItems($order);
        $this->createTransaction($order, $request->mode);
        $this->clearCheckoutSession();

        // Set session variable to mark that the order has been completed
        Session::put('order_completed', true);

        return redirect()->route('checkout.order.confirmation');
    }

    protected function createOrder($address)
    {
        return Order::create([
            'user_id' => $address->user_id,
            'subtotal' => Session::get('checkout')['subtotal'],
            'discount' => Session::get('checkout')['discounts'],
            'tax' => Session::get('checkout')['tax'],
            'total' => Session::get('checkout')['total'],
            'name' => $address->name,
            'phone' => $address->phone,
            'email' => $address->email,
            'address' => $address->address,
            'city' => $address->city,
            'zip' => $address->zip,
            'state' => $address->state,
            'landmark' => $address->landmark,
            'status' => 'pending',
        ]);
    }

    protected function createOrderItems($order)
    {
        foreach (Cart::instance('cart')->content() as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'price' => $item->price,
                'quantity' => $item->qty,
            ]);
        }
    }

    protected function createTransaction(Order $order, $mode)
    {
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'amount' => $order->total,
            'mode' => $mode,
            'status' => 'completed',
        ]);
    }

    protected function clearCheckoutSession()
    {
        Cart::instance('cart')->destroy();
        Session::forget(['checkout', 'coupon', 'discounts']);
        Session::put('order_id', Order::latest()->first()->id);
    }

    public function setAmountforCheckout()
    {
        if (Cart::instance('cart')->content()->count() <= 0) {
            Session::forget('checkout');
            return;
        }

        if (Session::has('coupon')) {
            Session::put('checkout', [
                'coupon' => Session::get('coupon'),
                'discounts' => Session::get('discounts')['discount'],
                'subtotal' => Session::get('discounts')['subtotal'],
                'tax' => Session::get('discounts')['tax'],
                'total' => Session::get('discounts')['total'],
            ]);
        } else {
            Session::put('checkout', [
                'discounts' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total(),
            ]);
        }
    }

    public function order_confirmation()
    {
        // Check if the order has been completed and prevent further access
        if (!Session::has('order_completed')) {
            return redirect()->route('cart.index')->with('error', 'Order not found or already completed.');
        }

        // Once the order is completed, display the confirmation page
        $order = Order::find(Session::get('order_id'));
        return view('frontend.checkout.order-confirmation', compact('order'));
    }
}