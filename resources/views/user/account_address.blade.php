@extends('frontend.layouts.master')
@section('title', '- UserInformation')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
      <h2 class="page-title">My Account</h2>
      <div class="row">
        <div class="col-lg-3">
          @include('user.account-nav')
        </div>
        <div class="col-lg-9">
            <div class="page-content my-account__address">
              <div class="row">
                <div class="col-6">
                  <p class="notice">The following addresses will be used on the checkout page by default.</p>
                </div>
                <div class="col-6 text-right">
                  <a href="{{ route('user.address.add', Auth::id()) }}" class="btn btn-sm btn-primary text-light"><span class="material-symbols-rounded">
                    add
                    </span>Add New</a>
                </div>
              </div>
              <div class="my-account__address-list row">
                <h5>Shipping Address</h5>

                @if($address)
                <div class="my-account__address-item col-md-6">
                    <div class="my-account__address-item__title">
                    <h5>{{ $address->name }} <i class="fa fa-check-circle" style="color: green"></i></h5>
                    <a href="{{ route('user.address.edit', Auth::id()) }}" class="btn btn-sm btn-primary text-light">
                        <span class="material-symbols-rounded">edit_square</span>Edit
                    </a>
                    </div>
                    <div class="my-account__address-item__detail">
                    <p>{{ $address->address }}</p>
                    <p>{{ $address->locality }}</p>
                    <p>{{ $address->city }}</p>
                    <p>{{ $address->state }}</p>
                    <p>{{ $address->landmark }}</p>
                    <p>{{ $address->zip }}</p>
                    <br>
                    <p>{{ $address->email }}</p>
                    <p>{{ $address->phone }}</p>
                    </div>
                </div>
                @else
                <p class="text-muted">No address found. Please <a href="{{ route('user.address.add', Auth::id()) }}">add a new address</a>.</p>
                @endif
                <hr>
              </div>
            </div>
          </div>
      </div>
    </section>
  </main>
@endsection
