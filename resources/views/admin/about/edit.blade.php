@extends('admin.layouts.master')
@section('title', '- Update About')
@section('content')

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Update About</h3>
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
                    <div class="text-tiny">Update About</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            @if(Session::has('success'))
                <div class="alert alert-success" style="font-size: 18px; color: green;">
                    {{ Session::get('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="form-new-product form-style-1" method="POST" action="{{ route('admin.about.update', $about->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <fieldset class="name">
                    <div class="body-title">Title <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Title" name="title" tabindex="0" value="{{ old('title', $about->title) }}" aria-required="true" required>
                    @error('title')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Description <span class="tf-color-1">*</span></div>
                    <textarea class="flex-grow" placeholder="Description" name="description" rows="4" aria-required="true" required>{{ old('description', $about->description) }}</textarea>
                    @error('description')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Mission</div>
                    <textarea class="flex-grow" placeholder="Mission" name="mission" rows="3">{{ old('mission', $about->mission) }}</textarea>
                    @error('mission')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Vision</div>
                    <textarea class="flex-grow" placeholder="Vision" name="vision" rows="3">{{ old('vision', $about->vision) }}</textarea>
                    @error('vision')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Company Info</div>
                    <textarea class="flex-grow" placeholder="Company Info" name="company_infor" rows="3">{{ old('company_infor', $about->company_infor) }}</textarea>
                    @error('company_infor')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </fieldset>

                <fieldset>
                    <div class="body-title">Upload Image</div>
                    <div class="upload-image flex-grow">
                        @if($about->image && file_exists(public_path('uploads/abouts/' . $about->image)))
                        <div class="item" id="imgpreview">
                            <img src="{{ asset('uploads/abouts/' . $about->image) }}" class="effect8" alt="{{ $about->title }}">
                        </div>
                        @endif
                        <div class="image-preview" id="imgpreview" style="display: none;">
                            <img src="sample.jpg" class="effect8" alt="" />
                        </div>
                        <div class="item up-load">
                            <label class="uploadfile" for="aboutImage">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your image here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="aboutImage" name="image">
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
    $('#aboutImage').on('change', function(e) {
        const [file] = this.files;
        if (file) {
            $("#imgpreview img").attr('src', URL.createObjectURL(file));
            $('#imgpreview').show();
        }
    });
</script>
@endpush
