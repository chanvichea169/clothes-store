<!-- jQuery (if needed) -->
<script src="{{ asset('js/jquery.min.js') }}"></script>

<!-- Bootstrap 5 Bundle (recommended) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Other scripts -->
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/apexcharts/apexcharts.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
@stack('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = @json(csrf_token());
        const currentLocale = @json(app()->getLocale());

        const langBtns = document.querySelectorAll('.language-option');
        if (langBtns.length) {
            langBtns.forEach(option => {
                option.addEventListener('click', function (e) {
                    e.preventDefault();

                    const lang = this.getAttribute('data-lang');

                    localStorage.setItem('preferred_language', lang);

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = this.getAttribute('href');

                    const tokenInput = document.createElement('input');
                    tokenInput.type = 'hidden';
                    tokenInput.name = '_token';
                    tokenInput.value = csrfToken;
                    form.appendChild(tokenInput);

                    document.body.appendChild(form);
                    form.submit();
                });
            });
        }

        const preferredLang = localStorage.getItem('preferred_language');
        if (preferredLang && preferredLang !== currentLocale) {
            const langOption = document.querySelector(`.language-option[data-lang="${preferredLang}"]`);
            if (langOption) {
                langOption.click();
            }
        }
    });
</script>
