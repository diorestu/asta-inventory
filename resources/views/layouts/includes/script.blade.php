{{-- type="13f11869d98b38b17e2994ee-text/javascript" --}}
<!-- jQuery -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>

<!-- Feather Icon JS -->
<script src="{{ asset('assets/js/feather.min.js') }}"></script>

<!-- Slimscroll JS -->
<script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>

<!-- Bootstrap Core JS -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- ApexChart JS -->
{{--
<script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script> --}}
{{--
<script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script> --}}

<!-- Chart JS -->
{{--
<script src="{{ asset('assets/plugins/chartjs/chart.min.js') }}"></script>
<script src="{{ asset('assets/plugins/chartjs/chart-data.js') }}"></script> --}}

<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tangkap session dari Laravel
        @if (session('success'))
            Toastify({
                text: "{{ session('success') }}",
                duration: 2500,
                gravity: "top",
                position: "right",
                backgroundColor: "#1b263b",
                stopOnFocus: true,
            }).showToast();
        @endif

        @if (session('error'))
            Toastify({
                text: "{{ session('error') }}",
                duration: 2500,
                gravity: "top",
                position: "right",
                backgroundColor: "#9d0208",
                stopOnFocus: true,
            }).showToast();
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                Toastify({
                    text: "{{ $error }}",
                    duration: 2500,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#9d0208",
                    stopOnFocus: true,
                }).showToast();
            @endforeach
        @endif
    });
</script>