<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Kemendag - Etalase Produk UMKM</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <?php echo view('web/template/head'); ?>
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
    <!-- ======= Team Section ======= -->
    <section id="team" class="team " style="margin-top: 50px;">
      <div class="container">
        <div class="section-title">
          <h2>Info</h2>
          <p>Kuliner Nusantara</p>
        </div>
        <div class="row">
          <div>
            <!-- <form> -->
                <div class="row">
                    <div class="col-lg-10">
                      <select class="form-control select2 mt-3 mb-5" id="provinsi">
                        <option value="">Semua Provinsi</option>
                        <?php foreach ($provinsi as $prov_value) { ?>
                          <option <?php echo ($prov_params == $prov_value->id_provinsi) ? 'selected' : '' ?> value="<?php echo $prov_value->id_provinsi ?>"><?php echo $prov_value->nama_provinsi ?></option>
                        <?php } ?>
                      </select>
                      <br>
                      <select class="form-control select2 mt-3" id="kota">
                        <option value="">Semua Kota</option>
                        <?php if($kot_params != ""){ foreach ($kota as $kota_value) { ?>
                          <option <?php echo ($kot_params == $kota_value->id) ? 'selected' : '' ?> value="<?php echo $kota_value->id ?>"><?php echo $kota_value->nama ?></option>
                        <?php } } ?>
                      </select>
                      <input type="text" value="<?php echo ($value_params != "") ? $value_params : '' ?>" class="form-control mt-3" onkeyup="keywordnew()" id="key" placeholder="Temukan Sesuatu">
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-primary" onClick="keyword()">Cari</button>
                        <button type="button" class="btn btn-primary" onClick="reset()">Reset</button>
                    </div>
                </div>
            <!-- </form> -->
          </div>
        </div>
        <br/>
        <div class="row">
          <?php if($kuliner == null){ ?> <p>Tidak Ada Data</p> <?php }else{ foreach($kuliner as $kuliner_value){ ?>
          <div class="col-lg-6" style="margin-bottom: 20px;">
            <div class="member d-flex align-items-start">
              <div class="row">
                <div class="col-lg-4">
                  <div class="pic">
                    <img src="<?php echo base_url(); ?>/assets/uploads/kuliner/<?php echo $kuliner_value->image ?>" class="img-fluid" alt="">
                  </div>
                </div>
                <div class="col-lg-8">
                  <div class="member-info">
                    <h4><?php echo $kuliner_value->nama ?></h4>
                    <span><?php echo $kuliner_value->alamat ?></span>
                    <i class="bi bi-clock"></i> <a href="#"><time datetime="2020-01-01"> Buka <?php echo $kuliner_value->jam_buka ?> - <?php echo $kuliner_value->jam_tutup ?> </time></a>
                    <p><?php echo $kuliner_value->nama_kategori ?></p>
                    <p><?php echo $kuliner_value->nama_kota." - ".$kuliner_value->nama_provinsi ?></p>
                    <p>Deskripsi:</p>
                    <p><?php echo $kuliner_value->deskripsi ?></p>
                    <div class="social">
                      <?php if($kuliner_value->facebook != null){ ?>
                        <a target="blank" href="<?php echo $kuliner_value->facebook ?>"><i class="ri-facebook-fill"></i></a>
                      <?php } ?>
                      <?php if($kuliner_value->instagram != null){ ?>
                      <a target="blank" href="<?php echo $kuliner_value->instagram ?>"><i class="ri-instagram-fill"></i></a>
                      <?php } ?>
                      <?php if($kuliner_value->maps != null){ ?>
                      <a target="blank" href="<?php echo $kuliner_value->maps ?>"><i class="ri-map-pin-line"></i></a>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php } } ?>
        </div>
      </div>
    </section><!-- End Team Section -->
    <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-12 entries">
                    <div class="blog-pagination">
                        <ul class="justify-content-center">
                            <?php echo $pager->links(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php echo view('web/template/footer'); ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <?php echo view('web/template/script'); ?>
  <!-- jQuery -->
  <script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
  <!-- Select2 -->
  <script src="<?php echo base_url() ?>/assets/plugins/select2/js/select2.full.min.js"></script>
  <script>
    $('#provinsi').change(function(){
        var prov_id = $('#provinsi').val();
        var kota_select = document.getElementById('kota');
        if (prov_id != ""){
            var post_url = "<?php echo base_url();?>/produk/get_city/" + prov_id;
            kota_select.removeAttribute("disabled");
            $.ajax({
                type: "POST",
                url: post_url,
                data: {'id_provinsi':prov_id},
                success: function(cities) //we're calling the response json array 'cities'
                {
                    $('#kota').show();
                    $('#kota').html(cities);
                } //end success
              }); //end AJAX
        } else {
            // $('#kota').hide();
            // kota_select.disabled = true;
            var post_url = "<?php echo base_url();?>/produk/get_city/all";
            $.ajax({
              type: "POST",
              url: post_url,
              data: {
                'id_provinsi': 'all'
              },
              success: function (cities) {
                $('#kota').show();
                $('#kota').html(cities);
              }
            });
        }//end if
    }); //end change

    $('.select2').select2({
        theme: 'bootstrap4'
    })

    function keywordnew()
    {
        var post_url = "<?php echo base_url(); ?>";
        var input = document.getElementById("key");

        input.addEventListener("keyup", function(event) {
          if (event.keyCode === 13) {
            if (input.value != "") {
              window.location.href = post_url+"/lokasi-kuliner?keyword="+input.value;
            }else{
              window.location.href = post_url+"/lokasi-kuliner";
            }
          }
      });
    }

    function keyword()
    {
      var post_url = "<?php echo base_url(); ?>";
      var input = document.getElementById("key");
      var provinsi = $('#provinsi').val();
      var kota = $('#kota').val();
      if (input.value != "") {
        if (provinsi != "") {
          if (kota != "") {
            window.location.href = post_url+"/lokasi-kuliner?keyword="+input.value+"&provinsi="+provinsi+"&kota="+kota;
          }else{
            window.location.href = post_url+"/lokasi-kuliner?keyword="+input.value+"&provinsi="+provinsi;
          }
        }else{
          window.location.href = post_url+"/lokasi-kuliner?keyword="+input.value;
        }
      }else{
        if (provinsi != "") {
          if (kota != "") {
            window.location.href = post_url+"/lokasi-kuliner?provinsi="+provinsi+"&kota="+kota;
          }else{
            window.location.href = post_url+"/lokasi-kuliner?provinsi="+provinsi;
          }
        }else{
          window.location.href = post_url+"/lokasi-kuliner";
        }
      }
    }

    function reset()
    {
      var post_url = "<?php echo base_url(); ?>";
      window.location.href = post_url+"/lokasi-kuliner";
    }
  </script>
</body>

</html>