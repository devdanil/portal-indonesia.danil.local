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
</head>

<body>

  <!-- ======= Header ======= -->
  <?php echo view('web/template/header'); ?>


  <main id="main">
    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog" style="margin-top: 100px;">
        <div class="container" data-aos="fade-up">  
          <div class="row">  
            <div class="col-lg-12 entries">  
              <article class="entry">
  
                <div class="post-img" align="center">
                  <img src="http://portal-indonesia.id/assets/img/panduan.jpg" alt="" class="img-fluid" style="height: 100%;">
                </div>
                <div class="entry-content">    
                  <div class="read-more"> 
                    <a href="<?php echo base_url() ?>/assets/tata_cara/Alur Pendaftaran.pdf" target="_blank" style="background-color: #66B2FF">Download Panduan</a>
                    <?php if (!session()->get('logged_in')) { ?>
                    <a href="<?php echo base_url() ?>/register">Registrasi</a>
                    <?php } ?>
                  </div>
                </div>
  
              </article>  
            </div><!-- End blog entries list -->
          </div>  
        </div>
      </section><!-- End Blog Section -->
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php echo view('web/template/footer'); ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php echo view('web/template/script'); ?>

</body>

</html>