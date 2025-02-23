<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        $orders = Order::orderBy('created_at', 'DESC')->paginate(12);

        return view('admin.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function order_details($order_id)
    {

        $order = Order::find($order_id);
        if (!$order) {
            return redirect()->route('admin.orders.index')->with('error', 'Order not found.');
        }

        $orderItems = OrderItem::where('order_id', $order_id)
                               ->orderBy('id')
                               ->paginate(12);

        $transaction = Transaction::where('order_id', $order_id)->first();

        return view('admin.order.details', compact('order', 'orderItems', 'transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_order_status(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = $request->order_status;

        if ($order->status == 'delivered') {
            $order->delivered_date = Carbon::now();
        } else if ($order->status == 'canceled') {
            $order->canceled_date = Carbon::now();
        }

        $order->save();

        if ($request->order_status == 'delivered') {
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            if ($transaction) {
                $transaction->status = 'approved';
                $transaction->save();
            }
        }

        return back()->with("status", "Status changed successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}