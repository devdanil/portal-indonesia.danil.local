<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="<?php echo base_url() ?>/assets/logo.png" rel="icon">
  <link href="<?php echo base_url() ?>/assets/logo.png" rel="apple-touch-icon">
  <title>Etalase Produk UMKM - Forgot Password</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <?php echo view('web/template/head'); ?>
  <script src='https://www.google.com/recaptcha/api.js'></script>
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
    <div style="margin-top: 150px;"></div>
    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog">
      <div class="container" data-aos="fade-up">
        <div class="row">
          <!-- <section id="team"> -->
            <!-- <div class="container"> -->
              <!-- <div class="row"> -->
                <div class="card col-12">
                  <div class="card-body login-card-body">
                    <p class="login-box-msg">
                      <h3>Forgot Password</h3>
                    </p>
                    <?php if (!empty(session()->getFlashdata('error'))) : ?>
                      <div class="alert alert-warning alert-dismissible fade show" role="alert">
                          <?php echo session()->getFlashdata('error'); ?>
                      </div>
                    <?php endif; ?>
                    <form action="<?php echo base_url(); ?><?php echo (empty($email)) ? '/email-cek' : '/kode-cek' ?>" method="post">
                      <?= csrf_field(); ?>
                      <?php if(empty($email)){ ?>
                      <div class="input-group mb-3">
                        <input type="email" value="<?php echo (old('email')) ? old('email') : '' ?>" name="email" id="email" required class="form-control" placeholder="Masukkan Email">
                      </div>
                      <?php } ?>
                      <?php if(!empty($email)){ ?>
                      <input hidden type="email" value="<?php echo $email ?>" name="email" id="email" required class="form-control" placeholder="Masukkan Email">
                      <div class="input-group mb-3">
                        <input type="text" value="<?php echo (old('code_secret')) ? old('code_secret') : '' ?>" name="code_secret" id="code_secret" required class="form-control" placeholder="Masukkan Kode">
                      </div>
                      <?php } ?>
                      <div class="row">
                        <div class="col-12">
                          <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                        <!-- /.col -->
                      </div>
                    </form>
                  </div>
                  <!-- /.login-card-body -->
                </div>        
              <!-- </div> -->
            <!-- </div> -->
          <!-- </section> -->
        </div>
      </div>
    </section><!-- End Blog Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php echo view('web/template/footer'); ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <?php echo view('web/template/script'); ?>
</body>

</html>