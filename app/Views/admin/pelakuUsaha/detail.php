<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Indonesia | Detail Pelaku Usaha</title>
  <link href="<?php echo base_url() ?>/assets/logo.png" rel="icon">
  <link href="<?php echo base_url() ?>/assets/logo.png" rel="apple-touch-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
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
            <h1>Detail Pelaku Usaha</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin')?>/pelaku-usaha">Pelaku Usaha</a></li>
              <li class="breadcrumb-item active">Detail Pelaku Usaha</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img" style="background-color: #ffffff;"
                       src="<?php echo base_url() ?>/assets/front/img/logo.png"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo ($pelaku_usaha->nama_usaha == null) ? '-' : $pelaku_usaha->nama_usaha?></h3>

                <p class="text-muted text-center"><?php echo ($pelaku_usaha->kelompok == null) ? 'Tidak ada info kelompok usaha' : $pelaku_usaha->kelompok?></p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tentang <?php echo ($pelaku_usaha->nama_usaha == null) ? '-' : ucwords(strtolower($pelaku_usaha->nama_usaha))?></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-id-card mr-1"></i> Kontak</strong>

                <p class="text-muted">
                    <?php echo ($pelaku_usaha->telpon == null) ? 'Tidak ada info telepon' : $pelaku_usaha->telpon?>
                    <br/>
                    <?php echo ($pelaku_usaha->handphone == null) ? 'Tidak ada info handphone' : $pelaku_usaha->handphone?>
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>

                <p class="text-muted"><?php echo ($pelaku_usaha->alamat == null) ? 'Tidak ada info alamat' : $pelaku_usaha->alamat?></p>

                <hr>

                <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

                <p class="text-muted">
                    <?php echo ($pelaku_usaha->email == null) ? 'Tidak ada info email' : $pelaku_usaha->email?>
                </p>

                <hr>

                <strong><i class="fab fa-chrome mr-1"></i> Website</strong>
                
                <a target="blank" src="<?php echo ($pelaku_usaha->website == null) ? '#' : $pelaku_usaha->website?>">
                    <p class="text-muted">
                        <?php echo ($pelaku_usaha->website == null) ? 'Tidak ada info website' : $pelaku_usaha->website?>
                    </p>
                </a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#info" data-toggle="tab">Informasi Pelaku Usaha</a></li>
                  <li class="nav-item"><a class="nav-link" href="#produk" data-toggle="tab">Produk</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="info">
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Umum</h3>
                      </div>
                      <div class="card-body">
                        <dl class="row">
                          <dt class="col-sm-4">No Registrasi</dt>
                          <dd class="col-sm-8"><?php echo ($pelaku_usaha->no_reg == null) ? 'Tidak ada informasi no registrasi' : $pelaku_usaha->no_reg?></dd>

                          <dt class="col-sm-4">Nama Pimpinan</dt>
                          <dd class="col-sm-8"><?php echo ($pelaku_usaha->nama_pimpinan == null) ? 'Tidak ada informasi nama pimpinan' : ucwords(strtolower($pelaku_usaha->nama_pimpinan))?></dd>
                          
                          <dt class="col-sm-4">Jenis Usaha</dt>
                          <dd class="col-sm-8"><?php echo ($pelaku_usaha->jenis_usaha == null) ? 'Tidak ada informasi jenis usaha' : ucwords(strtolower($pelaku_usaha->jenis_usaha))?></dd>
                          
                          <dt class="col-sm-4">Kelompok Usaha</dt>
                          <dd class="col-sm-8"><?php echo ($pelaku_usaha->kelompok == null) ? 'Tidak ada informasi kelompok usaha' : ucwords(strtolower($pelaku_usaha->kelompok))?></dd>
                        </dl>
                      </div>
                    </div>
                  </div>
                  
                  <div class="tab-pane" id="produk">
                    <div class="card card-default">
                      <div class="card-header">
                        <h3 class="card-title">Daftar Produk</h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <?php foreach ($produk as $key => $val_produk) { ?>
                          <div class="callout callout-success">
                            <div class="row">
                              <div class="col-sm-4">
                                <dl>
                                  <dt class="col-sm-6">Nama Produk</dt>
                                  <dd class="col-sm-8"><?php echo ($val_produk->nama_produk == null) ? '-' : $val_produk->nama_produk?></dd>
                                  <dt class="col-sm-6">Deskripsi Produk</dt>
                                  <dd class="col-sm-8"><?php echo ($val_produk->deskripsi_in == null) ? '-' : $val_produk->deskripsi_in?></dd>
                                </dl>
                              </div>
                              <div class="col-sm-8">
                                <dl>
                                  <dt class="col-sm-4">Foto Produk</dt>
                                  <dd class="col-sm-8">
                                    <img width="80%" src="<?php echo base_url()."/assets/uploads/".$val_produk->foto_produk ?>" >
                                  </dd>
                                </dl>
                              </div>
                            </div>
                          </div>
                        <?php } ?>
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
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
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>/assets/back/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url() ?>/assets/back/js/demo.js"></script>
</body>
</html>
