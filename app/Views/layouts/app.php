<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Kemendag - Etalase Produk UMKM</title>
  <meta content="Etalase Produk UMKM" name="description">
  <meta content="produk umkm" name="keywords">
  <?= csrf_meta() ?>
  <?= view('templates/head'); ?>
</head>

<body>

  <?= view('templates/header'); ?>
  <?= view($view); ?>
  <?= view('templates/footer'); ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="fas fa-chevron-up"></i></a>

  <?= view('templates/script'); ?>
</body>

</html>