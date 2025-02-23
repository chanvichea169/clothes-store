@extends('admin.layouts.master')
@section('title', '- Add_Slide')
@section('content')

<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Slide</h3>
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
                    <a href="{{ route('admin.slide.index') }}">
                        <div class="text-tiny">Slider</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">New Slide</div>
                </li>
            </ul>
        </div>
        <!-- new-category -->
        <div class="wg-box">
            <form class="form-new-product form-style-1" method="POST" action="{{ route('admin.slide.store') }}" enctype="multipart/form-data">
                @csrf
                <fieldset class="name">
                    <div class="body-title">Tagline <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="tagline" name="tagline" tabindex="0" value="{{ old('tagline') }}" aria-required="true" required="">
                </fieldset>
                <fieldset class="name">
                    <div class="body-title">Title <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="title" name="title" tabindex="0" value="{{ old('title') }}" aria-required="true" required="">
                </fieldset>
                <fieldset class="name">
                    <div class="body-title">Subtitle <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="subtitle" name="subtitle" tabindex="0" value="{{ old('subtitle') }}" aria-required="true" required="">
                </fieldset>
                <fieldset class="name">
                    <div class="body-title">Link <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="link" name="link" tabindex="0" value="{{ old('link') }}" aria-required="true" required="">
                </fieldset>
                <fieldset>
                    <div class="body-title">Upload images <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        <div class="image-preview" id="imgpreview" style="display: none;">
                            <img src="sample.jpg" class="effect8" alt="" />
                        </div>
                        <div class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image">
                            </label>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="category">
                    <div class="body-title">Status</div>
                    <div class="select flex-grow">
                        <select name="status">
                            <option>Select</option>
                            <option value="1" @if(old('status')=="1") selected @endif>Action</option>
                            <option value="0" @if(old('status')=="0") selected @endif>Inactive</option>
                        </select>
                    </div>
                </fieldset>
                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Save</button>
                </div>
            </form>
        </div>
        <!-- /new-category -->
    </div>
    <!-- /main-content-wrap -->
</div>

@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

   $('#myFile').on('change', function(e) {
                const photoInput = $('#myFile');
                const [file] = this.files;
                if (file) {
                    $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    $('#imgpreview').show();
                }
            });
</script>
@endpush
