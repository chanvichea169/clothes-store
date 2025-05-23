@extends('admin.layouts.master')
@section('title', ' - Add Product')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Add Product</h3>
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
                    <div class="text-tiny">Add product</div>
                </li>
            </ul>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{ route('admin.store.product') }}">
            @csrf
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Product name <span class="tf-color-1">*</span></div>
                    <input class="mb-10 @error('name') is-invalid @enderror" type="text" placeholder="Enter product name"
                        name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger text-tiny mt-2">{{ $message }}</div>
                    @enderror
                    <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                    <input class="mb-10 @error('slug') is-invalid @enderror" type="text" placeholder="Enter product slug"
                        name="slug" value="{{ old('slug') }}" required>
                    @error('slug')
                        <div class="text-danger text-tiny mt-2">{{ $message }}</div>
                    @enderror
                    <div class="text-tiny">Do not exceed 100 characters when entering the product slug.</div>
                </fieldset>

                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select class="@error('category_id') is-invalid @enderror" name="category_id" required>
                                <option value="">Choose category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id')
                            <div class="text-danger text-tiny mt-2">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset class="brand">
                        <div class="body-title mb-10">Brand <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select class="@error('brand_id') is-invalid @enderror" name="brand_id" required>
                                <option value="">Choose Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('brand_id')
                            <div class="text-danger text-tiny mt-2">{{ $message }}</div>
                        @enderror
                    </fieldset>
                </div>

                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Status <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10 ht-150 @error('status') is-invalid @enderror" name="status"
                        placeholder="Status" required>{{ old('status') }}</textarea>
                    @error('status')
                        <div class="text-danger text-tiny mt-2">{{ $message }}</div>
                    @enderror
                    <div class="text-tiny">Enter the product status.</div>
                </fieldset>

                <fieldset class="description">
                    <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10 @error('description') is-invalid @enderror" name="description"
                        placeholder="Description" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger text-tiny mt-2">{{ $message }}</div>
                    @enderror
                    <div class="text-tiny">Enter detailed product description.</div>
                </fieldset>
            </div>

            <div class="wg-box">
                <fieldset>
                    <div class="body-title">Upload images <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" style="display:none">
                            <img src="" class="effect8" alt="">
                        </div>
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
                    @error('image')
                        <div class="text-danger text-tiny mt-2">{{ $message }}</div>
                    @enderror
                    <div class="text-tiny">Maximum file size: 2MB. Allowed formats: jpeg, png, jpg, gif, svg.</div>
                </fieldset>

                <fieldset>
                    <div class="body-title mb-10">Upload Gallery Images</div>
                    <div class="upload-image mb-16">
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
                    @error('gallery')
                        <div class="text-danger text-tiny mt-2">{{ $message }}</div>
                    @enderror
                    @error('gallery.*')
                        <div class="text-danger text-tiny mt-2">{{ $message }}</div>
                    @enderror
                    <div class="text-tiny">Maximum 5 images, 2MB each. Allowed formats: jpeg, png, jpg, gif, svg.</div>
                </fieldset>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Sale Price <span class="tf-color-1">*</span></div>
                        <input class="mb-10 @error('price') is-invalid @enderror" type="number" min="0.01" step="0.01"
                            placeholder="Enter sale price" name="price" value="{{ old('price') }}" required>
                        @error('price')
                            <div class="text-danger text-tiny mt-2">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                        <input class="mb-10 @error('cost') is-invalid @enderror" type="number" min="0.01" step="0.01"
                            placeholder="Enter cost" name="cost" value="{{ old('cost') }}" required>
                        @error('cost')
                            <div class="text-danger text-tiny mt-2">{{ $message }}</div>
                        @enderror
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">SKU <span class="tf-color-1">*</span></div>
                        <input class="mb-10 @error('SKU') is-invalid @enderror" type="text" placeholder="Enter SKU"
                            name="SKU" value="{{ old('SKU') }}" required>
                        @error('SKU')
                            <div class="text-danger text-tiny mt-2">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span></div>
                        <input class="mb-10 @error('quantity') is-invalid @enderror" type="number" min="0"
                            placeholder="Enter quantity" name="quantity" value="{{ old('quantity') }}" required>
                        @error('quantity')
                            <div class="text-danger text-tiny mt-2">{{ $message }}</div>
                        @enderror
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Stock</div>
                        <div class="select mb-10">
                            <select class="@error('stock_status') is-invalid @enderror" name="stock_status">
                                <option value="instock" {{ old('stock_status', 'instock') == 'instock' ? 'selected' : '' }}>In Stock</option>
                                <option value="outofstock" {{ old('stock_status') == 'outofstock' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                        </div>
                        @error('stock_status')
                            <div class="text-danger text-tiny mt-2">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title mb-10">Featured</div>
                        <div class="select mb-10">
                            <select class="@error('featured') is-invalid @enderror" name="featured">
                                <option value="0" {{ old('featured', 0) == 0 ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('featured') == 1 ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                        @error('featured')
                            <div class="text-danger text-tiny mt-2">{{ $message }}</div>
                        @enderror
                    </fieldset>
                </div>

                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Add product</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        $('#myFile').on('change', function(e) {
            const [file] = this.files;
            if (file) {
                $("#imgpreview img").attr('src', URL.createObjectURL(file));
                $('#imgpreview').show();
            }
        });

        $('#gFile').on('change', function(e) {
            const gphotos = this.files;
            $.each(gphotos, function(key, value) {
                $('#galUpload').prepend(`<div class="item gitems"><img src="${URL.createObjectURL(value)}" /></div>`);
            });
        });

        $("input[name='name']").on('input', function() {
            const slug = stringToSlug($(this).val());
            $("input[name='slug']").val(slug);
        });

        function stringToSlug(text) {
            return text.toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '');
        }
    });
</script>
@endpush
