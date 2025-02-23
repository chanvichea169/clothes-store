@extends('admin.layouts.master')
@section('title', ' - Add_Coupon')
@section('content')

<div class="main-content">
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Coupon Information</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}" class="color-dark">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('admin.coupons') }}">
                            <div class="text-tiny">Coupons</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">New Coupon</div>
                    </li>
                </ul>
            </div>
            <div class="wg-box">
                <form class="form-new-product form-style-1" method="POST" action="{{ route('admin.coupon.store') }}">
                    @csrf
                    <fieldset class="name">
                        <div class="body-title">Coupon Code <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Coupon Code" name="code"
                            value="{{ old('code') }}" required>
                    </fieldset>
                    @error('code') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                    <fieldset class="category">
                        <div class="body-title">Coupon Type</div>
                        <div class="select flex-grow">
                            <select name="type">
                                <option value="">Select</option>
                                <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Percent</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('type') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                    <fieldset class="name">
                        <div class="body-title">Value <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Coupon Value" name="value"
                            value="{{ old('value') }}" required>
                    </fieldset>
                    @error('value') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                    <fieldset class="name">
                        <div class="body-title">Cart Value <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Cart Value" name="cart_value"
                            value="{{ old('cart_value') }}" required>
                    </fieldset>
                    @error('cart_value') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                    <fieldset class="name">
                        <div class="body-title">Expiry Date <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="date" name="expiry_date"
                            value="{{ old('expiry_date') }}" required>
                    </fieldset>
                    @error('expiry_date') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                    <div class="bot">
                        <button class="tf-button w208" type="submit">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(function() {
            $('#myFile').on('change', function(e) {
                const photoInput = $('#myFile');
                const [file] = this.files;
                if (file) {
                    $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    $('#imgpreview').show();
                }
            });

            $("input[name='name']").on('change', function() {
                $("input[name='slug']").val(stringToSlug($(this).val()));
            });

            function stringToSlug(Text) {
                return Text.toLowerCase()
                    .replace(/ /g, '-')
                    .replace(/[^\w-]+/g, '');
            }
        });
    </script>
@endpush

@endsection
