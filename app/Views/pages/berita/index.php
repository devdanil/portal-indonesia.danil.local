<main id="main">
  <section id="breadcrumbs" class="breadcrumbs">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center" style="margin-top: 25px;">
        <h2>Berita</h2>
        <ol>
          <li><a href="<?= base_url() ?>">Home</a></li>
          <li>Berita</li>
        </ol>
      </div>
    </div>
  </section>

  <!-- ======= Blog Section ======= -->
  <section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
      <div class="row">
        <?php if ($berita == null) { ?><p>Informasi tidak tersedia</p><?php } else {
                                                                      foreach ($berita as $berita_value) {
                                                                        $link = str_replace(" ", "-", $berita_value->judul);
                                                                        $num_char = 550;
                                                                        $text = strip_tags($berita_value->isi_berita);
                                                                      ?>
            <div class="col-lg-12 entries">
              <article class="entry">
                <div class="entry-img" align="center">
                  <img src="<?= base_url() ?>/assets/uploads/featuredImage/<?= $berita_value->featured_image ?>" alt="" class="img-fluid">
                </div>

                <h2 class="entry-title">
                  <a href="<?= base_url('pages/berita/show/' . $link) ?>"><?= $berita_value->judul ?></a>
                </h2>

                <div class="entry-meta">
                  <ul>
                    <li class="d-flex align-items-center"><i class="fa fa-user"></i> <a href="<?= base_url('pages/berita/show/' . $link) ?>">Admin</a></li>
                    <li class="d-flex align-items-center"><i class="fa fa-clock"></i> <a href="<?= base_url('pages/berita/show/' . $link) ?>"><time datetime="<?= $berita_value->created_at ?>"><?= $berita_value->created_at ?></time></a></li>
                  </ul>
                </div>

                <div class="entry-content">
                  <?= $berita_value->summary ?>
                  <div class="read-more">
                    <a href="<?= base_url('pages/berita/show/' . $link) ?>">Baca selengkapnya</a>
                  </div>
                </div>

              </article>
          <?php }
                                                                    } ?>
          <div class="blog-pagination">
            <ul class="justify-content-center">
              <?= $pager->links(); ?>
            </ul>
          </div>
            </div>
      </div>
    </div>
  </section><!-- End Blog Section -->
</main>