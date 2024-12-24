<footer id="footer" class="mt-auto">

  <div class="d-block d-lg-none pt-3 footer-links">
    <h4 class="text-center">Links</h4>
    <div class="row">
      <div class="col-6">
        <ul type="none">
          <li><i class="fa fa-chevron-right"></i> <a href="<?php echo base_url() ?>">Home</a></li>
          <li><i class="fa fa-chevron-right"></i> <a href="<?= base_url('pages/etalase') ?>">Etalase</a></li>
          <li><i class="fa fa-chevron-right"></i> <a href="<?= base_url('pages/katalog/kuliner') ?>">Kuliner</a></li>
          <li><i class="fa fa-chevron-right"></i> <a href="<?= base_url('pages/registrasi') ?>">Registrasi</a></li>
          <li><i class="fa fa-chevron-right"></i> <a href="<?= base_url('pages/publikasi') ?>">Publikasi</a></li>
        </ul>
      </div>
      <div class="col-6">
        <ul type="none">
          <li><i class="fa fa-chevron-right"></i> <a href="<?= base_url('pages/pelakuUsaha') ?>">Pelaku Usaha</a></li>
          <li><i class="fa fa-chevron-right"></i> <a href="<?= base_url('pages/panduan') ?>">Panduan</a></li>
          <li><i class="fa fa-chevron-right"></i> <a href="<?= base_url('pages/faq') ?>">FAQ</a></li>
          <li><i class="fa fa-chevron-right"></i> <a href="<?= base_url('pages/contact') ?>">Kontak</a></li>
          <li><i class="fa fa-chevron-right"></i> <a href="<?= base_url('auth/login') ?>">Login</a></li>
        </ul>
      </div>
    </div>
  </div>
  <hr class="d-lg-none">
  <div class="container">
    <div class="copyright">
      <label for="" style="font-weight: bold">Etalase Produk UMKM Indonesia</label> <br>
      Kementerian Perdagangan Republik Indonesia<br>
      Jl. M. I. Ridwan Rais, No. 5, Jakarta Pusat 10110, Telepon (021) 3841961/62<br>
      Email: info@portal-indonesia.id</br>
      Copyright ©️ 2021 - <?= date("Y") ?> Direktorat Penggunaan dan Pemasaran Produk Dalam Negeri
    </div>
    <div class="text-center mt-3">
      <div id="histats_counter"></div>
      <!-- Histats.com  START  (aync)-->
      <script type="text/javascript">
        var _Hasync = _Hasync || [];
        _Hasync.push(['Histats.start', '1,4615408,4,200,270,23,00001010']);
        _Hasync.push(['Histats.fasi', '1']);
        _Hasync.push(['Histats.track_hits', '']);
        (function() {
          var hs = document.createElement('script');
          hs.type = 'text/javascript';
          hs.async = true;
          hs.src = ('//s10.histats.com/js15_as.js');
          (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
        })();
      </script>
      <noscript><a href="#" target="_blank"><img src="" //sstatic1.histats.com/0.gif?4615408&101"" alt="free html hit counter" border="0"></a></noscript>
    </div>
  </div>
</footer>