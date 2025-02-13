<!-- jQuery & Bootstrap -->
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

<!-- Additional Libraries -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>

<!-- jQuery (CDN & Local) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<!-- Dropdown Notification -->
<script src="{{ asset('assets/js/dropdownNotification.js') }}"></script>

<!-- Inisialisasi DataTable -->
<script>
    $(document).ready(function() {

        var url = window.location.pathname;
        var orderConfig;

        if (url === '/notifications') {
            orderConfig = [
                [2, "desc"]
            ];
        } else if (url === '/categories') {
            orderConfig = [
                [0, "asc"]
            ];
        } else {
            orderConfig = [
                [5, "desc"]
            ];
        }

        // DataTable Biasa
        $('#myTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "order": orderConfig
        });
    });
</script>



@yield('customJS')
</body>

</html>
