@extends('admin.layouts.master')
@section('title', '- Create About')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>About</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <a href="{{ route('admin.about.index') }}">
                        <div class="text-tiny">About</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <div class="text-tiny">New About</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="form-new-product form-style-1" method="POST" action="{{ route('admin.about.store') }}" enctype="multipart/form-data">
                @csrf

                <fieldset class="name">
                    <div class="body-title">Title <span class="tf-color-1">*</span></div>
                    <input type="text" name="title" placeholder="Enter a catchy title" value="{{ old('title') }}" required class="flex-grow">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Description <span class="tf-color-1">*</span></div>
                    <textarea name="description" placeholder="Brief description about the store" required class="flex-grow">{{ old('description') }}</textarea>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Mission</div>
                    <textarea name="mission" placeholder="Our mission is..." class="flex-grow">{{ old('mission') }}</textarea>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Vision</div>
                    <textarea name="vision" placeholder="Our vision is..." class="flex-grow">{{ old('vision') }}</textarea>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Company Information</div>
                    <textarea name="company_infor" placeholder="Company history, values, or milestones" class="flex-grow">{{ old('company_infor') }}</textarea>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Upload Image</div>
                    <div class="upload-image flex-grow">
                        <div id="imgpreview" class="image-preview" style="display: none;">
                            <img src="#" alt="About Image Preview" class="effect8" />
                        </div>
                        <div class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon"><i class="icon-upload-cloud"></i></span>
                                <span class="body-text">Drop your image here or <span class="tf-color">click to browse</span></span>
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('myFile').addEventListener('change', function() {
        const [file] = this.files;
        if (file) {
            const preview = document.getElementById('imgpreview');
            const img = preview.querySelector('img');
            img.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    });
</script>
@endpush
