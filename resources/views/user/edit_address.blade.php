@extends('frontend.layouts.master')
@section('title', '- Edit Address')
@section('content')
<style>
.text-dangers {
    color: red;
    font-size: 16px;
}
</style>
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Edit Address</h2>
        <div class="row">
            <div class="col-lg-3">
                @include('user.account-nav')
            </div>
            <div class="col-lg-9">
                <div class="page-content my-account__address">
                    <div class="row">
                        <div class="col-6">
                            <p class="notice">Update your saved address below.</p>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('user.address') }}"class="btn btn-sm btn-primary text-light"><span class="material-symbols-rounded">
                                arrow_back</span>Back
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-5">
                                <div class="card-header">
                                    <h5>Edit Address</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('user.address.update', $address->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="name"
                                                        value="{{ old('name', $address->name) }}">
                                                    <label for="name">Full Name <code
                                                            class="text-dangers">*</code></label>
                                                    @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="email"
                                                        value="{{ old('email', $address->email) }}">
                                                    <label for="email">Email <code
                                                            class="text-dangers">*</code></label>
                                                    @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="phone"
                                                        value="{{ old('phone', $address->phone) }}">
                                                    <label for="phone">Phone Number <code
                                                            class="text-dangers">*</code></label>
                                                    @error('phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="zip"
                                                        value="{{ old('zip', $address->zip) }}">
                                                    <label for="zip">Pincode <code class="text-dangers">*</code></label>
                                                    @error('zip')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mt-3 mb-3">
                                                    <input type="text" class="form-control" name="state"
                                                        value="{{ old('state', $address->state) }}">
                                                    <label for="state">State <code class="text-dangers">*</code></label>
                                                    @error('state')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="city"
                                                        value="{{ old('city', $address->city) }}">
                                                    <label for="city">Town / City <code
                                                            class="text-dangers">*</code></label>
                                                    @error('city')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="address"
                                                        value="{{ old('address', $address->address) }}">
                                                    <label for="address">House no, Building Name <code
                                                            class="text-dangers">*</code></label>
                                                    @error('address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="locality"
                                                        value="{{ old('locality', $address->locality) }}">
                                                    <label for="locality">Road Name, Area, Colony <code
                                                            class="text-dangers">*</code></label>
                                                    @error('locality')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="landmark"
                                                        value="{{ old('landmark', $address->landmark) }}">
                                                    <label for="landmark">Landmark <code
                                                            class="text-dangers">*</code></label>
                                                    @error('landmark')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" name="country"
                                                        value="{{ old('country', $address->country) }}">
                                                    <label for="country">Country <code
                                                            class="text-dangers">*</code></label>
                                                    @error('country')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                        id="isdefault" name="isdefault"
                                                        {{ $address->isdefault ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="isdefault">
                                                        Make as Default Address
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-right">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
