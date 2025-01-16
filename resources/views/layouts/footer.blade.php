    </div>
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset('assets/js/app.min.js') }}"></script>
  <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Script Datatable -->
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
  <link rel="stylesheet"  href="{{ asset('assets/css/searchableOptionList.css') }}">
  <script type="text/javascript" src="jQuery.js"></script>
  <script type="text/javascript" src="{{ asset('assets/js/sol-2.0.0.js') }}"></script>

  <script type="text/javascript">
    $(function() {
        // initialize sol
        $('#my-select').searchableOptionList();
    });
</script>

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