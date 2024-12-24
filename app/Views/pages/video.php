<main id="main">

  <!-- ======= Blog Section ======= -->
  <section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
      <div class="section-title" style="margin-top: 100px;">
        <h2>Info</h2>
        <p>Video Produk Indonesia</p>
      </div>
      <div class="row">
        <section id="team" class="team ">
          <div class="container">
            <div class="row">
              <?php foreach ($video as $value) { ?>
                <div class="col-lg-6">
                  <div class="member d-flex align-items-start">
                    <?php echo ($value->url_video == null) ? '-' : preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "<iframe width=\"420\" height=\"315\" src=\"//www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe>", $value->url_video) ?>
                    <div class="member-info">
                      <h4><?php echo ($value->judul_video == null) ? '-' : $value->judul_video ?></h4>
                      <p><?php echo ($value->keyword == null) ? '-' : $value->keyword ?></p>
                      <!-- <div align="right" style="margin-top: 50px;">
                    <button class="btn btn-primary">Detail</button>
                  </div> -->
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </section>
      </div>
    </div>
  </section><!-- End Blog Section -->
</main>