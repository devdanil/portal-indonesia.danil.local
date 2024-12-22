<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Indonesia | Berita</title>
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
            <h1>Berita</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Berita</li>
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
                <h3 class="card-title">Data Berita</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php if (!empty(session()->getFlashdata('success'))) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h4><?php echo session()->getFlashdata('success'); ?></h4>
                    </div>
                <?php endif; ?>
                <?php if (!empty(session()->getFlashdata('gagal'))) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h4><?php echo session()->getFlashdata('gagal'); ?></h4>
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
                    <tr id="filter_col2" data-column="1">
                        <td>Judul </td>
                        <td><input type="text" class="column_filter" id="col1_filter"></td>
                    </tr>
                </tbody>
            </table>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Featured Image</th>
                    <th>Judul</th>
                    <!-- <th>Isi Berita</th> -->
                    <!-- <th>Keyword</th> -->
                    <th>Summary</th>
                    <th>Utama</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach($berita as $value) { ?>
                  <tr>
                    <td><img src="<?php echo base_url()."/assets/uploads/featuredImage/".$value->featured_image ?>" width="50%" /></td>
                    <td><?php echo ($value->judul == null ) ? '-' : $value->judul ?></td>
                    <!-- <td><?php //echo ($value->isi_berita == null ) ? '-' : $value->isi_berita ?></td> -->
                    <!-- <td><?php //echo ($value->keyword == null ) ? '-' : $value->keyword ?></td> -->
                    <td><?php echo ($value->summary == null ) ? '-' : $value->summary ?></td>
                    <td><?php echo ($value->utama == 0 ) ? 'Tidak Utama' : 'Utama' ?></td>
                    <td><?php echo ($value->status == 0 ) ? 'Published' : 'Draft' ?></td>
                    <td>
                        <?php if($value->status == 0 ) { $text='Sent to Draft';$warna='danger';}else{ $text='Sent to Publish';$warna='success';} ?>
                        <a class="btn btn-sm bg-<?php echo $warna ?>"  href="<?php echo base_url('admin') ?>/status-berita/<?php echo $value->id ?>" 
                        onclick="return confirm('Apakah anda yakin akan mengubah status?')"
                        data-toggle="tooltip" data-placement="bottom" title="<?php echo $text ?>" ><?php echo $text ?></a>
                        <a class="btn btn-sm bg-primary" href="<?php echo base_url('admin') ?>/edit-berita/<?php echo $value->id ?>" data-toggle="tooltip" data-placement="bottom" title="Edit" >Edit</a>
                        <?php if($value->utama == 0 ) { ?>
                        <a class="btn btn-sm bg-success" href="<?php echo base_url('admin') ?>/sent-utama/<?php echo $value->id ?>" 
                        onclick="return confirm('Apakah anda yakin akan menjadikan highlight?')"
                        data-toggle="tooltip" data-placement="bottom" title="Utama" >Jadikan Highlight</a>
                        <?php } ?>
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
    var base_url = "<?= base_url('admin') ?>/tambah-berita";
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
