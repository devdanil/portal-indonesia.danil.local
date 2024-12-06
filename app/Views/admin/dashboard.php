<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Kemendag - Etalase Produk UMKM | Dashboard</title>
  <link href="<?php echo base_url() ?>/assets/logo.png" rel="icon">
  <link href="<?php echo base_url() ?>/assets/logo.png" rel="apple-touch-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/back/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center" style="background-color: white;">
    <img class="animation__wobble" src="<?php echo base_url() ?>/assets/front/img/Logo-n.png" alt="Portal Indonesia Logo" height="auto" width="auto">
  </div>

  <!-- Navbar -->
  <?php echo view('admin/template/navbar'); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php echo view('admin/template/aside'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Jumlah Pelaku Usaha</span>
                <span class="info-box-number">
                  <?php echo $pelaku_total ?> Pelaku Usaha
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Jumlah Produk</span>
                <span class="info-box-number"><?php echo $produk_total ?> Produk</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Jumlah Kuliner</span>
                <span class="info-box-number"><?php echo $kuliner_total ?> Kulliner</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Jumlah Video</span>
                <span class="info-box-number"><?php echo $video_total ?> Video</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Grafik Laporan Bulanan</h5>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                    <p class="text-center">
                      <strong><?php echo date("Y-m-d H:i:s");?></strong>
                    </p>

                    <div class="chart">
                      <canvas id="salesChart" height="230" style="height: 260px;"></canvas>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <p class="text-center">
                      <strong>Kategori Produk UMKM</strong>
                    </p>

                    <div class="progress-group">
                      Makanan dan Minuman
                      <span class="float-right"><b><?php echo $produk_makanan ?></b>/<?php echo $produk_total ?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-primary" style="width: <?php echo ($produk_makanan/$produk_total)*100 ?>%"></div>
                      </div>
                    </div>
                    <div class="progress-group">
                      Fashion
                      <span class="float-right"><b><?php echo $produk_fashion ?></b>/<?php echo $produk_total ?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" style="width: <?php echo ($produk_fashion/$produk_total)*100 ?>%"></div>
                      </div>
                    </div>
                    <div class="progress-group">
                      <span class="progress-text">Kosmetik</span>
                      <span class="float-right"><b><?php echo $produk_kosmetik ?></b>/<?php echo $produk_total ?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-success" style="width: <?php echo ($produk_kosmetik/$produk_total)*100 ?>%"></div>
                      </div>
                    </div>
                    <div class="progress-group">
                      Kerajinan
                      <span class="float-right"><b><?php echo $produk_kerajinan ?></b>/<?php echo $produk_total ?></span>
                       <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" style="width: <?php echo ($produk_kerajinan/$produk_total)*100 ?>%"></div>
                      </div>
                    </div>
                    <div class="progress-group">
                      Jasa
                      <span class="float-right"><b><?php echo $produk_jasa ?></b>/<?php echo $produk_total ?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-info" style="width: <?php echo ($produk_jasa/$produk_total)*100 ?>%"></div>
                      </div>
                    </div>
                    <div class="progress-group">
                      Dekorasi
                      <span class="float-right"><b><?php echo $produk_dekorasi ?></b>/<?php echo $produk_total ?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-default" style="width: <?php echo ($produk_dekorasi/$produk_total)*100 ?>%"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Data Produk</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table id="table-dashboard" class="table" >
                    <thead>
                    <tr>
                      <th>Foto Produk</th>
                      <th>Pelaku Usaha</th>
                      <th>Nama Produk</th>
                      <th>Tanggal</th>
                      <th>Status</th>
                      <th>#</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php foreach($produk as $produk_val){ #print_r($produk_val);?>
                        
                      <tr>
                        <td><img width="30%" src="<?php echo base_url()."/assets/uploads/".$produk_val->foto_produk?>" > </td>
                        <td><?php echo $produk_val->nama_usaha ?></td>
                        <td><?php echo $produk_val->nama_produk ?></td>
                        <td><?php echo $produk_val->insert_date ?></td>
                        <td><span class="badge badge-danger">Non-Approved</span></td>
                        <td>
                          <a class="btn btn-sm bg-success"  href="<?php echo base_url() ?>/approve-produk/<?php echo $produk_val->id_produk ?>" 
                          onclick="return confirm('Apakah anda yakin akan meng-approve produk?')"
                          data-toggle="tooltip" data-placement="bottom" title="Approve" ><i class="fas fa-check"></i></a>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                <div align="right" style="margin-top: 10px; margin-right: 10px;">
                  <h5>
                    <a href="produk" rel="noopener noreferrer">Selengkapnya >></a>
                  </h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Data Pelaku Usaha</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table id="table-dashboard-pelaku" class="table" >
                    <thead>
                    <tr>
                      <th>Nama Usaha</th>
                      <th>Nama Pimpinan</th>
                      <th>Email</th>
                      <th>Handphone</th>
                      <th>Tanggal</th>
                      <th>Status</th>
                      <th>#</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php foreach($pelaku_usaha as $pelaku_val){ #print_r($pelaku_usaha);?>
                        
                      <tr>
                        <td><?php echo $pelaku_val->nama_usaha ?></td>
                        <td><?php echo $pelaku_val->nama_pimpinan ?></td>
                        <td><?php echo $pelaku_val->email ?></td>
                        <td><?php echo $pelaku_val->handphone ?></td>
                        <td><?php echo $pelaku_val->insert_date ?></td>
                        <td><span class="badge badge-danger">Non-Approved</span></td>
                        <td>
                          <a class="btn btn-sm bg-success"  href="<?php echo base_url() ?>/approve-pelaku-usaha/<?php echo $pelaku_val->id_pelaku ?>" 
                          onclick="return confirm('Apakah anda yakin akan meng-approve produk?')"
                          data-toggle="tooltip" data-placement="bottom" title="Approve" ><i class="fas fa-check"></i></a>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                <div align="right" style="margin-top: 10px; margin-right: 10px;">
                  <h5>
                    <a href="pelaku-usaha-admin" rel="noopener noreferrer">Selengkapnya >></a>
                  </h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php echo view('admin/template/footer'); ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
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
<!-- overlayScrollbars -->
<script src="<?php echo base_url() ?>/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>/assets/back/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?php echo base_url() ?>/assets/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/raphael/raphael.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url() ?>/assets/plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url() ?>/assets/back/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="<?php echo base_url() ?>/assets/back/js/pages/dashboard2.js"> -->
<script>
  var salesChartCanvas = $('#salesChart').get(0).getContext('2d')

var salesChartData = {
  labels: <?php echo json_encode($bulan); ?>,
  datasets: [
    {
      label: 'Pelaku Usaha',
      backgroundColor: 'rgba(210, 214, 222, 1)',
      borderColor: 'rgba(210, 214, 222, 1)',
      pointRadius: false,
      pointColor: 'rgba(210, 214, 222, 1)',
      pointStrokeColor: '#c1c7d1',
      pointHighlightFill: '#fff',
      pointHighlightStroke: 'rgba(220,220,220,1)',
      data: <?php echo json_encode($total); ?>
    }
  ]
}

var salesChartOptions = {
  maintainAspectRatio: false,
  responsive: true,
  legend: {
    display: false
  },
  scales: {
    xAxes: [{
      gridLines: {
        display: false
      }
    }],
    yAxes: [{
      gridLines: {
        display: false
      }
    }]
  }
}
var salesChart = new Chart(salesChartCanvas, {
  type: 'line',
  data: salesChartData,
  options: salesChartOptions
}
)

</script>
<script>
  $(function () {
    $("#table-dashboard").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $("#table-dashboard-pelaku").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });                
</script>
</body>
</html>
