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

    <main id="main" style="margin-top: 100px;">
        <!-- <section id="about" class="about">
            <div class="container">

                <div class="row content">
                    <div class="col-lg-6">
                        <img src="assets/img/100.png" class="img-fluid">
                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0">
                        <h3>Etalase Produk UMKM</h3>
                        <p>
                            Portal ini diperuntukan bagi semua pelaku usaha di Indonesia yang berkeinginan untuk
                            mempromosikan produknya melalui Internet. Registrasi dilakukan oleh Pelaku usaha sendiri
                            tanpa dipungut bayaran.
                        </p>
                        <ul>
                            <a href="#about"
                                class="btn-get-started animate__animated animate__fadeInUp scrollto">Registrasi</a>
                        </ul>
                    </div>
                </div>

            </div>
        </section> -->
        <section id="portfolio" class="portfolio">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 d-flex justify-content-center">
                        <ul id="portfolio-flters">
                            <a href="<?php echo base_url() ?>/etalase">
                                <li class="filter<?php echo ($active_params == 'all') ? '-active' : '' ?>">Semua Produk Terbaru</li>
                            </a>
                            <?php foreach($kategori as $kat_value ){ ?>
                                <a href="?kategori=<?php echo $kat_value->id_kategori ?>">
                                    <li class="filter<?php echo ($active_params == $kat_value->id_kategori) ? '-active' : '' ?>"><?php echo $kat_value->kategori ?></li>
                                </a>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div>
                    <!-- <form> -->
                        <div class="row">
                            <div class="col">
                                <input type="text" value="<?php echo ($active_params_keywords != "") ? $active_params_keywords : '' ?>" onkeyup="keywordnew()" id="key" class="form-control" placeholder="Temukan Sesuatu">
                            </div>
                            <div class="col">
                                <select id="kat" class="form-select select2" aria-label="Default select example">
                                    <option value="" <?php echo ($active_params == 'all') ? 'selected' : '' ?>>Semua Kategori</option>
                                    <?php foreach($kategori as $kat_value ){ ?>
                                        <option <?php echo ($active_params == $kat_value->id_kategori) ? 'selected' : '' ?> value="<?php echo $kat_value->id_kategori ?>"><?php echo $kat_value->kategori." (".$kat_value->total.")" ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col">
                                <select id="subkat" class="form-select select2" <?php echo ($active_params == "all" ) ? 'disabled' : '' ?> aria-label="Default select example">
                                    <?php if($active_params != "" || $active_params != "all"){ ?>
                                    <option value="" <?php echo ($active_params_sub == 'all') ? 'selected' : '' ?>>Semua Sub Kategori</option>
                                    <?php foreach($subkategori as $subkat_value ){ ?>
                                        <option <?php echo ($active_params_sub == $subkat_value->id_sub) ? 'selected' : '' ?> value="<?php echo $subkat_value->id_sub ?>"><?php echo $subkat_value->nama?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <div class="col">
                                <select id="prov" class="form-select select2" aria-label="Default select example">
                                    <option value="" selected>Semua Provinsi</option>
                                    <?php foreach($provinsi as $prov_value ){ ?>
                                        <option <?php echo ($active_params_prov == $prov_value->id_provinsi) ? 'selected' : '' ?> value="<?php echo $prov_value->id_provinsi ?>"><?php echo $prov_value->nama_provinsi." (".$prov_value->total.")" ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </section>
        <section id="pricing" class="pricing">
            <div class="container">
                <div class="row">
                    <?php if ($produk == null) { ?>
                        <div align="center">Tidak Ada Produk </div>
                    <?php }else{ foreach($produk as $prod_value ){ ?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="box">
                            <!-- <span class="popular"><i class="bi bi-star-fill"></i>Populer</span> -->
                            <?php 
                                $insert_date =new DateTime($prod_value->insert_date);
                                $now = new DateTime(); 
                                if ($insert_date->diff($now)->d <= 7 ) { ?>
                                    <span class="advanced">Baru</span>
                                <?php }
                            ?>
                            <h3><?php echo $prod_value->nama_produk ?></h3>
                            <div>
                                <img src="<?php echo base_url() ?>/assets/uploads/<?php echo $prod_value->foto_produk ?>" class="img-fluid">      
                            </div>
                            <ul>
                                <li><?php echo $prod_value->kategori ?></li>
                                <li><?php echo $prod_value->nama_produk ?></li>
                                <li><?php echo ($prod_value->jenis_usaha == null || $prod_value->jenis_usaha == 0  ) ? 'Tidak ada informasi jenis usaha' : $prod_value->jenis_usaha ?></li>
                                <li><i class="bi bi-envelope"></i><a href="<?php echo $prod_value->email ?>">
                                <?php echo $prod_value->email ?></a></li>
                                <li><i class="bi bi-telephone"> <?php echo $prod_value->handphone ?></i></li>
                            </ul>
                            <?php if ($prod_value->shoope != null || $prod_value->bukalapak != null || $prod_value->tokopedia != null ) { ?>
                                <hr>
                                Pesan Melalui
                            <?php } ?>
                            <div align="center" style="margin-top: 10px;">
                                <table>
                                    <tr>
                                        <?php if ($prod_value->shoope != null) { ?>
                                            <td>
                                                <a href="<?php echo $prod_value->shoope ?>" target="_blank">
                                                    <img src="<?php echo base_url() ?>/assets/front/social/shopee.png" alt="shoppi" height="50px">
                                                </a>
                                            </td>
                                        <?php } ?>
                                        <?php if ($prod_value->bukalapak != null) { ?>
                                            <td>
                                                <a href="<?php echo $prod_value->bukalapak ?>" target="_blank">
                                                    <img src="<?php echo base_url() ?>/assets/front/social/bukalapak.png" alt="bukalapak " height="50px">
                                                </a>
                                            </td>
                                        <?php } ?>
                                        <?php if ($prod_value->tokopedia != null) { ?>
                                            <td>
                                                <a href="<?php echo $prod_value->tokopedia ?>" target="_blank">
                                                    <img src="<?php echo base_url() ?>/assets/front/social/tokopedia.png" alt="tokopedia" height="50px">
                                                </a>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                </table>
                            </div>

                            <div class="btn-wrap">
                                <!-- <a href="#" class="btn-detail">Detail</a> -->
                                <a href="<?php echo base_url() ?>/detail/<?php echo $prod_value->id_produk ?>" class="btn-buy">Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php } }?>
                </div>
            </div>
        </section>
        <section id="blog" class="blog">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-12 entries">
                        <div class="blog-pagination">
                            <!-- <ul class="justify-content-center">
                                <li><a href="#">Prev</a></li>
                                <li><a href="#">1</a></li>
                                <li class="active"><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">Next</a></li>
                            </ul> -->
                            <ul class="justify-content-center">
                                <?php echo $pager->links(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
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
        $('.select2').select2({
            theme: 'bootstrap4'
        })

        $(document).ready(function(e) {
            $('#prov').change(function(){
                var prov_id = $('#prov').val();
                var kat_id = $('#kat').val();
                var subkat_id = $('#subkat').val();
                var key = $('#key').val();
                var post_url = "<?php echo base_url(); ?>";

                if (prov_id != ""){
                    if(kat_id != ""){
                        if (key != "") {
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase/?keyword="+key+"&kategori="+kat_id+"&provinsi="+prov_id+"&subkategori="+subkat_id;
                            }else{
                                window.location.href = post_url+"/etalase/?keyword="+key+"&kategori="+kat_id+"&provinsi="+prov_id;
                            }
                        }else{
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase/?kategori="+kat_id+"&provinsi="+prov_id+"&subkategori="+subkat_id;
                            }else{
                                window.location.href = post_url+"/etalase/?kategori="+kat_id+"&provinsi="+prov_id;
                            }
                        }
                    }else{
                        if (key != "") {
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase/?keyword="+key+"&provinsi="+prov_id+"&subkategori="+subkat_id;
                            }else{
                                window.location.href = post_url+"/etalase/?keyword="+key+"&provinsi="+prov_id;
                            }
                        }else{
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase/?provinsi="+prov_id+"&subkategori="+subkat_id;
                            }else{
                                window.location.href = post_url+"/etalase/?provinsi="+prov_id+"&subkategori="+subkat_id;
                            }
                        }
                    }
                } else {
                    if(kat_id != ""){
                        if (key != "") {
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase/?keyword="+key+"&kategori="+kat_id+"&subkategori="+subkat_id;
                            }else{
                                window.location.href = post_url+"/etalase/?keyword="+key+"&kategori="+kat_id;
                            }
                        }else{
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase/?kategori="+kat_id+"&subkategori="+subkat_id;
                            }else{
                                window.location.href = post_url+"/etalase/?kategori="+kat_id;
                            }
                        }
                    }else{
                        if (key != "") {
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase?keyword="+key+"&subkategori="+subkat_id;
                            }else{
                                window.location.href = post_url+"/etalase?keyword="+key;    
                            }
                        }else{
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase?subkategori="+subkat_id;
                            }else{
                                window.location.href = post_url+"/etalase";
                            }
                        }
                    }
                }
            });

            $('#kat').change(function(){
                var prov_id = $('#prov').val();
                var kat_id = $('#kat').val();
                var subkat_id = $('#subkat').val();
                var key = $('#key').val();
                var post_url = "<?php echo base_url(); ?>";
                if (kat_id != ""){
                    if(prov_id != ""){
                        if (key != "") {
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase/?keyword="+key+"&kategori="+kat_id+"&provinsi="+prov_id+"&subkategori="+subkat_id;
                            }else{
                                if (subkat_id != "") {
                                    window.location.href = post_url+"/etalase?keyword="+key+"&kategori="+kat_id+"&provinsi="+prov_id+"&subkategori="+subkat_id;
                                }else{
                                    window.location.href = post_url+"/etalase?keyword="+key+"&kategori="+kat_id+"&provinsi="+prov_id;
                                }
                            }
                        }else{
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase/?kategori="+kat_id+"&provinsi="+prov_id+"&subkategori="+subkat_id;
                            }else{
                                window.location.href = post_url+"/etalase/?kategori="+kat_id+"&provinsi="+prov_id;
                            }
                        }
                    }else{
                        if (key != "") {
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase?keyword="+key+"&kategori="+kat_id+"&subkategori="+subkat_id;
                            }else{
                                window.location.href = post_url+"/etalase?keyword="+key+"&kategori="+kat_id;
                            }
                        }else{
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase?kategori="+kat_id+"&subkategori="+subkat_id;
                            }else{
                                window.location.href = post_url+"/etalase?kategori="+kat_id;
                            }
                        }
                    }
                } else {
                    if(prov_id != ""){
                        if (subkat_id != "") {
                            window.location.href = post_url+"/etalase/?provinsi="+prov_id+"&subkategori="+subkat_id;
                        }else{
                            window.location.href = post_url+"/etalase/?provinsi="+prov_id;
                        }
                    }else{
                        if (key != "") {
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase?keyword="+key+"&subkategori="+subkat_id;
                            }else{
                                window.location.href = post_url+"/etalase?keyword="+key;
                            }    
                        }else{
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase?subkategori="+subkat_id;
                            }else{
                                window.location.href = post_url+"/etalase";
                            }
                        }
                    }
                }
            });

            $('#subkat').change(function(){
                var prov_id = $('#prov').val();
                var kat_id = $('#kat').val();
                var subkat_id = $('#subkat').val();
                var key = $('#key').val();
                var post_url = "<?php echo base_url(); ?>";
                if (kat_id != ""){
                    if(prov_id != ""){
                        if (key != "") {
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase/?keyword="+key+"&kategori="+kat_id+"&provinsi="+prov_id+"&subkategori="+subkat_id;
                            }else{
                                if (subkat_id != "") {
                                    window.location.href = post_url+"/etalase?keyword="+key+"&kategori="+kat_id+"&provinsi="+prov_id+"&subkategori="+subkat_id;
                                }else{
                                    window.location.href = post_url+"/etalase?keyword="+key+"&kategori="+kat_id+"&provinsi="+prov_id;
                                }
                            }
                        }else{
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase/?kategori="+kat_id+"&provinsi="+prov_id+"&subkategori="+subkat_id;
                            }else{
                                window.location.href = post_url+"/etalase/?kategori="+kat_id+"&provinsi="+prov_id;
                            }
                        }
                    }else{
                        if (key != "") {
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase?keyword="+key+"&kategori="+kat_id+"&subkategori="+subkat_id;
                            }else{
                                window.location.href = post_url+"/etalase?keyword="+key+"&kategori="+kat_id;
                            }
                        }else{
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase?kategori="+kat_id+"&subkategori="+subkat_id;
                            }else{
                                window.location.href = post_url+"/etalase?kategori="+kat_id;
                            }
                        }
                    }
                } else {
                    if(prov_id != ""){
                        if (subkat_id != "") {
                            window.location.href = post_url+"/etalase/?provinsi="+prov_id+"&subkategori="+subkat_id;
                        }else{
                            window.location.href = post_url+"/etalase/?provinsi="+prov_id;
                        }
                    }else{
                        if (key != "") {
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase?keyword="+key+"&subkategori="+subkat_id;
                            }else{
                                window.location.href = post_url+"/etalase?keyword="+key;
                            }    
                        }else{
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase?subkategori="+subkat_id;
                            }else{
                                window.location.href = post_url+"/etalase";
                            }
                        }
                    }
                }
            });

        });

        function keywordnew()
        {
            var post_url = "<?php echo base_url(); ?>";
            var input = document.getElementById("key");
            var kat_id = document.getElementById("kat").value;
            var subkat_id = document.getElementById("subkat").value;
            var prov_id = document.getElementById("prov").value;

            input.addEventListener("keyup", function(event) {
                if (event.keyCode === 13) {
                    if (kat_id != ""){
                        if(prov_id != ""){
                            if (input.value != "") {
                                if (subkat_id != "") {
                                    window.location.href = post_url+"/etalase?keyword="+input.value+"&kategori="+kat_id+"&provinsi="+prov_id+"&subkategori="+subkat_id;
                                }else{
                                    window.location.href = post_url+"/etalase?keyword="+input.value+"&kategori="+kat_id+"&provinsi="+prov_id;
                                }
                            }else{
                                if (subkat_id != "") {
                                    window.location.href = post_url+"/etalase/?kategori="+kat_id+"&provinsi="+prov_id+"&subkategori="+subkat_id;
                                }else{
                                    window.location.href = post_url+"/etalase/?kategori="+kat_id+"&provinsi="+prov_id;
                                }
                            }
                        }else{
                            if (input.value != "") {
                                if (subkat_id != "") {
                                    window.location.href = post_url+"/etalase?keyword="+input.value+"&kategori="+kat_id+"&subkategori="+subkat_id;
                                }else{
                                    window.location.href = post_url+"/etalase?keyword="+input.value+"&kategori="+kat_id;
                                }
                            }else{
                                if (subkat_id != "") {
                                    window.location.href = post_url+"/etalase?kategori="+kat_id+"&subkategori="+subkat_id;
                                }else{
                                    window.location.href = post_url+"/etalase?kategori="+kat_id;
                                }
                            }
                        }
                    } else {
                        if(prov_id != ""){
                            if (subkat_id != "") {
                                window.location.href = post_url+"/etalase/?provinsi="+prov_id+"&subkategori="+subkat_id;       
                            }else{
                                window.location.href = post_url+"/etalase/?provinsi="+prov_id;
                            }
                        }else{
                            if (input.value != "") {
                                if (subkat_id != "") {
                                    window.location.href = post_url+"/etalase?keyword="+input.value+"&subkategori="+subkat_id; 
                                }else{
                                    window.location.href = post_url+"/etalase?keyword="+input.value; 
                                }   
                            }else{
                                if (subkat_id != "") {
                                    window.location.href = post_url+"/etalase?subkategori"+subkat_id;
                                }else{
                                    window.location.href = post_url+"/etalase";
                                }
                            }
                        }
                    }
                }
            });
        }

    </script>
</body>

</html>