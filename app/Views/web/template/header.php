<header id="header" class="fixed-top d-flex align-items-center">
  <div class="container d-flex align-items-center">
    <nav id="navbar" class="navbar">
      <ul>
        <label for="ETALASE " style="color: #6372b0; font-weight: bold; margin-left: 133px;">ETALASE PRODUK UMKM
        </label>&nbsp;&nbsp;<!--<a href="http://ecatalog.portal-indonesia.id" target="_blank"><b>E-KATALOG FASHION MUSLIM</b></a>
        &nbsp;&nbsp;<a href="https://katalog-produk-halal.id/" target="_blank"><b>KATALOG PRODUK HALAL</b></a>-->
      </ul>
      <ul>
        <li>
          <a href="<?php echo base_url() ?>" class="logo me-auto">
            <img style="width: 100%;" src="<?php echo base_url() ?>/assets/front/img/Logo-n.png">
          </a>
        </li>
        <li><a href="<?php echo base_url() ?>" class="<?php echo ($active == 'home') ? 'active' : '' ?>">Home</a></li>

        <li><a href="<?php echo base_url() ?>/etalase"
            class="<?php echo ($active == 'etalase') ? 'active' : '' ?>">Etalase</a></li>

        <li class="dropdown"><a href="#">Katalog</a>
          <ul>
          <li><a href="<?php echo base_url() ?>/lokasi-kuliner" 
              class="<?php echo($active == 'lokasi-kuliner') ? 'active' : ''?>">Kuliner</a></li>
          <li><a href="http://ecatalog.portal-indonesia.id" target="_blank">Fashion Muslim</a></li>
          <li><a href="https://katalog-produk-halal.id/" target="_blank">Produk Halal</a></li>
          <li><a href="https://e-katalog.aprisindo.or.id/" target="_blank">Alas Kaki</a></li>
          </ul>
        </li>

        <!--<li><a href="<?php echo base_url() ?>/lokasi-kuliner"
            class="<?php echo ($active == 'lokasi_kuliner') ? 'active' : '' ?>">Kuliner</a></li> -->
        <?php if (! session()->get('logged_in')) { ?>
        <li><a href="<?php echo base_url() ?>/register"
            class="<?php echo ($active == 'register') ? 'active' : '' ?>">Registrasi</a></li>
        <?php } ?>
        <li><a href="<?php echo base_url() ?>/pelaku-usaha"
            class="<?php echo ($active == 'pelaku_usaha') ? 'active' : '' ?>">Pelaku Usaha</a></li>

        <li><a href="<?php echo base_url() ?>/info"
            class="<?php echo ($active == 'info') ? 'active' : '' ?>">Publikasi</a></li>

        <li><a href="<?php echo base_url() ?>/panduan"
            class="<?php echo ($active == 'panduan') ? 'active' : '' ?>">Panduan</a></li>

        <li><a href="<?php echo base_url() ?>/faq" class="<?php echo ($active == 'faq') ? 'active' : '' ?>">FAQ</a></li>

        <li><a href="<?php echo base_url() ?>/contact"
            class="<?php echo ($active == 'contact_us') ? 'active' : '' ?>">Contact Us</a></li>


        <?php if (session()->get('logged_in')) { ?>
        <li class="dropdown <?php echo ($active == 'logging_in') ? 'active' : '' ?>"><a href="#"
            style="border-width: 2px;">
            <span style="color: green;"><?php echo substr(session()->get('name'), 0, 10) ?></span> <i
              class="bi bi-chevron-down"></i></a>
          <ul>
            <?php if (session()->get('level') == 3) { ?>
            <li><a href="<?php echo base_url() ?>/profile">Profil</a></li>
            <?php }else{ ?>
            <li><a href="<?php echo base_url() ?>/admin">Dashboard</a></li>
            <?php } ?>
            <li><a class="<?php echo ($active == 'riwayat') ? 'active' : '' ?>"
                href="<?php echo base_url() ?>/riwayat">Riwayat Kegiatan</a></li>
            <li><a href="<?php echo base_url() ?>/logout">Logout</a></li>
          </ul>
        </li>
        <?php  }else{ ?>
        <?php if($active != "login"){ ?>
        <li><a href="<?php echo base_url() ?>/login" class="getstarted">Login</a></li>
        <?php } } ?>
        <li>
          <a href="<?php echo base_url() ?>" class="logo me-auto" style="margin-left: 20px;">
            <img style="width: 100%;" src="<?php echo base_url() ?>/assets/front/img/Logo-bbi.png">
            <img style="width: 100%;" src="<?php echo base_url() ?>/assets/front/img/CALLCENTER PANGAN.jpg">
          </a>
        </li>
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav>
  </div>
</header>