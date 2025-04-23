@extends('frontend.layouts.master')
@section('title', '- UserInformation')
@section('content')

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
      <h2 class="page-title">Account Details</h2>
      <div class="row">
        <div class="col-lg-3">
            @include('user.account-nav')
        </div>
        <div class="col-lg-9">
          <div class="page-content my-account__edit">
            <div class="my-account__edit-form">
              <form name="{{ route('user.change.password') }}" action="#" method="POST" class="needs-validation" novalidate="" enctype="multipart/form-data">
                <!-- Profile Image Upload -->
                <div class="row mb-4">
                  <div class="col-md-6">
                    <div class="profile-card text-center p-4">
                      <div class="profile-image-wrapper mx-auto mb-3">
                        <img id="profile-preview" src="{{ auth()->user()->profile_picture ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=random' }}"
                             class="profile-image rounded-circle shadow-sm" width="150" height="150">
                      </div>
                      <div class="upload-btn-wrapper">
                        <button class="btn btn-upload">
                          <span class="material-symbols-rounded me-2">
                              upload
                          </span>Change Photo
                        </button>
                        <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                      </div>
                      <div class="small text-muted mt-2">JPG or PNG, Max 2MB</div>
                    </div>
                  </div>
                  <div class="col-md-6 d-flex align-items-center">
                    <div class="profile-info-card p-4 w-100">
                      <h5 class="mb-3">Profile Information</h5>
                      <p class="text-muted">Update your account's profile information and email address.</p>
                      <div class="d-grid gap-2 mt-4">
                        <button type="button" class="btn btn-outline-primary">Delete Photo</button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Personal Information -->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-floating my-3">
                      <input type="text" class="form-control" placeholder="Full Name" name="name" value="" required="">
                      <label for="name">Name</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating my-3">
                      <input type="text" class="form-control" placeholder="Mobile Number" name="mobile" value="{{ old('mobile') }}" required="">
                      <label for="mobile">Mobile Number</label>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-floating my-3">
                      <input type="email" class="form-control" placeholder="Email Address" name="email" value="" required="">
                      <label for="account_email">Email Address</label>
                    </div>
                  </div>

                  <!-- Password Change Section -->
                  <div class="col-md-12 mt-4">
                    <div class="password-change-header p-3 bg-light rounded">
                      <h5 class="mb-0">Password Change</h5>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating my-3">
                      <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Old password" required="">
                      <label for="old_password">Old password</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating my-3">
                      <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New password" required="">
                      <label for="account_new_password">New password</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating my-3">
                      <input type="password" class="form-control" cfpwd="" data-cf-pwd="#new_password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm new password" required="">
                      <label for="new_password_confirmation">Confirm new password</label>
                      <div class="invalid-feedback">Passwords did not match!</div>
                    </div>
                  </div>

                  <div class="col-md-12 mt-3">
                    <div class="d-flex justify-content-end">
                      <button type="submit" class="btn btn-primary btn-lg px-4">Save Changes</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
</main>

<style>
    /* Profile Section Styles */
    .profile-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #e9ecef;
    }

    .profile-info-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #e9ecef;
        height: 100%;
    }

    .profile-image {
        object-fit: cover;
        border: 3px solid #f0f2f5;
        transition: all 0.3s ease;
    }

    .profile-image:hover {
        transform: scale(1.03);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Upload Button Styles */
    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }

    .btn-upload {
        background-color: #f8f9fa;
        border: 1px dashed #adb5bd;
        color: #3e51fb;
        padding: 8px 20px;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-upload:hover {
        background-color: #3295f7;
        border-color: #b1b6ba;
        color: #f6f7f8;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
    }

    /* Password Change Header */
    .password-change-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-left: 4px solid #0d6efd;
    }

    /* Form Input Focus Styles */
    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
</style>

<script>
    // Profile picture preview
    document.getElementById('profile_picture').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            // Check file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size exceeds 2MB limit');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-preview').src = e.target.result;
                document.getElementById('profile-preview').classList.add('shadow-sm');
            }
            reader.readAsDataURL(file);
        }
    });
</script>

@endsection
