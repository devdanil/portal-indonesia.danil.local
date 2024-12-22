<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Indonesia | <?php echo (empty($model)) ? 'Form Tambah Kegiatan' : 'Form Edit Kegiatan' ?></title>
  <?=  view('admin/template/header-form');?>
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
            <h1>Kegiatan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo (empty($model)) ? 'Tambah Kegiatan' : 'Edit Kegiatan' ?></li>
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
                <h3 class="card-title"><?php echo (empty($model)) ? 'Form Tambah Kegiatan' : 'Form Edit Kegiatan' ?></h3>
              </div>
                <?php if (!empty(session()->getFlashdata('error'))) : ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <h4>Periksa Entrian Form</h4>
                        </hr />
                        <?php echo session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>
              <form enctype="multipart/form-data" method="post" action="<?php echo base_url('admin'); ?><?php echo (empty($model)) ? '/kegiatan/save' : '/kegiatan/update/'.$model->id_pembinaan ?>">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="card card-primary">
                        <div class="card-header">
                          <h3 class="card-title">Tentang Kegiatan</h3>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_kegiatan">Nama Kegiatan</label>
                                    <input type="text" value="<?php echo (empty($model)) ? old('nama_kegiatan') : $model->nama_kegiatan ?>" name="nama_kegiatan" class="form-control" id="nama_kegiatan" placeholder="Nama Kegiatan" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="penyelenggara">Penyelenggara</label>
                                    <select class="form-control select2" name="penyelenggara" id="penyelenggara" required>
                                        <option value="">-- Pilih Penyelenggara --</option>
                                        <?php foreach ($penyelenggara as $penyelenggara_value) { ?>
                                            <option value="<?php echo $penyelenggara_value->id_penyelenggara ?>" <?php echo (!empty($model) && $model->penyelenggara == $penyelenggara_value->id_penyelenggara ) ? 'selected' : ((old('penyelenggara') == $penyelenggara_value->id_penyelenggara  ) ? 'selected' : '') ?> ><?php echo $penyelenggara_value->nama?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kapasitas_peserta">Kapasitas Peserta</label>
                                    <input type="number" value="<?php echo (empty($model)) ? old('kapasitas_peserta') : $model->kapasitas_peserta ?>" name="kapasitas_peserta" class="form-control" id="kapasitas_peserta" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ketentuan">Ketentuan</label>
                                    <!-- <input type="text" value="<?php //echo (empty($model)) ? old('ketentuan') : $model->ketentuan ?>" name="ketentuan" class="form-control" id="ketentuan" required> -->
                                    <textarea class="form-control" name="ketentuan" id="ketentuan" cols="30" rows="10" required><?php echo (empty($model)) ? old('ketentuan') : $model->ketentuan ?></textarea>
                                </div>
                            </div>
                            
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="card card-primary">
                        <div class="card-header">
                          <h3 class="card-title">Lokasi Kegiatan</h3>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="lokasi_pameran">Lokasi Pameran</label>
                                  <input type="text" value="<?php echo (empty($model)) ? old('lokasi_pameran') : $model->lokasi_pameran ?>" name="lokasi_pameran" class="form-control" id="lokasi_pameran" required>
                              </div>
                            </div>
                            <div class="col-md-4">
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
                            <div class="col-md-4">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kontak_person">Kontak Person</label>
                                    <input type="text" value="<?php echo (empty($model)) ? old('kontak_person') : $model->kontak_person ?>" name="kontak_person" class="form-control" id="kontak_person" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="wa_group">WA Group</label>
                                    <input type="text" value="<?php echo (empty($model)) ? old('wa_group') : $model->wa_group ?>" name="wa_group" class="form-control" id="wa_group" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pamflet">Pamflet</label>
                                    <input type="file" name="pamflet" class="form-control" id="pamflet">
                                </div>
                            </div>
                            <div class="col-sm-6">
                              <label for="preview">Preview</label>
                              <?php 
                                if(!empty($model)){ 
                                  if($model->pamflet != '' || $model->pamflet != null) { ?>
                                    <img src="<?php echo empty($model) ? '#' : base_url() ?>/assets/img/pameran/<?php echo $model->pamflet ?>" width="100%" alt="">
                                  <?php } else { ?>
                                    <p>Gambar tidak ada</p>
                              <?php } } ?>
                              <br>
                              <b>Untuk mengganti atau menambahkan Pamflet Klik choose file</b>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="card card-primary">
                        <div class="card-header">
                          <h3 class="card-title">Waktu Kegiatan</h3>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal_publikasi">Tanggal Publikasi</label>
                                    <input type="date" value="<?php echo (empty($model)) ? old('tanggal_publikasi') : date('Y-m-d', strtotime($model->tanggal_publikasi)) ?>" name="tanggal_publikasi" class="form-control" id="tanggal_publikasi" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="waktu_awal">Waktu Awal Kegiatan</label>
                                    <input type="date" value="<?php echo (empty($model)) ? old('waktu_awal') : date('Y-m-d', strtotime($model->waktu_awal)) ?>" name="waktu_awal" class="form-control" id="waktu_awal" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="waktu_akhir">Waktu Akhir Kegiatan</label>
                                    <input type="date" value="<?php echo (empty($model)) ? old('waktu_akhir') : date('Y-m-d', strtotime($model->waktu_akhir)) ?>" name="waktu_akhir" class="form-control" id="waktu_akhir" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="awal_pendaftaran">Awal Pendaftaran</label>
                                    <input type="date" value="<?php echo (empty($model)) ? old('awal_pendaftaran') : date('Y-m-d', strtotime($model->awal_pendaftaran)) ?>" name="awal_pendaftaran" class="form-control" id="awal_pendaftaran" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="batas_pendaftaran">Akhir Pendaftaran</label>
                                    <input type="date" value="<?php echo (empty($model)) ? old('batas_pendaftaran') : date('Y-m-d', strtotime($model->batas_pendaftaran)) ?>" name="batas_pendaftaran" class="form-control" id="batas_pendaftaran" required>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="card card-primary">
                        <div class="card-header">
                          <h3 class="card-title">Kategori</h3>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-6">
                                <label for="kategori_produk">Kategori Produk</label>
                                <div class="form-check">
                                  <?php if (!empty($model)) { $datakat=json_decode($model->kategori_produk); $jumlahkat = count($datakat); ?>
                                    <?php foreach ($kategori as $kategori_value) { $checked = '';?>
                                      <?php for($i=0; $i<$jumlahkat; $i++){ 
                                        if ($datakat[$i] == $kategori_value->id_kategori) {
                                          $checked = 'checked';
                                        } }
                                      ?>
                                      <input class="form-check-input" type="checkbox" value="<?php echo $kategori_value->id_kategori?>" name="kategori_produk[]" id="kategori_produk" <?= $checked?>>
                                      <label class="form-check-label" for="kategori_produk[]">
                                        <?php echo $kategori_value->kategori?>
                                      </label><br>
                                    <?php } ?>
                                  <?php } else { ?>
                                  <?php foreach ($kategori as $kategori_value) { ?>
                                      <input class="form-check-input" type="checkbox" value="<?php echo $kategori_value->id_kategori?>" name="kategori_produk[]" id="kategori_produk" checked>
                                      <label class="form-check-label" for="kategori_produk[]">
                                        <?php echo $kategori_value->kategori?>
                                      </label><br>
                                  <?php } } ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                              <label for="pangan_non">Kategori Pangan</label>
                              <div class="form-check">
                                <?php
                                  if (!empty($kat1)) {
                                    if($kat1 == 'nonpangan'){
                                      $checked = 'checked';
                                    } else {
                                      if (old('nonpangan') == 'nonpangan') {
                                        $checked = 'checked';
                                      } else {
                                        $checked = '';
                                      }
                                    }
                                  } else {
                                    $checked = 'checked';
                                  }
                                ?>
                                <input class="form-check-input" type="checkbox" value="nonpangan" name="nonpangan" id="nonpangan" <?= $checked ?>>
                                <label class="form-check-label" for="nonpangan">
                                  Non Pangan 
                                </label>
                              </div>
                              <div class="form-check">
                                <?php 
                                  if (!empty($kat2)) {
                                    if($kat2 == 'pangan'){
                                      $checked2 = 'checked';
                                    } else {
                                      if (old('pangan') == 'pangan') {
                                        $checked2 = 'checked';
                                      } else {
                                        $checked2 = '';
                                      }
                                    }
                                  } else {
                                    $checked2 = '';
                                  }
                                ?>
                                <input class="form-check-input" type="checkbox" value="pangan" name="pangan" id="pangan" <?= $checked2 ?> >
                                <label class="form-check-label" for="pangan">
                                  Pangan
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
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
  <?= view('admin/template/foot-form'); ?>
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
         var post_url = "<?php echo base_url('admin');?>/produk/get_city/" + prov_id;
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
