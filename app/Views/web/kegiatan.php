<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Kegiatan Dan Jadwal Pameran</title>
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
          <p>KEGIATAN DAN JADWAL PAMERAN</p>
        </div>
        <div class="row">
          <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4><?php echo session()->getFlashdata('success'); ?></h4>
            </div>
          <?php endif; ?>
          <?php if (!empty(session()->getFlashdata('errorDaftar'))) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4><?php echo session()->getFlashdata('errorDaftar'); ?></h4>
            </div>
          <?php endif; ?>
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
                  <tr id="filter_col4" data-column="3">
                      <td>Tahun </td>
                      <td><input type="text" class="column_filter" id="col3_filter"></td>
                  </tr>
              </tbody>
          </table>
          <table class="table table-bordered table-striped" id="example1">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nama Kegiatan</th>
                  <th scope="col">Penyelenggara</th>
                  <th scope="col">Waktu Kegiatan (Awal - Akhir)</th>
                  <th scope="col">Pangan non pangan</th>
                  <th scope="col">Produk yang akan dipamerkan</th>
                  <th scope="col">Kuota Peserta</th>
                  <th scope="col">Lokasi Pameran</th>
                  <th scope="col">Kota</th>
                  <th scope="col">Provinsi</th>
                  <th scope="col">Pamflet</th>
                  <th scope="col">Batas Akhir Pendaftaran</th>
                  <th scope="col">Kontak Person</th>
                  <?php if (session()->get('logged_in')) { ?>
                  <th scope="col"></th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                  <?php $no=1; foreach($kegiatan as $keg_value) { ?>
                  <?php 
                    $nonpangan = $keg_value->pangan_non;
                    $explode = explode(";", $nonpangan);
                    if ($explode[0] == 'nonpangan') {
                        $kat1 = $explode[0];
                        $kat2 = $explode[1];
                    } else {
                        $kat1 = $explode[1];
                        $kat2 = $explode[0];
                    }
                    $sambung = ''; if($kat1 != '' && $kat2 != ''){ $sambung = ','; } ?>
                  <tr>
                      <th scope="row"><?php echo $no; ?></th>
                      <td><a href="<?php echo base_url().'/detail-kegiatan/'.str_replace(" ", "-", $keg_value->nama_kegiatan) ?>"><?php echo $keg_value->nama_kegiatan ?></a></td>
                      <td><?php echo $keg_value->namaPenyelenggara ?></td>
                      <td><?php echo date('d F Y', strtotime($keg_value->waktu_awal))." - ".date('d F Y', strtotime($keg_value->waktu_akhir)) ?></td>
                      <td><?php echo $kat1.' '.$sambung.' '.$kat2 ?></td>
                      <td><?php echo $keg_value->namakategori ?></td>
                      <td><?php echo $keg_value->kapasitas_peserta ?></td>
                      <td><?php echo $keg_value->lokasi_pameran ?></td>
                      <td><?php echo $keg_value->namakota ?></td>
                      <td><?php echo $keg_value->nama_provinsi ?></td>
                      <td><a href="#" class="pop"><img width="100%" src="<?php echo base_url().'/assets/img/pameran/'.$keg_value->pamflet ?>" alt=""></a></td>
                      <td><?php echo date('d F Y', strtotime($keg_value->batas_pendaftaran)) ?></td>
                      <td><?php echo $keg_value->kontak_person ?></td>
                      <?php if (session()->get('logged_in')) { ?>
                      <td>
                        <!-- <a class="btn btn-sm bg-success"  href="<?php //echo base_url() ?>/daftar-kegiatan/<?php //echo $keg_value->id_pembinaan ?>" data-toggle="tooltip" data-placement="bottom" title="Daftar" >
                          <i class="fas fa-plus-circle"></i>
                        </a> -->
                      </td>
                      <?php } ?>
                  </tr>
                  <?php $no++;} ?>
              </tbody>
            </table>
        </div>

      </div>
    </section><!-- End Blog Section -->
    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="" class="imagepreview" style="width: 100%;">
                </div>
            </div>
        </div>
    </div>

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

          $('.pop').on('click', function() {
              $('.imagepreview').attr('src', $(this).find('img').attr('src'));
              $('#imagemodal').modal('show');   
          });
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