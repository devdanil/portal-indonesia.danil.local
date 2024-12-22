<main id="main">
  <!-- ======= Breadcrumbs ======= -->
  <div style="margin-top: 100px;"></div>

  <!-- ======= Blog Section ======= -->
  <section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Info</h2>
        <p>TATA CARA, PERIZINAN DAN PERATURAN</p>
      </div>
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
              <table class="table table-bordered table-striped" id="example1">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">File</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  foreach ($tatacara as $item) { ?>
                    <tr>
                      <th scope="row"><?= $no; ?></th>
                      <td><?= $item->judul ?></td>
                      <td><?= $item->kategori ?></td>
                      <td>
                        <a target="blank" href="<?= base_url($item->url)   ?>">Download</a>
                      </td>
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
    <div class="blog-pagination">
      <ul class="justify-content-center">
        <?= $pager->links(); ?>
      </ul>
    </div>
  </section><!-- End Blog Section -->
</main>