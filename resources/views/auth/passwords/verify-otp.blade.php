<!-- resources/views/auth/passwords/verify-otp.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify OTP') }}</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.verify.otp') }}">
                        @csrf

                        <input type="hidden" name="email_or_phone" value="{{ session('email') ?? session('phone') }}">

                        <div class="form-group row">
                            <label for="otp" class="col-md-4 col-form-label text-md-right">
                                {{ __('Enter OTP') }}
                            </label>

                            <div class="col-md-6">
                                <input id="otp" type="text"
                                    class="form-control @error('otp') is-invalid @enderror"
                                    name="otp" required autofocus>

                                @error('otp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Verify OTP') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
