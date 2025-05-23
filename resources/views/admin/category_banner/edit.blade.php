@extends('admin.layouts.master')
@section('title', '- Update Category Banner')
@section('content')

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Update Category Banner</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <a href="{{ route('admin.category-banners.index') }}">
                        <div class="text-tiny">Category Banners</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <div class="text-tiny">Update Banner</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            @if(Session::has('success'))
                <div class="alert alert-success" style="font-size: 18px; color: green;">
                    {{ Session::get('success') }}
                </div>
            @endif

            <form class="form-new-product form-style-1" method="POST" action="{{ route('admin.category-banners.update', $categoryBanner->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $categoryBanner->id }}">

                <fieldset class="name">
                    <div class="body-title">Title <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Title" name="title" tabindex="0" value="{{ old('title', $categoryBanner->title) }}" aria-required="true" required>
                    @error('title')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Starting Price <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="number" placeholder="Starting Price" name="starting_price" tabindex="0" value="{{ old('starting_price', $categoryBanner->starting_price) }}" aria-required="true" required>
                    @error('starting_price')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </fieldset>

                <fieldset>
                    <div class="body-title">Upload Banner Image</div>
                    <div class="upload-image flex-grow">
                        @if($categoryBanner->image)
                        <div class="item" id="imgpreview">
                            <img src="{{ asset('uploads/category_banners/' . $categoryBanner->image) }}" class="effect8" alt="{{ $categoryBanner->title }}">
                        </div>
                        @endif
                        <div class="image-preview" id="imgpreview" style="display: none;">
                            <img src="sample.jpg" class="effect8" alt="" />
                        </div>
                        <div class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your image here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image">
                            </label>
                        </div>
                    </div>
                </fieldset>

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Save Change</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('#myFile').on('change', function(e) {
        const [file] = this.files;
        if (file) {
            $("#imgpreview img").attr('src', URL.createObjectURL(file));
            $('#imgpreview').show();
        }
    });
</script>
@endpush
