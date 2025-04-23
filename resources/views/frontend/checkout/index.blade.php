@extends('frontend.layouts.master')
@section('title', '- CheckOut')
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
        <form name="checkout-form" id="checkout-form" action="{{ route('checkout.place.an.order') }}" method="POST">
            @csrf
            <div class="checkout-form">
                <div class="billing-info__wrapper">
                    <div class="row">
                        <div class="col-12">
                            <h4>SHIPPING DETAILS</h4>
                        </div>
                    </div>
                    @if($address)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="my-account__address-list">
                                    <div class="my-account__address-list-item">
                                        <div class="my-account__address-list-item__detail">
                                            <p><strong>{{ $address->name }}</strong></p>
                                            <p>{{ $address->address }}, {{ $address->locality }}</p>
                                            <p>{{ $address->city }}, {{ $address->state }}, {{ $address->country }} - {{ $address->zip }}</p>
                                            <p>Email: {{ $address->email }}</p>
                                            <p>Phone: {{ $address->phone }}</p>
                                        </div>
                                    </div>
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
                                    <tr><th>PRODUCT</th><th class="text-right">SUBTOTAL</th></tr>
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
                                    <tr><th>Subtotal</th><td class="text-right">${{ Cart::instance('cart')->subtotal() }}</td></tr>
                                    @if(Session::has('coupon'))
                                        <tr><th>Discount ({{ Session::get('coupon')['code'] }})</th><td class="text-right">-${{ Session::get('discounts')['discount'] ?? 0 }}</td></tr>
                                        <tr><th>Subtotal After Discount</th><td class="text-right">${{ Session::get('discounts')['subtotal'] ?? Cart::instance('cart')->subtotal() }}</td></tr>
                                    @endif
                                    <tr><th>Shipping</th><td class="text-right">Free</td></tr>
                                    <tr><th>VAT</th><td class="text-right">${{ Session::has('coupon') ? Session::get('discounts')['tax'] : Cart::instance('cart')->tax() }}</td></tr>
                                    <tr><th>Total</th><td class="text-right">${{ Session::has('coupon') ? Session::get('discounts')['total'] : Cart::instance('cart')->total() }}</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="checkout__payment-methods">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mode" id="mode1" value="card" required>
                                <label class="form-check-label" for="mode1">Debit or Credit Card</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mode" id="mode2" value="paypal" required>
                                <label class="form-check-label" for="mode2">PayPal</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mode" id="mode3" value="cod" required>
                                <label class="form-check-label" for="mode3">Cash on Delivery</label>
                            </div>

                            <div id="card-form" class="mt-4" style="display: none;">
                                <div id="card-element"></div>
                                <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                            </div>

                            <div id="paypal-button-container" class="mt-3" style="display: none;"></div>

                            <div class="policy-text">
                                Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="#">privacy policy</a>.
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

@section('scripts')
<script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=USD"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paypalRadio = document.getElementById('mode2');
        const cardRadio = document.getElementById('mode1');
        const codRadio = document.getElementById('mode3');
        const paypalContainer = document.getElementById('paypal-button-container');
        const cardForm = document.getElementById('card-form');
        const placeOrderBtn = document.querySelector('.btn-checkout');
        const form = document.getElementById('checkout-form');

        // Show/Hide Payment Sections
        function togglePaymentUI() {
            if (paypalRadio.checked) {
                paypalContainer.style.display = 'block';
                cardForm.style.display = 'none';
                placeOrderBtn.style.display = 'none';
            } else if (cardRadio.checked) {
                cardForm.style.display = 'block';
                paypalContainer.style.display = 'none';
                placeOrderBtn.style.display = 'block';
            } else if (codRadio.checked) {
                cardForm.style.display = 'none';
                paypalContainer.style.display = 'none';
                placeOrderBtn.style.display = 'block';
            }
        }

        document.querySelectorAll('input[name="mode"]').forEach(radio => {
            radio.addEventListener('change', togglePaymentUI);
        });

        togglePaymentUI(); // Initial state

        // PayPal Buttons
        paypal.Buttons({
            createOrder: (data, actions) => {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: "{{ Session::has('coupon') ? Session::get('discounts')['total'] : Cart::instance('cart')->total() }}"
                        }
                    }]
                });
            },
            onApprove: (data, actions) => {
                return actions.order.capture().then(function(details) {
                    const formData = new FormData(form);
                    formData.append('paypal_order_id', data.orderID);
                    formData.append('mode', 'paypal');

                    fetch("{{ route('checkout.place.an.order') }}", {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(result => {
                        if (result.status === 'success') {
                            window.location.href = result.redirect_url;
                        } else {
                            alert(result.message || 'Payment failed.');
                        }
                    });
                });
            }
        }).render('#paypal-button-container');

        // Stripe Setup
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        form.addEventListener('submit', async (e) => {
            if (!cardRadio.checked) return; // Submit directly for COD

            e.preventDefault();

            const { token, error } = await stripe.createToken(cardElement);

            if (error) {
                document.getElementById('card-errors').textContent = error.message;
            } else {
                let input = document.createElement('input');
                input.setAttribute('type', 'hidden');
                input.setAttribute('name', 'stripeToken');
                input.setAttribute('value', token.id);
                form.appendChild(input);
                form.submit();
            }
        });
    });
</script>
@endsection

