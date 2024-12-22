<main id="main">
  <!-- ======= Team Section ======= -->
  <section id="team" class="team " style="margin-top: 50px;">
    <div class="container">
      <h4 class="text-muted text-uppercase mb-3"><b>Kuliner Nusantara</b></h4>
      <form method="get" class="mb-3">
        <div class="row">
          <div class="col-lg-4">
            <input type="text" value="<?= $filter['search'] ?>" name="search" class="form-control " placeholder="Temukan Sesuatu">
          </div>
          <div class="col-lg-4">
            <select class="form-control filter " name="provinsi_id">
              <option selected value="">Semua Provinsi</option>
              <?php
              foreach ($provinsi as $item) {
                echo '<option  value="' . $item->id_provinsi . '" ' . ($item->id_provinsi == $filter['provinsi_id'] ? 'selected' : '') . '>' . $item->nama_provinsi . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="col-lg-4">
            <select name="kota_id" class="form-control" <?= !$filter['provinsi_id'] ? 'disabled' : '' ?>>
              <option value="">Semua Kota</option>
              <?php
              if ($filter['provinsi_id']) {
                foreach ($kota as $item) {
                  echo '<option  value="' . $item->id . '" ' . ($item->id == $filter['kota_id'] ? 'selected' : '') . '>' . $item->nama . '</option>';
                }
              }
              ?>
            </select>
          </div>
        </div>
      </form>
      <div class="row">
        <?php if ($kuliner == null) { ?> <p>Tidak Ada Data</p> <?php } else {
                                                                foreach ($kuliner as $kuliner_value) { ?>
            <div class="col-lg-6" style="margin-bottom: 20px;">
              <div class="member d-flex align-items-start shadow-sm">
                <div class="row">
                  <div class="col-lg-4">
                    <div class="pic w-100 mt-1">
                      <img src="<?= base_url(); ?>/assets/uploads/kuliner/<?= $kuliner_value->image ?>" class="img-fluid"  alt="">
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <div class="member-info ps-0">
                      <h4><?= $kuliner_value->nama ?></h4>
                      <span><?= $kuliner_value->alamat ?></span>
                      <i class="fas fa-clock"></i> <a href="#"><time > Buka <?= $kuliner_value->jam_buka ?> - <?= $kuliner_value->jam_tutup ?> </time></a>
                      <p><?= $kuliner_value->nama_kategori ?></p>
                      <p><?= $kuliner_value->nama_kota . " - " . $kuliner_value->nama_provinsi ?></p>
                      <p>Deskripsi:</p>
                      <p><?= $kuliner_value->deskripsi ?></p>
                      <div class="social">
                        <?php if ($kuliner_value->facebook) { ?>
                          <a target="blank" href="<?= $kuliner_value->facebook ?>"><i class="fab fa-facebook-square"></i></a>
                        <?php } ?>
                        <?php if ($kuliner_value->instagram) { ?>
                          <a target="blank" href="<?= $kuliner_value->instagram ?>"><i class="fab fa-instagram-square"></i></a>
                        <?php } ?>
                        <?php if ($kuliner_value->maps) { ?>
                          <a target="blank" href="<?= $kuliner_value->maps ?>"><i class="fa fa-map"></i></a>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        <?php }
                                                              } ?>
      </div>
    </div>
  </section><!-- End Team Section -->
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