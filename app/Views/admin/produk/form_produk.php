<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Indonesia | <?php echo (empty($model)) ? 'Form Tambah Produk' : 'Form Edit Produk' ?></title>
  <link href="<?php echo base_url() ?>/assets/logo.png" rel="icon">
  <link href="<?php echo base_url() ?>/assets/logo.png" rel="apple-touch-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/back/css/adminlte.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/summernote/summernote-bs4.min.css">
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
            <h1>Kategori</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo (empty($model)) ? 'Tambah Produk' : 'Edit Produk' ?></li>
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
                <h3 class="card-title"><?php echo (empty($model)) ? 'Form Tambah Produk' : 'Form Edit Produk' ?></h3>
              </div>
                <?php if (!empty(session()->getFlashdata('error'))) : ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <h4>Periksa Entrian Form</h4>
                        </hr />
                        <?php echo session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>
              <form enctype="multipart/form-data" method="post" action="<?php echo base_url(); ?><?php echo (empty($model)) ? '/produk/save' : '/produk/update/'.$model->id_produk ?>">
                <?= csrf_field(); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori">Nama Kategori</label>
                                <select class="form-control select2" name="kategori" id="kategori" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach ($kategori as $kat_value) { ?>
                                        <option value="<?php echo $kat_value->id_kategori?>" <?php echo (!empty($model) && $model->id_kategori == $kat_value->id_kategori ) ? 'selected' : ((old('kategori') == $kat_value->id_kategori ) ? 'selected' : '') ?> ><?php echo $kat_value->kategori?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="subkategori">Nama SubKategori</label>
                                <select class="form-control select2" name="subkategori" id="subkategori" required>
                                    <option value="">-- Pilih SubKategori --</option>
                                    <?php
                                        if(!empty($model)){ 
                                            foreach ($subkategori as $kat_value) { ?>
                                                <option value="<?php echo $kat_value->id_sub?>" <?php echo (!empty($model) && $model->id_sub == $kat_value->id_sub ) ? 'selected' : ((old('subkategori') == $kat_value->id_sub ) ? 'selected' : '') ?> ><?php echo $kat_value->nama?></option>
                                    <?php 
                                            }
                                        } 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="provinsi">Provinsi</label>
                                <select class="form-control select2" name="provinsi" id="provinsi" required>
                                    <option value="">-- Pilih Provinsi --</option>
                                    <?php foreach ($provinsi as $provinsi_value) { ?>
                                        <option value="<?php echo $provinsi_value->id_provinsi?>" <?php echo (!empty($model) && $model->id_provinsi == $provinsi_value->id_provinsi ) ? 'selected' : ((old('provinsi') == $provinsi_value->id_provinsi ) ? 'selected' : '') ?> ><?php echo $provinsi_value->nama_provinsi?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kabkot">Kabupaten / Kota</label>
                                <select class="form-control select2" name="kabkot" id="kabkot" required>
                                    <option value="">-- Pilih KabKot --</option>
                                    <?php
                                        if(!empty($model)){ 
                                            foreach ($kabkot as $kabkot_value) { ?>
                                                <option value="<?php echo $kabkot_value->id?>" <?php echo (!empty($model) && $model->id_kota == $kabkot_value->id ) ? 'selected' : ((old('kabkot') == $kabkot_value->id ) ? 'selected' : '') ?> ><?php echo $kabkot_value->nama?></option>
                                    <?php 
                                            }
                                        } 
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori">Pelaku Usaha</label>
                                <select class="form-control select2" name="pelaku_usaha" id="pelaku_usaha" required>
                                    <option value="0">-- Pilih Pelaku Usaha --</option>
                                    <?php foreach ($pelaku_usaha as $pelaku_usaha_value) { ?>
                                        <option value="<?php echo $pelaku_usaha_value->id_pelaku?>" <?php echo (!empty($model) && $model->id_pelaku_usaha == $pelaku_usaha_value->id_pelaku ) ? 'selected' : ((old('pelaku_usaha') == $pelaku_usaha_value->id_pelaku ) ? 'selected' : '') ?> ><?php echo $pelaku_usaha_value->nama_usaha?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama_produk">Nama Produk</label>
                                <input type="text" value="<?php echo (empty($model)) ? old('nama_produk') : $model->nama_produk ?>" name="nama_produk" class="form-control" id="nama_produk" placeholder="Nama Produk" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_registrasi">No Registrasi</label>
                                <input type="text" value="<?php echo (empty($model)) ? old('no_registrasi') : $model->no_registrasi ?>" name="no_registrasi" class="form-control" id="no_registrasi" placeholder="No Registrasi" required>
                            </div>
                            <div class="form-group">
                                <label for="tahun_reg">Tahun Registrasi</label>
                                <input type="text" value="<?php echo (empty($model)) ? old('tahun_reg') : $model->tahun_reg ?>" name="tahun_reg" class="form-control" id="tahun_reg" placeholder="Tahun Registrasi" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="deskripsi_in">Deskripsi</label>
                                <textarea name="deskripsi_in" id="deskripsi_in" ><?php echo (empty($model)) ? old('deskripsi_in') : $model->deskripsi_in ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="deskripsi_en">Deskripsi Dalam Bahasa Inggris </label>
                                <textarea name="deskripsi_en" id="deskripsi_en" ><?php echo (empty($model)) ? old('deskripsi_en') : $model->deskripsi_en ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori">Spesifikasi Teknis</label>
                                <textarea name="spesifikasi_in" id="spesifikasi_in" ><?php echo (empty($model)) ? old('spesifikasi_in') : $model->spesifikasi_in ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori">Spesifikasi Teknis Dalam Bahasa Inggris </label>
                                <textarea name="spesifikasi_en" id="spesifikasi_en" ><?php echo (empty($model)) ? old('spesifikasi_en') : $model->spesifikasi_en ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="berat_dg_kemasan">Berat Dengan Kemasan</label>
                                <input type="text" value="<?php echo (empty($model)) ? old('berat_dg_kemasan') : $model->berat_dg_kemasan ?>" name="berat_dg_kemasan" class="form-control" id="berat_dg_kemasan" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="berat">Berat</label>
                                <input type="text" value="<?php echo (empty($model)) ? old('berat') : $model->berat ?>" name="berat" class="form-control" id="berat" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="foto_produk">Foto Produk</label>
                                <input type="file" value="<?php echo (empty($model)) ? old('foto_produk') : $model->foto_produk ?>" name="foto_produk" class="form-control" id="foto_produk" accept="images/jpeg, images/png">
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
<!-- Page specific script -->
<script>
$(function () {
    $('#deskripsi_in').summernote()
    $('#deskripsi_en').summernote()
    $('#spesifikasi_in').summernote()
    $('#spesifikasi_en').summernote()

    $('.select2').select2({
        theme: 'bootstrap4'
    })

    $.validator.setDefaults({
        submitHandler: function () {
            alert( "Form successful submitted!" );
        }
    });
});

$(document).ready(function(e) {
 $('#kategori').change(function(){
     var kat_id = $('#kategori').val();
     if (kat_id != ""){
         var post_url = "<?php echo base_url();?>/produk/get_sub_kategori/" + kat_id;
         $.ajax({
             type: "POST",
             url: post_url,
             data: {'id_kategori':kat_id},
             success: function(sub_kategori) //we're calling the response json array 'cities'
             {
                 //$('#f_city').empty();
                 $('#subkategori').show();
                 $('#subkategori').html(sub_kategori);
                 /*$.each(cities,function(id,city)
                 {
                     var opt = $('<option />'); // here we're creating a new select option for each group
                     opt.val(id);
                     opt.text(city);
                     $('#f_city').append(opt);
                 });*/
             } //end success
          }); //end AJAX
     } else {
         //$('#f_city').empty();
         //$('#subKategori').hide();
     }//end if
 }); //end change
 
 $('#provinsi').change(function(){
     var prov_id = $('#provinsi').val();
     if (prov_id != ""){
         var post_url = "<?php echo base_url();?>/produk/get_city/" + prov_id;
         $.ajax({
             type: "POST",
             url: post_url,
             data: {'id_provinsi':prov_id},
             success: function(cities) //we're calling the response json array 'cities'
             {
                 //$('#f_city').empty();
                 $('#kabkot').show();
                 $('#kabkot').html(cities);
                 /*$.each(cities,function(id,city)
                 {
                     var opt = $('<option />'); // here we're creating a new select option for each group
                     opt.val(id);
                     opt.text(city);
                     $('#f_city').append(opt);
                 });*/
             } //end success
          }); //end AJAX
     } else {
         //$('#f_city').empty();
         $('#kabkot').hide();
     }//end if
 }); //end change
});

</script>
</body>
</html>
