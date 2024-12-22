<section id="hero">
  <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">


    <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
    <div class="carousel-inner" role="listbox">

      <?php $no = 1;
      foreach ($slide as $slide_value) { ?>
        <div class="carousel-item <?php echo ($no == 1) ? 'active' : '' ?>" style="background-image: url(<?= base_url() ?>/assets/uploads/slider/<?php echo $slide_value->img ?>)">
          <div class="carousel-container">
            <div class="container">
              <h2 class="animate__animated animate__fadeInDown"><?php echo $slide_value->nama ?></h2>
              <p class="animate__animated animate__fadeInUp"><?php echo $slide_value->deskripsi ?></p>
              <a href="<?php echo $slide_value->link_button ?>" class="btn-get-started animate__animated animate__fadeInUp scrollto"><?php echo $slide_value->nama_button ?></a>
            </div>
          </div>
        </div>
      <?php $no++;
      } ?>

    </div>

    <?php if (count($slide) > 1) { ?>
      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon fa fa-chevron-left" aria-hidden="true"></span>
      </a>

      <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon fa fa-chevron-right" aria-hidden="true"></span>
      </a>
    <?php } ?>



  </div>
</section><!-- End Hero -->

<main id="main">

  <!-- ======= About Section ======= -->
  <section style="padding: 0px; padding-top: 50px;" id="about" class="about">
    <div class="container">
      <div class="row content">
        <div class="col-lg-6" align="right">
          <img src="<?= base_url() ?>/assets/uploads/featuredImage/<?= $highlight[0]->featured_image ?>" class="img-fluid" style="height: 80%;">
        </div>
        <div class="col-lg-6 pt-4 pt-lg-0">
          <h3><?= $highlight[0]->judul ?></h3>
          <p><?= $highlight[0]->summary ?></p>
          <ul>
            <button type="button" class="btn btn-warning">
              <a class="text-white" href="<?= base_url('pages/berita/show/' . $highlight[0]->judul) ?>">Baca Selengkapnya</a>
            </button>
            <button type="button" class="btn btn-info">
              <a href="<?= base_url('pages/berita') ?>" style="color: white;">List Berita</a>
            </button>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <button class="btn btn-priamry">

  </button>
  <!-- End About Section -->

  <!-- ======= Clients Section ======= -->
  <!-- End Clients Section -->

  <section style="padding: 0px;" id="portfolio" class="portfolio">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 d-flex justify-content-center mb-3">
          <a href="<?= base_url() ?>" class="btn btn-sm mx-1 <?= !$filter['kategori_id'] ? 'btn-danger' : 'btn-secondary' ?>">Semua Produk Terbaru</a>
          <?php foreach ($kategori as $item) {
            echo '<a href="' . base_url('?kategori_id=' . $item->id_kategori) . '" class="btn btn-sm mx-1 ' . ($item->id_kategori == $filter['kategori_id'] ? 'btn-danger' : 'btn-secondary') . '">' . $item->kategori . '</a>';
          } ?>
        </div>
      </div>

      <div class="row portfolio-container">
        <?php foreach ($produk as $item) {
          echo '<div class="col-lg-3 col-md-3 portfolio-item filter-' . $item->id_kategori . '">
              <a href="' . base_url('pages/etalase/show/' . $item->id_produk) . '" class="portfolio-wrap">
                <img src="' . base_url('/assets/uploads/' . $item->foto_produk)  . '" class="img-fluid">
                <div class="portfolio-info">
                  <h4>' . $item->nama_produk . '</h4>
                    <p>' . $item->kategori . '</p>
                  <div class="portfolio-links">
                  </div>
                </div>
              </a>
            </div>';
        } ?>
      </div>
      <div align="center">
        <label for="" style="font-size: larger; color: red; font-weight: bold;">
          <a href="<?= base_url('pages/etalase') ?>">Liat Seluruh Produk</a>
        </label>
      </div>
      <hr>
    </div>
  </section>
  <!-- ======= Services Section ======= -->
  <section id="services" class="services">
    <div class="container">
      <div align="center" style="margin-bottom: 20px;">
        <h3>Jadwal Kegiatan dan Publikasi</h3>
      </div>
      <div class="row">
        <?php if (count($kegiatan) > 0) {
          foreach ($kegiatan as $item) {
            echo '<div class="col-md-6">
              <div class="icon-box">
                <i class="bi bi-calendar4-week"></i>
                <h4><a href="' . base_url('pages/kegiatan/show/' . $item->nama_kegiatan) . '">' . $item->nama_kegiatan . '
                </a>
                </h4>
                <p>Penyelenggara : ' . $item->namaPenyelenggara . '
                <br />
                  Waktu Kegiatan : ' . date('d F Y', strtotime($item->waktu_awal)) . " - " . date('d F Y', strtotime($item->waktu_akhir)) . '
                </p>
              </div>
            </div>';
          }
        } else {
          echo '<p>Tidak Ada Informasi Pameran</p>';
        } ?>
      </div>

    </div>
  </section>

  <!-- End Services Section -->

  <!-- ======= Portfolio Section ======= -->
  <!-- End Portfolio Section -->

</main>