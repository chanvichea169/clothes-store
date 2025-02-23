<script src="{{  asset('assets/js/plugins/jquery.min.js')}}"></script>
<script src="{{  asset('assets/js/plugins/bootstrap.bundle.min.js') }}"></script>
<script src="{{  asset('assets/js/plugins/bootstrap-slider.min.js') }}"></script>
<script src="{{  asset('assets/js/plugins/swiper.min.js') }}"></script>
<script src="{{  asset('assets/js/plugins/countdown.js') }}"></script>
<script src="{{  asset('assets/js/theme.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/preline@latest/dist/preline.min.js""></script>
<script>
    document.addEventListener("livewire:navigated", () => {
        window.HSStaticMethods.autoInit();
    });
</script>
