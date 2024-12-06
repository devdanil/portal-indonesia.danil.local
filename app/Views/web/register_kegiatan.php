<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Etalase Produk UMKM - Registrasi Kegiatan</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  
  <?php echo view('web/template/head'); ?>

  <!-- =======================================================
  * Template Name: Sailor - v4.6.0
  * Template URL: https://bootstrapmade.com/sailor-free-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
<?php echo view('web/template/header'); ?>
  <main id="main">
    <section id="features" class="features" style="margin-top: 100px;">
      <div class="container">

        <div class="section-title">
          <h2>Register</h2>
          <p>REGISTRASI KEGIATAN PAMERAN</p>
        </div>
        <?php if (!empty(session()->getFlashdata('error'))) : ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <h4>Periksa Entrian Form</h4>
                </hr />
                <?php echo session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>
        <?php if($level == 1 || $level == 2){ ?>
        <div class="col-lg-9 mt-4 mt-lg-0">
          <h3>Mohon maaf selain pelaku usaha tidak bisa mendaftar. Terima Kasih</h3>
        </div>
        <?php }else{ ?>
        <div class="row">
          <div class="col-lg-3">
            <ul class="nav nav-tabs flex-column">
              <li class="nav-item">
                <a class="nav-link active show" data-bs-toggle="tab" href="#tab-4"><?php echo $namakegiatan ?></a>
              </li>
            </ul>
          </div>
          <div class="col-lg-9 mt-4 mt-lg-0">
            <div class="tab-content">
              <div class="tab-pane active show" id="tab-4">
                <div class="row">
                  <div class="col-lg-12 details order-2 order-lg-1">
                    <div class="col-lg-8 mt-5 mt-lg-0">
                      <form enctype="multipart/form-data" action="<?php echo base_url(); ?><?php echo (empty($model)) ? '/pameran/save' : '#' ?>" method="post" role="form" class="php-email-form">
                        <?= csrf_field(); ?>
                        <!-- otomatis diisi dari prodil user -->
                        <div class="form-group mt-3">
                          <label for="" class="form-label">Nama Kelompok Usaha/Perusahaan*</label>
                          <input type="text" class="form-control" name="nama_usaha" id="nama_usaha" value="<?php echo strtoupper($pelaku_usaha->nama_usaha)?>" readonly>
                        </div>
                        <div class="form-group mt-3">
                          <label for="" class="form-label">No. Sertifikat PIRT</label>
                          <input type="text" class="form-control" name="no_izin_pirt" value="<?php echo ($pelaku_usaha->no_izin_pirt) != '' ? strtoupper($pelaku_usaha->no_izin_pirt) : '-' ?>" id="no_izin_pirt" readonly>
                        </div>
                        <div class="form-group mt-3">
                          <label for="" class="form-label">Nama Penanggung Jawab</label>
                          <input type="text" class="form-control" name="nama_pimpinan" id="nama_pimpinan" value="<?php echo ($pelaku_usaha->nama_pimpinan) != '' ? strtoupper($pelaku_usaha->nama_pimpinan) : '-' ?>" readonly>
                        </div>
                        <div class="form-group mt-3">
                          <label for="" class="form-label">Alamat Usaha</label>
                          <textarea class="form-control" name="alamat" rows="5" readonly><?php echo ($pelaku_usaha->alamat) != '' ? strtoupper($pelaku_usaha->alamat) : '-' ?></textarea>
                        </div>
                        <div class="form-group mt-3">
                          <label for="" class="form-label">No Telepon</label>
                          <input type="text" class="form-control" name="telpon" id="telpon" value="<?php echo ($pelaku_usaha->telpon) != '' ? strtoupper($pelaku_usaha->telpon) : '-'?>" readonly>
                        </div>
                        <div class="form-group mt-3">
                          <label for="" class="form-label">No HP</label>
                          <input type="text" class="form-control" name="handphone" id="handphone" value="<?php echo ($pelaku_usaha->handphone) != '' ? strtoupper($pelaku_usaha->handphone) : '-'?>" readonly>
                        </div>              
                        <hr>
                        <h5>Produk yang Dipamerkan</h5>      
                        <!-- Produk yang muncul yang telah di approve -->
                        <?php if(empty($produk)){ ?>
                          <div class="form-group mt-3">
                            <label for="" class="form-label">Mohon maaf anda belum memiliki produk dengan kategori <b><?php echo $namakategori ?></b>, sesuai dengan pameran ini. Silahkan untuk menambahkan produk anda di menu profile. Terima kasih.</label>
                          </div>
                        <?php }else{ ?>
                        <table id="customers" class="table table-bordered table-striped"> 
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Produk</th>
                              <th>Jenis</th>
                              <th>Kapasitas Produksi</th>
                              <th>Bahan Baku</th>
                              <th>Daftarkan Produk</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $i=0;$no=1; foreach($produk as $val_produk){ ?>
                            <tr>
                              <td><?php echo $no++?></td>
                              <td><?php echo $val_produk->nama_produk.' / '.old('produkpilihan[0]') ?></td>
                              <td><?php echo $val_produk->jenis ?></td>
                              <td><?php echo $val_produk->kapasitas_produksi.' '.$val_produk->satuan_kapasitas ?></td>
                              <td> - </td>
                              <td><input type="checkbox" name="produkpilihan[]" <?php echo (old('produkpilihan[0]') == $val_produk->id_produk) ? 'checked' : '' ?> value="<?php echo $val_produk->id_produk?>"></td>
                            </tr>
                            <?php $i++;} ?>
                          </tbody>
                        </table>
                        <hr>
                        <h5>Penanggung Jawab Selama Pameran</h5>
                        <input type="text" name="id_pembinaan" value="<?php echo $id_pembinaan ?>" readonly hidden>
                        <input type="text" name="id_pelaku" value="<?php echo $id_pelaku ?>" readonly hidden>
                        <div class="form-group mt-3">
                          <label for="" class="form-label">Nama*</label>
                          <input type="text" class="form-control" value="<?php echo (empty($model)) ? old('nama_pj') : $model->nama_pj ?>" name="nama_pj" id="nama_pj" required>
                        </div>
                        <div class="form-group mt-3">
                          <label for="" class="form-label">Jabatan*</label>
                          <input type="text" class="form-control" name="jabatan_pj" value="<?php echo (empty($model)) ? old('jabatan_pj') : $model->jabatan_pj ?>" id="jabatan_pj" required>
                        </div>
                        <div class="form-group mt-3">
                          <label for="" class="form-label">No HP*</label>
                          <input type="text" class="form-control" name="kontak_pj" value="<?php echo (empty($model)) ? old('kontak_pj') : $model->kontak_pj ?>" id="kontak_pj" required>
                        </div>
                        <div class="form-check mb-5">
                          <input class="form-check-input" type="checkbox" value="syarat" id="syarat" name="syarat" <?php echo (old('syarat') == 'syarat' || (!empty($model)) ) ? 'checked' : '' ?>>
                          <label class="form-check-label" for="syarat" style="font-weight: bold;">
                            Kami menyatakan berminat untuk ikut serta pada pameran <?php echo $namakegiatan ?> di <?php echo $tempat.' pada tanggal '.$waktu_awal.' - '.$waktu_akhir ?>. 
                            Bersedia memenuhi segala persyaratan serta ketentuan yang telah ditetapkan oleh Direktorat Penggunaan dan Pemasaran Produk Dalam Negeri KementerianPerdagangan.
                          </label>
                        </div>
                        <div class="row">
                          <div class="col-8">
                          </div>
                          <div class="g-recaptcha" data-sitekey="6LektGgpAAAAAMJrmalaUTpzhQEphSGW7paa7dk0"></div>                  
                        </div>
                        </div> 

                        <div class="form-group mt-3">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <?php } ?>
                      </form>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>

      </div>
    </section>
  </main>

  <?php echo view('web/template/footer'); ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <?php echo view('web/template/script'); ?>

</body>

</html>