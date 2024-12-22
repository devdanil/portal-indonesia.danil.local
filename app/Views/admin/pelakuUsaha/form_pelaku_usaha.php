<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Indonesia | <?php echo (empty($model)) ? 'Form Tambah Pelaku Usaha' : 'Form Edit Pelaku Usaha' ?></title>
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
              <li class="breadcrumb-item"><a href="<?php echo base_url('admin') ?>/pelaku-usaha-admin">List Pelaku Usaha</a></li>
              <li class="breadcrumb-item active"><?php echo (empty($model)) ? 'Tambah Pelaku Usaha' : 'Edit Pelaku Usaha' ?></li>
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
                <h3 class="card-title"><?php echo (empty($model)) ? 'Form Tambah Pelaku Usaha' : 'Form Edit Pelaku Usaha' ?></h3>
              </div>
                <?php if (!empty(session()->getFlashdata('error'))) : ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <h4>Periksa Entrian Form</h4>
                        </hr />
                        <?php echo session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>
              <form enctype="multipart/form-data" action="<?php echo base_url('admin'); ?><?php echo (empty($model)) ? '/pelaku-usaha/save' : '/pelaku-usaha/update/'.$model->id_pelaku ?>" method="post">
                <?= csrf_field(); ?>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="" class="form-label">Nama Kelompok Usaha/Perusahaan</label><span style="color:red"> *</span>
                        <input type="text" class="form-control" name="nama_usaha" id="nama_usaha" value="<?php echo (empty($model)) ? old('nama_usaha') : $model->nama_usaha ?>" required >
                      </div>
                      <div class="form-group">
                        <label for="" class="form-label">Nama Penanggung Jawab</label><span style="color:red"> *</span>
                        <input type="text" class="form-control" value="<?php echo (empty($model)) ? old('nama_pimpinan') : $model->nama_pimpinan ?>" name="nama_pimpinan" id="nama_pimpinan"
                          placeholder="" required>
                      </div>
                      <div class="form-group">
                        <label for="" class="form-label">Alamat Usaha</label><span style="color:red"> *</span>
                        <textarea class="form-control" id="alamat" name="alamat" rows="5" required><?php echo (empty($model)) ? old('alamat') : $model->alamat ?></textarea>
                      </div>
                      <div class="form-group">
                        <label for="" class="form-label">Jenis Usaha</label><span style="color:red"> *</span>
                        <div class="form-check">
                          <!-- <p><?//=old('jenis_usaha')[0]?></p> -->
                          <input class="form-check-input" type="checkbox" value="Produsen" 
                            <?php 
                              if (old('jenis_usaha')) {
                                $to_array = old('jenis_usaha');
                                for ($i=0; $i < count($to_array) ; $i++) { 
                                  echo ($to_array[$i] == 'Produsen') ? 'checked' : '';   
                                }
                              }elseif(!empty($model)){
                                $to_array = explode(",",$model->jenis_usaha);
                                for ($i=0; $i < count($to_array) ; $i++) { 
                                  echo ($to_array[$i] == 'Produsen') ? 'checked' : '';   
                                }
                              }
                            ?> 
                            id="jenis_usaha" name="jenis_usaha[]">
                          <label class="form-check-label" for="flexCheckDefault">
                            Produsen
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="Distributor" 
                            <?php 
                              if (old('jenis_usaha')) {
                                $to_array = old('jenis_usaha');
                                for ($i=0; $i <count($to_array) ; $i++) { 
                                  echo ($to_array[$i] == 'Distributor') ? 'checked' : '';   
                                }
                              }elseif(!empty($model)){
                                $to_array = explode(",",$model->jenis_usaha);
                                for ($i=0; $i < count($to_array) ; $i++) { 
                                  echo ($to_array[$i] == 'Distributor') ? 'checked' : '';   
                                }
                              }
                            ?> 
                            id="jenis_usaha" name="jenis_usaha[]">
                          <label class="form-check-label" for="flexCheckDefault">
                            Distributor
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="Agen" 
                            <?php 
                              if (old('jenis_usaha')) {
                                $to_array = old('jenis_usaha');
                                for ($i=0; $i < count($to_array) ; $i++) { 
                                  echo ($to_array[$i] == 'Agen') ? 'checked' : '';   
                                }
                              }elseif(!empty($model)){
                                $to_array = explode(",",$model->jenis_usaha);
                                for ($i=0; $i < count($to_array) ; $i++) { 
                                  echo ($to_array[$i] == 'Agen') ? 'checked' : '';   
                                }
                              }
                            ?> 
                            id="jenis_usaha" name="jenis_usaha[]">
                          <label class="form-check-label" for="flexCheckDefault">
                            Agen
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="Exportir" 
                            <?php
                              if (old('jenis_usaha')) {
                                $to_array = old('jenis_usaha');
                                for ($i=0; $i < count($to_array) ; $i++) { 
                                  echo ($to_array[$i] == 'Exportir') ? 'checked' : '';   
                                }
                              }elseif(!empty($model)){
                                $to_array = explode(",",$model->jenis_usaha);
                                for ($i=0; $i < count($to_array) ; $i++) { 
                                  echo ($to_array[$i] == 'Exportir') ? 'checked' : '';   
                                }
                              } 
                            ?> 
                            id="jenis_usaha" name="jenis_usaha[]">
                          <label class="form-check-label" for="flexCheckDefault">
                            Exportir
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="Pengecer" 
                            <?php
                              if (old('jenis_usaha')) {
                                $to_array = old('jenis_usaha');
                                for ($i=0; $i < count($to_array) ; $i++) { 
                                  echo ($to_array[$i] == 'Pengecer') ? 'checked' : '';   
                                } 
                              }elseif(!empty($model)){
                                $to_array = explode(",",$model->jenis_usaha);
                                for ($i=0; $i < count($to_array) ; $i++) { 
                                  echo ($to_array[$i] == 'Pengecer') ? 'checked' : '';   
                                }
                              }
                            ?> 
                            id="jenis_usaha" name="jenis_usaha[]">
                          <label class="form-check-label" for="flexCheckDefault">
                            Pengecer
                          </label>
                        </div>
                      </div>
                      
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="" class="form-label">No Izin PIRT</label>
                        <input type="text" class="form-control" value="<?php echo (empty($model)) ? old('no_izin_pirt') : $model->no_izin_pirt ?>" name="no_izin_pirt" id="no_izin_pirt"
                        placeholder="" >
                      </div>
                      <div class="form-group">
                        <label for="" class="form-label">NIK (No.KTP Penanggung Jawab)</label><span style="color:red"> *</span>
                        <input type="number" class="form-control" name="nik_pimpinan" id="nik_pimpinan" value="<?php echo (empty($model)) ? old('nik_pimpinan') : $model->nik_pimpinan ?>" required>
                      </div>
                      <div class="form-group">
                        <label for="" class="form-label">Kekayaan Bersih yang dimiliki</label><span style="color:red"> *</span>
                        <select class="form-control select2" id="kekayaan" name="kekayaan" aria-label="Default select example">
                          <option value="">-Pilih-</option>
                          <option <?php echo (!empty($model) && $model->kekayaan == 'Rp.0 s/d Rp.50.000.000,-' ) ? 'selected' : ((old('kekayaan') == 'Rp.0 s/d Rp.50.000.000,-' ) ? 'selected' : '') ?> value="Rp.0 s/d Rp.50.000.000,-">Rp.0 s/d Rp.50.000.000,-</option>
                          <option <?php echo (!empty($model) && $model->kekayaan == 'Rp.50.000.000 s/d Rp.500.000.000,-' ) ? 'selected' : ((old('kekayaan') == 'Rp.50.000.000 s/d Rp.500.000.000,-' ) ? 'selected' : '') ?> value="Rp.50.000.000 s/d Rp.500.000.000,-">Rp.50.000.000 s/d Rp.500.000.000,-</option>
                          <option <?php echo (!empty($model) && $model->kekayaan == 'Rp.500.000.000 s/d Rp.10.000.000.000,-' ) ? 'selected' : ((old('kekayaan') == 'Rp.500.000.000 s/d Rp.10.000.000.000,-' ) ? 'selected' : '') ?> value="Rp.500.000.000 s/d Rp.10.000.000.000,-">Rp.500.000.000 s/d Rp.10.000.000.000,-</option>
                          <option <?php echo (!empty($model) && $model->kekayaan == '> Rp.10.000.000.000,-' ) ? 'selected' : ((old('kekayaan') == '> Rp.10.000.000.000,-' ) ? 'selected' : '') ?> value="> Rp.10.000.000.000,-">> Rp.10.000.000.000,-</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="" class="form-label">Upload Identitas</label>
                        <div class="mb-3">
                          <input <?php echo (!empty($model) ? 'readonly' : '' ) ?> class="form-control" type="file" id="identitas" name="identitas">
                          <?php if(old('identitas') != '' ) { ?> 
                            <p class="form-group mt-3">Preview</p>
                            <img src="<?php echo base_url() ?>/assets/uploads/ktp/<?php echo old('identitas') ?>" width="50%" >
                          <?php }elseif((!empty($model))){ ?>
                            <p class="form-group mt-3">Preview</p>
                            <img src="<?php echo base_url() ?>/assets/uploads/ktp/<?php echo $model->identitas ?>" width="50%" >
                          <?php } ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="" class="form-label">Provinsi</label><span style="color:red"> *</span>
                        <select class="form-control select2" aria-label="Default select example" id="id_provinsi" name="id_provinsi">
                          <option>-Pilih-</option>
                          <?php foreach ($provinsi as $provinsi_value) { ?>
                              <option value="<?php echo $provinsi_value->id_provinsi?>" <?php echo (!empty($model) && $model->id_provinsi == $provinsi_value->id_provinsi ) ? 'selected' : ((old('id_provinsi') == $provinsi_value->id_provinsi ) ? 'selected' : '') ?> ><?php echo $provinsi_value->nama_provinsi?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="" class="form-label">Kota/Kabupaten</label><span style="color:red"> *</span>
                        <select class="form-control select2" aria-label="Default select example" id="id_kota" name="id_kota">
                          <option>-Pilih-</option>
                            <?php
                                if(!empty($model)){ 
                                    foreach ($kabkot as $kabkot_value) { ?>
                                        <option value="<?php echo $kabkot_value->id?>" <?php echo (!empty($model) && $model->id_kota == $kabkot_value->id ) ? 'selected' : ((old('id_kota') == $kabkot_value->id ) ? 'selected' : '') ?> ><?php echo $kabkot_value->nama?></option>
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
                        <label for="" class="form-label">Kodepos</label>
                        <input type="text" class="form-control" name="kode_pos" id="kode_pos" value="<?php echo (empty($model)) ? old('kode_pos') : $model->kode_pos ?>">
                      </div>
                      <div class="form-group">
                        <label for="" class="form-label">No Telepon</label>
                        <input type="text" class="form-control" name="telpon" id="telpon" value="<?php echo (empty($model)) ? old('telpon') : $model->telpon ?>">
                      </div>
                      <div class="form-group">
                        <label for="" class="form-label">Email </label><span style="color:red"> *</span>
                        <input type="text" class="form-control" name="email" id="email" value="<?php echo (empty($model)) ? old('email') : $model->email ?>" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="" class="form-label">No HP</label><span style="color:red"> *</span>
                        <input type="text" class="form-control" name="handphone" id="handphone" value="<?php echo (empty($model)) ? old('handphone') : $model->handphone ?>" required>
                      </div>
                      <div class="form-group">
                        <label for="" class="form-label">Website</label>
                        <input type="text" class="form-control" name="website" id="website" value="<?php echo (empty($model)) ? old('website') : $model->website ?>">
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="setuju" id="setuju" name="setuju" 
                        <?php echo (old('setuju') == 'setuju' || (!empty($model)) ) ? 'checked' : '' ?> >
                        <label class="form-check-label" for="flexCheckDefault" style="font-weight: bold;">
                          Kami menyatakan bahwa semua informasi yang kami sampaikan adalah benar. Jika tidak sesuai
                          maka kami akan bertanggung jawab sesuai dengan ketentuan hukum yang berlaku.
                        </label>
                      </div>
                      <div class="g-recaptcha" data-sitekey="6LektGgpAAAAAMJrmalaUTpzhQEphSGW7paa7dk0"></div>
                      <div class="form-group mt-3">
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
                    </div>
                  </div>
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
<!-- jquery-validation -->
<script src="<?php echo base_url() ?>/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>/assets/back/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url() ?>/assets/back/js/demo.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url() ?>/assets/plugins/select2/js/select2.full.min.js"></script>
<!-- Page specific script -->
<script>
  $(document).ready(function(e) {
     $('#id_provinsi').change(function(){
        var prov_id = $('#id_provinsi').val();
        if (prov_id != ""){
            var post_url = "<?php echo base_url('admin');?>/produk/get_city/" + prov_id;
            $.ajax({
                type: "POST",
                url: post_url,
                data: {'id_provinsi':prov_id},
                success: function(cities) //we're calling the response json array 'cities'
                {
                    $('#id_kota').show();
                    $('#id_kota').html(cities);
                } //end success
              }); //end AJAX
        } else {
            $('#id_kota').hide();
        }//end if
    }); //end change
  });

$(function () {
  $('.select2').select2({
      theme: 'bootstrap4'
  })
    
  $.validator.setDefaults({
    submitHandler: function () {
      alert( "Form successful submitted!" );
    }
  });
  $('#quickForm').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        minlength: 5
      },
      terms: {
        required: true
      },
    },
    messages: {
      email: {
        required: "Please enter a email address",
        email: "Please enter a vaild email address"
      },
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
      terms: "Please accept our terms"
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>
</body>
</html>
