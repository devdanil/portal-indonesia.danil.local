<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Indonesia | User</title>
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
            <h1>Settings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User</li>
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
                <h3 class="card-title">Data User</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table cellpadding="3" cellspacing="0" border="0" style="width: 67%;">
                <thead>
                    <tr>
                        <th>Pencarian</th>
                        <th>Tulis kata</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="filter_col1" data-column="0">
                        <td>Username </td>
                        <td><input type="text" class="column_filter" id="col0_filter"></td>
                    </tr>
                    <tr id="filter_col2" data-column="1">
                        <td>Nama Lengkap </td>
                        <td><input type="text" class="column_filter" id="col1_filter"></td>
                    </tr>
                </tbody>
            </table>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>No Handphone</th>
                    <th>Email</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach($user as $value) { ?>
                  <tr>
                    <td><?php echo ($value->username == null ) ? '-' : $value->username ?></td>
                    <td><?php echo ($value->fullname == null ) ? '-' : $value->fullname ?></td>
                    <td><?php echo ($value->hp == null ) ? '-' : $value->hp ?></td>
                    <td><?php echo ($value->email == null ) ? '-' : $value->email ?></td>
                    <td>
                        <a class="btn btn-sm bg-danger"  href="<?php echo base_url('admin') ?>/hapus-user/<?php echo $value->id ?>" 
                        onclick="return confirm('Apakah anda yakin akan menghapus data?')" data-toggle="tooltip" data-placement="bottom" title="Hapus" ><i class="fas fa-trash-alt"></i></a>
                        <a class="btn btn-sm bg-primary" href="<?php echo base_url('admin') ?>/edit-user/<?php echo $value->id ?>" data-toggle="tooltip" data-placement="bottom" title="Edit" ><i class="fas fa-pencil-alt"></i></a>
                        <a class="btn btn-sm bg-success" href="<?php echo base_url('admin') ?>/reset-user/<?php echo $value->id ?>" data-toggle="tooltip" data-placement="bottom" title="Reset Password" ><i class="fas fa-unlock-alt"></i></a>
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
    var base_url = "<?= base_url('admin') ?>/tambah-user";
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
