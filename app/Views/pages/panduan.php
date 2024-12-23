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
                  <a href="<?php echo base_url('pages/registrasi') ?>">Registrasi</a>
                <?php } ?>
              </div>
            </div>

          </article>
        </div><!-- End blog entries list -->
      </div>
    </div>
  </section><!-- End Blog Section -->
</main>