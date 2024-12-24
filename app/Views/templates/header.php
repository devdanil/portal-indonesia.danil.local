<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PVDJD8R" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<header id="header" class="fixed-top d-flex align-items-center">
  <div class="container d-flex justify-content-center">
    <nav id="navbar" class="navbar w-100 justify-content-center">

      <ul class="justify-content-between w-lg">
        <li class="px-4">
          <a href="<?= base_url() ?>" class="logo me-auto">
            <img width="130" src="<?= base_url('img/Logo-n.png') ?>">
          </a>
          <div style="font-size: 8pt;color: #6372b0; " class="text-nowrap text-lg-center"><b>ETALASE PRODUK UMKM</b></div>
        </li>
        <li><a href="<?= base_url() ?>" class="<?= ($active == 'home') ? 'active' : '' ?>">Home</a></li>

        <li><a href="<?= base_url('pages/etalase') ?>"
            class="<?= ($active == 'etalase') ? 'active' : '' ?>">Etalase</a></li>

        <li class="dropdown "><a class="<?= ($active == 'kuliner') ? 'active' : '' ?>" href="#">Katalog</a>
          <ul>
            <li><a href="<?= base_url('pages/katalog/kuliner') ?>"
                class="<?= ($active == 'kuliner') ? 'active' : '' ?>">Kuliner </a></li>
            <li><a href="http://ecatalog.portal-indonesia.id" target="_blank">Fashion Muslim</a></li>
            <li><a href="https://katalog-produk-halal.id/" target="_blank">Produk Halal</a></li>
            <li><a href="https://e-katalog.aprisindo.or.id/" target="_blank">Alas Kaki</a></li>
          </ul>
        </li>

        <?php if (!session()->get('logged_in')) { ?>
          <li><a href="<?= base_url('pages/registrasi') ?>"
              class="<?= ($active == 'register') ? 'active' : '' ?>">Registrasi</a></li>
        <?php } ?>
        <li><a href="<?= base_url('pages/pelakuUsaha') ?>"
            class="<?= ($active == 'pelaku_usaha') ? 'active' : '' ?>">Pelaku Usaha</a></li>

        <li><a href="<?= base_url('pages/publikasi') ?>"
            class="<?= ($active == 'publikasi') ? 'active' : '' ?>">Publikasi</a></li>

        <li><a href="<?= base_url('pages/panduan') ?>"
            class="<?= ($active == 'panduan') ? 'active' : '' ?>">Panduan</a></li>

        <li><a href="<?= base_url('pages/faq') ?>" class="<?= ($active == 'faq') ? 'active' : '' ?>">FAQ</a></li>

        <li><a href="<?= base_url('pages/contact') ?>"
            class="<?= ($active == 'contact') ? 'active' : '' ?>">Kontak</a></li>


        <?php if (session()->get('logged_in')) { ?>
          <li class="dropdown <?= ($active == 'logging_in') ? 'active' : '' ?>"><a href="#"
              style="border-width: 2px;">
              <span style="color: green;"><?= substr(session()->get('name'), 0, 10) ?></span> <i
                class="fa fa-chevron-down"></i></a>
            <ul>
              <?php if (session()->get('level') == 3) { ?>
                <li><a href="<?= base_url('user/profile') ?>">Profil</a></li>
              <?php } else { ?>
                <li><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
              <?php } ?>
              <li><a class="<?= ($active == 'riwayat') ? 'active' : '' ?>"
                  href="<?= base_url('user/riwayat') ?>">Riwayat Kegiatan</a></li>
              <li><a href="<?= base_url('auth/logout') ?>">Logout</a></li>
            </ul>
          </li>
        <?php  } else { ?>
          <?php if ($active != "login") { ?>
            <li><a href="<?= base_url('auth/login') ?>" class="getstarted">Login</a></li>
        <?php }
        } ?>
        <li>
          <a href="<?= base_url() ?>" class="logo me-auto" style="margin-left: 20px;">
            <img width="50" src="<?= base_url('img/Logo-bbi.png') ?>">
            <img width="130" src="<?= base_url('img/CALLCENTER PANGAN.jpg') ?>">
          </a>
        </li>
      </ul>
      <div class="d-lg-none d-flex justify-content-between align-content-center w-100">
        <div><a href="<?= base_url() ?>" class="logo me-auto">
          <img width="130" src="<?= base_url('img/Logo-n.png') ?>">
        </a>
        <div style="font-size: 8pt;color: #6372b0; " class="text-nowrap text-lg-center"><b>ETALASE PRODUK UMKM</b></div></div>
        <i class="fa fa-list mobile-nav-toggle my-auto me-3"></i>
      </div>
    </nav>
  </div>
</header>