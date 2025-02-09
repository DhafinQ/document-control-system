$(document).ready(function () {
    // DataTable Document
    let tableDocument = $('#tableDocument').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "dom": "<'d-flex justify-content-between'lf>rtip",
        "order": [5, "desc"]
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

    $('input[name="filterDocument"]').on('change', function () {
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