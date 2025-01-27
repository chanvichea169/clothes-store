@extends('layouts.admin')
@section('content')

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Category infomation</h3>
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
                    <a href="{{ route('admin.categories') }}">
                        <div class="text-tiny">Category</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Edit Category</div>
                </li>
            </ul>
        </div>
        <!-- new-category -->
        <div class="wg-box">

            @if(Session::has('error'))
                <h4 class="alert alert-danger text-center">{{ Session::get('error') }}</h4>
            @endif

            <form
                class="form-new-product form-style-1"
                action="{{ route('admin.update.category') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @method('PUT')
                @csrf
                <input type="hidden" name="id" value="{{ $category->id }}" hidden>
                <fieldset class="name">
                    <div class="body-title">Category Name <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Category name" name="name"
                        tabindex="0" value="{{ $category->name }}" aria-required="true" required="">
                </fieldset>

                @error('name')
                    <div class="alert alert-danger text-center">{{ $message }}</div>
                @enderror
                <fieldset class="name">
                    <div class="body-title">Category Slug <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Category Slug" name="slug"
                        tabindex="0" value="{{ $category->slug }}" aria-required="true" required="" >
                </fieldset>
                @error('slug')
                    <div class="alert alert-danger text-center">{{ $message }}</div>
                @enderror
                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span>
                        </div>
                        <div class="upload-image flex-grow">
                            @if ($category->image)
                                <div class="item" id="imgpreview" style="display:block;">
                                    <img src="{{ asset('uploads/categories/' . $category->image) }}" class="effect8" alt="{{ $category->name }}">
                                </div>
                            @endif
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or select <span
                                            class="tf-color">click to browse</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
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
@push('scripts')
    <script>
        $(function() {
            $('#myFile').on('change', function(e) {
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                const [file] = this.files;
                if (file) {
                    if (!allowedTypes.includes(file.type)) {
                        alert('Please upload a valid image file (JPEG, PNG, GIF).');
                        this.value = '';
                        $('#imgpreview').hide();
                        return;
                    }
                    $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    $('#imgpreview').show();
                } else {
                    $('#imgpreview').hide();
                }
            });

            $("input[name='name']").on('change', function() {
                $("input[name='slug']").val(stringToSlug($(this).val()));
            });

            function stringToSlug(Text) {
                return Text
                    .toLowerCase()
                    .trim()
                    .replace(/[\s\W-]+/g, '-') // Replace spaces and non-word characters with '-'
                    .replace(/^-+|-+$/g, '');  // Remove leading and trailing '-'
            }
        });
    </script>
@endpush

@endsection
