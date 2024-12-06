<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Kemendag - Etalase Produk UMKM</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <?php echo view('web/template/head'); ?>

  <!-- =======================================================
  * Template Name: Sailor - v4.6.0
  * Template URL: https://bootstrapmade.com/sailor-free-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

  <!-- Global site tag (gtag.js) - Google Analytics - EMAIL M2M -->
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-155041488-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-155041488-1');
  </script>


  <!-- Google Tag Manager -->
  <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-PVDJD8R');
  </script>
  <!-- End Google Tag Manager -->

</head>

<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PVDJD8R" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <!-- ======= Header ======= -->
  <?php echo view('web/template/header'); ?>

  <!-- ======= Hero Section ======= -->
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

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <?php if ($popup == null) { ?> <h5 class="modal-title" id="judul">null</h5> <?php } else {
                                                                                      foreach ($popup as $popup_value) { ?>
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="judul"><?php echo $popup_value->judul ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <img src="<?php echo base_url() . "/assets/uploads/popup/" . $popup_value->img_url ?>" alt="" srcset="" class="image-modal">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="<?php echo $popup_value->link ?>" target="blank"><button type="button" class="btn btn-primary">Join</button></a>
                  </div>
                </div>
            <?php }
                                                                                    } ?>
          </div>
        </div>

        <!-- Slide 3 -->
        <!--<div class="carousel-item" style="background-image: url(assets/img/slide/slide-3.jpg)">
          <div class="carousel-container">
            <div class="container">
              <h2 class="animate__animated animate__fadeInDown"></h2>
              <p class="animate__animated animate__fadeInUp">Ut velit est quam dolor ad a aliquid qui aliquid. Sequi ea ut et est quaerat sequi nihil ut aliquam. Occaecati alias dolorem mollitia ut. Similique ea voluptatem. Esse doloremque accusamus repellendus deleniti vel. Minus et tempore modi architecto.</p>
              <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a>
            </div>
          </div>
        </div>-->

      </div>



      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
      </a>

      <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
      </a>

    </div>
  </section><!-- End Hero -->

  <main id="main">


    <!-- <section id="clients" class="clients section-bg">
      <div class="container">

        <div class="row">

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <a href="etalase?kategori=1"><img src="<?php echo base_url() ?>/assets/front/img/kategori/Makanan.png" class="img-fluid" alt=""></a>
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <a href="etalase?kategori=2"><img src="<?php echo base_url() ?>/assets/front/img/kategori/fabric.png" class="img-fluid" alt="Tekstil & Produk Tekstil"></a>
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <a href="etalase?kategori=4"><img src="<?php echo base_url() ?>/assets/front/img/kategori/bag.png" class="img-fluid" alt=""></a>
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <a href="etalase?kategori=3"><img src="<?php echo base_url() ?>/assets/front/img/kategori/beauty.png" class="img-fluid" alt=""></a>
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <a href="etalase?kategori=7"><img src="<?php echo base_url() ?>/assets/front/img/kategori/factory.png" class="img-fluid" alt=""></a>
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
            <a href="etalase?kategori=6"><img src="<?php echo base_url() ?>/assets/front/img/kategori/car-parts.png" class="img-fluid" alt=""></a>
          </div>

        </div>

      </div>
    </section> -->

    <!-- ======= About Section ======= -->
    <section style="padding: 0px; padding-top: 50px;" id="about" class="about">
      <div class="container">
        <div class="row content">
          <div class="col-lg-6" align="right">
            <img src="<?php echo base_url() ?>/assets/uploads/featuredImage/<?php echo $highlight[0]->featured_image ?>" class="img-fluid" style="height: 80%;">
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0">
            <h3><?php echo $highlight[0]->judul ?></h3>
            <p><?php echo $highlight[0]->summary ?></p>
            <ul>
              <button type="button" class="btn btn-warning">
                <?php $link = str_replace(" ", "-", $highlight[0]->judul); ?>
                <a href="<?php echo base_url() ?>/blog/<?php echo $link ?>" style="color: white;">Baca Selengkapnya</a>
              </button>
              <button type="button" class="btn btn-info">
                <a href="<?php echo base_url() ?>/blog" style="color: white;">List Berita</a>
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
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">Semua Produk Terbaru</li>
              <?php foreach ($kategori as $kat_value) {
                $nama_kat = strtolower(str_replace(" ", "-", $kat_value->kategori)) ?>
                <li data-filter=".filter-<?php echo $kat_value->id_kategori ?>"><?php echo $kat_value->kategori ?></li>
              <?php } ?>
            </ul>
          </div>
        </div>

        <div class="row portfolio-container">
          <?php foreach ($produk as $pro_value) {
            foreach ($pro_value as $value_pro) {
              $nama_kat = strtolower(str_replace(" ", "-", $value_pro->kategori)) ?>
              <div class="col-lg-3 col-md-3  portfolio-item filter-<?php echo $value_pro->id_kategori ?>">
                <div class="portfolio-wrap">
                  <img src="<?php echo base_url() ?>/assets/uploads/<?php echo $value_pro->foto_produk ?>" class="img-fluid">
                  <div class="portfolio-info">
                    <h4><?php echo $value_pro->nama_produk ?></h4>
                    <p><?php echo $value_pro->kategori ?></p>
                    <div class="portfolio-links">
                      <?php
                      helper('filesystem');
                      if (file_exists("http://localhost/portal-indonesia/assets/uploads/" . $value_pro->foto_produk)) {
                        $foto = $value_pro->foto_produk;
                      } else {
                        $foto = "not-found.png";
                      }
                      ?>
                      <a href="<?php echo base_url(); ?>/<?php echo "detail/" . $value_pro->id_produk ?>"><i class="bx bx-link"></i></a>
                    </div>
                  </div>
                </div>
              </div>
          <?php }
          } ?>
        </div>
        <div align="center">
          <label for="" style="font-size: larger; color: red; font-weight: bold;">
            <a href="<?php echo base_url() ?>/etalase">Liat Seluruh Produk</a>
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
          <?php if (empty($kegiatan)) { ?> <p>Tidak Ada Informasi Pameran</p> <?php } else {
                                                                            foreach ($kegiatan as $keg_value) { //$pecah = explode('-',$keg_value->tgl_kegiatan); 
                                                                            ?>
              <div class="col-md-6">
                <div class="icon-box">
                  <i class="bi bi-calendar4-week"></i>
                  <h4><a href="<?php echo base_url() . '/detail-kegiatan/' . str_replace(" ", "-", $keg_value->nama_kegiatan) ?>"><?php echo $keg_value->nama_kegiatan ?></a>
                  </h4>
                  <p>Penyelenggara : <?php echo $keg_value->namaPenyelenggara ?><br />
                    Waktu Kegiatan : <?php echo date('d F Y', strtotime($keg_value->waktu_awal)) . " - " . date('d F Y', strtotime($keg_value->waktu_akhir)) ?>
                  </p>
                </div>
              </div>
          <?php }
                                                                          } ?>
        </div>

      </div>
    </section>

    <!-- End Services Section -->

    <!-- ======= Portfolio Section ======= -->
    <!-- End Portfolio Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php echo view('web/template/footer'); ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
  <?php echo view('web/template/script'); ?>
  <script type="text/javascript">
    var popup = document.getElementById('judul').innerHTML;
    if (popup != "null") {
      $(window).on('load', function() {
        $('#exampleModal').modal('show');
      });
    }
  </script>

</body>

</html>