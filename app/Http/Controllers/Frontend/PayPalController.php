<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class PaypalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createOrder(Request $request)
    {
        $clientId = config('paypal.client_id');
        $secret = config('paypal.secret');


        $total = Session::get('checkout.total', 0);
        $totalFormatted = number_format((float) $total, 2, '.', '');

        $tokenResponse = Http::withBasicAuth($clientId, $secret)
            ->asForm()
            ->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        $accessToken = $tokenResponse['access_token'];

        $orderResponse = Http::withToken($accessToken)
            ->post('https://api-m.sandbox.paypal.com/v2/checkout/orders', [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'reference_id' => 'default',
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $totalFormatted,
                    ],
                ]],
                'application_context' => [
                    'return_url' => route('paypal.success'),
                    'cancel_url' => route('paypal.cancel'),
                ],
            ]);

        $orderId = $orderResponse['id'];

        return redirect()->away('https://www.sandbox.paypal.com/checkoutnow?token=' . $orderId);
    }


    public function captureOrder(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication required',
            ], 401);
        }

        try {
            $clientId = config('paypal.client_id');
            $secret = config('paypal.secret');

            $tokenResponse = Http::withBasicAuth($clientId, $secret)
                ->asForm()
                ->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
                    'grant_type' => 'client_credentials',
                ]);

            $accessToken = $tokenResponse['access_token'];
            $orderID = $request->input('token');

            $captureResponse = Http::withToken($accessToken)
                ->post("https://api-m.sandbox.paypal.com/v2/checkout/orders/{$orderID}/capture");

            if ($captureResponse->successful()) {
                $paymentDetails = $captureResponse->json();

                if ($paymentDetails['status'] === 'COMPLETED') {
                    return $this->success($request);
                } else {
                    throw new \Exception('Payment capture failed.');
                }
            } else {
                throw new \Exception('PayPal capture API failed.');
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function success(Request $request)
    {
        DB::beginTransaction();

        try {

            if (!Session::has('pending_order')) {
                throw new \Exception('Session expired. Please try again.');
            }

            $pending = Session::get('pending_order');


            if (!isset($pending['checkout'], $pending['address'], $pending['cart_content'])) {
                throw new \Exception('Invalid order data.');
            }


            $order = Order::create([
                'user_id' => Auth::id(),
                'subtotal' => $pending['checkout']['subtotal'] ?? 0,
                'discount' => $pending['checkout']['discount'] ?? 0,
                'tax' => $pending['checkout']['tax'] ?? 0,
                'total' => $pending['checkout']['total'] ?? 0,
                'name' => $pending['address']['name'] ?? '',
                'phone' => $pending['address']['phone'] ?? '',
                'email' => $pending['address']['email'] ?? '',
                'address' => $pending['address']['address'] ?? '',
                'city' => $pending['address']['city'] ?? '',
                'zip' => $pending['address']['zip'] ?? '',
                'state' => $pending['address']['state'] ?? '',
                'landmark' => $pending['address']['landmark'] ?? '',
                'payment_method' => 'paypal',
                'payment_status' => 'completed',
            ]);


            foreach ($pending['cart_content'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'price' => $item['price'],
                    'quantity' => $item['qty'],
                    'name' => $item['name'],
                ]);
            }


            Transaction::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'mode' => 'paypal',
                'status' => 'completed',
                'amount' => $pending['checkout']['total'] ?? $order->total,
                'transaction_id' => $request->input('paymentId') ?? 'PAYPAL-'.uniqid(),
                'currency' => 'USD',
                'payment_details' => json_encode($request->all()),
            ]);


            Cart::instance('cart')->destroy();
            Session::forget(['checkout', 'coupon', 'discounts', 'pending_order']);
            Session::put('order_completed', true);
            Session::put('completed_order_id', $order->id);

            DB::commit();

            return redirect()->route('checkout.order.confirmation')
                   ->with('success', 'Your payment was successful!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('PayPal payment processing failed: '.$e->getMessage());

            return redirect()->route('cart.index')
                   ->with('error', 'Payment processing failed: '.$e->getMessage());
        }
    }

    public function cancel()
    {
        return redirect()->route('checkout.index')->with('error', 'PayPal payment was cancelled.');
    }
}