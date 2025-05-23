@extends('admin.layouts.master')
@section('title', '- Add Category Banner')
@section('content')

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap-20 mb-27">
            <h3>Slide</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap-10">
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
                    <div class="text-tiny">New Category Banner</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <form class="form-new-product form-style-1"
                  method="POST"
                  action="{{ route('admin.category-banners.store') }}"
                  enctype="multipart/form-data">
                @csrf

                <fieldset class="name">
                    <div class="body-title">Title <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Title" name="title" value="{{ old('title') }}" required>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Starting Price <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="number" placeholder="Starting Price" name="starting_price" value="{{ old('starting_price') }}" required>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Link <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Link" name="link" value="{{ old('link') }}" required>
                </fieldset>

                <fieldset>
                    <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        <div class="image-preview" id="imgpreview" style="display: none">
                            <img src="sample.jpg" class="effect8" alt="Category Banner Image" />
                        </div>
                        <div class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon"><i class="icon-upload-cloud"></i></span>
                                <span class="body-text">Drop your image here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" required>
                            </label>
                        </div>
                    </div>
                </fieldset>

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Save</button>
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
