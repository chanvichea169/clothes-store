@extends('frontend.layouts.master')

@section('title', 'Pay with Card')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Complete Payment</h4>
                </div>
                <div class="card-body">
                    <!-- Order Summary -->
                    <div class="alert alert-info">
                        <p><strong>Order #{{ $order_id }}</strong></p>
                        <p>Amount Due: <strong>${{ number_format($amount, 2) }} {{ strtoupper($currency) }}</strong></p>
                    </div>

                    <!-- Stripe Card Form -->
                    <form id="stripe-payment-form">
                        <div id="card-element" class="mb-3 p-3 border rounded">
                            <!-- Stripe injects card fields here -->
                        </div>
                        <div id="card-errors" role="alert" class="alert alert-danger d-none"></div>

                        <button id="submit-button" class="btn btn-primary w-100 py-2">
                            <span id="button-text">Pay Now</span>
                            <span id="button-spinner" class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{ config('services.stripe.key') }}");
    const elements = stripe.elements();
    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
            }
        }
    });
    cardElement.mount('#card-element');

    const form = document.getElementById('stripe-payment-form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Disable button and show spinner
        const submitButton = document.getElementById('submit-button');
        const buttonText = document.getElementById('button-text');
        const spinner = document.getElementById('button-spinner');

        submitButton.disabled = true;
        buttonText.classList.add('d-none');
        spinner.classList.remove('d-none');

        // Confirm the card payment
        const { error, paymentIntent } = await stripe.confirmCardPayment(
            "{{ $client_secret }}", {
                payment_method: {
                    card: cardElement,
                }
            }
        );

        if (error) {
            // Show error to user
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
            errorElement.classList.remove('d-none');

            // Re-enable button
            submitButton.disabled = false;
            buttonText.classList.remove('d-none');
            spinner.classList.add('d-none');
        } else if (paymentIntent.status === 'succeeded') {
            // Redirect to success page
            window.location.href = "{{ route('checkout.success') }}?payment_id=" + paymentIntent.id;
        }
    });
</script>
@endsection
