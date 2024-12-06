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
    <section id="faq" class="faq" style="margin-top: 50px;">
      <div class="container">

        <div class="section-title">
          <h2>F.A.Q</h2>
          <p>Frequently Asked Questions</p>
        </div>
        <?php if($faq != null){ foreach($faq as $faq_value){ ?>
        <div class="row faq-item d-flex align-items-stretch">
          <div class="col-lg-5">
            <i class="bx bx-help-circle"></i>
            <h4><?php echo $faq_value->question ?></h4>
          </div>
          <div class="col-lg-7">
            <p><?php echo $faq_value->answer ?></p>
          </div>
        </div>
        <?php } }else{ ?> <p>Tidak Ada Data</p> <?php } ?>
      </div>
    </section><!-- End Frequently Asked Questions Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php echo view('web/template/footer'); ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <?php echo view('web/template/script'); ?>

</body>

</html>