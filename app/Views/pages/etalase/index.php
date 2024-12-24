<main id="main" style="margin-top: 110px;">
  <form method="get">
    <input type="hidden" name="page" value="<?= $filter['page'] ?>">
    <div class="container ">
      <h4 class="text-muted text-uppercase mb-3"><b>Etalase Produk</b></h4>
      <div class="row ">
        <div class="col">
          <input type="text" name="search" value="<?= $filter['search'] ?>" class="form-control" placeholder="Temukan Sesuatu">
        </div>
        <div class="col">
          <select id="kat" class="form-select filter select2" name="kategori_id">
            <option value="" selected>Semua Kategori</option>
            <?php foreach ($kategori as $item) { ?>
              <option <?= ($filter['kategori_id'] == $item->id_kategori) ? 'selected' : '' ?> value="<?= $item->id_kategori ?>"><?= $item->kategori . " (" . $item->total . ")" ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col">
          <select id="subkat" class="form-select filter select2" name="subkategori_id">
            <option value="" selected>Semua Sub Kategori</option>
            <?php foreach ($subkategori as $item) { ?>
              <option <?= ($filter['subkategori_id'] == $item->id_sub) ? 'selected' : '' ?> value="<?= $item->id_sub ?>"><?= $item->nama ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col">
          <select id="prov" class="form-select filter select2" name="provinsi_id">
            <option value="" selected>Semua Provinsi</option>
            <?php foreach ($provinsi as $item) { ?>
              <option <?= ($filter['provinsi_id'] == $item->id_provinsi) ? 'selected' : '' ?> value="<?= $item->id_provinsi ?>"><?= $item->nama_provinsi . " (" . $item->total . ")" ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
    <section id="pricing" class="pricing">
      <div class="container">
        <div class="row">
          <?php if ($produk == null) { ?>
            <div align="center">Tidak Ada Produk </div>
            <?php } else {
            foreach ($produk as $prod_value) { ?>
              <div class="col-lg-3 col-md-6 mb-4">
                <div class="box">
                  <?php
                  $insert_date = new DateTime($prod_value->insert_date);
                  $now = new DateTime();
                  if ($insert_date->diff($now)->d <= 7) { ?>
                    <span class="advanced">Baru</span>
                  <?php }
                  ?>
                  <h3><?= $prod_value->nama_produk ?></h3>
                  <div>
                    <img src="<?= base_url() ?>/assets/uploads/<?= $prod_value->foto_produk ?>" class="img-fluid">
                  </div>
                  <ul>
                    <li><?= $prod_value->kategori ?></li>
                    <li><?= $prod_value->nama_produk ?></li>
                    <li><?= ($prod_value->jenis_usaha == null || $prod_value->jenis_usaha == 0) ? 'Tidak ada informasi jenis usaha' : $prod_value->jenis_usaha ?></li>
                    <li><i class="fa fa-envelope"></i><a href="<?= $prod_value->email ?>">
                        <?= $prod_value->email ?></a></li>
                    <li><i class="fa fa-phone-alt "> <?= $prod_value->handphone ?></i></li>
                  </ul>
                  <?php if ($prod_value->shoope != null || $prod_value->bukalapak != null || $prod_value->tokopedia != null) { ?>
                    <hr>
                    Pesan Melalui
                  <?php } ?>
                  <div align="center" style="margin-top: 10px;">
                    <table>
                      <tr>
                        <?php if ($prod_value->shoope != null) { ?>
                          <td>
                            <a href="<?= $prod_value->shoope ?>" target="_blank">
                              <img src="<?= base_url() ?>/assets/front/social/shopee.png" alt="shoppi" height="50px">
                            </a>
                          </td>
                        <?php } ?>
                        <?php if ($prod_value->bukalapak != null) { ?>
                          <td>
                            <a href="<?= $prod_value->bukalapak ?>" target="_blank">
                              <img src="<?= base_url() ?>/assets/front/social/bukalapak.png" alt="bukalapak " height="50px">
                            </a>
                          </td>
                        <?php } ?>
                        <?php if ($prod_value->tokopedia != null) { ?>
                          <td>
                            <a href="<?= $prod_value->tokopedia ?>" target="_blank">
                              <img src="<?= base_url() ?>/assets/front/social/tokopedia.png" alt="tokopedia" height="50px">
                            </a>
                          </td>
                        <?php } ?>
                      </tr>
                    </table>
                  </div>

                  <div class="btn-wrap">
                    <!-- <a href="#" class="btn-detail">Detail</a> -->
                    <a href="<?= base_url('pages/etalase/show/' . $prod_value->id_produk) ?>" class="btn-buy">Detail</a>
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
              <ul class="justify-content-center">
                <?= $pager->links(); ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
  </form>
</main>