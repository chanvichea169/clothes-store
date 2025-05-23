<!-- jQuery (if needed) -->
<script src="{{ asset('js/jquery.min.js') }}"></script>

<!-- Bootstrap 5 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- ApexCharts must load before your chart script -->
<script src="{{ asset('js/apexcharts/apexcharts.js') }}"></script>

<!-- Other scripts -->
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<!-- Corrected Preline CDN -->
<script src="https://cdn.jsdelivr.net/npm/preline@latest/dist/preline.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('scripts')

