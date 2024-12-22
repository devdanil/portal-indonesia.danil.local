<main id="main">
  <script src='https://www.google.com/recaptcha/api.js?hl=id'></script>
  <section id="features" class="features" style="margin-top: 50px;">
    <div class="container">
      <h4 class="text-muted text-uppercase mb-3"><b>REGISTRASI PELAKU USAHA</b></h4>
      <div class="row">
        <div class="col-lg-3">
          <ul class="nav nav-tabs flex-column">
            <li class="nav-item">
              <a class="nav-link <?php echo ($tab_active == 'regispelaku') ? 'active' : '' ?> show" data-bs-toggle="tab" href="#tab-4">Registrasi Pelaku Usaha</a>
            </li>
            <?php if (!empty($showKodeRegis)) { ?>
              <li class="nav-item">
                <a class="nav-link <?php echo ($tab_active == 'kode_regis') ? 'active' : '' ?>" data-bs-toggle="tab" href="#tab-2">Isi Kode Registrasi</a>
              </li>
            <?php } ?>
          </ul>
        </div>
        <div class="col-lg-9 mt-4 mt-lg-0">
          <div class="tab-content">
            <?php if (!empty($showKodeRegis)) { ?>
              <div class="tab-pane <?php echo ($tab_active == 'kode_regis') ? 'active' : '' ?>" id="tab-2">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Masukan Kode Registrasi</h3>
                    <?php if (!empty(session()->getFlashdata('errorcek'))) : ?>
                      <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?php echo session()->getFlashdata('errorcek'); ?>
                      </div>
                    <?php endif; ?>
                    <form action="<?php echo base_url('pages/registrasi/update/'.$id) ?>" method="post">
                      <?= csrf_field(); ?>
                      <div class="form-group my-3">
                        <label for="" class="form-label">Masukkan Kode Registrasi sebanyak 5 karakter yang dikirimkan ke
                          email anda</label>
                        <input <?php echo (!empty($kode_regis) ? 'disabled' : '') ?> type="text" class="form-control" name="no_reg" id="no_reg"
                          value="<?php echo (!empty($kode_regis) ? $kode_regis : old('no_reg')) ?>" required>
                      </div>
                      <div class="g-recaptcha" data-sitekey="6LektGgpAAAAAMJrmalaUTpzhQEphSGW7paa7dk0"></div>
                      <?php if (empty($kode_regis)) { ?>
                        <div class="form-group mt-3">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      <?php } ?>
                    </form>
                  </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="<?php echo base_url() ?>/assets/front/img/features-2.png" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
            <?php } ?>
            <div class="tab-pane <?php echo ($tab_active == 'regispelaku') ? 'active' : '' ?> show" id="tab-4">
              <div class="row">
                <div class="col-lg-12 details order-2 order-lg-1">
                  <div class="col-lg-8 mt-5 mt-lg-0">
                    <?php if (!empty(session()->getFlashdata('error'))) : ?>
                      <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <h4>Periksa Entrian Form</h4>
                        </hr />
                        <?php echo session()->getFlashdata('error'); ?>
                      </div>
                    <?php endif; ?>
                    <form enctype="multipart/form-data" action="<?php echo base_url('pages/registrasi/store') ?>" method="post">
                      <?= csrf_field(); ?>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Nama Kelompok Usaha/Perusahaan</label><span style="color:red"> *</span>
                        <input type="text" class="form-control" name="nama_usaha" id="nama_usaha" value="<?php echo (empty($model)) ? old('nama_usaha') : $model->nama_usaha ?>" required <?php echo (!empty($model) ? 'readonly' : '') ?>>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">No. Sertifikat PIRT</label>
                        <input type="text" class="form-control" value="<?php echo (empty($model)) ? old('no_izin_pirt') : $model->no_izin_pirt ?>" name="no_izin_pirt" id="no_izin_pirt"
                          placeholder="" <?php echo (!empty($model) ? 'readonly' : '') ?>>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Nama Penanggung Jawab</label><span style="color:red"> *</span>
                        <input type="text" class="form-control" value="<?php echo (empty($model)) ? old('nama_pimpinan') : $model->nama_pimpinan ?>" name="nama_pimpinan" id="nama_pimpinan"
                          placeholder="" <?php echo (!empty($model) ? 'readonly' : '') ?> required>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">NIK (No.KTP Penanggung Jawab)</label><span style="color:red"> *</span>
                        <input type="number" <?php echo (!empty($model) ? 'readonly' : '') ?> class="form-control"  name="nik_pimpinan" id="nik_pimpinan" value="<?php echo (empty($model)) ? old('nik_pimpinan') : $model->nik_pimpinan ?>" required>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Alamat Usaha</label><span style="color:red"> *</span>
                        <textarea class="form-control" <?php echo (!empty($model) ? 'readonly' : '') ?> id="alamat" name="alamat" rows="5" required><?php echo (empty($model)) ? old('alamat') : $model->alamat ?></textarea>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Kekayaan Bersih yang dimiliki</label><span style="color:red"> *</span>
                        <select class="form-select" <?php echo (!empty($model) ? 'disabled' : 'required') ?> id="kekayaan" name="kekayaan" aria-label="Default select example">
                          <option value="">-Pilih-</option>
                          <option <?php echo (!empty($model) && $model->kekayaan == 'Rp. 0 s.d Rp. 1 Miliar') ? 'selected' : ((old('kekayaan') == 'Rp. 0 s.d Rp. 1 Miliar') ? 'selected' : '') ?> value="Rp. 0 s.d Rp. 1 Miliar">Rp. 0 s.d Rp. 1 Miliar</option>
                          <option <?php echo (!empty($model) && $model->kekayaan == 'Rp. 1 Miliar s.d 5 Miliar') ? 'selected' : ((old('kekayaan') == 'Rp. 1 Miliar s.d 5 Miliar') ? 'selected' : '') ?> value="Rp. 1 Miliar s.d 5 Miliar">Rp. 1 Miliar s.d 5 Miliar</option>
                          <option <?php echo (!empty($model) && $model->kekayaan == 'Rp. 5 Miliar s.d 10 Miliar') ? 'selected' : ((old('kekayaan') == 'Rp. 5 Miliar s.d 10 Miliar') ? 'selected' : '') ?> value="Rp. 5 Miliar s.d 10 Miliar">Rp. 5 Miliar s.d 10 Miliar</option>
                          <option <?php echo (!empty($model) && $model->kekayaan == '> Rp. 10 Miliar') ? 'selected' : ((old('kekayaan') == '> Rp. 10 Miliar') ? 'selected' : '') ?> value="> Rp. 10 Miliar">> Rp. 10 Miliar</option>
                        </select>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Jenis Usaha</label><span style="color:red"> *</span>
                        <div class="form-check">
                          <!-- <p><? //=old('jenis_usaha')[0]
                                  ?></p> -->
                          <input <?php echo (!empty($model) ? 'disabled' : '') ?> class="form-check-input" type="checkbox" value="Produsen" 
                            <?php
                            if (old('jenis_usaha')) {
                              $to_array = old('jenis_usaha');
                              for ($i = 0; $i < count($to_array); $i++) {
                                echo ($to_array[$i] == 'Produsen') ? 'checked' : '';
                              }
                            } elseif (!empty($model)) {
                              $to_array = explode(",", $model->jenis_usaha);
                              for ($i = 0; $i < count($to_array); $i++) {
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
                          <input <?php echo (!empty($model) ? 'disabled' : '') ?> class="form-check-input" type="checkbox" value="Distributor"
                            <?php
                            if (old('jenis_usaha')) {
                              $to_array = old('jenis_usaha');
                              for ($i = 0; $i < count($to_array); $i++) {
                                echo ($to_array[$i] == 'Distributor') ? 'checked' : '';
                              }
                            } elseif (!empty($model)) {
                              $to_array = explode(",", $model->jenis_usaha);
                              for ($i = 0; $i < count($to_array); $i++) {
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
                          <input <?php echo (!empty($model) ? 'disabled' : '') ?> class="form-check-input" type="checkbox" value="Agen"
                            <?php
                            if (old('jenis_usaha')) {
                              $to_array = old('jenis_usaha');
                              for ($i = 0; $i < count($to_array); $i++) {
                                echo ($to_array[$i] == 'Agen') ? 'checked' : '';
                              }
                            } elseif (!empty($model)) {
                              $to_array = explode(",", $model->jenis_usaha);
                              for ($i = 0; $i < count($to_array); $i++) {
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
                          <input <?php echo (!empty($model) ? 'disabled' : '') ?> class="form-check-input" type="checkbox" value="Exportir"
                            <?php
                            if (old('jenis_usaha')) {
                              $to_array = old('jenis_usaha');
                              for ($i = 0; $i < count($to_array); $i++) {
                                echo ($to_array[$i] == 'Exportir') ? 'checked' : '';
                              }
                            } elseif (!empty($model)) {
                              $to_array = explode(",", $model->jenis_usaha);
                              for ($i = 0; $i < count($to_array); $i++) {
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
                          <input <?php echo (!empty($model) ? 'disabled' : '') ?> class="form-check-input" type="checkbox" value="Pengecer"
                            <?php
                            if (old('jenis_usaha')) {
                              $to_array = old('jenis_usaha');
                              for ($i = 0; $i < count($to_array); $i++) {
                                echo ($to_array[$i] == 'Pengecer') ? 'checked' : '';
                              }
                            } elseif (!empty($model)) {
                              $to_array = explode(",", $model->jenis_usaha);
                              for ($i = 0; $i < count($to_array); $i++) {
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
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Upload Identitas</label>
                        <div class="mb-3">
                          <input <?php echo (!empty($model) ? 'readonly' : '') ?> class="form-control" type="file" id="identitas" name="identitas">
                          <?php if (old('identitas') != '') { ?>
                            <p class="form-group mt-3">Preview</p>
                            <img src="<?php echo base_url() ?>/assets/uploads/ktp/<?php echo old('identitas') ?>" width="50%">
                          <?php } elseif ((!empty($model))) { ?>
                            <p class="form-group mt-3">Preview</p>
                            <img src="<?php echo base_url() ?>/assets/uploads/ktp/<?php echo $model->identitas ?>" width="50%">
                          <?php } ?>
                        </div>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Provinsi</label><span style="color:red"> *</span>
                        <select <?php echo (!empty($model) ? 'disabled' : 'required') ?> class="form-select select2" aria-label="Default select example" id="provinsi_id" name="id_provinsi">
                          <option>Pilih</option>
                          <?php foreach ($provinsi as $provinsi_value) { ?>
                            <option value="<?php echo $provinsi_value->id_provinsi ?>" <?php echo (!empty($model) && $model->id_provinsi == $provinsi_value->id_provinsi) ? 'selected' : ((old('id_provinsi') == $provinsi_value->id_provinsi) ? 'selected' : '') ?>><?php echo $provinsi_value->nama_provinsi ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Kota/Kabupaten</label><span style="color:red"> *</span>
                        <select <?php echo (!empty($model) ? 'disabled' : 'required') ?> class="form-select select2" aria-label="Default select example" id="kota_id" name="id_kota">
                          <option value="" selected>Pilih</option>
                          <?php
                          if (!empty($model)) {
                            foreach ($kabkot as $kabkot_value) { ?>
                              <option value="<?php echo $kabkot_value->id ?>" <?php echo (!empty($model) && $model->id_kota == $kabkot_value->id) ? 'selected' : ((old('id_kota') == $kabkot_value->id) ? 'selected' : '') ?>><?php echo $kabkot_value->nama ?></option>
                          <?php
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Kodepos</label>
                        <input <?php echo (!empty($model) ? 'readonly' : '') ?> type="text" class="form-control" name="kode_pos" id="kode_pos" value="<?php echo (empty($model)) ? old('kode_pos') : $model->kode_pos ?>">
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">No Telepon</label>
                        <input <?php echo (!empty($model) ? 'readonly' : '') ?> type="text" class="form-control" name="telpon" id="telpon" value="<?php echo (empty($model)) ? old('telpon') : $model->telpon ?>">
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">No HP</label><span style="color:red"> *</span>
                        <input <?php echo (!empty($model) ? 'readonly' : '') ?> type="text" class="form-control" name="handphone" id="handphone" value="<?php echo (empty($model)) ? old('handphone') : $model->handphone ?>" required>
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Website</label>
                        <input <?php echo (!empty($model) ? 'readonly' : '') ?> type="url" class="form-control" name="website" id="website" value="<?php echo (empty($model)) ? old('website') : $model->website ?>">
                      </div>
                      <div class="form-group mt-3">
                        <label for="" class="form-label">Email </label><span style="color:red"> *</span>
                        <input <?php echo (!empty($model) ? 'readonly' : '') ?> type="email" class="form-control" name="email" id="email" value="<?php echo (empty($model)) ? old('email') : $model->email ?>" required>
                      </div>
                      <hr>
                      <div class="form-check">
                        <input <?php echo (!empty($model) ? 'disabled' : '') ?> class="form-check-input" type="checkbox" value="setuju" id="setuju" name="setuju"
                          <?php echo (old('setuju') == 'setuju' || (!empty($model))) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="flexCheckDefault" style="font-weight: bold;">
                          Kami menyatakan bahwa semua informasi yang kami sampaikan adalah benar. Jika tidak sesuai
                          maka kami akan bertanggung jawab sesuai dengan ketentuan hukum yang berlaku.
                        </label>
                      </div>
                      
                      <?php if (empty($model)) { ?>
                        <div class="g-recaptcha" data-sitekey="6LektGgpAAAAAMJrmalaUTpzhQEphSGW7paa7dk0"></div>
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
      </div>
    </div>
  </section>
</main>