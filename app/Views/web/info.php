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

        <!-- ======= Breadcrumbs ======= -->
        <div style="margin-top: 100px;"></div>

        <!-- ======= Services Section ======= -->
        <section id="services" class="services">
            <div class="container">
            <div class="section-title">
          <h2></h2>
          <p>Jadwal Kegiatan dan Publikasi</p>
        </div>
                <div class="row">
                    <div class="col-md-4 mt-3 mt-md-0">
                        <div class="icon-box">
                            <i class="bi bi-calendar4-week"></i>
                            <h4><a href="<?php echo base_url() ?>/kegiatan">Kegiatan - Jadwal Pameran</a></h4>
                            <p>Dapatkan informasi seputar kegiatan dan jadwal pameran</p>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3 mt-md-0">
                        <div class="icon-box">
                            <i class="bi bi-card-checklist"></i>
                            <h4><a href="<?php echo base_url() ?>/peraturan">Peraturan - Regulasi</a></h4>
                            <p>Informasi seputar Tatacara, Perizinan, dan Peraturan terkait produk dalam negeri</p>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3 mt-md-0">
                        <div class="icon-box">
                            <i class="bi bi-camera-reels"></i>
                            <h4><a href="<?php echo base_url() ?>/video">Video Produk Indonesia</a></h4>
                            <p>Daftar video produk Indonesia</p>
                        </div>
                    </div>
                    <!--<div class="col-md-4 mt-3 mt-md-0">
                        <div class="icon-box">
                            <i class="bi bi-card-checklist"></i>
                            <h4><a href="https://www.katalogprodukhalal.id/" target="_blank">Katalog Produk Halal</a></h4>
                            <p>Katalog daftar produk halal di Indonesia. Daftarkan produk halalmu pada website ini</p>
                        </div>
                    </div> -->
                </div>

            </div>
        </section>

        <!-- tabel -->
        <!-- <section id="features" class="features">
            <div class="container">

                <div class="section-title">
                    <h2>Kegiatan dan Pameran</h2>
                    <p>Jadwal Kegiatan dan Pameran</p>
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
                                <td>Nama Kegiatan </td>
                                <td><input type="text" class="column_filter" id="col1_filter"></td>
                            </tr>
                            <tr id="filter_col3" data-column="2">
                                <td>Penyelenggara </td>
                                <td><input type="text" class="column_filter" id="col2_filter"></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-striped" id="example1">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Kegiatan</th>
                            <th scope="col">Penyelenggara</th>
                            <th scope="col">Waktu Kegiatan</th>
                            <th scope="col">Tempat</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php //$no=1; foreach($kegiatan as $keg_value) { ?>
                            <tr>
                                <th scope="row"><?php //echo $no; ?></th>
                                <td><?php //echo $keg_value->nama_kegiatan ?></td>
                                <td><?php //echo $keg_value->penyelenggara ?></td>
                                <td><?php //echo $keg_value->waktu_awal ?></td>
                                <td><?php //echo $keg_value->lokasi_pameran ?></td>
                            </tr>
                            <?php //$no++;} ?>
                        </tbody>
                      </table>
                </div>
            </div>
        </section> -->

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