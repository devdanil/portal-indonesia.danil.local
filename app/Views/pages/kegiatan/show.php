<main id="main" style="margin-top: 100px;">
  <section id="about" class="about">
    <div class="container">
      <div class="row content">
        <?php if (!empty(session()->getFlashdata('errorDaftar'))) : ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h4><?php echo session()->getFlashdata('errorDaftar'); ?></h4>
          </div>
        <?php endif; ?>
        <?php if (empty($kegiatan)) { ?>
          <h5>Tidak ada data</h5>
        <?php } else { ?>
          <div class="col-lg-6" align="center">
            <?php
            $file = base_url() . "/assets/img/pameran/" . $kegiatan[0]->pamflet;
            $file_headers = @get_headers($file);
            if ($file_headers[0] == 'HTTP/1.1 404 Not Found' || $file_headers[0] == 'HTTP/1.0 404 Not Found') { ?>
              <a href="#" class="pop">
                <img src="http://portal-indonesia.id/assets/img/pameran/<?php echo $kegiatan[0]->pamflet ?>" height="300px">
              </a>
            <?php
            } else { ?>
              <a href="#" class="pop">
                <img src="<?php echo base_url() ?>/assets/img/pameran/<?php echo $kegiatan[0]->pamflet ?>" height="300px">
              </a>
            <?php
            }
            ?>

          </div>
          <div class="col-lg-6 pt-4 pt-lg-0">
            <h4><?php echo $kegiatan[0]->nama_kegiatan ?></h4>
            <p style="color: grey;">
              Waktu Kegiatan <?php echo date('d F Y', strtotime($kegiatan[0]->waktu_awal)) . ' s.d ' . date('d F Y', strtotime($kegiatan[0]->waktu_akhir)) ?>
            </p>
            <?php $sambung = '';
            if ($kat1 != '' && $kat2 != '') {
              $sambung = ',';
            } ?>
            <ul>
              <li><i class="fa fa-check-double"></i> <strong>Penyelenggara</strong> <?php echo ($kegiatan[0]->namaPenyelenggara == null) ? '-' : $kegiatan[0]->namaPenyelenggara  ?></li>
              <li><i class="fa fa-check-double"></i> <strong>Kategori : </strong>
                <?php if ($kategori == null) { ?>
                  -
                <?php } else { ?>
                  <ul>
                    <?php foreach ($kategori as $val_kat) { ?>
                      <li><i class="fa fa-check"></i> <?php echo $val_kat->nama_kategori ?></li>
                    <?php } ?>
                  </ul>
                <?php } ?>
              </li>
              <li><i class="fa fa-check-double"></i> <strong>Kuota Peserta</strong> <?php echo ($kegiatan[0]->kapasitas_peserta == null) ? '-' : $kegiatan[0]->kapasitas_peserta  ?></li>
              <li><i class="fa fa-check-double"></i> <strong>Lokasi Pameran</strong> <?php echo ($kegiatan[0]->lokasi_pameran == null) ? '-' : $kegiatan[0]->lokasi_pameran  ?></li>
              <li><i class="fa fa-check-double"></i> <strong>Pangan / Non Pangan</strong> <?php echo ($kegiatan[0]->pangan_non == null) ? '-' : $kat1 . ' ' . $sambung . ' ' . $kat2  ?></li>
              <li><i class="fa fa-check-double"></i> <strong>Kota / Kabupaten</strong> <?php echo ($kegiatan[0]->namakota == null) ? '-' : $kegiatan[0]->namakota  ?></li>
              <li><i class="fa fa-check-double"></i> <strong>Provinsi</strong> <?php echo ($kegiatan[0]->nama_provinsi == null) ? '-' : $kegiatan[0]->nama_provinsi  ?></li>
              <li><i class="fa fa-check-double"></i> <strong>Batas Pendaftaran</strong> <?php echo ($kegiatan[0]->batas_pendaftaran == null) ? '-' : $kegiatan[0]->batas_pendaftaran  ?></li>
              <li><i class="fa fa-check-double"></i> <strong>Kontak Person</strong> <?php echo ($kegiatan[0]->kontak_person == null) ? '-' : $kegiatan[0]->kontak_person  ?></li>
              <li><i class="fa fa-check-double"></i> <strong>Ketentuan</strong> <?php echo ($kegiatan[0]->ketentuan == null) ? '-' : $kegiatan[0]->ketentuan  ?></li>
            </ul>
            <?php
            $pesan = "Mohon maaf anda belum bisa melakukan pendaftaran, kuota peserta sudah penuh. Terima kasih";
            if (((strtotime(date('Y-m-d')) - strtotime($kegiatan[0]->batas_pendaftaran)) / 60 / 60 / 24) > 0) {
              $pesan = "Mohon maaf anda belum bisa melakukan pendaftartan, tanggal pendaftaran berakhir pada tanggal . Terima kasih";
            }

            if (((strtotime(date('Y-m-d')) - strtotime($kegiatan[0]->awal_pendaftaran)) / 60 / 60 / 24) < 0) {
              $pesan = "Waktu pendaftaran tanggal " . date('d F Y', strtotime($kegiatan[0]->awal_pendaftaran));
            }

            if (count($peserta) == $kegiatan[0]->kapasitas_peserta || ((strtotime(date('Y-m-d')) - strtotime($kegiatan[0]->batas_pendaftaran)) / 60 / 60 / 24) > 0 || ((strtotime(date('Y-m-d')) - strtotime($kegiatan[0]->awal_pendaftaran)) / 60 / 60 / 24) < 0) { ?>
              <strong><?php echo $pesan ?></strong>
              <br><br>
            <?php } else { ?>
              <a href="<?php echo base_url() . '/register-kegiatan/' . str_replace(" ", "-", $kegiatan[0]->nama_kegiatan) ?>"><button class="btn btn-primary">Daftar</button></a>
            <?php } ?>
            <!-- di buka jika di butuhkan <button type="button" class="btn btn-primary seleksic" data-toggle="modal" data-target="#seleksi">Hasil Seleksi Peserta</button> -->
          </div>
        <?php } ?>
      </div>
    </div>
  </section>
  <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <img src="" class="imagepreview" style="width: 100%;">
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="seleksi" tabindex="-1" role="dialog" aria-labelledby="seleksiTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="seleksiTitle">Hasil Seleksi</h5>
        </div>
        <div class="modal-body">
          <?php if (empty($peserta)) { ?>
            <p>Belum ada yang mendaftar</p>
          <?php } else { ?>
            <table class="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Usaha</th>
                  <th>Penanggung Jawab</th>
                  <th>Produk yg dipamerkan</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                $index = 0;
                foreach ($datapesertanew['dataPeserta'] as $pvalue) { ?>
                  <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $pvalue->nama_usaha ?></td>
                    <td><?php echo $pvalue->nama_pj ?></td>
                    <td>
                      <ul>
                        <?php $i = 0;
                        foreach ($datapesertanew['produk'][$index++] as $produkvalue) { ?>
                          <li><?php echo $produkvalue->nama_produk ?></li>
                        <?php } ?>
                      </ul>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          <?php } ?>
        </div>
        <div class="modal-footer">

        </div>
      </div>
    </div>
  </div>
</main>