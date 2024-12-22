<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Indonesia | Sub Kategori</title>
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
            <h1>Sub Kategori</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sub Kategori</li>
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
                <h3 class="card-title">Data Kategori Produk</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Sub Kategori</th>
                    <th>Kategori</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php $no=1; foreach($subkategori as $value) { ?>
                  <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $value->nama ?></td>
                    <td><?php echo ($value->kategori == null ) ? '-' : $value->kategori ?></td>
                    <td>
                        <a class="btn btn-sm bg-danger"  href="<?php echo base_url('admin') ?>/hapus-subkategori/<?php echo $value->id_sub ?>" 
                        onclick="return confirm('Apakah anda yakin akan menghapus data?')"
                        data-toggle="tooltip" data-placement="bottom" title="Hapus" ><i class="fas fa-trash-alt"></i></a>
                        <a class="btn btn-sm bg-success" href="<?php echo base_url('admin') ?>/edit-subkategori/<?php echo $value->id_sub ?>" data-toggle="tooltip" data-placement="bottom" title="Edit" ><i class="fas fa-pencil-alt"></i></a>
                    </td>
                  </tr>
                  <?php $no++; } ?>
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
    var base_url = "<?= base_url('admin') ?>/tambah-subkategori";
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
</script>
</body>
</html>
