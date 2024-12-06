<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pelaku Usaha</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <?php echo view('web/template/head'); ?>
  <!-- DataTables -->
  <link rel="stylesheet"
    href="<?php echo base_url() ?>/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet"
    href="<?php echo base_url() ?>/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet"
    href="<?php echo base_url() ?>/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet"
    href="<?php echo base_url() ?>/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
          <h2>Data</h2>
          <p>PELAKU USAHA</p>
        </div>
        <div class="row">

          <table cellpadding="3" cellspacing="0" border="0" style="width: 67%;">
            <thead>
              <tr>
                <th>Pencarian spesifik</th>
                <th>Tulis kata</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr id="filter_col6" data-column="5">
                <td>Provinsi</td>
                <td>
                  <!-- <input type="text" class="column_filter" id="col5_filter"> -->
                  <select class="column_filter select2" id="col5_filter">
                    <option <?php echo ($params_prov == '') ? 'selected' : '' ?> value="">Semua Provinsi</option>
                    <?php foreach($provinsi as $prov_value){ ?>
                          <option <?php echo ($params_prov == $prov_value->nama_provinsi) ? 'selected' : '' ?> value="<?php echo $prov_value->nama_provinsi ?>"><?php echo $prov_value->nama_provinsi ?>
                          </option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr id="filter_col5" data-column="4">
                <td>Kabupaten / Kota</td>
                <td>
                  <!-- <input type="text" class="column_filter" id="col4_filter"> -->
                  <select class="column_filter select2" id="col4_filter" <?php echo ($params_prov == '') ? 'disabled' : '' ?> >
                    <option <?php echo ($params_kota == '') ? 'selected' : '' ?> value="">Semua Kota/Kabupaten</option>
                    <?php if($params_prov != ''){ foreach($kota as $kota_value){ ?>
                          <option <?php echo ($params_kota == $kota_value->nama) ? 'selected' : '' ?> value="<?php echo $kota_value->nama ?>"><?php echo $kota_value->nama ?>
                          </option>
                    <?php } } ?>
                  </select>
                </td>
              </tr>
              <tr id="filter_col2" data-column="1">
                <td>Nama Perusahaan </td>
                <td>
                  <input value="<?php echo ($params_keyword != "") ? $params_keyword : '' ?>" type="text" class="column_filter" id="col1_filter">
                  <button onClick="searchByKeyword()" class="column_filter">Cari</button>
                </td>
              </tr>
              <tr>
                <!--<td>
                    <a href="<?php echo $link ?>"><button class="btn btn-primary" >Export Excel</button></a>
                </td> -->
              </tr>
            </tbody>
          </table>
          <table class="table" style="margin-top: 40px;">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Usaha</th>
                <th>Produk</th>
                <th>Alamat</th>
                <th>Kabupaten / Kota</th>
                <th>Provinsi</th>
                <th>No. Telepon/HP</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody>
            <?php $no=1; foreach($pelaku_usaha as $pelaku_value) { ?>
              <tr>
                <td></td>
                <td><?php echo ($pelaku_value->nama_usaha == "" || $pelaku_value->nama_usaha == null) ? 'Tidak ada informasi nama perusahaan' : $pelaku_value->nama_usaha ?></td>
                <td><?php echo ($pelaku_value->nama_produk == "" || $pelaku_value->nama_produk == null) ? 'Tidak ada informasi nama produk' : $pelaku_value->nama_produk ?></td>
                <td><?php echo ($pelaku_value->alamat == "" || $pelaku_value->alamat == null) ? 'Tidak ada informmasi alamat' : $pelaku_value->alamat ?></td>
                <td><?php echo ($pelaku_value->nama == "" ) ? '-' : $pelaku_value->nama ?></td>
                <td><?php echo ($pelaku_value->nama_provinsi == "" ) ? '-' : $pelaku_value->nama_provinsi ?></td>
                <td><?php echo ($pelaku_value->handphone == "" || $pelaku_value->handphone == null || $pelaku_value->handphone == 0) ? '-' : $pelaku_value->handphone ?></td>
                <td><?php echo ($pelaku_value->email == "" || $pelaku_value->email == null ) ? 'Tidak ada informasi email' : $pelaku_value->email ?></td>
              </tr>
              <?php $no++;} ?>
            </tbody>
          </table>
          <label style="color: gray"><?php echo (count($pelaku_usaha) == null) ? 0 : count($pelaku_usaha) ?> dari <?php echo (!empty($total) ? $total : 0 ) ?> data</label>
          

          <!-- <table class="table table-bordered table-striped" id="example1">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Usaha</th>
                <th scope="col">Produk</th>
                <th scope="col">Alamat</th>
                <th scope="col">Kabupaten / Kota</th>
                <th scope="col">Provinsi</th>
                <th scope="col">No. Telepon/HP</th>
                <th scope="col">Email</th>
              </tr>
            </thead>
            <tbody>
              <?php $no=1; foreach($pelaku_usaha as $pelaku_value) { ?>
              <tr>
                <th scope="row"><?php echo $no; ?></th>
                <td>
                  <?php echo ($pelaku_value->nama_usaha == "" || $pelaku_value->nama_usaha == null) ? 'Tidak ada informasi nama perusahaan' : $pelaku_value->nama_usaha ?>
                </td>
                <td>
                  <?php echo ($pelaku_value->nama_produk == "" || $pelaku_value->nama_produk == null) ? 'Tidak ada informasi nama produk' : $pelaku_value->nama_produk ?>
                </td>
                <td>
                  <?php echo ($pelaku_value->alamat == "" || $pelaku_value->alamat == null) ? 'Tidak ada informmasi alamat' : $pelaku_value->alamat ?>
                </td>
                <td><?php echo ($pelaku_value->nama == "" ) ? '-' : $pelaku_value->nama ?></td>
                <td><?php echo ($pelaku_value->nama_provinsi == "" ) ? '-' : $pelaku_value->nama_provinsi ?></td>
                <td>
                  <?php echo ($pelaku_value->handphone == "" || $pelaku_value->handphone == null || $pelaku_value->handphone == 0) ? '-' : $pelaku_value->handphone ?>
                </td>
                <td>
                  <?php echo ($pelaku_value->email == "" || $pelaku_value->email == null ) ? 'Tidak ada informasi email' : $pelaku_value->email ?>
                </td>
              </tr>
              <?php $no++;} ?>
            </tbody>
          </table> -->

        </div>

      </div>
    </section><!-- End Blog Section -->
    <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-12 entries">
                    <div class="blog-pagination">
                        <!-- <ul class="justify-content-center">
                          <ul>
                            
                          </ul>
                            <li><a href="#">Prev</a></li>
                            <li><a href="#">1</a></li>
                            <li class="active"><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">Next</a></li>
                        </ul> -->
                        <ul class="justify-content-center">
                            <?php echo $pager->links(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php echo view('web/template/footer'); ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <?php echo view('web/template/script'); ?>
  <!-- jQuery -->
  <script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
  <!-- Select2 -->
  <script src="<?php echo base_url() ?>/assets/plugins/select2/js/select2.full.min.js"></script>
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
      $('.select2').select2({
        theme: 'bootstrap4'
      })
    });

    $(function () {
      $("#example1").DataTable({
        // "dom": '<"top"lp>rt<"bottom"ilp><"clear">',
        "dom": 'Bfrtip',
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": [{
          extend: 'excel',
          text: 'Export Excel'
        }],
        "language": {
          "emptyTable": "Tidak ada data yang tersedia pada tabel ini",
          "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
          "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
          "buttons": {
            "excel": "Excel"
          },
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


    function filterColumn(i) {
      $('#newtable').DataTable().column(i).search(
        $('#col' + i + '_filter').val()
      ).draw();
    }

    $(document).ready(function () {
      // $('#newtable').DataTable();

      $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
      });

      $('select.column_filter').on('change', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
      });
    });

    $(document).ready(function (e) {
      $('#col5_filter').change(function () {
        var prov_id = $('#col5_filter').val();
        var kota_select = document.getElementById('col4_filter');
        var keyword = $('#col1_filter').val();
        var url = window.location.href;
        var url_pelaku = "<?php echo base_url(); ?>/pelaku-usaha";
        if (prov_id != "") {
          // var post_url = "<?php echo base_url();?>/produk/get_city/" + prov_id;
          window.location.href = url_pelaku+"?provinsi="+prov_id;
          // kota_select.removeAttribute("disabled");
          // $.ajax({
          //   type: "POST",
          //   url: post_url,
          //   data: {
          //     'id_provinsi': prov_id
          //   },
          //   success: function (cities) {
          //     $('#col4_filter').show();
          //     $('#col4_filter').html(cities);
          //   }
          // });
        } else {
          kota_select.selectedIndex = '';
          // $('#newtable').DataTable().column(4).search(
          //   $('#col4_filter').val()
          // ).draw();
          kota_select.disabled = true;
          var uri = "<?php echo base_url(); ?>/pelaku-usaha";
          // var post_url = "<?php echo base_url();?>/produk/get_city/all";
          if (keyword != "") {
            window.location.href = uri+"?keyword="+keyword;
          }else{
            window.location.href = uri;
          }
          // $.ajax({
          //   type: "POST",
          //   url: post_url,
          //   data: {
          //     'id_provinsi': 'all'
          //   },
          //   success: function (cities) {
          //     $('#col4_filter').show();
          //     $('#col4_filter').html(cities);
          //   }
          // });
        }
      });

      $('#col4_filter').change(function () {
        var prov_id = $('#col5_filter').val();
        var kota_select = $('#col4_filter').val();
        var url = window.location.href;
        var url_pelaku = "<?php echo base_url(); ?>/pelaku-usaha";
        if (prov_id != "") {
          if (kota_select != "") {
            window.location.href = url_pelaku+"?provinsi="+prov_id+"&kota="+kota_select;
          }else{
            window.location.href = url_pelaku+"?provinsi="+prov_id;
          }
        } else {
          window.location.href = url_pelaku+"?kota="+kota_select;
        }
      });
    });

    function searchByKeyword()
    {
      var prov_id = $('#col5_filter').val();
      var kota_select = $('#col4_filter').val();
      var keyword = $('#col1_filter').val();
      var url_pelaku = "<?php echo base_url(); ?>/pelaku-usaha?type=filter";
      if (prov_id != "") {
        var url_pelaku = url_pelaku+"&provinsi="+prov_id;
      }

      if (kota_select != "") {
        var url_pelaku = url_pelaku+"&kota="+kota_select;
      }
      
      if (keyword != "") {
        var url_pelaku = url_pelaku+"&keyword="+keyword;
      }

      window.location.href = url_pelaku;
    }

  </script>
</body>

</html>