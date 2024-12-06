<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Etalase Produk UMKM - Berita</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <?php echo view('web/template/head'); ?>
    <!-- =======================================================
  * Template Name: Sailor - v4.6.0
  * Template URL: https://bootstrapmade.com/sailor-free-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <?php echo view('web/template/header'); ?>

    <main id="main">
        <!-- ======= Breadcrumbs ======= -->
        <section id="breadcrumbs" class="breadcrumbs">
        <div class="container" style="margin-top: 25px;">

            <div class="d-flex justify-content-between align-items-center">
            <h2>Berita</h2>
            <ol>
                <li><a href="<?php echo base_url() ?>">Home</a></li>
                <li><a href="<?php echo base_url() ?>/blog">Berita</a></li>
                <?php if($berita != null){ ?>
                <li><?php echo $berita[0]->judul ?></li>
                <?php } ?>
            </ol>
            </div>

        </div>
        </section><!-- End Breadcrumbs -->

        <!-- ======= Blog Single Section ======= -->
        <section id="blog" class="blog">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <?php if($berita == null){?> <p>404 Not Found</p> <?php }else{ $link = str_replace(" ", "-",$berita[0]->judul); ?>
                    <div class="col-lg-12 entries">
                        <article class="entry entry-single">
                            <!-- <div class="entry-img" align="center">
                                <img src="assets/img/blog/blog-1.jpg" alt="" class="img-fluid">
                            </div> -->

                            <h2 class="entry-title">
                                <a href="<?php echo base_url()."/blog/".$link ?>"><?php echo $berita[0]->judul ?></a>
                            </h2>

                            <div class="entry-meta">
                                <ul>
                                    <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="<?php echo base_url()."/blog/".$link ?>">Admin</a></li>
                                    <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="<?php echo base_url()."/blog/".$link ?>"><time datetime="2<?php echo $berita[0]->created_at ?>"><?php echo $berita[0]->created_at ?></time></a></li>
                                </ul>
                            </div>

                            <div class="entry-content">
                                <p><?php echo $berita[0]->isi_berita ?></p>
                            </div>

                            <!-- <div class="entry-footer">
                                <i class="bi bi-folder"></i>
                                <ul class="cats">
                                <li><a href="#">Info</a></li>
                                </ul>
                            </div> -->
                        </article>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>

    </main>

    <!-- ======= Footer ======= -->
    <?php echo view('web/template/footer'); ?>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <?php echo view('web/template/script'); ?>
    
</body>

</html>