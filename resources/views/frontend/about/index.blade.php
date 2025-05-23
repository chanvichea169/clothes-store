@extends('frontend.layouts.master')
@section('title', '- About')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
      <div class="mw-930">
        <h2 class="page-title">About US</h2>
      </div>

      <div class="about-us__content pb-5 mb-5">
        <p class="mb-5">
          <img loading="lazy" class="w-100 h-auto d-block" src="{{ asset('uploads/abouts/' . $about->image) }}"
          alt="{{ $about->title }}" width="1410"
            height="550" />
        </p>
        <div class="mw-930">
            <h3 class="mb-4">OUR STORY</h3>
            <p class="fs-6 fw-medium mb-4">{{ $about->title }}</p>
            <p class="mb-4">
                {{ $about->description }}
            </p>
        <div class="row mb-3">
            <div class="col-md-6">
              <h5 class="mb-3">Our Mission</h5>
              <p class="mb-3">{{ $about->mission }}</p>
            </div>
            <div class="col-md-6">
              <h5 class="mb-3">Our Vision</h5>
              <p class="mb-3">{{ $about->vision }}</p>
            </div>
          </div>
        </div>
        <div class="mw-930 d-lg-flex align-items-lg-center">
          <div class="image-wrapper col-lg-6">
            <img class="h-auto" loading="lazy" src="{{ asset('uploads/abouts/' . $about->image) }}"
          alt="{{ $about->title }}" width="450" height="500" >
          </div>
          <div class="content-wrapper col-lg-6 px-lg-4">
            <h5 class="mb-3">The Company</h5>
            <p>{{ $about->company_infor }}</p>
          </div>
        </div>
      </div>
    </section>


</main>
@endsection
