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
        <div class="container">

            <div class="d-flex justify-content-between align-items-center" style="margin-top: 25px;">
                <h2>Berita</h2>
                <ol>
                    <li><a href="<?php echo base_url() ?>">Home</a></li>
                    <li>Berita</li>
                </ol>
            </div>

        </div>
        </section><!-- End Breadcrumbs -->

        <!-- ======= Blog Section ======= -->
        <section id="blog" class="blog">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <?php if($berita == null){ ?><p>Informasi tidak tersedia</p><?php }else{ foreach($berita as $berita_value){ 
                        $link = str_replace(" ", "-",$berita_value->judul); 
                        $num_char = 550;
                        $text = strip_tags($berita_value->isi_berita);
                    ?>
                    <div class="col-lg-12 entries">
                        <article class="entry">
                            <div class="entry-img" align="center">
                                <img src="<?php echo base_url() ?>/assets/uploads/featuredImage/<?php echo $berita_value->featured_image ?>" alt="" class="img-fluid">
                            </div>

                            <h2 class="entry-title">
                                <a href="<?php echo base_url()."/blog/".$link ?>"><?php echo $berita_value->judul ?></a>
                            </h2>

                            <div class="entry-meta">
                                <ul>
                                <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="<?php echo base_url()."/blog/".$link ?>">Admin</a></li>
                                <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="<?php echo base_url()."/blog/".$link ?>"><time datetime="<?php echo $berita_value->created_at ?>"><?php echo $berita_value->created_at ?></time></a></li>
                                </ul>
                            </div>

                            <div class="entry-content">
                                <?php echo $berita_value->summary ?>
                                <div class="read-more">
                                <a href="<?php echo base_url()."/blog/".$link ?>">Baca selengkapnya</a>
                                </div>
                            </div>

                        </article>
                        <?php } } ?>
                        <div class="blog-pagination">
                            <ul class="justify-content-center">
                                <?php echo $pager->links(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- End Blog Section -->

    </main>

    <!-- ======= Footer ======= -->
    <?php echo view('web/template/footer'); ?>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <?php echo view('web/template/script'); ?>
    
</body>

</html>