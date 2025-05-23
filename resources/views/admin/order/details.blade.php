@extends('admin.layouts.master')
@section('title', '- Order_Details')
@section('content')
<style>
    .table-transaction>tbody>tr:nth-of-type(odd) {
        --bs-table-accent-bg: #fff !important;
    }
    td, th {
        font-size: 14px;
    }
</style>
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Order Details</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{ route('order.index') }}">
                        <div class="text-tiny">Order</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Order Details</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <h5>Order Details</h5>
                </div>
                <a class="tf-button style-1 w208 btn-sm" href="{{ route('order.index') }}">Back</a>
            </div>
            <div class="table-responsive">
                @if(Session::has('status'))
                    <p class="alert" style="font-size: 20px; color: white; background: rgb(2, 178, 75);">{{ Session::get('status') }}</p>
                @endif
                <table class="table table-striped table-bordered">
                    <tr>
                    <th>Order No</th>
                        <td>{{ $order->id }}</td>
                        <th>Mobile</th>
                        <td>{{ $order->phone }}</td>
                        <th>Zip Code</th>
                        <td>{{ $order->zip }}</td>
                    </tr>
                    <th>Order Date</th>
                        <td>{{ $order->created_at }}</td>
                        <th>Delivered Date</th>
                        <td>{{ $order->delivered_date }}</td>
                        <th>Canceled Date</th>
                        <td>{{ $order->canceled_date }}</td>
                    </tr>
                    <tr>
                        <th>Order Status</th>
                        <td>
                            @if($order->status == 'delivered')
                                <p class="badge bg-success" style="font-size: 14px;">Delivered</p>
                            @elseif($order->status == 'canceled')
                                <p class="badge bg-danger" style="font-size: 14px;">Canceled</p>
                            @elseif($order->status == 'shipped')
                                <p class="badge bg-info" style="font-size: 14px;">Shipped</p>
                            @elseif($order->status == 'processing')
                                <p class="badge bg-primary" style="font-size: 14px;">Processing</p>
                            @elseif($order->status == 'refunded')
                                <p class="badge bg-warning" style="font-size: 14px;">Refunded</p>
                            @else
                                <p class="badge bg-warning" style="font-size: 14px;">Ordered</p>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

            </div>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <h5>Order Items</h5>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">SKU</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Brand</th>
                            <th class="text-center">Options</th>
                            <th class="text-center">Return Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderItems as $item)
                        <tr>
                            <td class="pname">
                                <div class="image">
                                    <img src="{{ asset('uploads/products/thumbnails') }}/{{ $item->product->image }}" alt="{{ $item->product->name }}" class="image">
                                </div>
                                <div class="name">
                                    <a href="{{ route('admin.products', ['product_slug'=>$item->product->slug]) }}" target="_blank" >
                                </div>
                                <div class="name">
                                    <a href="{{ route('admin.products', ['product_slug' => $item->product->slug]) }}" target="_blank">
                                        <strong>{{ $item->product->name }}</strong>
                                    </a>
                                </div>
                            </td>
                            <td class="text-center">${{ $item->price }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-center">{{ $item->product->SKU }}</td>
                            <td class="text-center">{{ $item->product->category->name }}</td>
                            <td class="text-center">{{ $item->product->brand->name }}</td>
                            <td class="text-center">{{ $item->option }}</td>
                            <td class="text-center">{{ $item->rstatus == 0 ? "No":"YES" }}</td>
                            <td class="text-center">
                                <div class="list-icon-function view-icon">
                                    <div class="item eye">
                                        <i class="icon-eye"></i>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $orderItems->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <div class="wg-box mt-5">
            <h5>📦 Shipping Address</h5>
            <div class="my-account__address-item col-md-6">
                <div class="my-account__address-item__detail">
                    <p>👤 {{ $order->name }}</p>
                    <p>🏠 {{ $order->address }}</p>
                    <p>{{ $order->locality }}</p>
                    <p>🏙️ {{ $order->city }}</p>
                    <p>{{ $order->landkmark }}</p>
                    <p>📮 {{ $order->zip }}</p>
                    <br>
                    <p>📞 Mobile: {{ $order->phone }}</p>
                </div>
            </div>
        </div>

        <div class="wg-box mt-5">
            <h5>Transactions</h5>
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <th>Subtotal</th>
                        <td>${{ $order->subtotal }}</td>
                        <th>Tax</th>
                        <td>${{ $order->tax }}</td>
                        <th>Discount</th>
                        <td>${{ $order->discount }}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td>${{ $order->total }}</td>
                        <th>Payment Mode</th>
                        <td>{{ $transaction->mode }}</td>
                        <th>Status</th>
                        <td>
                            @if($transaction->status == 'approved')
                                <span class="badge bg-success" style="font-size: 14px;">Approved</span>
                            @elseif($transaction->status == 'refunded')
                                <span class="badge badge-warning" style="font-size: 14px;">Refunded</span>
                            @elseif($transaction->status == 'declined')
                                <span class="badge badge-danger" style="font-size: 14px;">Declined</span>
                            @else
                                <span class="badge bg-warning" style="font-size: 14px;">Pending</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="wg-box mt-5">
            <h5>Update Order Status</h5>
            <form action="{{ route('update.order.status', $order->id)}} " method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="select">
                            <select name="order_status" id="order_status">
                                <option value="ordered" {{ $order->status == 'ordered' ? "selected":"" }}>🛒 Ordered</option>
                                <option value="processing" {{ $order->status == 'processing' ? "selected":"" }}>⏳ Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? "selected":"" }}>📦 Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? "selected":"" }}>✅ Delivered</option>
                                <option value="canceled" {{ $order->status == 'canceled' ? "selected":"" }}>❌ Canceled</option>
                                <option value="refunded" {{ $order->status == 'refunded' ? "selected":"" }}>💸 Refunded</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary tf-button w208">Update Status</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

