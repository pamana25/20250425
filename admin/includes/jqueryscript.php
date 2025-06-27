<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
  <script src="https://cdn.datatables.net/plug-ins/1.11.3/sorting/datetime-moment.js"></script> -->

    <script>

      $(document).ready(function() {

        // $.fn.dataTable.moment('MMM D, YYYY');

        //for managencp page
        $('#datatable').DataTable({
          order: [[4, 'desc']],
        });

        //for managelss page
        $('#datatable1').DataTable({
          order: [[4, 'desc']],
        });

        });

        
        // console.log(moment().format("MMM D, YYYY"));

    </script>