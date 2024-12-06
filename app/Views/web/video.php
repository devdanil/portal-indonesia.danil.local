<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Kemendag - Etalase Produk UMKM</title>
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

    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog">
      <div class="container" data-aos="fade-up">
        <div class="section-title" style="margin-top: 100px;">
          <h2>Info</h2>
          <p>Video Produk Indonesia</p>
        </div>
        <div class="row">
          <!-- <div class="col-lg-12 entries">

            <article class="entry">
              <div>
                <iframe width="1280" height="720" src="https://www.youtube.com/embed/qcpWTIXZxI8"
                  title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; 
                  clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                </iframe>
              </div>

              <h2 class="entry-title">
                <a href="blog-single.html">ETALASE UMKM - SEKAR JAWI Food - Produk Jamu dan Minuman Tradisional</a>
              </h2>

              <div class="entry-meta">
                <ul>
                  <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a
                      href="blog-single.html">Admin</a></li>
                  <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="blog-single.html"><time
                        datetime="2020-01-01">Nov 1, 2021</time></a></li>
                </ul>
              </div>

              <div class="entry-content">
                <p>
                  Menarik untuk diketahui berbagai produk unggulan dari SEKAR JAWI Food - Produk Jamu dan Minuman
                  Tradisional
                </p>
              </div>

            </article>

            <div class="blog-pagination">
              <ul class="justify-content-center">
                <li><a href="#">1</a></li>
                <li class="active"><a href="#">2</a></li>
                <li><a href="#">3</a></li>
              </ul>
            </div>

          </div> -->
          <!-- <table cellpadding="3" cellspacing="0" border="0" style="width: 67%;">
            <thead>
                <tr>
                    <th>Pencarian</th>
                    <th>Tulis kata</th>
                </tr>
            </thead>
            <tbody>
                <tr id="filter_col1" data-column="0">
                    <td>Judul </td>
                    <td><input type="text" class="column_filter" id="col0_filter"></td>
                </tr>
            </tbody>
          </table>
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Judul</th>
              <th>Keyword</th>
              <th>Video</th>
            </tr>
            </thead>
            <tbody>
            
            <tr>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            
            </tbody>
          </table> -->
          <section id="team" class="team ">
            <div class="container">
              <div class="row">
              <?php foreach($video as $value) { ?>
                <div class="col-lg-6"> 
                  <div class="member d-flex align-items-start">
                    <?php echo ($value->url_video == null ) ? '-' : preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","<iframe width=\"420\" height=\"315\" src=\"//www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe>",$value->url_video) ?>
                    <div class="member-info">
                      <h4><?php echo ($value->judul_video == null ) ? '-' : $value->judul_video ?></h4>
                      <p><?php echo ($value->keyword == null ) ? '-' : $value->keyword ?></p>
                      <!-- <div align="right" style="margin-top: 50px;">
                        <button class="btn btn-primary">Detail</button>
                      </div> -->
                    </div>
                  </div>
                </div> 
                <?php } ?>              
              </div>
            </div>
          </section>
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
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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