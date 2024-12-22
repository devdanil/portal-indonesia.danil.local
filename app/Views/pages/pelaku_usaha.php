<main id="main">
  <!-- ======= Team Section ======= -->
  <section id="team" class="team " style="margin-top: 50px;">
    <div class="container">
      <h4 class="text-muted text-uppercase"><b>Pelaku Usaha</b></h4>
      <form method="get">
        <div class="row">
          <div class="col-lg-4">
            <input value="<?= $filter['search'] ?>" name="search" type="text" class="form-control " id="col1_filter" placeholder="Temukan Nama Usaha">
          </div>
          <div class="col-lg-4">
            <select class="form-select filter" name="provinsi_id" id="col5_filter">
              <option selected value="">Semua Provinsi</option>
              <?php
              foreach ($provinsi as $item) {
                echo '<option value="' . $item->id_provinsi . '" ' . ($item->id_provinsi == $filter['provinsi_id'] ? "selected" : '') . '>' . $item->nama_provinsi . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="col-lg-4">
            <select class="form-select filter" name="kota_id" id="col4_filter" <?= !$filter['provinsi_id'] ? 'disabled' : '' ?>>
              <option selected value="">Semua Kota/Kabupaten</option>
              <?php
              if ($filter['provinsi_id']) {
                foreach ($kota as $item) {
                  echo '<option value="' . $item->id . '" ' . ($item->id == $filter['kota_id'] ? "selected" : '') . '>' . $item->nama . '</option>';
                }
              }
              ?>
            </select>
          </div>
          <div class="col-12 mt-3">
            <table class="table">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama Usaha</th>
                  <th>Produk</th>
                  <th>Alamat</th>
                  <th>Kabupaten / Kota</th>
                  <th>Provinsi</th>
                  <th>No. Telepon/HP</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = ($filter['page'] - 1) * 10 + 1;
                foreach ($pelaku_usaha as $pelaku_value) { ?>
                  <tr>
                    <td><?= $no ?>.</td>
                    <td><?= ($pelaku_value->nama_usaha == "" || $pelaku_value->nama_usaha == null) ? 'Tidak ada informasi nama perusahaan' : $pelaku_value->nama_usaha ?></td>
                    <td><?= ($pelaku_value->nama_produk == "" || $pelaku_value->nama_produk == null) ? 'Tidak ada informasi nama produk' : $pelaku_value->nama_produk ?></td>
                    <td><?= ($pelaku_value->alamat == "" || $pelaku_value->alamat == null) ? 'Tidak ada informmasi alamat' : $pelaku_value->alamat ?></td>
                    <td><?= ($pelaku_value->nama == "") ? '-' : $pelaku_value->nama ?></td>
                    <td><?= ($pelaku_value->nama_provinsi == "") ? '-' : $pelaku_value->nama_provinsi ?></td>
                    <td><?= ($pelaku_value->handphone == "" || $pelaku_value->handphone == null || $pelaku_value->handphone == 0) ? '-' : $pelaku_value->handphone ?></td>
                    <td><?= ($pelaku_value->email == "" || $pelaku_value->email == null) ? 'Tidak ada informasi email' : $pelaku_value->email ?></td>
                  </tr>
                <?php $no++;
                } ?>
              </tbody>
            </table>
            <label style="color: gray"><?= (count($pelaku_usaha) == null) ? 0 : count($pelaku_usaha) ?> dari <?= (!empty($total) ? $total : 0) ?> data</label>
          </div>

        </div>
      </form>

    </div>
  </section><!-- End Blog Section -->
  <section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
      <div class="row">
        <div class="col-lg-12 entries">
          <div class="blog-pagination">
            <ul class="justify-content-center">
              <?= $pager->links(); ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>