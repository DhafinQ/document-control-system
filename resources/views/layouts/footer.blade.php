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
<script src="jQuery.js"></script>

<!-- Searchable Option List (SOL) -->
<script src="{{ asset('assets/js/sol-2.0.0.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/css/searchableOptionList.css') }}">

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<!-- Dropdown Notification -->
<script src="{{ asset('assets/js/dropdownNotification.js') }}"></script>

<!-- Inisialisasi Searchable Option List -->
<script>
    $(function () {
        $('#my-select').searchableOptionList();
    });
</script>

<!-- Inisialisasi DataTable -->
<script>
    $(document).ready(function () {
        var url = window.location.pathname;
        var orderConfig;

        if (url === '/notifications') {
            orderConfig = [[2, "desc"]];
        } else if (url === '/categories') {
            orderConfig = [[0, "asc"]];
        } else {
            orderConfig = [[5, "desc"]];
        }

        // DataTable Biasa
        $('#myTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "order": orderConfig 
        });

        // DataTable Approval
        let tableApproval = $('#tableApproval').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "dom": "<'d-flex justify-content-between'lf>rtip",
            "order": orderConfig 
        });

        let searchBoxApproval = $('#tableApproval_wrapper .dataTables_filter');
        searchBoxApproval.addClass('d-flex align-items-center');

        let radioButtonsApproval = `
            <div class="me-3">
                <label class="me-1"><input type="radio" name="filterApproval" value="all" checked> Semua</label>
                <label class="me-1"><input type="radio" name="filterApproval" value="approved"> Approved</label>
                <label class="me-1"><input type="radio" name="filterApproval" value="pending"> Pending</label>
            </div>
        `;

        searchBoxApproval.prepend(radioButtonsApproval);

        $('input[name="filterApproval"]').on('change', function () {
            let filterValue = $('input[name="filterApproval"]:checked').val();
            let labelText = "Menampilkan: Semua";
            //masukin fungsi untuk setiap radio disini
            if (filterValue === "all") {
                tableApproval.column(3).search("").draw();
                labelText = "Menampilkan: Semua";
            } else if (filterValue === "approved") {
                tableApproval.column(3).search("Disetujui", true, false).draw();
                labelText = "Menampilkan: Disetujui";
            } else if (filterValue === "pending") {
                tableApproval.column(3).search("Draft", true, false).draw();
                labelText = "Menampilkan: Pending";
            }

            $("#dynamicLabel").html(labelText);
        });

        // DataTable Document
        let tableDocument = $('#tableDocument').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "dom": "<'d-flex justify-content-between'lf>rtip",
            "order": orderConfig 
        });

        let searchBoxDocument = $('#tableDocument_wrapper .dataTables_filter');
        searchBoxDocument.addClass('d-flex align-items-center');

        let radioButtonsDocument = `
            <div class="me-3">
                <label class="me-1"><input type="radio" name="filterDocument" value="all" checked> Semua</label>
                <label class="me-1"><input type="radio" name="filterDocument" value="aktif"> Aktif</label>
                <label class="me-1"><input type="radio" name="filterDocument" value="kadaluarsa"> Kadaluarsa</label>
            </div>
        `;

        searchBoxDocument.prepend(radioButtonsDocument);

        $('input[name="filterDocument"]').on('change', function () {
            let filterValue = $('input[name="filterDocument"]:checked').val();
            let labelText = "Menampilkan: Semua";
            //masukin fungsi untuk setiap radio disini
            if (filterValue === "all") {
                tableDocument.column(3).search("").draw();
                labelText = "Menampilkan: Semua";
            } else if (filterValue === "aktif") {
                tableDocument.column(3).search("approved", true, false).draw();
                labelText = "Menampilkan: Aktif";
            } else if (filterValue === "kadaluarsa") {
                tableDocument.column(3).search("pending", true, false).draw();
                labelText = "Menampilkan: Kadaluarsa";
            }

            $("#dynamicLabel2").html(labelText);
        });
    });
</script>

@yield('customJS')
</body>
</html>
