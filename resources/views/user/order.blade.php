@extends('frontend.layouts.master')
@section('title', '- Orders')
@section('content')
    <style>
        .table> :not(caption)>tr>th {
        padding: 0.625rem 1.5rem .625rem !important;
        background-color: #6a6e51 !important;
        }

        .table>tr>td {
        padding: 0.625rem 1.5rem .625rem !important;
        }

        .table-bordered> :not(caption)>tr>th,
        .table-bordered> :not(caption)>tr>td {
        border-width: 1px 1px;
        border-color: #6a6e51;
        }

        .table> :not(caption)>tr>td {
        padding: .8rem 1rem !important;
        }
        .bg-success {
        background-color: #40c710 !important;
        }

        .bg-danger {
            background-color: #f44032 !important;
        }

        .bg-warning {
            background-color: #f5d700 !important;
            color: #000;
        }
        .list-icon-function .item {
                display: flex;
                align-items: center;
                gap: 6px;
                background-color: #f0f4ff;
                border: 1px solid #cddafd;
                border-radius: 6px;
                padding: 6px 12px;
                color: #2563eb; /* blue-600 */
                font-size: 14px;
                cursor: pointer;
                transition: background-color 0.3s ease, box-shadow 0.3s ease;
            }

            .list-icon-function .item:hover {
                background-color: #e0ecff;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            }

            .list-icon-function .item span {
                font-size: 20px;
            }

            .list-icon-function .item p {
                margin: 0;
                font-weight: 500;
            }
    </style>

    <main class="pt-90" style="padding-top: 0px;">
        <div class="mb-4 pb-4"></div>
            <section class="my-account container">
                <h2 class="page-title">Orders</h2>
                <div class="row">
                <div class="col-lg-2">
            @include('user.account-nav')
        </div>

            <div class="col-lg-10">
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 80px">OrderNo</th>
                                    <th>Name</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Subtotal</th>
                                    <th class="text-center">Tax</th>
                                    <th class="text-center">Total</th>

                                    <th class="text-center">Status</th>
                                    <th class="text-center">Order Date</th>
                                    <th class="text-center">Items</th>
                                    <th class="text-center">Delivered On</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td class="text-center">{{ $order->id }}</td>
                                    <td class="text-center">{{ $order->name }}</td>
                                    <td class="text-center">{{ $order->phone }}</td>
                                    <td class="text-center">${{ $order->subtotal }}</td>
                                    <td class="text-center">${{ $order->tax }}</td>
                                    <td class="text-center">${{ $order->total }}</td>

                                    <td class="text-center">
                                        @if($order->status == 'delivered')
                                        <span class="badge bg-success">Delivered</span>
                                        @elseif($order->status == 'canceled')
                                            <span class="badge bg-danger">Canceled</span>
                                        @elseif($order->status == 'shipped')
                                            <span class="badge bg-info">Shipped</span>
                                        @elseif($order->status == 'processing')
                                            <span class="badge bg-primary">Processing</span>
                                        @else
                                            <span class="badge bg-warning">Ordered</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $order->created_at }}</td>
                                    <td class="text-center">{{ $order->orderItems->count() }}</td>
                                    <td class="text-center">{{ $order->deliverd_date }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('user.order.details', $order->id) }}">
                                            <div class="list-icon-function view-icon float-start">
                                                <div class="item eye">
                                                    <span class="material-symbols-rounded">visibility</span>
                                                    <p>View</p>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
        </section>
    </main>
@endsection
