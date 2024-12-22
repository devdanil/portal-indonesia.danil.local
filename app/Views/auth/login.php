<main id="main" class="bg-light" style="margin-top: 80px;">
  <script src='https://www.google.com/recaptcha/api.js?hl=id'></script>
  <section id="blog" class="d-flex justify-content-center align-center">
    <div class="container my-auto" data-aos="fade-up">
      <div class="row">
        <div class="col-md-4 mx-auto px-sm-5">
          <?php if (!empty(session()->getFlashdata('error'))) : ?>
            <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
              <?= session()->getFlashdata('error'); ?>
            </div>
          <?php endif; ?>
          <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
              <?= session()->getFlashdata('success'); ?>
            </div>
          <?php endif; ?>
          <form action="<?= base_url('auth/validation') ?>" method="post">
            <?= csrf_field() ?>
            <div class="card border-0 shadow-lg">
              <div class="card-header bg-white">
                <h4 class="bg-white text-center mt-3 text-muted">Login</h4>
              </div>
              <div class="card-body mt-3 px-3">

                <div class="input-group mb-3">
                  <input type="text" name="username" id="username" class="form-control "
                    placeholder="Username atau Email" required>

                </div>
                <div class="input-group mb-3" id="show_hide_password">
                  <input type="password" name="password" id="password" class="form-control " placeholder="Password" required>
                </div>

                <div class="g-recaptcha" data-sitekey="6LektGgpAAAAAMJrmalaUTpzhQEphSGW7paa7dk0"></div>
              </div>
              <div class="card-footer bg-white d-grid gap-2 pt-3 pb-4">
                <button type="submit" class="btn btn-primary  btn-block">Login</button>
                <a href="<?= base_url('pages/registrasi') ?>" class="btn  btn-success" style="color:white">Registrasi Pelaku Usaha</a>
                <a class="btn  btn-danger btn-block" href="<?= base_url('auth/forgot') ?>">
                  Lupa password
                </a>
              </div>
          </form>
        </div>
      </div>

    </div>
    </div>
  </section><!-- End Blog Section -->

</main>