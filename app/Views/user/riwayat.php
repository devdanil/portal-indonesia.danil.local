<main id="main">
  <div style="margin-top: 100px;"></div>
  <section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Riwayat</h2>
        <p>Riwayat Kegiatan</p>
      </div>
      <?php if (!empty(session()->getFlashdata('sukses'))) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <h4><?php echo session()->getFlashdata('sukses'); ?></h4>
        </div>
      <?php endif; ?>
      <?php if (!empty(session()->getFlashdata('errorDaftar'))) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <h4><?php echo session()->getFlashdata('errorDaftar'); ?></h4>
        </div>
      <?php endif; ?>
      <div class="row">
        <form method="get">
          <div class="row">
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
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th scope="col">No.</th>
                      <th scope="col">Nama Kegiatan</th>
                      <th scope="col">Penyelenggara</th>
                      <th scope="col">Waktu Kegiatan</th>
                      <th>Penanggung Jawab</th>
                      <th>Jabatan Penanggung Jawab</th>
                      <th>Kontak Penanggung Jawab</th>
                      <th scope="col">Tempat</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 10 * ($filter['page'] - 1) + 1;
                    if (count($pembinaan) > 0) {
                      foreach ($pembinaan as $item) { ?>
                        <tr>
                          <th scope="row"><?= $no; ?></th>
                          <td><?= $item->nama_kegiatan ?></td>
                          <td><?= $item->namapenyelenggara ?></td>
                          <td><?= $item->waktu_awal . ' s.d ' . $item->waktu_akhir ?></td>
                          <td><?= $item->nama_pj ?? '-' ?></td>
                          <td><?= $item->jabatan_pj ?? '-' ?></td>
                          <td><?= $item->kontak_pj ?? '-' ?></td>
                          <td><?= $item->lokasi_pameran ?></td>
                          <td><?= ($item->status_kehadiran == null) ? '-' : ($item->status_kehadiran == 0 ? 'Belum proses kurasi' : ($item->status_kehadiran == 1 ? 'Diapprove' : 'Ditolak')) ?></td>
                        </tr>
                    <?php $no++;
                      }
                    } else {
                      echo '<tr><td colspan="9" class="text-center">Tidak ada data</td></tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="blog-pagination">
        <ul class="justify-content-center">
          <?= $pager->links(); ?>
        </ul>
      </div>
    </div>
  </section><!-- End Blog Section -->

</main>