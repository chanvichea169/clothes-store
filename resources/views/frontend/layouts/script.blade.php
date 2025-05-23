<script src="{{ asset('assets/js/plugins/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/swiper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/countdown.js') }}"></script>
<script src="{{ asset('assets/js/theme.js') }}"></script>

<!-- Corrected Preline CDN -->
<script src="https://cdn.jsdelivr.net/npm/preline@latest/dist/preline.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Ensure the active state is correctly set when page loads
    const currentLocale = "{{ app()->getLocale() }}"; // Get current locale from Blade

    // Set the active class based on the locale
    const englishLink = document.querySelector('a[href="{{ route('change.language', 'en') }}"]');
    const khmerLink = document.querySelector('a[href="{{ route('change.language', 'km') }}"]');

    if (currentLocale === 'en') {
        englishLink.classList.add('active');
        khmerLink.classList.remove('active');
    } else if (currentLocale === 'km') {
        khmerLink.classList.add('active');
        englishLink.classList.remove('active');
    }

    // Prevent dropdown from resetting on click
    const dropdown = document.getElementById("languageDropdown");
    dropdown.addEventListener("click", function (e) {
        e.stopPropagation(); // Prevent dropdown from closing on click
    });

    const dropdownMenu = document.querySelector('.dropdown-menu');
    dropdownMenu.addEventListener("click", function (e) {
        e.stopPropagation(); // Prevent closing of dropdown when clicking inside
    });
});

</script>
