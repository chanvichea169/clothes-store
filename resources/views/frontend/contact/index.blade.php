@extends('frontend.layouts.master')
@section('title', '- Contact')
@section('content')
<style>
    .text-danger {
        color:red !important;
    }
</style>
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
      <div class="mw-930">
        <h2 class="page-title">CONTACT US</h2>
      </div>
    </section>

    <hr class="mt-2 text-secondary " />
    <div class="mb-4 pb-4"></div>

    <section class="contact-us container">
      <div class="mw-930">
        <div class="contact-us__form">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
          <form name="contact-us-form" class="needs-validation" novalidate="" action="{{ route('contact.store') }}" method="POST">
            @csrf
            <h3 class="mb-5">Get In Touch</h3>
            <div class="form-floating my-4">
              <input type="text" class="form-control" name="name" placeholder="Name *" required="">
              <label for="contact_us_name">Name *</label>
              @error('name')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-floating my-4">
              <input type="text" class="form-control" name="phone" placeholder="Phone *" required="">
              <label for="contact_us_name">Phone *</label>
              @error('phone')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-floating my-4">
              <input type="email" class="form-control" name="email" placeholder="Email address *" required="">
              <label for="contact_us_name">Email address *</label>
              @error('email')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="my-4">
              <textarea class="form-control form-control_gray" name="message" placeholder="Your Message" cols="30"
                rows="8" required=""></textarea>
                @error('message')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="my-4">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </section>
</main>

@endsection

@push('scripts')

<script>
document.getElementById("contact-us-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission

    let form = event.target;
    let formData = new FormData(form);

    // Send form data to Laravel
    fetch(form.action, {
        method: "POST",
        body: formData
    }).then(response => response.json())
    .then(data => console.log("Laravel Response:", data))
    .catch(error => console.error("Laravel Error:", error));

    // Send form data to Getform.io
    fetch("https://getform.io/f/bkkyrpgb", {
        method: "POST",
        body: formData
    }).then(response => response.json())
    .then(data => console.log("Getform.io Response:", data))
    .catch(error => console.error("Getform.io Error:", error));

    alert("Your message has been sent!");
    form.reset(); // Reset form after submission
});
</script>c

@endpush
