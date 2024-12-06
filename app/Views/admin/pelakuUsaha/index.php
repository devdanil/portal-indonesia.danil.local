<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Indonesia | Pelaku Usaha</title>
  <link href="<?php echo base_url() ?>/assets/logo.png" rel="icon">
  <link href="<?php echo base_url() ?>/assets/logo.png" rel="apple-touch-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/select2/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/back/css/adminlte.min.css">
</head>
<style>
  .blog .blog-pagination {
    color: #8795a4;
  }
  .blog .blog-pagination ul {
    display: flex;
    padding: 0;
    margin: 0;
    list-style: none;
  }
  .blog .blog-pagination li {
    margin: 0 5px;
    transition: 0.3s;
  }
  .blog .blog-pagination li a {
    color: #556270;
    padding: 7px 16px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .blog .blog-pagination li.active, .blog .blog-pagination li:hover {
    background: #d9232d;
  }
  .blog .blog-pagination li.active a, .blog .blog-pagination li:hover a {
    color: #fff;
  }
</style>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <?php echo view('admin/template/navbar'); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php echo view('admin/template/aside'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pelaku Usaha</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Pelaku Usaha</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Pelaku Usaha</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php if (!empty(session()->getFlashdata('sukses'))) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h4><?php echo session()->getFlashdata('sukses'); ?></h4>
                    </div>
                <?php endif; ?>
                <?php if (!empty(session()->getFlashdata('error'))) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h4><?php echo session()->getFlashdata('error'); ?></h4>
                    </div>
                <?php endif; ?>
                <table cellpadding="3" cellspacing="0" border="0" style="width: 67%;">
                  <thead>
                      <tr>
                          <th>Pencarian</th>
                          <th>Pilih</th>
                      </tr>
                  </thead>
                  <tbody>
                    <form action="">
                      <tr id="filter_col4" data-column="3">
                        <td>Provinsi</td>
                        <td>
                          <!-- <input type="text" class="column_filter" id="col5_filter"> -->
                          <select name="provinsi" class="column_filter select2" id="col3_filter">
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
                          <select class="select2 column_filter" name="kota" id="col4_filter">
                            <option value="">Semua Kota/Kabupaten</option>
                            <?php if($params_prov != ''){ 
                              foreach($kota as $kota_value){ ?>
                                  <option <?php echo ($params_kota == $kota_value->nama) ? 'selected' : '' ?> value="<?php echo $kota_value->nama ?>"><?php echo $kota_value->nama ?>
                                  </option>
                            <?php 
                              } 
                            } 
                            ?>
                          </select>
                        </td>
                      </tr>
                      <tr id="filter_col7" data-column="6">
                          <td>Status Registrasi</td>
                          <td>
                            <select name="status" class="column_filter select2" id="col6_filter" >
                              <option <?php echo ($params_status == '') ? 'selected' : '' ?> value="">Semua Status</option>
                              <option <?php echo ($params_status == '0') ? 'selected' : '' ?> value="0">Belum Aktivasi</option>
                              <option <?php echo ($params_status == '1') ? 'selected' : '' ?> value="1">Proses Verikiasi Admin</option>
                              <option <?php echo ($params_status == '2') ? 'selected' : '' ?> value="2">Approved</option>
                              <option <?php echo ($params_status == '3') ? 'selected' : '' ?> value="3">Rejected</option>
                            </select>
                          </td>
                      </tr>
                      <tr id="filter_col8" data-column="6">
                          <td>Status Pelaku Usaha</td>
                          <td>
                            <select name="status" class="column_filter select2" id="col7_filter" >
                              <option <?php echo ($status_pelaku_usaha == '') ? 'selected' : '' ?> value="">Semua Status</option>
                              <option <?php echo ($status_pelaku_usaha == '0') ? 'selected' : '' ?> value="0">Tidak Diketahui</option>
                              <option <?php echo ($status_pelaku_usaha == '1') ? 'selected' : '' ?> value="1">Aktif</option>
                              <option <?php echo ($status_pelaku_usaha == '2') ? 'selected' : '' ?> value="2">Tidak Aktif</option>
                            </select>
                          </td>
                      </tr>
                      <tr id="filter_col2" data-column="1">
                        <td>Email/Nama Perusahaan</td>
                        <td>
                          <input type="text" name="email" class="column_filter" value="<?php echo ($params_email == '') ? '' : $params_email ?>" id="col1_filter">
                          <button class="btn btn-success btn-sm" type="submit" >Cari</button>
                        </td>
                      </tr>
                      <tr id="filter_col3" data-column="1">
                        <td>Tanggal Bergabung</td>
                        <td>
                          <div class="row">
                            <div class="col">
                              <label>Start Date</label>
                              <input type="date" name="start_date date-filter" class="form-control" value="<?php echo $params_start_date; ?>" id="start_date">
                            </div>
                            <div class="col">
                              <label>End Date</label>
                              <input type="date" name="end_date date-filter" class="form-control" value="<?php echo $params_end_date; ?>" id="end_date">
                            </div>
                          </div>
                        </td>
                      </tr>
                    </form>
                  </tbody>
                </table>
                <a href="<?php echo $link ?>" class="btn btn-primary mb-4">Export Excel</a>
                <a href="<?php echo base_url('tambah-pelaku-usaha') ?>" class="btn btn-primary mb-4">Tambah Pelaku Usaha</a>
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Kelompok Usaha</th>
                      <th>No Registrasi</th>
                      <th>Nama Perusahaan</th>
                      <th>Provinsi</th>
                      <th>Kab / Kota</th>
                      <!-- <th>Alamat</th> -->
                      <!-- <th>Nama Pimpinan</th> -->
                      <th>No Telepon</th>
                      <th>Status Registrasi</th>
                      <th>Status Pelaku Usaha</th>
                      <th>Produk</th>
                      <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no=1; foreach($pelaku_usaha as $value) { ?>
                    <tr>
                      <td><?php echo ($value->id_pelaku == null ) ? '-' : $value->id_pelaku ?></td>
                      <td><?php echo ($value->no_reg == null ) ? '-' : $value->no_reg ?></td>
                      <td><?php echo $value->nama_usaha ?></td>
                      <td><?php echo ($value->nama_provinsi == "" ) ? '-' : $value->nama_provinsi ?></td>
                      <td><?php echo $value->nama_kota_kab ?? '-' ?></td>
                      <!-- <td><?php //echo $value->alamat ?></td> -->
                      <!-- <td><?php //echo $value->nama_pimpinan ?></td> -->
                      <td><?php echo $value->telpon ?></td>
                      <td>
                        <?php
                          if ($value->status_registrasi == 0 ) {
                            echo '<span class="badge badge-secondary">Belum Aktivasi</span>';
                          }elseif($value->status_registrasi == 1 ){
                            echo '<span class="badge badge-warning">Proses Verikiasi Admin</span>';
                          }elseif ($value->status_registrasi == 2) {
                            echo '<span class="badge badge-success">Approved</span>';
                          }elseif ($value->status_registrasi == 3) {
                            echo '<span class="badge badge-danger">Rejected</span>';
                          }else{
                            echo "Status tidak ada";
                          }
                        ?>
                      </td>
                      <td><?php echo statusPelkauUsaaha($value->status_pelaku_usaha) ?></td>
                      <td><?php echo $value->produk_data ?? "-" ?></td>
                      <td>
                          <?php if ($value->status_registrasi == 1 || $value->status_registrasi == 0) { ?>
                            <a class="btn btn-sm bg-success"  href="<?php echo base_url() ?>/approve-pelaku-usaha/<?php echo $value->id_pelaku ?>" 
                            onclick="return confirm('Apakah anda yakin akan meng-approve pelaku usaha?')"
                            data-toggle="tooltip" data-placement="bottom" title="Approve" ><i class="fas fa-check"></i></a>
                          <?php } ?>
                          <a class="btn btn-sm bg-danger"  href="<?php echo base_url() ?>/reject-pelaku-usaha/<?php echo $value->id_pelaku ?>" 
                          onclick="return confirm('Apakah anda yakin akan meng-reject pelaku usaha?')"
                          data-toggle="tooltip" data-placement="bottom" title="Reject" ><i class="fas fa-times-circle"></i></a>
                          <a class="btn btn-sm bg-primary" href="<?php echo base_url() ?>/detail-pelaku-usaha/<?php echo $value->id_pelaku ?>" data-toggle="tooltip" data-placement="bottom" title="Detail" ><i class="fas fa-info-circle"></i></a>
                          <a class="btn btn-sm bg-success" href="<?php echo base_url() ?>/edit-pelaku/<?php echo $value->id_pelaku ?>" data-toggle="tooltip" data-placement="bottom" title="Edit" ><i class="fas fa-pencil-alt"></i></a>
                          <?php if ($value->status_pelaku_usaha == '1') { ?>
                            <a class="btn btn-sm bg-danger"  href="<?php echo base_url() ?>/ubah-status-pelaku-usaha/<?php echo $value->id_pelaku ?>/2" data-toggle="tooltip" data-placement="bottom" title="Status Tidak Aktif">
                              <i class="fas fa-user-times"></i>
                            </a>
                          <?php } else if($value->status_pelaku_usaha == '2'){ ?>
                            <a class="btn btn-sm bg-success"  href="<?php echo base_url() ?>/ubah-status-pelaku-usaha/<?php echo $value->id_pelaku ?>/1" data-toggle="tooltip" data-placement="bottom" title="Status Aktif">
                              <i class="fas fa-user-check"></i>
                            </a>
                          <?php }else{ ?>
                            <a class="btn btn-sm bg-success"  href="<?php echo base_url() ?>/ubah-status-pelaku-usaha/<?php echo $value->id_pelaku ?>/1" data-toggle="tooltip" data-placement="bottom" title="Status Aktif">
                              <i class="fas fa-user-check"></i>
                            </a>
                            <a class="btn btn-sm bg-danger"  href="<?php echo base_url() ?>/ubah-status-pelaku-usaha/<?php echo $value->id_pelaku ?>/2" data-toggle="tooltip" data-placement="bottom" title="Status Tidak Aktif">
                              <i class="fas fa-user-times"></i>
                            </a>
                          <?php } ?>
                          <a class="btn btn-sm bg-success" href="<?php echo base_url() ?>/pelaku-usaha-admin/reset-password/<?php echo $value->id_pelaku ?>" data-toggle="tooltip" data-placement="bottom" title="Reset Password" ><i class="fas fa-unlock-alt"></i></a>
                      </td>
                    </tr>
                    <?php $no++; } ?>
                    </tbody>
                  </table>
                </div>
                <label style="color: gray"><?php echo (count($pelaku_usaha) == null) ? 0 : count($pelaku_usaha) ?> dari <?php echo (!empty($total) ? $total : 0 ) ?> data</label>                
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-12 entries">
                    <div class="blog-pagination">
                        <ul class="justify-content-center">
                            <?php echo $pager->links(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php echo view('admin/template/footer'); ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url() ?>/assets/plugins/select2/js/select2.full.min.js"></script>
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
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>/assets/back/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url() ?>/assets/back/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $('.select2').select2({
      theme: 'bootstrap4'
    })
  });

  $(function () {
    var base_url = "<?= base_url('') ?>/tambah-pelaku-usaha";
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": [
            {
                extend: 'excel',
                text: 'Export Excel'
            },
            {
                text: 'Tambah Data',
                action: function ( e, dt, node, config ) {
                    window.location.href = base_url;
                }
            }
        ]
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

    function sByEmail(){
      var email = document.getElementById("col1_filter").value;
      const urlSearchParams = new URLSearchParams(window.location.search);
      const params = Object.fromEntries(urlSearchParams.entries());
      var url_pelaku = "<?php echo base_url(); ?>/pelaku-usaha-admin";
      
      if (params.provinsi || params.kota || params.status) {
        window.location.href = window.location.search+"&email="+email;
      } else if(params.email) {
        window.location.href = url_pelaku+"?email="+email;
      } else{
        window.location.href = window.location.search+"?email="+email;
      }
    }

    $(document).ready(function (e) {
      $('#filter_col4').change(function () {
        var prov_id = $('#col3_filter').val();
        var status = $('#col6_filter').val();
        var status_pelaku = $('#col7_filter').val();
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        var url = window.location.href;
        var url_pelaku = "<?php echo base_url(); ?>/pelaku-usaha-admin";
        window.location.href = url_pelaku+"?provinsi="+prov_id+"&status="+status+"&status_pelaku_usaha="+status_pelaku+"&start_date="+start_date+"&end_date="+end_date;
      });

      $('#filter_col5').change(function () {
        var prov_id = $('#col3_filter').val();
        var kota_select = $('#col4_filter').val();
        var status = $('#col6_filter').val();
        var status_pelaku = $('#col7_filter').val();
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        var url = window.location.href;
        var url_pelaku = "<?php echo base_url(); ?>/pelaku-usaha-admin";
        window.location.href = url_pelaku+"?provinsi="+prov_id+"&kota="+kota_select+"&status="+status+"&status_pelaku_usaha="+status_pelaku+"&start_date="+start_date+"&end_date="+end_date;
      });

      $('#filter_col7').change(function () {
        var prov_id = $('#col3_filter').val();
        var kota_select = $('#col4_filter').val();
        var status = $('#col6_filter').val();
        var status_pelaku = $('#col7_filter').val();
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        var url = window.location.href;
        var url_pelaku = "<?php echo base_url(); ?>/pelaku-usaha-admin";
        window.location.href = url_pelaku+"?provinsi="+prov_id+"&kota="+kota_select+"&status="+status+"&status_pelaku_usaha="+status_pelaku+"&start_date="+start_date+"&end_date="+end_date;
      });

      $('#filter_col8').change(function () {
        var prov_id = $('#col3_filter').val();
        var kota_select = $('#col4_filter').val();
        var status = $('#col6_filter').val();
        var status_pelaku = $('#col7_filter').val();
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        var url = window.location.href;
        var url_pelaku = "<?php echo base_url(); ?>/pelaku-usaha-admin";
        window.location.href = url_pelaku+"?provinsi="+prov_id+"&kota="+kota_select+"&status="+status+"&status_pelaku_usaha="+status_pelaku+"&start_date="+start_date+"&end_date="+end_date;
      });

      var today = new Date().toISOString().slice(0, 10);

      // $('#start_date').val(today);
      $('#start_date').attr('max',today);
      // $('#end_date').val(today);
      $('#end_date').attr('max',today);

      $('#filter_col3').change(function(){
        var prov_id = $('#col3_filter').val();
        var kota_select = $('#col4_filter').val();
        var status = $('#col6_filter').val();
        var status_pelaku = $('#col7_filter').val();
        var url = window.location.href;
        var url_pelaku = "<?php echo base_url(); ?>/pelaku-usaha-admin";
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        if(start_date != "" && end_date != ""){
          window.location.href = url_pelaku+"?provinsi="+prov_id+"&kota="+kota_select+"&status="+status+"&status_pelaku_usaha="+status_pelaku+"&start_date="+start_date+"&end_date="+end_date;
        }
      });
    });

</script>
</body>
</html>
