<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }
    public function orders()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('user.order', compact('orders'));
    }

    public function order_details($order_id)
    {

        $order = Order::where('user_id', Auth::user()->id)->where('id', $order_id)->first();
        if($order)
        {
            $orderItems = OrderItem::where('order_id', $order_id)->orderBy('id')->paginate(12);
            $transaction = Transaction::where('order_id', $order_id)->first();
            return view('user.order_details', compact('order', 'orderItems', 'transaction'));
        }else
        {
            return redirect()->route('login');
        }
    }

    public function cancel_order($order_id)
    {
        $order = Order::find($order_id);
        $order->status = 'canceled';
        $order->canceled_date = Carbon::now();
        $order->save();
        return back()->with('status', "Order has been canceled!");
    }

    public function address()
    {
        $user_id = Auth::id();
        if (!$user_id) {
            return redirect()->route('login');
        }

        $address = Address::where('user_id', $user_id)->first(); // Assuming user_id is the correct column
        return view('user.account_address', compact('address'));
    }

    public function addaddress($user_id)
    {
        return view('user.add_address', compact('user_id'));
    }
    public function storeAddress(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'zip' => 'required|string|max:10',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'isdefault' => 'nullable|boolean',
        ]);

        Address::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'zip' => $request->zip,
            'state' => $request->state,
            'city' => $request->city,
            'address' => $request->address,
            'locality' => $request->locality,
            'landmark' => $request->landmark,
            'isdefault' => $request->isdefault ? 1 : 0,
        ]);

        return redirect()->route('user.address')->with('success', 'Address added successfully!');
    }

    public function editAddress($address_id)
    {
        $address = Address::find($address_id);
        return view('user.edit_address', compact('address'));
    }
    public function updateAddress(Request $request, $address_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'zip' => 'required|string|max:10',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'isdefault' => 'nullable|boolean',
        ]);

        $address = Address::find($address_id);
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->zip = $request->zip;
        $address->state = $request->state;
        $address->city = $request->city;

        $address->address = $request->address;
        $address->locality = $request->locality;
        $address->landmark = $request->landmark;
        $address->isdefault = $request->isdefault ? 1 : 0;
        $address->save();
        return redirect()->route('user.address')->with('success', 'Address updated successfully!');
    }

    public function account_details()
    {
        return view('user.account_details');
    }

    public function admin_index()
    {
        $userInfo = User::withCount('orders')->orderBy('id', 'DESC')->paginate(10);
        return view('admin.user.index', compact('userInfo'));
    }
    public function admin_edit($id)
    {
        $user = User::find($id);
        $orders = Order::where('user_id', $user->id)->get();
        return view('admin.user.edit', compact('user', 'orders'));
    }
    public function admin_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'role' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->status = $request->status;
        $user->save();
        return redirect()->route('admin.user.index')->with('success', 'User updated successfully!');
    }
}