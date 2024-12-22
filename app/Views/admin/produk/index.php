<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Indonesia | Produk</title>
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
            <h1>Produk</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Produk</li>
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
                <h3 class="card-title">Data Produk</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php if (!empty(session()->getFlashdata('success'))) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h4><?php echo session()->getFlashdata('success'); ?></h4>
                    </div>
                <?php endif; ?>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Pelaku Usaha</th>
                    <th>Kategori</th>
                    <th>Nama Produk</th>
                    <th>No Registrasi</th>
                    <th>Tahun Registrasi</th>
                    <th>Photo Produk</th>
                    <th>Deskripsi</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php $no=1; foreach($produk as $value) { ?>
                  <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $value->nama_usaha ?></td>
                    <td><?php echo $value->kategori ?></td>
                    <td><?php echo ($value->nama_produk == null ) ? '-' : $value->nama_produk ?></td>
                    <td><?php echo $value->no_registrasi ?></td>
                    <td><?php echo $value->tahun_reg ?></td>
                    <td><?php if($value->foto_produk){ ?><img src="<?php echo base_url('assets/uploads/'.$value->foto_produk); ?>" alt="" srcset="" width="100px"><?php } else { echo "-"; };?></td>
                    <td>
                        <?php
                            if ($value->deskripsi_in != '') {
                                $num_char = 50;
                                echo substr(strip_tags($value->deskripsi_in), 0, $num_char) . '...';
                            }else{
                                echo "-";
                            }
                        ?>
                    </td>
                    <td>
                        <?php if ($value->status == 0) { ?>
                          <a class="btn btn-sm bg-success"  href="<?php echo base_url('admin') ?>/approve-produk/<?php echo $value->id_produk ?>" 
                          onclick="return confirm('Apakah anda yakin akan meng-approve produk?')"
                          data-toggle="tooltip" data-placement="bottom" title="Approve" ><i class="fas fa-check"></i></a>
                        <?php } ?>
                        <a class="btn btn-sm bg-danger"  href="<?php echo base_url('admin') ?>/hapus-produk/<?php echo $value->id_produk ?>" 
                        onclick="return confirm('Apakah anda yakin akan menghapus produk?')"
                        
                        data-toggle="tooltip" data-placement="bottom" title="Hapus" ><i class="fas fa-trash-alt"></i></a>
                        <a class="btn btn-sm bg-primary" href="<?php echo base_url('admin') ?>/edit-produk/<?php echo $value->id_produk ?>" data-toggle="tooltip" data-placement="bottom" title="Edit" ><i class="fas fa-pencil-alt"></i></a>
                        <?php if ($value->status_show == 0) { ?>
                          <a class="btn btn-sm bg-success"  href="<?php echo base_url('admin') ?>/action-produk/<?php echo $value->id_produk ?>/1" data-toggle="tooltip" data-placement="bottom" title="Show"><i class="fas fa-eye"></i></a>
                          <?php }else{ ?>
                            <a class="btn btn-sm bg-danger" href="<?php echo base_url('admin') ?>/action-produk/<?php echo $value->id_produk ?>/0" data-toggle="tooltip" data-placement="bottom" title="Hide"><i class="fas fa-eye-slash"></i></a>
                        <?php } ?>
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
    var base_url = "<?= base_url('admin') ?>/tambah-produk";
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
</script>
</body>
</html>
