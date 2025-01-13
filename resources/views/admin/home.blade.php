<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTable Example</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
</head>
<body>
  <div class="container mt-4">
    <table id="example" class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Umur</th>
                <th>Kota</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Andika</td>
                <td>25</td>
                <td>Jakarta</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Rian</td>
                <td>30</td>
                <td>Bandung</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Budi</td>
                <td>27</td>
                <td>Surabaya</td>
            </tr>
        </tbody>
    </table>
</div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- Inisialisasi DataTable -->
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "paging": true,     
                "searching": true, 
                "ordering": true,  
            });
        });
    </script>
</body>
</html>
