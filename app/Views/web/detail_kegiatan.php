<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Kemendag - Etalase Produk UMKM</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <?php echo view('web/template/head'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
        <section id="about" class="about">
        <div class="container">
            <div class="row content">
                <?php if (!empty(session()->getFlashdata('errorDaftar'))) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h4><?php echo session()->getFlashdata('errorDaftar'); ?></h4>
                    </div>
                <?php endif; ?>
                <?php if(empty($kegiatan)){ ?> 
                    <h5>Tidak ada data</h5>
                <?php }else{ ?> 
                <div class="col-lg-6" align="center">
                    <?php
                                $file = base_url()."/assets/img/pameran/".$kegiatan[0]->pamflet;
                                $file_headers = @get_headers($file);                    
                                if($file_headers[0] == 'HTTP/1.1 404 Not Found' || $file_headers[0] == 'HTTP/1.0 404 Not Found'){?>   
                                <a href="#" class="pop">         
                                <img src="http://portal-indonesia.id/assets/img/pameran/<?php echo $kegiatan[0]->pamflet ?>" height="300px"> 
                                </a>                                      
                                <?php
                                }else{?>   
                                <a href="#" class="pop">
                                <img src="<?php echo base_url() ?>/assets/img/pameran/<?php echo $kegiatan[0]->pamflet ?>" height="300px">
                                </a>
                                <?php
                                }
                            ?>

                </div>
                <div class="col-lg-6 pt-4 pt-lg-0">
                    <h4><?php echo $kegiatan[0]->nama_kegiatan ?></h4>
                    <p style="color: grey;">
                    Waktu Kegiatan <?php echo date('d F Y', strtotime($kegiatan[0]->waktu_awal)).' s.d '.date('d F Y', strtotime($kegiatan[0]->waktu_akhir)) ?>
                    </p>
                    <?php $sambung = ''; if($kat1 != '' && $kat2 != ''){ $sambung = ','; } ?>
                    <ul>
                        <li><i class="ri-check-double-line"></i> <strong>Penyelenggara</strong> <?php echo ($kegiatan[0]->namaPenyelenggara == null) ? '-' : $kegiatan[0]->namaPenyelenggara  ?></li>
                        <li><i class="ri-check-double-line"></i> <strong>Kategori : </strong>
                            <?php if($kategori == null){ ?>
                                -
                            <?php } else { ?>
                            <ul>
                                <?php foreach($kategori as $val_kat){ ?>
                                <li><i class="ri-check-line"></i> <?php echo $val_kat->nama_kategori ?></li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                        </li>
                        <li><i class="ri-check-double-line"></i> <strong>Kuota Peserta</strong> <?php echo ($kegiatan[0]->kapasitas_peserta == null) ? '-' : $kegiatan[0]->kapasitas_peserta  ?></li>
                        <li><i class="ri-check-double-line"></i> <strong>Lokasi Pameran</strong> <?php echo ($kegiatan[0]->lokasi_pameran == null) ? '-' : $kegiatan[0]->lokasi_pameran  ?></li>
                        <li><i class="ri-check-double-line"></i> <strong>Pangan / Non Pangan</strong> <?php echo ($kegiatan[0]->pangan_non == null) ? '-' : $kat1.' '.$sambung.' '.$kat2  ?></li>
                        <li><i class="ri-check-double-line"></i> <strong>Kota / Kabupaten</strong> <?php echo ($kegiatan[0]->namakota == null) ? '-' : $kegiatan[0]->namakota  ?></li>
                        <li><i class="ri-check-double-line"></i> <strong>Provinsi</strong> <?php echo ($kegiatan[0]->nama_provinsi == null) ? '-' : $kegiatan[0]->nama_provinsi  ?></li>
                        <li><i class="ri-check-double-line"></i> <strong>Batas Pendaftaran</strong> <?php echo ($kegiatan[0]->batas_pendaftaran == null) ? '-' : $kegiatan[0]->batas_pendaftaran  ?></li>
                        <li><i class="ri-check-double-line"></i> <strong>Kontak Person</strong> <?php echo ($kegiatan[0]->kontak_person == null) ? '-' : $kegiatan[0]->kontak_person  ?></li>
                        <li><i class="ri-check-double-line"></i> <strong>Ketentuan</strong> <?php echo ($kegiatan[0]->ketentuan == null) ? '-' : $kegiatan[0]->ketentuan  ?></li>
                    </ul>
                    <?php 
                        $pesan = "Mohon maaf anda belum bisa melakukan pendaftaran, kuota peserta sudah penuh. Terima kasih"; 
                        if(((strtotime(date('Y-m-d')) - strtotime($kegiatan[0]->batas_pendaftaran)) / 60 / 60 / 24) > 0) {
                            $pesan = "Mohon maaf anda belum bisa melakukan pendaftartan, tanggal pendaftaran berakhir pada tanggal . Terima kasih";
                        }

                        if (((strtotime(date('Y-m-d')) - strtotime($kegiatan[0]->awal_pendaftaran)) / 60 / 60 / 24) < 0) {
                            $pesan = "Waktu pendaftaran tanggal ".date('d F Y', strtotime($kegiatan[0]->awal_pendaftaran));
                        }

                        if (count($peserta) == $kegiatan[0]->kapasitas_peserta || ((strtotime(date('Y-m-d')) - strtotime($kegiatan[0]->batas_pendaftaran)) / 60 / 60 / 24) > 0 || ((strtotime(date('Y-m-d')) - strtotime($kegiatan[0]->awal_pendaftaran)) / 60 / 60 / 24) < 0) { ?>
                            <strong><?php echo $pesan ?></strong>
                            <br><br>
                    <?php } else { ?>
                            <a href="<?php echo base_url().'/register-kegiatan/'.str_replace(" ", "-", $kegiatan[0]->nama_kegiatan) ?>"><button class="btn btn-primary">Daftar</button></a>
                    <?php } ?>
                    <!-- di buka jika di butuhkan <button type="button" class="btn btn-primary seleksic" data-toggle="modal" data-target="#seleksi">Hasil Seleksi Peserta</button> -->
                </div>
                <?php } ?>
            </div>
        </div>
        </section>
        <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="" class="imagepreview" style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="seleksi" tabindex="-1" role="dialog" aria-labelledby="seleksiTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="seleksiTitle">Hasil Seleksi</h5>
                    </div>
                    <div class="modal-body">
                        <?php if(empty($peserta)){ ?>
                            <p>Belum ada yang mendaftar</p>
                        <?php } else { ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Usaha</th>
                                        <th>Penanggung Jawab</th>
                                        <th>Produk yg dipamerkan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1;$index=0; foreach($datapesertanew['dataPeserta'] as $pvalue){ ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $pvalue->nama_usaha ?></td>
                                            <td><?php echo $pvalue->nama_pj ?></td>
                                            <td>
                                                <ul>
                                                    <?php $i=0;foreach($datapesertanew['produk'][$index++] as $produkvalue){ ?>
                                                    <li><?php echo $produkvalue->nama_produk ?></li>
                                                    <?php } ?>
                                                </ul>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- ======= Footer ======= -->
    <?php echo view('web/template/footer'); ?>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
            
    <?php echo view('web/template/script'); ?>
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <script>
        $(function() {
          $('.pop').on('click', function() {
              $('.imagepreview').attr('src', $(this).find('img').attr('src'));
              $('#imagemodal').modal('show');   
          });
          
          $('.seleksic').on('click', function() {
              $('#seleksi').modal('show');   
          });
        });
    </script>
</body>

</html>