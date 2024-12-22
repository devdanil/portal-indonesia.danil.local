<main id="main">
  <div style="margin-top: 100px;"></div>
  <section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Info</h2>
        <p>KEGIATAN DAN JADWAL PAMERAN</p>
      </div>
      <form method="get">
        <div class="row">
          <div class="col-12 mb-3">
            <?php if (!empty(session()->getFlashdata('success'))) : ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4><?= session()->getFlashdata('success'); ?></h4>
              </div>
            <?php endif; ?>
            <?php if (!empty(session()->getFlashdata('errorDaftar'))) : ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4><?= session()->getFlashdata('errorDaftar'); ?></h4>
              </div>
            <?php endif; ?>
          </div>
          <div class="col-lg-3">
            <div class="d-flex">
              <div class="input-group  mb-3 w-auto ">
                <span class="input-group-text">Limit</span>
                <select class="form-select filter" name="limit">
                  <option value="10" <?= $filter['limit'] == 10 ? 'selected' : '' ?>>10</option>
                  <option value="25" <?= $filter['limit'] == 25 ? 'selected' : '' ?>>25</option>
                  <option value="50" <?= $filter['limit'] == 50 ? 'selected' : '' ?>>50</option>
                  <option value="100" <?= $filter['limit'] == 100 ? 'selected' : '' ?>>100</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-lg-9">
            <div class="d-flex justify-content-start justify-content-lg-end">
              <div class="input-group w-auto  mb-3">
                <input type="text" class="form-control" name="search" placeholder="Cari.." aria-label="Cari kegiatan.." value="<?= $filter['search'] ?>">
                <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped" id="example1">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Kegiatan</th>
                    <th scope="col">Penyelenggara</th>
                    <th scope="col">Waktu Kegiatan (Awal - Akhir)</th>
                    <th scope="col">Pangan non pangan</th>
                    <th scope="col">Produk yang akan dipamerkan</th>
                    <th scope="col">Kuota Peserta</th>
                    <th scope="col">Lokasi Pameran</th>
                    <th scope="col">Kota</th>
                    <th scope="col">Provinsi</th>
                    <th scope="col">Pamflet</th>
                    <th scope="col">Batas Akhir Pendaftaran</th>
                    <th scope="col">Kontak Person</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = ($filter['page'] - 1) * 10 + 1;
                  foreach ($kegiatan as $keg_value) { ?>
                    <?php
                    $nonpangan = $keg_value->pangan_non;
                    $explode = explode(";", $nonpangan);
                    if ($explode[0] == 'nonpangan') {
                      $kat1 = $explode[0];
                      $kat2 = $explode[1];
                    } else {
                      $kat1 = $explode[1];
                      $kat2 = $explode[0];
                    }
                    $sambung = '';
                    if ($kat1 != '' && $kat2 != '') {
                      $sambung = ',';
                    } ?>
                    <tr>
                      <th><?= $no; ?></th>
                      <td><a href="<?= base_url('pages/kegiatan/show/' . $keg_value->nama_kegiatan) ?>"><?= $keg_value->nama_kegiatan ?></a></td>
                      <td><?= $keg_value->namaPenyelenggara ?></td>
                      <td><?= date('d F Y', strtotime($keg_value->waktu_awal)) . " - " . date('d F Y', strtotime($keg_value->waktu_akhir)) ?></td>
                      <td><?= $kat1 . ' ' . $sambung . ' ' . $kat2 ?></td>
                      <td><?= $keg_value->namakategori ?></td>
                      <td><?= $keg_value->kapasitas_peserta ?></td>
                      <td><?= $keg_value->lokasi_pameran ?></td>
                      <td><?= $keg_value->namakota ?></td>
                      <td><?= $keg_value->nama_provinsi ?></td>
                      <td><a href="<?= base_url() . '/assets/img/pameran/' . $keg_value->pamflet ?>" target="_blank"><img width="100%" src="<?= base_url() . '/assets/img/pameran/' . $keg_value->pamflet ?>" alt=""></a></td>
                      <td><?= date('d F Y', strtotime($keg_value->batas_pendaftaran)) ?></td>
                      <td><?= $keg_value->kontak_person ?></td>

                    </tr>
                  <?php $no++;
                  } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="blog-pagination mt-3">
      <ul class="justify-content-center">
        <?= $pager->links(); ?>
      </ul>
    </div>
  </section><!-- End Blog Section -->
</main>