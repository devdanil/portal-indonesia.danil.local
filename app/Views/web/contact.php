<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Kemendag - Etalase Produk UMKM</title>
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
    <section id="contact" class="contact" style="margin-top: 50px;">
      <div class="container">
        <div class="section-title">
          <h2>Kontak</h2>
          <p>Hubungi Kami</p>
        </div>
        <div>
          <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.6136017202352!2d106.83122695081093!3d-6.182440362278131!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f4316d9d2fa7%3A0x8ff42ec1d74238de!2sJl.%20M.I.%20Ridwan%20Rais%20No.5%2C%20RT.7%2FRW.1%2C%20Gambir%2C%20Kecamatan%20Gambir%2C%20Kota%20Jakarta%20Pusat%2C%20Daerah%20Khusus%20Ibukota%20Jakarta%2010110!5e0!3m2!1sid!2sid!4v1637399738591!5m2!1sid!2sid" frameborder="0" allowfullscreen="" loading="lazy"></iframe>
        </div>

        <div class="row mt-5">

          <div class="col-lg-4">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Location:</h4>
                <p>Jalan M. I. Ridwan Rais No. 5 Jakarta Pusat 10110. DKI Jakarta, Indonesia.</p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>info@portal-indonesia.id</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Call:</h4>
                <p>(021)7987772</p>
              </div>

            </div>

          </div>

          <div class="col-lg-8 mt-5 mt-lg-0">

            <form action="<?php echo base_url() ?>/contact-us" method="post" class="php-email-form">
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" value="<?php echo old('name')?>" name="name" class="form-control" id="name" placeholder="Nama Lengkap" required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="email" value="<?php echo old('email')?>" class="form-control" name="email" id="email" placeholder="Email" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <input type="text" value="<?php echo old('subject')?>" class="form-control" name="subject" id="subject" placeholder="Subjek" required>
              </div>
              <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="5" placeholder="Pesan" required><?php echo old('message')?></textarea>
              </div>
              <div class="my-3">
                <?php if (!empty(session()->getFlashdata('success'))) : ?>
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <h4><?php echo session()->getFlashdata('success'); ?></h4>
                  </div>
                <?php endif; ?>
                <?php if (!empty(session()->getFlashdata('errorSend'))) : ?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <h4><?php echo session()->getFlashdata('errorSend'); ?></h4>
                  </div>
                <?php endif; ?>
                <div class="g-recaptcha" data-sitekey="6LektGgpAAAAAMJrmalaUTpzhQEphSGW7paa7dk0"></div> 
              </div>
              <div class="text-center"><button type="submit">Kirim</button></div>
            </form>

          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php echo view('web/template/footer'); ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <?php echo view('web/template/script'); ?>

</body>

</html>