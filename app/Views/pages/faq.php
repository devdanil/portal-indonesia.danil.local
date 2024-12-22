<main id="main">
  <section id="faq" class="faq" style="margin-top: 50px;">
    <div class="container">

      <div class="section-title">
        <h2>F.A.Q</h2>
        <p>Frequently Asked Questions</p>
      </div>
      <?php if ($faq != null) {
        foreach ($faq as $faq_value) { ?>
          <div class="row faq-item d-flex align-items-stretch">
            <div class="col-lg-5">
              <i class="bx bx-help-circle"></i>
              <h4><?php echo $faq_value->question ?></h4>
            </div>
            <div class="col-lg-7">
              <p><?php echo $faq_value->answer ?></p>
            </div>
          </div>
        <?php }
      } else { ?> <p>Tidak Ada Data</p> <?php } ?>
    </div>
  </section><!-- End Frequently Asked Questions Section -->

</main>