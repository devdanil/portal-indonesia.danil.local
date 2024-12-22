<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Indonesia | Kegiatan</title>
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
            <h1>Kegiatan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Kegiatan</li>
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
                <h3 class="card-title">Data Kegiatan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php if (!empty(session()->getFlashdata('success'))) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h4><?php echo session()->getFlashdata('success'); ?></h4>
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
                    <tr id="filter_col4" data-column="3">
                        <td>Lokasi </td>
                        <td><input type="text" class="column_filter" id="col3_filter"></td>
                    </tr>
                </tbody>
            </table>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Judul Kegiatan</th>
                    <th>Waktu</th>
                    <th>Lokasi</th>
                    <th>Penyelenggara</th>
                    <th>Kategori Pangan</th>
                    <th>Ketentuan</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php $no=1; foreach($kegiatan as $value) { ?>
                  <tr>
                    <td><?php echo ($value->nama_kegiatan == null ) ? '-' : $value->nama_kegiatan ?></td>
                    <td><?php echo ($value->waktu_awal == null ) ? '-' : $value->waktu_awal ?></td>
                    <td><?php echo ($value->lokasi_pameran == null ) ? '-' : $value->lokasi_pameran ?></td>
                    <td><?php echo ($value->namaPenyelenggara == null ) ? '-' : $value->namaPenyelenggara ?></td>
                    <td><?php echo ($value->pangan_non == null ) ? '-' : $value->pangan_non ?></td>
                    <td><?php echo ($value->ketentuan == null ) ? '-' : $value->ketentuan ?></td>
                    <td>
                        <?php echo ($value->status == null ) ? '-' : ($value->status == 0 ? 'Tidak Aktif' : 'Aktif') ?>
                    </td>
                    <td>
                        <a class="btn btn-sm bg-danger"  href="<?php echo base_url('admin') ?>/hapus-kegiatan/<?php echo $value->id_pembinaan ?>" 
                        onclick="return confirm('Apakah anda yakin akan menghapus data?')"
                        data-toggle="tooltip" data-placement="bottom" title="Hapus" ><i class="fas fa-trash-alt"></i></a>
                        <a class="btn btn-sm bg-primary" href="<?php echo base_url('admin') ?>/edit-kegiatan/<?php echo $value->id_pembinaan ?>" data-toggle="tooltip" data-placement="bottom" title="Edit" ><i class="fas fa-pencil-alt"></i></a>
                        <a class="btn btn-sm bg-warning" href="<?php echo base_url('admin') ?>/list-peserta-kegiatan/<?php echo $value->id_pembinaan ?>" data-toggle="tooltip" data-placement="bottom" title="List Peserta" >
                          <i class="fa fa-user-circle"></i>
                        </a>
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
    var base_url = "<?= base_url('admin') ?>/tambah-kegiatan";
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
