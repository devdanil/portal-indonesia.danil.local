<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="<?php echo base_url() ?>/assets/logo.png" rel="icon">
  <link href="<?php echo base_url() ?>/assets/logo.png" rel="apple-touch-icon">
  <title>Kemendag - Etalase Produk UMKM</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <?php echo view('web/template/head'); ?>
  <script src='https://www.google.com/recaptcha/api.js'></script>
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
                <h3>Login</h3>
              </p>
              <?php if (!empty(session()->getFlashdata('error'))) : ?>
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo session()->getFlashdata('error'); ?>
              </div>
              <?php endif; ?>
              <?php if (!empty(session()->getFlashdata('success'))) : ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo session()->getFlashdata('success'); ?>
              </div>
              <?php endif; ?>
              <form action="<?= base_url() ?>/login/process" method="post">
                <?= csrf_field(); ?>
                <div class="input-group mb-3">
                  <input type="text" name="username" id="username" class="form-control"
                    placeholder="Username atau Email">

                </div>
                <div class="input-group mb-3" id="show_hide_password">
                  <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                </div>
                <div>
                  <input type="checkbox" onclick="show()"> Show Password<br>
                  <a href="<?php echo base_url() ?>/forget-password" style="cursor: pointer;">
                    <label for="">Lupa password?</label>
                  </a>
                </div>
                <br>
                <div class="row">
                  <div class="col-8">
                  </div>
                  <div class="g-recaptcha" data-sitekey="6LektGgpAAAAAMJrmalaUTpzhQEphSGW7paa7dk0"></div>                  
                </div>
                <br>
                <div class="row">
                  <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                    <button class="btn btn-primary btn-block" style="background-color: green"><a href="<?php echo base_url() ?>/register" class="<?php echo ($active == 'register') ? 'active' : '' ?>" style="color:white">Registrasi Pelaku Usaha</a></button>                
                  </div>
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
  <script>
    function show() {
      var x = document.getElementById("password");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
  </script>
</body>

</html>