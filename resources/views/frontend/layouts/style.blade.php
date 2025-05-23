
<link rel="shortcut icon" href="{{  asset('assets/images/logo.png') }}" type="image/x-icon">
<link rel="preconnect" href="{{  asset('https://fonts.gstatic.com/') }}">
<link href="{{  asset('https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap') }}" rel="stylesheet">
<link href="{{  asset('https://fonts.googleapis.com/css2?family=Allura&amp;display=swap')}}" rel="stylesheet">
<link rel="stylesheet" href="{{  asset('assets/css/plugins/swiper.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{  asset('assets/css/style.css') }}" type="text/css" />
<link rel="stylesheet" href="{{  asset('assets/css/custom.css') }}" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Load Google Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style>
    /* Hover and focus styles */
.hover-primary:hover, .hover-primary:focus {
    color: #0d6efd !important;
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.hover-bg-light:hover, .hover-bg-light:focus {
    background-color: #f8f9fa !important;
    transition: background-color 0.2s ease;
}

.hover-scale:hover {
    transform: scale(1.02);
    transition: transform 0.2s ease;
}

.hover-text-danger:hover {
    color: #dc3545 !important;
}

.dropdown-item:hover, .dropdown-item:focus {
    color: #0d6efd;
}

.dropdown-item.active {
    background-color: #f8f9fa;
    color: #0d6efd;
    font-weight: 500;
}
.language-changed {
    transform: scale(1.05);
    transition: transform 0.3s ease;
    color: #0d6efd;
}
/* Smooth transitions */
.dropdown-toggle, .dropdown-item, .btn {
    transition: all 0.2s ease;
}

/* Improved dropdown menu styling */
.dropdown-menu {
    border: 1px solid rgba(0,0,0,0.1) !important;
}

.dropdown-item {
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    margin: 0 0.25rem;
}
    .avatar {
    position: relative;
    display: inline-block;
    width: 32px;
    height: 32px;
}
.avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.avatar-sm {
    width: 28px;
    height: 28px;
}
.header-tools__item {
    margin-left: 15px;
}
.dropdown-toggle::after {
    margin-left: 0.5em;
    vertical-align: middle;
}
.material-symbols-rounded {
    font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    font-size: 1.1em;
    vertical-align: middle;
    margin-right: 4px;
}

.btn-sm .material-symbols-rounded {
    font-size: 1em;
    margin-right: 3px;
}

</style>
@stack('styles')

