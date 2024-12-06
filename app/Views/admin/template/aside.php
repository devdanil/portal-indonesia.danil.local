<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link" style="background-color: #ffffff;">
      <img src="<?php echo base_url() ?>/assets/front/img/Logo-n.png" alt="Portal indonesia Logo" class="brand-image">
      <!-- <img src="<?php echo base_url() ?>/assets/front/img/bbi.png" alt="Portal indonesia Logo" class="brand-image"> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url() ?>/assets/back/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $nama_user ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?php echo base_url() ?>/admin" class="nav-link <?php echo ($active == 'dashboard') ? 'active' : '' ?>">
              <i class="nav-icon far fa-circle nav-icon"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url() ?>/reset-user/<?php echo session()->get('user_id') ?>" class="nav-link">
              <i class="nav-icon fas fa-key"></i>
              <p>Change Password</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('logout') ?>" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
            </a>
          </li>
          
          <li class="nav-header">PRODUK</li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/kategori" class="nav-link <?php echo ($active == 'kategori') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Kategori Produk
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/subkategori" class="nav-link <?php echo ($active == 'subkategori') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Sub Kategori Produk
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/produk" class="nav-link <?php echo ($active == 'produk') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Master Produk
              </p>
            </a>
          </li>
          
          <li class="nav-header">PELAKU USAHA</li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/pelaku-usaha-admin" class="nav-link <?php echo ($active == 'pelaku_usaha') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-ellipsis-h"></i>
              <p>List Pelaku Usaha</p>
            </a>
          </li>

          <li class="nav-header">INFORMASI</li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/informasi-penyelenggara" class="nav-link <?php echo ($active == 'penyelenggara') ? 'active' : '' ?>">
              <i class="fas fa-circle nav-icon"></i>
              <p>Penyelenggara</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/informasi-berita" class="nav-link <?php echo ($active == 'berita') ? 'active' : '' ?>">
              <i class="fas fa-circle nav-icon"></i>
              <p>Berita</p>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a href="<?= base_url() ?>/informasi-panduan" class="nav-link <?php echo ($active == 'panduan') ? 'active' : '' ?>">
              <i class="fas fa-circle nav-icon"></i>
              <p>Panduan PDF</p>
            </a>
          </li> -->
          <li class="nav-item">
            <a href="<?= base_url() ?>/informasi-slider" class="nav-link <?php echo ($active == 'slider') ? 'active' : '' ?>">
              <i class="fas fa-circle nav-icon"></i>
              <p>Slider</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/informasi-kegiatan" class="nav-link <?php echo ($active == 'informasi') ? 'active' : '' ?>">
              <i class="fas fa-circle nav-icon"></i>
              <p>Kegiatan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/informasi-tatacara" class="nav-link <?php echo ($active == 'tatacara') ? 'active' : '' ?>">
              <i class="fas fa-circle nav-icon"></i>
              <p>Regulasi</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/kuliner" class="nav-link <?php echo ($active == 'kuliner') ? 'active' : '' ?>">
              <i class="fas fa-circle nav-icon"></i>
              <p>Kuliner</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/informasi-video" class="nav-link <?php echo ($active == 'video') ? 'active' : '' ?>">
              <i class="fas fa-circle nav-icon"></i>
              <p>Video</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/informasi-popup" class="nav-link <?php echo ($active == 'popup') ? 'active' : '' ?>">
              <i class="fas fa-circle nav-icon"></i>
              <p>Popup</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url() ?>/informasi-faq" class="nav-link <?php echo ($active == 'faq') ? 'active' : '' ?>">
              <i class="fas fa-circle nav-icon"></i>
              <p>FAQ</p>
            </a>
          </li>
          <?php if (session()->get('level') == 1) { ?>
            <li class="nav-header">USER</li>
            <li class="nav-item">
              <a href="<?= base_url()?>/settings-user" class="nav-link <?php echo ($active == 'user') ? 'user' : '' ?>">
                <i class="nav-icon far fa-circle text-danger"></i>
                <p class="text">User</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url()?>/settings-log" class="nav-link <?php echo ($active == 'log') ? 'user' : '' ?>">
                <i class="nav-icon far fa-circle text-danger"></i>
                <p class="text">Log Aktivitas</p>
              </a>
            </li>
          <?php } ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>