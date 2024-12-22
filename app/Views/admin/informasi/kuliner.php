<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Indonesia | Kuliner</title>
  <?=  view('admin/template/header');?>
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
            <h1>Kuliner</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Kuliner</li>
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
                <h3 class="card-title">Data Kuliner</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php if (!empty(session()->getFlashdata('success'))) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h4><?php echo session()->getFlashdata('success'); ?></h4>
                    </div>
                <?php endif; ?>
              <table cellpadding="3" cellspacing="0" border="0" style="width: 67%;">
                <thead>
                    <tr>
                        <th>Spesifik Pencarian</th>
                        <th>Tulis kata</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="filter_col1" data-column="1">
                        <td>Nama </td>
                        <td><input type="text" class="column_filter" id="col1_filter"></td>
                    </tr>
                    <tr id="filter_col4" data-column="4">
                        <td>Provinsi </td>
                        <td><input type="text" class="column_filter" id="col4_filter"></td>
                    </tr>
                    <tr id="filter_col5" data-column="5">
                        <td>Kota </td>
                        <td><input type="text" class="column_filter" id="col5_filter"></td>
                    </tr>
                </tbody>
            </table>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Image</th>
                    <th>Nama</th>
                    <!-- <th>Alamat</th> -->
                    <th>Jam Buka</th>
                    <th>Jam Tutup</th>
                    <!-- <th>Deskripsi</th> -->
                    <th>Provinsi</th>
                    <th>Kota</th>
                    <th>Facebook</th>
                    <th>Instagram</th>
                    <th>Maps</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach($kuliner as $value) { ?>
                  <tr>
                    <td><img src="<?php echo base_url()."/assets/uploads/kuliner/".$value->image ?>" width="90%" ></td>
                    <td><?php echo ($value->nama == null ) ? '-' : $value->nama ?></td>
                    <!-- <td><?php //echo ($value->alamat == null ) ? '-' : $value->alamat ?></td> -->
                    <td><?php echo ($value->jam_buka == null ) ? '-' : $value->jam_buka ?></td>
                    <td><?php echo ($value->jam_tutup == null ) ? '-' : $value->jam_tutup ?></td>
                    <td><?php echo ($value->nama_provinsi == null ) ? '-' : $value->nama_provinsi ?></td>
                    <td><?php echo ($value->nama_kota == null ) ? '-' : $value->nama_kota ?></td>
                    <!-- <td><?php //echo ($value->deskripsi == null ) ? '-' : $value->deskripsi ?></td> -->
                    <td><?php echo ($value->facebook == null ) ? '-' : $value->facebook ?></td>
                    <td><?php echo ($value->instagram == null ) ? '-' : $value->instagram ?></td>
                    <td><?php echo ($value->maps == null ) ? '-' : $value->maps ?></td>
                    <td>
                        <a class="btn btn-sm bg-danger"  href="<?php echo base_url('admin') ?>/hapus-kuliner/<?php echo $value->id ?>" 
                        onclick="return confirm('Apakah anda yakin akan menghapus data?')"
                        data-toggle="tooltip" data-placement="bottom" title="Hapus" ><i class="fas fa-trash"></i></a>
                        <a class="btn btn-sm bg-primary" href="<?php echo base_url('admin') ?>/edit-kuliner/<?php echo $value->id ?>" data-toggle="tooltip" data-placement="bottom" title="Edit" ><i class="fas fa-pencil-alt"></i></a>
                    </td>
                  </tr>
                  <?php } ?>
                  </tbody>
                </table>
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
  <?= view('admin/template/foot'); ?>
<!-- Page specific script -->
<script>
  $(function () {
    var base_url = "<?= base_url('admin') ?>/tambah-kuliner";
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
