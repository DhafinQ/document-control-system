$(document).ready(function () {
    // DataTable Approval
    let tableApproval = $('#tableApproval').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "dom": "<'d-flex justify-content-between'lf>rtip",
        "order": [5, "desc"]
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


    // Approve Logic
    $(document).on('click', '#btn-modalTerima', function() {
        let id = $(this).data('id'); // get the data attribute value from the button
        let status = $(this).data('status'); // get the data attribute value from the button
        fetchDocumentData(id); // fetch data based on the id
    });

    $(document).on('click', '#btn-modalTolak', function() {
        let id = $(this).data('id'); // get the data attribute value from the button
        let status = $(this).data('status'); // get the data attribute value from the button
        fetchDocumentData(id); // fetch data based on the id
    });

    function fetchDocumentData(id) {
        $.ajax({
            url: '/document_revision/data/', // replace with your endpoint
            type: 'GET', // or 'POST', depending on your backend logic
            data: {
                id: id
            },
            success: function(response) {
                populateModal(response.data); // assume the server sends back a response with 'data'
            },
            error: function(xhr) {
                console.error('Error fetching document data:', xhr);
            }
        });
    }

    function populateModal(data) {
        $('#reason_container').css('display','none');
        $('#acc_judul_doc').val(data.judul);
        $('#acc_code_doc').val(data.code);
        $('#acc_category_doc').val(data.category);
        $('#acc_uplodeder_doc').val(data.uploader);
        $('#acc_url_doc').attr('href', data.url);
        $('#acc_status1_doc').prop('checked', data.acc_format);
        $('#acc_status2_doc').prop('checked', data.acc_content);

        if(data.reason != ''){
            $('#reason_container').css('display','block');
            $('#acc_reason').val(data.reason);
        }

        $('#rev_judul_doc').val(data.judul);
        $('#rev_code_doc').val(data.code);
        $('#rev_category_doc').val(data.category);
        $('#rev_uploader_doc').val(data.uploader);
        $('#rev_url_doc').attr('href', data.url);

        if (data.status !== 'Draft' || 
            (data.roles.includes("administrator") && data.acc_format && data.acc_content) || 
            (data.roles.includes("bagian-mutu") && data.acc_content) || 
            (data.roles.includes("pengendali-dokumen") && data.acc_format) ||
            (data.roles.includes("bagian-mutu") && !data.acc_format) ||
            (data.roles.includes("kepala-puskesmas") && (!data.acc_format || !data.acc_content))) {
            
            $('#acc-btn').css('display', 'none');
            $('#acc_status1_doc').prop('disabled', true);
            $('#acc_status2_doc').prop('disabled', true);
        } else {
            if(data.roles.includes("administrator")){
                $('#acc_status1_doc').prop('disabled', false);
                $('#acc_status2_doc').prop('disabled', false);
            }
            $('#acc-btn').css('display', 'block');
        }   

        $('#formTolak').attr('action', '{{ url('/document_approval/') }}' + '/' + data.id);
        $('#formTerima').attr('action', '{{ url('/document_approval/') }}' + '/' + data.id);
    }
});