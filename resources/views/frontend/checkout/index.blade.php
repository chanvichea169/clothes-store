@extends('layouts.app')

@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
        <h2 class="page-title">Shipping and Checkout</h2>
        <div class="checkout-steps">
            <a href="{{ route('cart.index') }}" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                    <span>Shopping Bag</span>
                    <em>Manage Your Items List</em>
                </span>
            </a>
            <a href="javascript:void(0)" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">02</span>
                <span class="checkout-steps__item-title">
                    <span>Shipping and Checkout</span>
                    <em>Checkout Your Items List</em>
                </span>
            </a>
            <a href="javascript:void(0)" class="checkout-steps__item">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title">
                    <span>Confirmation</span>
                    <em>Review And Submit Your Order</em>
                </span>
            </a>
        </div>
        <form name="checkout-form" action="{{ route('checkout.place.an.order') }}" method="POST">
            @csrf
            <div class="checkout-form">
                <div class="billing-info__wrapper">
                    <div class="row">
                        <div class="col-12">
                            <h4>SHIPPING DETAILS</h4>
                        </div>
                    </div>

                    <!-- Display the address if it exists -->
                    @if($address)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="my-account__address-list">
                                    <div class="my-account__address-list-item">
                                        <div class="my-account__address-list-item__detail">
                                            <p><strong>{{ $address->name }}</strong></p>
                                            <p>{{ $address->address }}, {{ $address->locality }}</p>
                                            <p>{{ $address->city }}, {{ $address->state }}, {{ $address->country }} - {{ $address->zip }}</p>
                                            <p>Phone: {{ $address->phone }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Display the address form if no address is found -->
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" required value="{{ old('name') }}">
                                    <label for="name">Full Name *</label>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" required value="{{ old('phone') }}">
                                    <label for="phone">Phone Number *</label>
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('zip') is-invalid @enderror" name="zip" id="zip" required value="{{ old('zip') }}">
                                    <label for="zip">Pincode *</label>
                                    @error('zip')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('state') is-invalid @enderror" name="state" id="state" required value="{{ old('state') }}">
                                    <label for="state">State *</label>
                                    @error('state')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" id="city" required value="{{ old('city') }}">
                                    <label for="city">Town / City *</label>
                                    @error('city')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" required value="{{ old('address') }}">
                                    <label for="address">House no, Building Name *</label>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('locality') is-invalid @enderror" name="locality" id="locality" required value="{{ old('locality') }}">
                                    <label for="locality">Road Name, Area, Colony *</label>
                                    @error('locality')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('landmark') is-invalid @enderror" name="landmark" id="landmark" required value="{{ old('landmark') }}">
                                    <label for="landmark">Landmark *</label>
                                    @error('landmark')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="checkout__totals-wrapper">
                    <div class="sticky-content">
                        <div class="checkout__totals">
                            <h3>Your Order</h3>
                            <table class="checkout-cart-items">
                                <thead>
                                    <tr>
                                        <th>PRODUCT</th>
                                        <th class="text-right">SUBTOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(Cart::instance('cart')->content() as $item)
                                        <tr>
                                            <td>{{ $item->name }} (x{{ $item->qty }})</td>
                                            <td class="text-right">${{ $item->price * $item->qty }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table class="checkout-totals">
                                <tbody>
                                    <tr>
                                        <th>Subtotal</th>
                                        <td class="text-right">${{ Cart::instance('cart')->subtotal() }}</td>
                                    </tr>
                                    @if(Session::has('coupon'))
                                        <tr>
                                            <th>Discount ({{ Session::get('coupon')['code'] }})</th>
                                            <td class="text-right">-${{ Session::get('discounts')['discount'] ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                            <th>Subtotal After Discount</th>
                                            <td class="text-right">${{ Session::get('discounts')['subtotal'] ?? Cart::instance('cart')->subtotal() }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th>Shipping</th>
                                        <td class="text-right">Free</td>
                                    </tr>
                                    <tr>
                                        <th>VAT</th>
                                        <td class="text-right">${{ Session::has('coupon') ? Session::get('discounts')['tax'] : Cart::instance('cart')->tax() }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td class="text-right">${{ Session::has('coupon') ? Session::get('discounts')['total'] : Cart::instance('cart')->total() }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="checkout__payment-methods">
                            <div class="form-check">
                                <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode1" value="card" required>
                                <label class="form-check-label" for="mode1">Debit or Credit Card</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode2" value="paypal" required>
                                <label class="form-check-label" for="mode2">PayPal</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode3" value="cod" required>
                                <label class="form-check-label" for="mode3">Cash on Delivery</label>
                            </div>
                            <div class="policy-text">
                                Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="#" target="_blank">privacy policy</a>.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-checkout">PLACE ORDER</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</main>
@endsection
