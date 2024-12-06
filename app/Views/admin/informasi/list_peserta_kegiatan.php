<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Indonesia | Peserta Kegiatan</title>
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
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/back/css/adminlte.min.css">
</head>
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
            <h1>Kegiatan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Kegiatan</a></li>
              <li class="breadcrumb-item active">Peserta Kegiatan</li>
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
                <h3 class="card-title">Data Peserta Kegiatan Bla</h3>
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
                            <th>Tulis kata</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="filter_col1" data-column="0">
                            <td>Nama Kegiatan </td>
                            <td><input type="text" class="column_filter" id="col0_filter"></td>
                        </tr>
                        <tr id="filter_col2" data-column="1">
                            <td>Email </td>
                            <td><input type="text" class="column_filter" id="col1_filter"></td>
                        </tr>
                    </tbody>
                </table>
                <form action="<?php echo base_url() ?>/approve-peserta-all" method="POST">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nama Kegiatan</th>
                    <th>Email Pelaku Usaha</th>
                    <th>Nama Pelaku Usaha</th>
                    <th>Produk</th>
                    <th>Penanggung Jawab</th>
                    <th>Jabatan Penanggung Jawab</th>
                    <th>Kontak Penanggung Jawab</th>
                    <th>Status</th>
                    <th></th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php $no=1;$index=0; foreach($peserta as $value) { ?>
                  <tr>
                    <td><?php echo ($value->nama_kegiatan == null ) ? '-' : $value->nama_kegiatan ?></td>
                    <td><?php echo ($value->email == null ) ? '-' : $value->email ?></td>
                    <td><?php echo ($value->nama_usaha == null ) ? '-' : $value->nama_usaha ?></td>
                    <td>
                      <ul>
                      <?php foreach ($list_barang[$index] as $key => $val_list) { ?>
                          <li><?php echo $val_list->nama_produk ?></li>
                      <?php } ?>
                      </ul>
                    </td>
                    <td><?php echo ($value->nama_pj == null ) ? '-' : $value->nama_pj ?></td>
                    <td><?php echo ($value->jabatan_pj == null ) ? '-' : $value->jabatan_pj ?></td>
                    <td><?php echo ($value->kontak_pj == null ) ? '-' : $value->kontak_pj ?></td>
                    <td>
                        <?php echo ($value->status_kehadiran == null ) ? '-' : ($value->status_kehadiran == 0 ? 'Belum proses kurasi' : ($value->status_kehadiran == 1 ? 'Peserta diapprove' : 'Peserta direject' )) ?>
                    </td>
                    <td>
                        <?php if($value->status_kehadiran == 0){ ?>
                        <a class="btn btn-sm bg-danger"  href="<?php echo base_url() ?>/reject-peserta/<?php echo $value->id_peserta  ?>" 
                        onclick="return confirm('Apakah anda yakin akan reject peserta?')"
                        data-toggle="tooltip" data-placement="bottom" title="Reject" ><i class="fa fa-times"></i></a>

                        <a class="btn btn-sm bg-primary"  href="<?php echo base_url() ?>/approve-peserta/<?php echo $value->id_peserta  ?>" 
                        onclick="return confirm('Apakah anda yakin akan approve peserta?')"
                        data-toggle="tooltip" data-placement="bottom" title="Approve" ><i class="fa fa-check"></i></a>
                        <?php } ?>
                    </td>
                    <td>
                      <?php if($value->status_kehadiran == 0){ ?>
                      <input type="checkbox" id="approvePeserta" name="approvePeserta[]" value="<?php echo $value->id_peserta?>" />
                      <?php } ?>
                    </td>
                  </tr>
                  <?php $no++;$index++; } ?>
                  </tbody>
                </table>
                <div class="text-right"><button type="submit" class="btn btn-sm bg-primary">Approve</button></div></form>
              </div>
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
  function approveAlls()
  {
    var approveAll = document.getElementById("approveAll");
    if (approveAll.checked == true) {
      document.getElementById("approvePeserta").checked = true;
    } else {
      document.getElementById("approvePeserta").checked = false;
    }
  }


  $(function () {
    var base_url = "<?= base_url('') ?>/tambah-kegiatan";
    $("#example1").DataTable({
      "dom": '<"wrapper"Bflipt>',
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

    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  function filterColumn ( i ) {
        $('#example1').DataTable().column( i ).search(
            $('#col'+i+'_filter').val()
        ).draw();
    }

    $(document).ready(function() {
        $('#example1').DataTable();
    
        // $('input.global_filter').on( 'keyup click', function () {
        //     filterGlobal();
        // } );
    
        $('input.column_filter').on( 'keyup click', function () {
            filterColumn( $(this).parents('tr').attr('data-column') );
        } );
    } );

</script>
</body>
</html>
