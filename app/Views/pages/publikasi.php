<main id="main">

  <!-- ======= Breadcrumbs ======= -->
  <div style="margin-top: 50px;"></div>

  <!-- ======= Services Section ======= -->
  <section id="services" class="services ">
    <div class="container">
      <h4 class="text-muted text-uppercase mb-3"><b>Jadwal Kegiatan dan Publikasi</b></h4>
      <div class="row mt-5">
        <div class="col-md-4 mt-3 mt-md-0">
          <div class="icon-box">
            <i class="bi bi-calendar4-week"></i>
            <h4><a href="<?= base_url('pages/kegiatan') ?>">Kegiatan - Jadwal Pameran</a></h4>
            <p>Dapatkan informasi seputar kegiatan dan jadwal pameran</p>
          </div>
        </div>
        <div class="col-md-4 mt-3 mt-md-0">
          <div class="icon-box">
            <i class="bi bi-card-checklist"></i>
            <h4><a href="<?= base_url('pages/peraturan') ?>">Peraturan - Regulasi</a></h4>
            <p>Informasi seputar Tatacara, Perizinan, dan Peraturan terkait produk dalam negeri</p>
          </div>
        </div>
        <div class="col-md-4 mt-3 mt-md-0">
          <div class="icon-box">
            <i class="bi bi-camera-reels"></i>
            <h4><a href="<?= base_url('pages/video') ?>">Video Produk Indonesia</a></h4>
            <p>Daftar video produk Indonesia</p>
          </div>
        </div>
        <!--<div class="col-md-4 mt-3 mt-md-0">
                <div class="icon-box">
                    <i class="bi bi-card-checklist"></i>
                    <h4><a href="https://www.katalogprodukhalal.id/" target="_blank">Katalog Produk Halal</a></h4>
                    <p>Katalog daftar produk halal di Indonesia. Daftarkan produk halalmu pada website ini</p>
                </div>
            </div> -->
      </div>

    </div>
  </section>

  <!-- tabel -->
  <!-- <section id="features" class="features">
    <div class="container">

        <div class="section-title">
            <h2>Kegiatan dan Pameran</h2>
            <p>Jadwal Kegiatan dan Pameran</p>
        </div>

        <div class="row">
            <table cellpadding="3" cellspacing="0" border="0" style="width: 67%;">
                <thead>
                    <tr>
                        <th>Pencarian spesifik</th>
                        <th>Tulis kata</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="filter_col2" data-column="1">
                        <td>Nama Kegiatan </td>
                        <td><input type="text" class="column_filter" id="col1_filter"></td>
                    </tr>
                    <tr id="filter_col3" data-column="2">
                        <td>Penyelenggara </td>
                        <td><input type="text" class="column_filter" id="col2_filter"></td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered table-striped" id="example1">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Kegiatan</th>
                    <th scope="col">Penyelenggara</th>
                    <th scope="col">Waktu Kegiatan</th>
                    <th scope="col">Tempat</th>
                  </tr>
                </thead>
                <tbody>
                    <?php //$no=1; foreach($kegiatan as $keg_value) { 
                    ?>
                    <tr>
                        <th scope="row"><?php //echo $no; 
                                        ?></th>
                        <td><?php //echo $keg_value->nama_kegiatan 
                            ?></td>
                        <td><?php //echo $keg_value->penyelenggara 
                            ?></td>
                        <td><?php //echo $keg_value->waktu_awal 
                            ?></td>
                        <td><?php //echo $keg_value->lokasi_pameran 
                            ?></td>
                    </tr>
                    <?php //$no++;} 
                    ?>
                </tbody>
              </table>
        </div>
    </div>
</section> -->

</main>