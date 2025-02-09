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

{{-- Select 2 SearchBox --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<!-- Dropdown Notification -->
<script src="{{ asset('assets/js/dropdownNotification.js') }}"></script>


<script>
    $(document).ready(function() {
        var oldSelections = @json(old('rev', isset($documentRevision) ? $documentRevision->revised_doc : []));

        // Function to format the initial selections
        function formatInitialSelections(data) {
            return data.map(function(doc) {
                return {
                    id: doc.id,
                    text: doc.title
                };
            });
        }

        if (oldSelections.length > 0) {
            $.ajax({
                url: '/documents_category',
                dataType: 'json',
                data: {
                    ids: oldSelections.join(',')
                },
                success: function(data) {
                    var initialSelections = formatInitialSelections(data);
                    $('#my-select').select2({
                        data: initialSelections,
                        ajax: {
                            url: '/documents_category',
                            dataType: 'json',
                            delay: 250, // Delay in milliseconds to prevent too many requests
                            data: function(params) {
                                var queryParameters = {
                                    q: params.term // Search term
                                };

                                // Conditionally set selectedOption based on $documentRevision->id
                                @if (isset($documentRevision) && !is_null($documentRevision->id))
                                    var selectedOption = {{ $documentRevision->document_id }};
                                    queryParameters.id = selectedOption;
                                @endif

                                return queryParameters;
                            },
                            processResults: function(data) {
                                return {
                                    results: data.map(function(doc) {
                                        return {
                                            id: doc.id,
                                            text: doc.title
                                        };
                                    })
                                };
                            },
                            cache: true
                        },
                        placeholder: 'Select documents',
                        allowClear: true,
                        multiple: true,
                        minimumInputLength: 2 // Minimum number of characters required to trigger the search
                    });

                    // Set the initial selections
                    $('#my-select').val(oldSelections).trigger('change');
                },
                error: function(error) {
                    console.error('Error fetching initial selections:', error);
                }
            });
        } else {
            $('#my-select').select2({
                ajax: {
                    url: '/documents_category', // URL endpoint for your search
                    dataType: 'json',
                    delay: 250, // Delay in milliseconds to prevent too many requests
                    data: function(params) {
                        var queryParameters = {
                            q: params.term // Search term
                        };

                        // Add id parameter if it exists
                        @if (isset($documentRevision) ? $documentRevision->id : 0)
                            var selectedOption = {{ $documentRevision->document_id }};
                            queryParameters.id = selectedOption;
                        @endif

                        return queryParameters;
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(doc) {
                                return {
                                    id: doc.id,
                                    text: doc.title
                                };
                            })
                        };
                    },
                    cache: true
                },
                placeholder: 'Select documents',
                allowClear: true,
                multiple: true,
                minimumInputLength: 3,
            });
        }
    });
</script>

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

        $('input[name="filterApproval"]').on('change', function() {
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
                <label class="me-1"><input type="radio" name="filterDocument" value="prosesrev"> Proses Revisi</label>
            </div>
        `;

        searchBoxDocument.prepend(radioButtonsDocument);

        $('input[name="filterDocument"]').on('change', function() {
            let filterValue = $('input[name="filterDocument"]:checked').val();
            let labelText = "Menampilkan: Semua";
            //masukin fungsi untuk setiap radio disini
            if (filterValue === "all") {
                tableDocument.column(3).search("").draw();
                labelText = "Menampilkan: Semua";
            } else if (filterValue === "aktif") {
                tableDocument.column(3).search("Disetujui", true, false).draw();
                labelText = "Menampilkan: Aktif";
            } else if (filterValue === "kadaluarsa") {
                tableDocument.column(3).search("Expired", true, false).draw();
                labelText = "Menampilkan: Kadaluarsa";
            } else if (filterValue === "prosesrev") {
                tableDocument.column(3).search("Proses Revisi", true, false).draw();
                labelText = "Menampilkan: Kadaluarsa";
            }

            $("#dynamicLabel2").html(labelText);
        });
    });
</script>

@yield('customJS')
</body>

</html>
