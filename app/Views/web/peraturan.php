<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Tata cara, Perizinan dan Peraturan</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <?php echo view('web/template/head'); ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- =======================================================
  * Template Name: Sailor - v4.6.0
  * Template URL: https://bootstrapmade.com/sailor-free-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <?php echo view('web/template/header'); ?>

  <main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <div style="margin-top: 100px;"></div>
    
    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Info</h2>
          <p>TATA CARA, PERIZINAN DAN PERATURAN</p>
        </div>
        <div class="row">
          
        <table cellpadding="3" cellspacing="0" border="0" style="width: 67%;">
            <thead>
                <tr>
                    <th>Pencarian spesifik</th>
                    <th>Tulis kata</th>
                </tr>
            </thead>
            <tbody>
                <tr id="filter_col2" data-column="1">
                    <td>Judul </td>
                    <td><input type="text" class="column_filter" id="col1_filter"></td>
                </tr>
                <tr id="filter_col3" data-column="2">
                    <td>Kategori</td>
                    <td><input type="text" class="column_filter" id="col2_filter"></td>
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered table-striped" id="example1">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Judul</th>
                <th scope="col">Kategori</th>
                <th scope="col">File</th>
              </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($tatacara as $tata_value) { ?>
                <tr>
                    <th scope="row"><?php echo $no; ?></th>
                    <td><?php echo $tata_value->judul ?></td>
                    <td><?php echo $tata_value->kategori ?></td>
                    <td>
                      <a target="blank" href="<?php echo base_url()."".$tata_value->url ?>" >Download</a>
                    </td>
                </tr>
                <?php $no++;} ?>
            </tbody>
          </table>

        </div>

      </div>
    </section><!-- End Blog Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php echo view('web/template/footer'); ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <?php echo view('web/template/script'); ?>
  <!-- jQuery -->
  <script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="<?php echo base_url() ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/plugins/jszip/jszip.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?php echo base_url() ?>/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script>
      $(function () {
          $("#example1").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false,
          "language":{
              "emptyTable": "Tidak ada data yang tersedia pada tabel ini",
              "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
              "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
              "thousands": ",",
              "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
              },

          }
          }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      });
      

      function filterColumn ( i ) {
          $('#example1').DataTable().column( i ).search(
              $('#col'+i+'_filter').val()
          ).draw();
      }

      $(document).ready(function() {
          $('#example1').DataTable();
      
          $('input.column_filter').on( 'keyup click', function () {
              filterColumn( $(this).parents('tr').attr('data-column') );
          } );
      } );
  </script>
</body>

</html>