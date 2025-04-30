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
use Stripe\Exception\ApiErrorException;

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
        $checkout = Session::get('checkout');

        $request->validate([
            'mode' => 'required|in:card,paypal,cod',
        ]);

        switch ($request->mode) {
            case 'paypal':
                Session::put('pending_order', [
                    'address' => $address->toArray(),
                    'checkout' => $checkout,
                    'cart_content' => Cart::instance('cart')->content()->toArray(),
                ]);
                $order = $this->createOrder($address, 'payment_pending');
                $this->createOrderItems($order);
                $this->createTransaction($order, 'paypal');
                $this->clearCheckoutSession($order);
                Session::put('order_completed', true);
                Session::put('completed_order_id', $order->id);
                Session::forget('pending_order');
                Session::forget('checkout');

                return redirect()->route('paypal.create-order');

            case 'card':
                    try {
                        Stripe::setApiKey(config('services.stripe.secret'));


                        $order = $this->createOrder($address, 'payment_pending');
                        $this->createOrderItems($order);
                        $this->createTransaction($order, 'card');
                        $this->clearCheckoutSession($order);
                        Session::put('order_completed', true);
                        Session::put('completed_order_id', $order->id);
                        Session::forget('checkout');
                        Session::forget('pending_order');

                        $paymentIntent = PaymentIntent::create([
                            'amount' => intval($checkout['total'] * 100),
                            'currency' => 'usd',
                            'metadata' => [
                                'order_id' => $order->id,
                                'user_id' => $user_id,
                            ],
                            'automatic_payment_methods' => ['enabled' => true],
                        ]);

                        return redirect()->route('checkout.order.confirmation');


                    } catch (ApiErrorException $e) {
                        return response()->json([
                            'status' => 'error',
                            'message' => $e->getMessage(),
                        ], 500);
                    }
                    break;

            case 'cod':
            $order = $this->createOrder($address);
            $this->createOrderItems($order);
            $this->createTransaction($order, 'cod');
            $this->clearCheckoutSession($order);

            Session::put('order_completed', true);

            return redirect()->route('checkout.order.confirmation');

        }
        return redirect()->route('checkout.process.card')->with('error', 'Invalid payment mode selected.');
    }

    protected function createOrder($address)
    {
        $checkout = Session::get('checkout');

        return Order::create([
            'user_id' => $address->user_id,
            'subtotal' => $checkout['subtotal'],
            'discount' => $checkout['discount'],
            'tax' => $checkout['tax'],
            'total' => $checkout['total'],
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

    protected function createTransaction($order, $mode, $transactionId = null)
    {
        return Transaction::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'mode' => $mode,
            'status' => $mode === 'cod' ? 'pending' : 'completed',
            'transaction_id' => $transactionId ?? ($mode === 'paypal' ? 'PAYPAL-' . uniqid() : 'TXN-' . uniqid()),
            'amount' => $order->total,
            'currency' => 'USD',
            'payment_details' => $mode === 'paypal' ? json_encode(request()->all()) : null,
        ]);
    }

    protected function clearCheckoutSession($order)
    {
        Cart::instance('cart')->destroy();
        Session::forget(['checkout', 'coupon', 'discounts']);
        Session::put('order_id', $order->id);
    }

    public function setAmountforCheckout()
    {
        if (Cart::instance('cart')->count() <= 0) {
            Session::forget('checkout');
            return;
        }

        if (Session::has('coupon')) {
            Session::put('checkout', [
                'coupon' => Session::get('coupon')['code'],
                'discount' => Session::get('discounts')['discount'],
                'subtotal' => Session::get('discounts')['subtotal'],
                'tax' => Session::get('discounts')['tax'],
                'total' => Session::get('discounts')['total'],
            ]);
        } else {
            Session::put('checkout', [
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total(),
            ]);
        }
    }

    public function order_confirmation()
    {
        if (!Session::has('order_completed')) {
            return redirect()->route('cart.index')->with('error', 'Order not found or already completed.');
        }

        $orderId = Session::get('completed_order_id') ?? Session::get('order_id');

        if (!$orderId) {
            return redirect()->route('cart.index')->with('error', 'Order ID missing.');
        }

        $order = Order::with('transactions')->find($orderId);

        if (!$order) {
            return redirect()->route('cart.index')->with('error', 'Order not found.');
        }

        $transaction = $order->transactions()->where('status', ['completed', 'pending'])->latest()->first();

        return view('frontend.checkout.order-confirmation', compact('order', 'transaction'));
    }


    public function showCardPaymentForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Session::has('checkout')) {
            return redirect()->route('cart.index');
        }

        $this->setAmountforCheckout();
        $checkout = Session::get('checkout');

        return view('frontend.checkout.payment-card', [
            'amount' => $checkout['total'],
            'currency' => 'usd',
            'order_id' => 'ORD-' . uniqid(),
        ]);
    }

    public function handleStripeReturn(Request $request)
    {
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        try {
            $paymentIntent = $stripe->paymentIntents->retrieve($request->input('payment_intent'));
            $order = Order::find($paymentIntent->metadata['order_id'] ?? null);

            if (!$order) {
                throw new \Exception("Order not found.");
            }

            switch ($paymentIntent->status) {
                case 'succeeded':
                    $order->update(['status' => 'processing']);
                    $this->createTransaction($order, 'card', $paymentIntent->id);
                    $this->clearCheckoutSession($order);
                    Session::put('order_completed', true);
                    return redirect()->route('checkout.order.confirmation')->with('success', 'Your payment was successful!');

                case 'requires_action':
                    return back()->with('error', 'Authentication required. Please complete 3D Secure verification.');

                default:
                    $order->update(['status' => 'failed']);
                    throw new \Exception("Payment failed: " . ($paymentIntent->last_payment_error ? $paymentIntent->last_payment_error->message : "Unknown error"));
            }

        } catch (\Exception $e) {
            return redirect()->route('checkout.payment.card')
                ->with('error', 'Payment processing failed. ' . $e->getMessage());
        }
    }



    /**
     * Stripe webhook (for async payment confirmation).
     */
    public function handleStripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch (\Exception $e) {
            return response('Invalid signature', 403);
        }

        if ($event->type === 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object;
            $order = Order::find($paymentIntent->metadata->order_id);

            if ($order && $order->status === 'payment_pending') {

                $order->update(['status' => 'processing']);

                $this->createTransaction($order, 'card', $paymentIntent->id);
            }
        }

        return response('Webhook handled', 200);
    }


}