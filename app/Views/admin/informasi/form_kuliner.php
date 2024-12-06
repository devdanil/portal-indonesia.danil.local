<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Indonesia | <?php echo (empty($model)) ? 'Form Tambah Kuliner' : 'Form Edit Kuliner' ?></title>
  <link href="<?php echo base_url() ?>/assets/logo.png" rel="icon">
  <link href="<?php echo base_url() ?>/assets/logo.png" rel="apple-touch-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/daterangepicker/daterangepicker.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/back/css/adminlte.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
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
              <li class="breadcrumb-item active"><?php echo (empty($model)) ? 'Tambah Kuliner' : 'Edit Kuliner' ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><?php echo (empty($model)) ? 'Form Tambah Kuliner' : 'Form Edit Kuliner' ?></h3>
              </div>
                <?php if (!empty(session()->getFlashdata('error'))) : ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <h4>Periksa Entrian Form</h4>
                        </hr />
                        <?php echo session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>
              <form enctype="multipart/form-data" method="post" action="<?php echo base_url(); ?><?php echo (empty($model)) ? '/kuliner/save' : '/kuliner/update/'.$model->id ?>">
                <?= csrf_field(); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama</label><span style="color:red"> *</span>
                                <input type="text" value="<?php echo (empty($model)) ? old('nama') : $model->nama ?>" name="nama" class="form-control" id="nama" placeholder="Nama" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alamat">Alamat</label><span style="color:red"> *</span>
                                <input type="text" value="<?php echo (empty($model)) ? old('alamat') : $model->alamat ?>" name="alamat" class="form-control" id="alamat" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jam_buka">Jam Buka</label><span style="color:red"> *</span>
                                <input type="text" value="<?php echo (empty($model)) ? old('jam_buka') : $model->jam_buka ?>" name="jam_buka" class="form-control" id="jam_buka" placeholder="E.g : 08:00:00" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jam_tutup">Jam Tutup</label><span style="color:red"> *</span>
                                <input type="text" value="<?php echo (empty($model)) ? old('jam_tutup') : $model->jam_tutup ?>" name="jam_tutup" class="form-control" id="jam_tutup" placeholder="E.g : 22:00:00" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label><span style="color:red"> *</span>
                                <input type="text" value="<?php echo (empty($model)) ? old('deskripsi') : $model->deskripsi ?>" name="deskripsi" class="form-control" id="deskripsi" placeholder="deskripsi" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="kategori">Nama Kategori</label>
                              <select class="form-control select2" name="kategori" id="kategori" required>
                                  <option value="">-- Pilih Kategori --</option>
                                  <?php foreach ($kategori as $kat_value) { ?>
                                      <option value="<?php echo $kat_value->id_sub?>" <?php echo (!empty($model) && $model->kategori == $kat_value->id_sub ) ? 'selected' : ((old('kategori') == $kat_value->id_sub ) ? 'selected' : '') ?> ><?php echo $kat_value->nama?></option>
                                  <?php } ?>
                              </select>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="instagram">Instagram</label>
                                <input type="text" value="<?php echo (empty($model)) ? old('instagram') : $model->instagram ?>" name="instagram" class="form-control" id="instagram" placeholder="E.g : instagram.com/bla">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="facebook">Facebook</label>
                                <input type="text" value="<?php echo (empty($model)) ? old('facebook') : $model->facebook ?>" name="facebook" class="form-control" id="facebook" placeholder="E.g : facebook.com/bla" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="maps">Maps</label>
                                <input type="text" value="<?php echo (empty($model)) ? old('maps') : $model->maps ?>" name="maps" class="form-control" id="maps" placeholder="E.g : google.com/maps/bla">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_provinsi">Provinsi</label>
                                <select class="form-control select2" name="id_provinsi" id="id_provinsi" required>
                                    <option value="">-- Pilih Provinsi --</option>
                                    <?php foreach ($provinsi as $prov_value) { ?>
                                        <option value="<?php echo $prov_value->id_provinsi ?>" <?php echo (!empty($model) && $model->id_provinsi == $prov_value->id_provinsi ) ? 'selected' : ((old('id_provinsi') == $prov_value->id_provinsi  ) ? 'selected' : '') ?> ><?php echo $prov_value->nama_provinsi?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_kota">Kabupaten / Kota</label>
                                <select class="form-control select2" name="id_kota" id="id_kota" required>
                                    <option value="">-- Pilih Kabupaten / Kota --</option>
                                    <?php
                                        if(!empty($model)){ 
                                            foreach ($kabkot as $kat_value) { ?>
                                                <option value="<?php echo $kat_value->id?>" <?php echo (!empty($model) && $model->id_kota == $kat_value->id ) ? 'selected' : ((old('id_kota') == $kat_value->id ) ? 'selected' : '') ?> ><?php echo $kat_value->nama?></option>
                                    <?php 
                                            }
                                        } 
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="image">Gambar</label><span style="color:red"> *</span>
                                <input type="file" value="<?php echo (empty($model)) ? old('image') : $model->image ?>" name="image" class="form-control" id="image">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <?php
                    if(empty($model)){
                      ?> 
                        <button type="submit" class="btn btn-primary">Submit</button>
                      <?php
                    }else {
                      ?>
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah anda yakin akan mengupdate data?')">Update</button>
                      <?php
                    }
                  ?>
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
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
<!-- Select2 -->
<script src="<?php echo base_url() ?>/assets/plugins/select2/js/select2.full.min.js"></script>
<!-- jquery-validation -->
<script src="<?php echo base_url() ?>/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>/assets/back/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url() ?>/assets/back/js/demo.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url() ?>/assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- InputMask -->
<script src="<?php echo base_url() ?>/assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="<?php echo base_url() ?>/assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo base_url() ?>/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Page specific script -->
<script>
$(function () {
    $('.select2').select2({
        theme: 'bootstrap4'
    })
    $('#answer').summernote()
    $('#tgl_kegiatan').daterangepicker()
    $.validator.setDefaults({
        submitHandler: function () {
            alert( "Form successful submitted!" );
        }
    });
});

$('#id_provinsi').change(function(){
     var prov_id = $('#id_provinsi').val();
     if (prov_id != ""){
         var post_url = "<?php echo base_url();?>/produk/get_city/" + prov_id;
         $.ajax({
             type: "POST",
             url: post_url,
             data: {'id_provinsi':prov_id},
             success: function(cities)
             {
                 $('#id_kota').show();
                 $('#id_kota').html(cities);
             }
          });
     } else {
         $('#id_kota').hide();
     }
 });

</script>
</body>
</html>
