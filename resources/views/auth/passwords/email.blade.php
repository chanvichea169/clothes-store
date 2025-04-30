@extends('frontend.layouts.master')
@section('content')
<div class="min-vh-100 d-flex align-items-center bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <div class="card-header text-white py-4" style="background-color: #4e73df;">
                        <h1 class="h4 mb-0 text-center text-light">{{ __('Reset Password') }}</h1>
                    </div>

                    <div class="card-body p-5">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <span class="material-icons-outlined me-2">check_circle</span>
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <span class="material-icons-outlined me-2">error</span>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <p class="text-muted mb-4">{{ __('Enter your email address and we\'ll send you a link to reset your password.') }}</p>

                        <form method="POST" action="{{ route('password.email') }}" class="needs-validation" novalidate>
                            @csrf

                            <div class="mb-4">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <span class="material-icons-outlined">mail</span>
                                    </span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}"
                                           required autocomplete="email" autofocus
                                           placeholder="your@email.com">
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">
                                        <span class="material-icons-outlined align-middle me-1">info</span>
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg py-3">
                                    {{ __('Send Password Reset Link') }}
                                    <span class="material-icons-outlined align-middle ms-2">send</span>
                                </button>
                            </div>

                            <div class="text-center pt-3">
                                <a href="{{ route('login') }}" class="text-decoration-none">
                                    <span class="material-icons-outlined align-middle me-1">arrow_back</span>
                                    {{ __('Back to Login') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
    }
    .card {
        border: none;
    }
    .card-header {
        border-bottom: none;
    }
    .input-group-text {
        border-right: none;
    }
    .form-control {
        border-left: none;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }
    .btn-primary {
        background-color: #4e73df;
        border: none;
        transition: all 0.3s;
    }
    .btn-primary:hover {
        background-color: #2e59d9;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .material-icons-outlined {
        font-size: 1.2em;
        vertical-align: middle;
    }
</style>
@endpush
