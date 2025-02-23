@extends('frontend.layouts.master')
@section('title', '- Wishlist')
@section('content')

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Wishlist</h2>
      <div class="checkout-steps">
        <a href="javascript:void(0)" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">01</span>
          <span class="checkout-steps__item-title">
            <span>Shopping Bag</span>
            <em>Manage Your Items List</em>
          </span>
        </a>
        <a href="javascript:void(0)" class="checkout-steps__item">
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
      <div class="shopping-cart">
        @if(Cart::instance('wishlist')->content()->count() > 0)
        <div class="cart-table__wrapper">
          <table class="cart-table">
            <thead>
              <tr>
                <th>Product</th>
                <th></th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>
                      <div class="shopping-cart__product-item">
                        <img loading="lazy" src="{{ asset('uploads/products/thumbnails') }}/{{ $item->model->image }}" width="120" height="120" alt="{{ $item->name }}" />
                      </div>
                    </td>
                    <td>
                      <div class="shopping-cart__product-item__detail">
                        <h4>{{ $item->name }}</h4>
{{--                         <ul class="shopping-cart__product-item__options">
                          <li>Color: Yellow</li>
                          <li>Size: L</li>
                        </ul> --}}
                      </div>
                    </td>
                    <td>
                      <span class="shopping-cart__product-price">${{ $item->price }}</span>
                    </td>
                    <td>
                        {{ $item->qty }}
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{ route('wishlist.move_to_cart',['rowId'=>$item->rowId]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-info btn-sm">Move to Cart</button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form action="{{ route('wishlist.remove_from_wishlist', ['rowId' => $item->rowId]) }}" method="POST" id="remove-item-{{ $item->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:void(0)" class="remove-cart" onclick="document.getElementById('remove-item-{{ $item->id }}').submit()" >
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                        <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                        </svg>
                                    </a>
                                </form>
                            </div>
                        </div>
                    </td>
                  </tr>
                @endforeach
            </tbody>
          </table>
          <div class="cart-table-footer">
        <form action="{{ route('wishlist.empty') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="" class="btn btn-danger">CLEAR WISHLIS</button>
        </form>
          </div>
        </div>
        @else
            <div class="row mt-3">
                <div class="col-md-12">
                    <p>
                        No item found in your wishlist.
                        <a href="{{ route('shop.index') }}" class="btn btn-primary text-white">
                            Wishlist Now <i class="fa fa-arrow-right"></i>
                        </a>

                    </p>
                </div>
            </div>
        @endif
      </div>
    </section>
</main>

@endsection
