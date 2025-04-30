@extends('admin.layouts.master')
@section('title', ' - Edit_Product')
@section('content')
<!-- main-content-wrap -->
<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Product Information</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{ route('admin.products') }}">
                        <div class="text-tiny">Products</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Edit product</div>
                </li>
            </ul>
        </div>
        <!-- form-add-product -->
        @if(Session::has('error'))
            <h4 class="alert alert-danger text-center">{{ Session::get('error') }}</h4>
        @endif
        <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{ route('admin.update.product',['slug'=>$product->slug]) }}">

            @method('PUT')
            @csrf
            <input type="hidden" name="slug" value="{{ $product->slug }}">

            <div class="wg-box">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <fieldset class="name">
                    <div class="body-title mb-10">Product name <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter product name"
                        name="name" tabindex="0" value="{{ old('name', $product->name) }}" aria-required="true" required="">
                    <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                </fieldset>

                @error('slug')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <fieldset class="name">
                    <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter product slug"
                        name="slug" tabindex="0" value="{{  $product->slug }}" aria-required="true" required="">
                    <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                </fieldset>

                @error('category_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select class="" name="category_id" required>
                                <option>Choose category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>

                    @error('brand_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <fieldset class="brand">
                        <div class="body-title mb-10">Brand <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select class="" name="brand_id" required>
                                <option>Choose Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                </div>

                @error('status')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Status <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10 ht-150" name="status" placeholder="Status" tabindex="0" aria-required="true" required>{{ old('status', $product->status) }}</textarea>
                    <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                </fieldset>

                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <fieldset class="description">
                    <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true" required>{{ $product->description }}</textarea>
                    <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                </fieldset>
            </div>

            <div class="wg-box">

                <fieldset>
                    <div class="body-title">Upload images <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                    @if($product->image)
                        <div class="item" id="imgpreview">
                            <img src="{{ asset('uploads/products/' . $product->image) }}" class="effect8" alt="{{ $product->name }}">
                        </div>
                    @endif
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <div class="body-title mb-10">Upload Gallery Images</div>
                    <div class="upload-image mb-16">
                        @if($product->gallery)
                            @foreach(explode(',', $product->gallery) as $image)
                                <div class="item gitems">
                                    <img src="{{ asset('uploads/products/thumbnails/') }}/{{ trim($image) }}" alt="">
                                </div>
                            @endforeach
                        @endif
                        <div id="galUpload" class="item up-load">
                            <label class="uploadfile" for="gFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="text-tiny">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="gFile" name="gallery[]" accept="image/*" multiple>
                            </label>
                        </div>
                    </div>
                </fieldset>


                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Sale Price<span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter regular price"
                            name="price" tabindex="0" value="{{ $product->price }}" aria-required="true" required>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Regular Price <sapan class="tf-color-1">*</sapan></div>
                        <input class="mb-10" type="text" placeholder="Enter Cost"
                            name="cost" tabindex="0" value="{{ $product->cost }}" aria-required="true" required>
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">SKU <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter SKU" name="SKU"
                            tabindex="0" value="{{ $product->SKU }}" aria-required="true" required>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter quantity"
                            name="quantity" tabindex="0" value="{{ old('quantity', $product->quantity) }}" aria-required="true" required>
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Stock</div>
                        <div class="select mb-10">
                            <select class="" name="stock_status">
                                <option value="instock" {{ $product->stock_status == 'instock' ? 'selected' : '' }}>In Stock</option>
                                <option value="outofstock" {{ $product->stock_status == 'outofstock' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Featured</div>
                        <div class="select mb-10">
                            <select class="" name="featured">
                                <option value="0" {{  $product->featured == 0 ? 'selected' : '' }}>No</option>
                                <option value="1" {{ $product->featured == 1 ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                    </fieldset>
                </div>

                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Update product</button>
                </div>
            </div>
        </form>
        <!-- /form-add-product -->
    </div>
    <!-- /main-content-wrap -->
</div>

@endsection
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

            $('#gFile').on('change', function(e) {
                const photoInput = $('#gFile');
                const gphotos = this.files;
                $.each(gphotos, function(key, value) {
                   $('#galUpload').prepend(`<div class="item"><img src="${URL.createObjectURL(value)}" /></div>`);
                });
            });

            $(document).ready(function() {
            $('#categoryDropdown').change(function() {
                const categoryId = $(this).val();

                if (categoryId) {
                    $.ajax({
                        url: '/get-brands-by-category',
                        type: 'GET',
                        data: { category_id: categoryId },
                        success: function(response) {
                            const brandDropdown = $('#brandDropdown');
                            brandDropdown.empty();
                            brandDropdown.append('<option value="">Choose Brand</option>');

                            if (response.length > 0) {
                                $.each(response, function(index, brand) {
                                    brandDropdown.append(`<option value="${brand.id}">${brand.brand_name}</option>`);
                                });
                            } else {
                                brandDropdown.append('<option value="">No brands found for this category</option>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching brands:', xhr.responseText);
                            $('#brandDropdown').empty();
                            $('#brandDropdown').append('<option value="">Error fetching brands</option>');
                        }
                    });
                } else {
                    $('#brandDropdown').empty();
                    $('#brandDropdown').append('<option value="">Choose Brand</option>');
                }
            });
        });

        });
    </script>
@endpush
