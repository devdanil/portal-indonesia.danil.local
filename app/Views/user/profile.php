<main id="main">
  <script src='https://www.google.com/recaptcha/api.js?hl=id'></script>
  <section id="features" class="features" style="margin-top: 100px;">
    <div class="container">

      <div class="section-title">
        <h2>Profile</h2>
        <p>PROFILE PELAKU USAHA</p>
      </div>
      <?php if ($status_registrasi == 1) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <h4>
            Selamat anda berhasil melakukan registrasi, saat ini anda tidak dapat melakukan pendaftran produk dikarenakan akun anda sedang dalam tahap review.
            Untuk informasi password sudah kami kirimkan lewat email, jika ingin mengubah password silahkan klik tombol reset password.
          </h4>
        </div>
      <?php endif; ?>

      <div class="row">
        <div class="col-lg-3">
          <ul class="nav nav-tabs flex-column">
            <li class="nav-item">
              <a class="nav-link <?= ($tab_active == 'regispelaku') ? 'active' : '' ?> show" data-bs-toggle="tab" href="#tab-4">Pelaku Usaha</a>
            </li>
            <?php if (!empty($showRegisProduk)) { ?>
              <li class="nav-item">
                <a class="nav-link <?= ($tab_active == 'regisproduk') ? 'active' : '' ?>" data-bs-toggle="tab" href="#tab-3">Produk</a>
              </li>
            <?php } ?>
            <li class="nav-item">
              <a class="nav-link <?= ($tab_active == 'reset') ? 'active' : '' ?>" data-bs-toggle="tab" href="#tab-2">Reset Password</a>
            </li>
          </ul>
        </div>
        <div class="col-lg-9 mt-4 mt-lg-0">
          <div class="tab-content">
            <?php if (!empty($showRegisProduk)) { ?>
              <div class="tab-pane <?= ($tab_active == 'regisproduk') ? 'active' : '' ?>" id="tab-3">
                <div class="row">
                  <div class="col-lg-12 details order-2 order-lg-1">
                    <h3>Produk</h3>
                    <?php if (!empty(session()->getFlashdata('sukses'))) : ?>
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h4><?= session()->getFlashdata('sukses'); ?></h4>
                      </div>
                    <?php endif; ?>
                    <?php if (!empty(session()->getFlashdata('errorproduk'))) : ?>
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h4><?= session()->getFlashdata('errorproduk'); ?></h4>
                      </div>
                    <?php endif; ?>
                    <p>
                      Form ini dimaksudkan kepada pelaku usaha untuk memasukkan data produk-produknya untuk ditampilkan
                      pada website ini, setelah ini kami akan melakukan verifikasi
                    </p>
                    <div>
                      <section id="pricing" class="pricing">
                        <div class="container">
                          <div class="row">
                            <?php if ($produk == null) { ?> <p>Belum ada produk</p> <?php } else {
                                                                                    foreach ($produk as $produk_value) { ?>
                                <div class="col-lg-4 col-md-12 mb-10">
                                  <div class="box">
                                    <?php
                                                                                      if ($produk_value->status == 0) { ?>
                                      <span class="advanced">Proses Review</span>
                                    <?php } else { ?>
                                      <span class="advanced">Public</span>
                                    <?php }
                                    ?>
                                    <h3><?= $produk_value->nama_produk ?></h3>
                                    <div>
                                      <img src="<?= base_url() . "/assets/uploads/" . $produk_value->foto_produk ?>"
                                        alt="" srcset="" class="responsive">
                                    </div>
                                    <ul>
                                      <li><?= $produk_value->kategori ?></li>
                                      <li><?= $produk_value->nama_produk ?></li>
                                      <li><?= $produk_value->jenis_usaha ?></li>
                                      <li><i class="fa fa-envelope"></i><a href="<?= $produk_value->email ?>">
                                          <?= $produk_value->email ?></a></li>
                                      <li><i class="fa fa-phone-alt"> <?= $produk_value->handphone ?></i></li>
                                    </ul>
                                    <div class="btn-wrap">
                                      <a href="<?= base_url('user/profile?edit=' . $produk_value->id_produk) ?>" class="btn btn-detail">Edit</a>
                                      <button type="button" class="btn btn-buy btn-delete-produk" data-id="<?= base64_encode($produk_value->id_produk) ?>">
                                        Delete
                                      </button>
                                    </div>
                                  </div>
                                </div>
                            <?php }
                                                                                  } ?>
                          </div>
                        </div>
                      </section>
                      <section id="blog" class="blog">
                        <div class="container" data-aos="fade-up">
                          <div class="row">
                            <div class="col-lg-12 entries">
                              <div class="blog-pagination">
                                <!-- <ul class="justify-content-center">
                                            <li><a href="#">Prev</a></li>
                                            <li><a href="#">1</a></li>
                                            <li class="active"><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">5</a></li>
                                            <li><a href="#">Next</a></li>
                                        </ul> -->
                                <ul class="justify-content-center">
                                  <?= $pager->links(); ?>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                      </section>
                      <div align="center" id="produk-li-1" role="presentation">
                        <h3>Tambah Produk</h3>
                        <?php if (!empty(session()->getFlashdata('error_cek'))) : ?>
                          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h4><?= session()->getFlashdata('error_cek'); ?></h4>
                          </div>
                        <?php endif; ?>
                      </div>
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="produk1" role="tabpanel" aria-labelledby="home-tab">
                          <?php
                          if (empty($edit)) {
                            $url = base_url('user/profile/store_produk');
                          } else {
                            $url = base_url('user/profile/update_produk/' . $edit->id_produk);
                          } ?>
                          <form enctype="multipart/form-data" action="<?= $url ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="form-group mt-3">
                              <label for="" class="form-label">Nama Produk</label><span style="color:red"> *</span>
                              <input type="text" class="form-control" value="<?= (empty($edit)) ? old('nama_produk') : $edit->nama_produk ?>" name="nama_produk" id="nama_produk"
                                placeholder="" required>
                            </div>
                            <div class="form-group mt-3">
                              <label for="" class="form-label">Kategori</label><span style="color:red"> *</span>
                              <select class="form-control select2" name="kategori" id="kategori_id" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($kategori as $kat_value) { ?>
                                  <option value="<?= $kat_value->id_kategori ?>" <?= (!empty($edit) && $edit->id_kategori == $kat_value->id_kategori) ? 'selected' : ((old('kategori') == $kat_value->id_kategori) ? 'selected' : '') ?>><?= $kat_value->kategori ?></option>
                                <?php } ?>
                              </select>
                            </div>
                            <div class="form-group mt-3">
                              <label for="" class="form-label">Sub Kategori</label><span style="color:red"> *</span>
                              <select class="form-control select2" name="subkategori" id="subkategori_id" required>
                                <?php if (!empty($edit)) {
                                  foreach ($subkategori as $sub_value) { ?>
                                    <option value="<?= $sub_value->id_sub ?>" <?= (!empty($edit) && $edit->id_sub == $sub_value->id_sub) ? 'selected' : ((old('subkategori') == $sub_value->id_sub) ? 'selected' : '') ?>><?= $sub_value->nama ?></option>
                                  <?php }
                                } else { ?>
                                  <option value="">-- Pilih SubKategori --</option>
                                <?php } ?>
                              </select>
                            </div>
                            <div class="form-group mt-3" id="div_jenis">
                              <label for="" class="form-label">Sertifikasi Halal</label>
                              <select class="form-control select2" name="jenis_makanan" id="jenis_makanan">
                                <option value="">-- Pilih Sertifikasi Halal --</option>
                                <option value="Bersertifikasi Halal" <?= (!empty($edit) && $edit->jenis_makanan == 'Bersertifikasi Halal') ? 'selected' : ((old('jenis_makanan') == 'Bersertifikasi Halal') ? 'selected' : '') ?>>Bersertifikasi Halal</option>
                                <option value="Belum Bersertifikasi Halal" <?= (!empty($edit) && $edit->jenis_makanan == 'Belum Bersertifikasi Halal') ? 'selected' : ((old('jenis_makanan') == 'Belum Bersertifikasi Halal') ? 'selected' : '') ?>>Belum Bersertifikasi Halal</option>
                              </select>
                            </div>
                            <div class="form-group mt-3">
                              <label for="" class="form-label">No. Sertifikasi Halal</label>
                              <input type="text" class="form-control" value="<?= (!empty($edit)) ? $edit->no_halal : old('no_halal') ?>" name="no_halal" id="no_halal" placeholder="">
                            </div>
                            <div class="form-group mt-3">
                              <label for="" class="form-label">Spesifikasi</label><span style="color:red"> *</span>
                              <textarea class="form-control custom-editor" name="spesifikasi_in" id="spesifikasi_in" rows="3" placeholder="" required>
                                <?= (!empty($edit)) ? $edit->spesifikasi_in : old('spesifikasi_in') ?>
                              </textarea>
                            </div>
                            <div class="form-group mt-3">
                              <label for="" class="form-label">Spesifikasi (Dalam Bahasa Inggris)</label>
                              <textarea class="form-control custom-editor" name="spesifikasi_en" id="spesifikasi_en" rows="3" placeholder="">
                                <?= (!empty($edit)) ? $edit->spesifikasi_in : old('spesifikasi_en') ?>
                              </textarea>
                            </div>
                            <div class="form-group mt-3">
                              <label for="" class="form-label">Link Tokopedia</label>
                              <input type="url" class="form-control" name="tokopedia" id="tokopedia" value="<?= (!empty($edit)) ? $edit->tokopedia : old('tokopedia') ?>"
                                placeholder="">
                            </div>
                            <div class="form-group mt-3">
                              <label for="" class="form-label">Link Shoppe</label>
                              <input type="url" class="form-control" name="shoope" id="shoope" value="<?= (!empty($edit)) ? $edit->shoope : old('shoope') ?>"
                                placeholder="">
                            </div>
                            <div class="form-group mt-3">
                              <label for="" class="form-label">Link Bukalapak</label>
                              <input type="url" class="form-control" name="bukalapak" id="bukalapak" value="<?= (!empty($edit)) ? $edit->bukalapak : old('bukalapak') ?>"
                                placeholder="">
                            </div>
                            <div class="form-group mt-3">
                              <label for="" class="form-label">Kapasitas Produksi Perbulan (Volume)</label><span style="color:red"> *</span>
                              <input type="number" class="form-control" name="kapasitas_produksi" id="kapasitas_produksi" value="<?= (!empty($edit)) ? $edit->kapasitas_produksi : old('kapasitas_produksi') ?>"
                                placeholder="" required>
                            </div>
                            <div class="form-group mt-3">
                              <label for="" class="form-label">Satuan Kapasitas Produksi Perbulan</label><span style="color:red"> *</span>
                              <input type="text" class="form-control" name="satuan_kapasitas" id="satuan_kapasitas" value="<?= (!empty($edit)) ? $edit->satuan_kapasitas : old('satuan_kapasitas') ?>"
                                required>
                            </div>
                            <div class="form-group mt-3">
                              <label for="" class="form-label">Tingkat TKDN/Asal Bahan Baku</label><span style="color:red"> *</span>
                              <!-- <input type="text" class="form-control" name="tkdn" id="tkdn" value="<?= (!empty($edit)) ? $edit->tkdn : old('tkdn') ?>"
                                placeholder="" required> -->
                              <select class="form-control select2" name="tkdn" id="tkdn" required>
                                <option value="">-- Pilih Asal Bahan Baku --</option>
                                <option value="1" <?= (!empty($edit) && $edit->tkdn == '1') ? 'selected' : ((old('tkdn') == '1') ? 'selected' : '') ?>>Dalam Negeri</option>
                                <option value="2" <?= (!empty($edit) && $edit->tkdn == '2') ? 'selected' : ((old('tkdn') == '2') ? 'selected' : '') ?>>Luar Negeri</option>
                                <option value="3" <?= (!empty($edit) && $edit->tkdn == '3') ? 'selected' : ((old('tkdn') == '3') ? 'selected' : '') ?>>Dalam dan Luar Negeri</option>
                              </select>
                            </div>
                            <div class="form-group mt-3">
                              <label for="" class="form-label">Foto Produk </label><span style="color:red"> *</span>
                              <div class="mb-3">
                                <input class="form-control" type="file" name="foto_produk" id="foto_produk" accept="image/*">
                              </div>
                            </div>
                            <div class="g-recaptcha" data-sitekey="6LektGgpAAAAAMJrmalaUTpzhQEphSGW7paa7dk0"></div>
                            <hr>
                            <div class="form-check">
                              <input <?= (old('setuju') == 'setuju') ? 'checked' : '' ?> class="form-check-input" type="checkbox" name="setuju" required>
                              <label class="form-check-label" for="flexCheckDefault" style="font-weight: bold;">
                                Kami menyatakan bahwa semua informasi yang kami sampaikan adalah benar. Jika tidak sesuai
                                maka kami akan bertanggung jawab sesuai dengan ketentuan hukum yang berlaku.
                              </label>
                            </div>
                            <div class="form-group mt-3">
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>

            <div class="tab-pane <?= ($tab_active == 'regispelaku') ? 'active' : '' ?> show" id="tab-4">
              <div class="row">
                <div class="col-lg-12 details order-2 order-lg-1">
                  <div class="col-lg-8 mt-5 mt-lg-0">
                    <?php if (!empty(session()->getFlashdata('error'))) : ?>
                      <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <h4>Periksa Entrian Form</h4>
                        </hr />
                        <?= session()->getFlashdata('error'); ?>
                      </div>
                    <?php endif; ?>
                    <form enctype="multipart/form-data" action="<?= base_url('user/profile/update') ?>" method="post">
                      <?= csrf_field(); ?>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Nama Kelompok Usaha/Perusahaan</label>
                        <input type="text" class="form-control" name="nama_usaha" id="nama_usaha" value="<?= (empty($model)) ? old('nama_usaha') : $model->nama_usaha ?>" required>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">No. Sertifikat PIRT</label>
                        <input type="text" class="form-control" value="<?= (empty($model)) ? old('no_izin_pirt') : $model->no_izin_pirt ?>" name="no_izin_pirt" id="no_izin_pirt"
                          placeholder="">
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Nama Penanggung Jawab</label>
                        <input type="text" class="form-control" value="<?= (empty($model)) ? old('nama_pimpinan') : $model->nama_pimpinan ?>" name="nama_pimpinan" id="nama_pimpinan"
                          placeholder="" required>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">NIK (No.KTP Penanggung Jawab)</label>
                        <input type="number" class="form-control" name="nik_pimpinan" id="nik_pimpinan" value="<?= (empty($model)) ? old('nik_pimpinan') : $model->nik_pimpinan ?>" required>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Alamat Usaha</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="5" required><?= (empty($model)) ? old('alamat') : $model->alamat ?></textarea>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Kekayaan Bersih yang dimiliki</label>
                        <select class="form-select" id="kekayaan" name="kekayaan" aria-label="Default select example">
                          <option value="">-Pilih-</option>
                          <option <?= (!empty($model) && $model->kekayaan == 'Rp. 0 s.d Rp. 1 Miliar') ? 'selected' : ((old('kekayaan') == 'Rp. 0 s.d Rp. 1 Miliar') ? 'selected' : '') ?> value="Rp. 0 s.d Rp. 1 Miliar">Rp. 0 s.d Rp. 1 Miliar</option>
                          <option <?= (!empty($model) && $model->kekayaan == 'Rp. 1 Miliar s.d 5 Miliar') ? 'selected' : ((old('kekayaan') == 'Rp. 1 Miliar s.d 5 Miliar') ? 'selected' : '') ?> value="Rp. 1 Miliar s.d 5 Miliar">Rp. 1 Miliar s.d 5 Miliar</option>
                          <option <?= (!empty($model) && $model->kekayaan == 'Rp. 5 Miliar s.d 10 Miliar') ? 'selected' : ((old('kekayaan') == 'Rp. 5 Miliar s.d 10 Miliar') ? 'selected' : '') ?> value="Rp. 5 Miliar s.d 10 Miliar">Rp. 5 Miliar s.d 10 Miliar</option>
                          <option <?= (!empty($model) && $model->kekayaan == '> Rp. 10 Miliar') ? 'selected' : ((old('kekayaan') == '> Rp. 10 Miliar') ? 'selected' : '') ?> value="> Rp. 10 Miliar">> Rp. 10 Miliar</option>
                        </select>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Jenis Usaha</label>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="Produsen"
                            <?php
                            if (!empty($model)) {
                              $to_array = explode(",", $model->jenis_usaha);
                              for ($i = 0; $i < count($to_array); $i++) {
                                echo (old('jenis_usaha') == 'Produsen' || ($to_array[$i] == 'Produsen')) ? 'checked' : '';
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
                            if (!empty($model)) {
                              $to_array = explode(",", $model->jenis_usaha);
                              for ($i = 0; $i < count($to_array); $i++) {
                                echo (old('jenis_usaha') == 'Distributor' || ($to_array[$i] == 'Distributor')) ? 'checked' : '';
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
                            if (!empty($model)) {
                              $to_array = explode(",", $model->jenis_usaha);
                              for ($i = 0; $i < count($to_array); $i++) {
                                echo (old('jenis_usaha') == 'Agen' || ($to_array[$i] == 'Agen')) ? 'checked' : '';
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
                            if (!empty($model)) {
                              $to_array = explode(",", $model->jenis_usaha);
                              for ($i = 0; $i < count($to_array); $i++) {
                                echo (old('jenis_usaha') == 'Exportir' || ($to_array[$i] == 'Exportir')) ? 'checked' : '';
                              }
                            }
                            // echo (old('jenis_usaha') == 'Exportir' || (!empty($model)&& $model->jenis_usaha == 'Exportir' ) ) ? 'checked' : '' 
                            ?>
                            id="jenis_usaha" name="jenis_usaha[]">
                          <label class="form-check-label" for="flexCheckDefault">
                            Exportir
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="Pengecer"
                            <?php
                            if (!empty($model)) {
                              $to_array = explode(",", $model->jenis_usaha);
                              for ($i = 0; $i < count($to_array); $i++) {
                                echo (old('jenis_usaha') == 'Pengecer' || ($to_array[$i] == 'Pengecer')) ? 'checked' : '';
                              }
                            }
                            // echo (old('jenis_usaha') == 'Pengecer' || (!empty($model) && $model->jenis_usaha == 'Pengecer' ) ) ? 'checked' : '' 
                            ?>
                            id="jenis_usaha" name="jenis_usaha[]">
                          <label class="form-check-label" for="flexCheckDefault">
                            Pengecer
                          </label>
                        </div>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Upload Identitas</label>
                        <div class="mb-3">
                          <input class="form-control" type="file" id="identitas" name="identitas">
                          <?php if (old('identitas') != '') { ?>
                            <p class="form-group mt-3">Preview</p>
                            <img src="<?= base_url() ?>/assets/uploads/ktp/<?= old('identitas') ?>" width="50%">
                          <?php } elseif ((!empty($model))) { ?>
                            <p class="form-group mt-3">Preview</p>
                            <?php if ($model->identitas != 0 & $model->identitas != "") { ?>
                              <img src="<?= base_url() ?>/assets/uploads/ktp/<?= $model->identitas ?>" width="50%">
                            <?php } else { ?>
                              <b>*Belum mengupload identitas*</b>
                            <?php } ?>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Provinsi</label>
                        <select class="form-select " aria-label="Default select example" id="provinsi_id" name="id_provinsi">
                          <option>-Pilih-</option>
                          <?php foreach ($provinsi as $provinsi_value) { ?>
                            <option value="<?= $provinsi_value->id_provinsi ?>" <?= (!empty($model) && $model->id_provinsi == $provinsi_value->id_provinsi) ? 'selected' : ((old('id_provinsi') == $provinsi_value->id_provinsi) ? 'selected' : '') ?>><?= $provinsi_value->nama_provinsi ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Kota/Kabupaten</label>
                        <select class="form-select " aria-label="Default select example" id="kota_id" name="id_kota" required>
                          <option value="" selected>-Pilih-</option>
                          <?php
                          if (!empty($model)) {
                            foreach ($kabkot as $kabkot_value) { ?>
                              <option value="<?= $kabkot_value->id ?>" <?= (!empty($model) && $model->id_kota == $kabkot_value->id) ? 'selected' : ((old('id_kota') == $kabkot_value->id) ? 'selected' : '') ?>><?= $kabkot_value->nama ?></option>
                          <?php
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Kodepos</label>
                        <input type="text" class="form-control" name="kode_pos" id="kode_pos" value="<?= (empty($model)) ? old('kode_pos') : $model->kode_pos ?>">
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">No Telepon</label>
                        <input type="text" class="form-control" name="telpon" id="telpon" value="<?= (empty($model)) ? old('telpon') : $model->telpon ?>">
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">No HP</label>
                        <input type="text" class="form-control" name="handphone" id="handphone" value="<?= (empty($model)) ? old('handphone') : $model->handphone ?>" required>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Website</label>
                        <input type="text" class="form-control" name="website" id="website" value="<?= (empty($model)) ? old('website') : $model->website ?>">
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Email </label>
                        <input type="text" class="form-control" name="email" id="email" value="<?= (empty($model)) ? old('email') : $model->email ?>" required>
                      </div>
                      <hr>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="setuju" id="setuju" name="setuju"
                          <?= (old('setuju') == 'setuju' || (!empty($model))) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="flexCheckDefault" style="font-weight: bold;">
                          Kami menyatakan bahwa semua informasi yang kami sampaikan adalah benar. Jika tidak sesuai
                          maka kami akan bertanggung jawab sesuai dengan ketentuan hukum yang berlaku.
                        </label>
                      </div>
                      <div class="g-recaptcha" data-sitekey="6LektGgpAAAAAMJrmalaUTpzhQEphSGW7paa7dk0"></div>
                      <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Perbaharui</button>
                      </div>
                    </form>

                  </div>
                </div>
                <!-- <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="assets/img/features-4.png" alt="" class="img-fluid">
                  </div> -->
              </div>
            </div>

            <div class="tab-pane <?= ($tab_active == 'reset') ? 'active' : '' ?> show" id="tab-2">
              <div class="row">
                <div class="col-lg-12 details order-2 order-lg-1">
                  <h3>Reset Password</h3>
                  <?php if (!empty(session()->getFlashdata('error'))) : ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <h4>Periksa Entrian Form</h4>
                      </hr />
                      <?= session()->getFlashdata('error'); ?>
                    </div>
                  <?php endif; ?>
                  <form enctype="multipart/form-data" action="<?= base_url('user/profile/change_password') ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="form-group my-3">
                      <label for="" class="form-label">Masukkan Password Baru</label>
                      <input type="text" class="form-control" name="password" id="password">
                    </div>
                    <div class="g-recaptcha" data-sitekey="6LektGgpAAAAAMJrmalaUTpzhQEphSGW7paa7dk0"></div>
                    <div class="form-group mt-3">
                      <button type="submit" class="btn btn-primary">Ubah</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </section>
  <div class="modal fade" id="Modal-Delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Hapus produk</h5>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin akan menghapus produk ini ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
          <form name="formDelete" action="">
            <button type="submit" class="btn btn-primary">Iya</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>