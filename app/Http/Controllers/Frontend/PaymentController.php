<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PayPalService;

class PaymentController extends Controller
{
    protected $paypalService;

    public function __construct(PayPalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    public function show()
    {
        return view('payment');
    }

    public function create(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        try {
            $response = $this->paypalService->createOrder($request->amount);

            foreach ($response->result->links as $link) {
                if ($link->rel === 'approve') {
                    return redirect()->away($link->href);
                }
            }
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function success(Request $request)
    {
        try {
            $response = $this->paypalService->captureOrder($request->token);

            // Process the payment
            $transactionId = $response->result->id;
            $payerName = $response->result->payer->name->given_name;

            // Save to database or whatever you need
            // Order::where('id', $orderId)->update([...]);

            return view('payment.success', [
                'transaction_id' => $transactionId,
                'payer_name' => $payerName
            ]);

        } catch (\Exception $e) {
            return redirect()->route('payment.show')->withError($e->getMessage());
        }
    }

    public function cancel()
    {
        return redirect()->route('payment.show')->withError('Payment was cancelled.');
    }
}
