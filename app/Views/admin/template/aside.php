<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link" style="background-color: #ffffff;">
    <img src="<?= base_url('img/Logo-n.png') ?>" alt="Portal indonesia Logo" class="brand-image">
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= base_url() ?>/assets/back/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?= session()->get('name') ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="<?= base_url('admin/dashboard') ?>" class="nav-link <?= ($active == 'dashboard') ? 'active' : '' ?>">
            <i class="nav-icon far fa-circle nav-icon"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/reset-user/' . session()->get('user_id'))  ?>" class="nav-link">
            <i class="nav-icon fas fa-key"></i>
            <p>Change Password</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('auth/logout') ?>" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>

        <li class="nav-header">PRODUK</li>
        <li class="nav-item">
          <a href="<?= base_url('admin/kategori') ?>" class="nav-link <?= ($active == 'kategori') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
              Kategori Produk
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/subkategori') ?>" class="nav-link <?= ($active == 'subkategori') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
              Sub Kategori Produk
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/produk') ?>" class="nav-link <?= ($active == 'produk') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-columns"></i>
            <p>
              Master Produk
            </p>
          </a>
        </li>

        <li class="nav-header">PELAKU USAHA</li>
        <li class="nav-item">
          <a href="<?= base_url('admin/pelaku-usaha-admin') ?>" class="nav-link <?= ($active == 'pelaku_usaha') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-ellipsis-h"></i>
            <p>List Pelaku Usaha</p>
          </a>
        </li>

        <li class="nav-header">INFORMASI</li>
        <li class="nav-item">
          <a href="<?= base_url('admin/informasi-penyelenggara') ?>" class="nav-link <?= ($active == 'penyelenggara') ? 'active' : '' ?>">
            <i class="fas fa-circle nav-icon"></i>
            <p>Penyelenggara</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/informasi-berita') ?>" class="nav-link <?= ($active == 'berita') ? 'active' : '' ?>">
            <i class="fas fa-circle nav-icon"></i>
            <p>Berita</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/informasi-slider') ?>" class="nav-link <?= ($active == 'slider') ? 'active' : '' ?>">
            <i class="fas fa-circle nav-icon"></i>
            <p>Slider</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/informasi-kegiatan') ?>" class="nav-link <?= ($active == 'informasi') ? 'active' : '' ?>">
            <i class="fas fa-circle nav-icon"></i>
            <p>Kegiatan</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/informasi-tatacara') ?>" class="nav-link <?= ($active == 'tatacara') ? 'active' : '' ?>">
            <i class="fas fa-circle nav-icon"></i>
            <p>Regulasi</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/kuliner') ?>" class="nav-link <?= ($active == 'kuliner') ? 'active' : '' ?>">
            <i class="fas fa-circle nav-icon"></i>
            <p>Kuliner</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/informasi-video') ?>" class="nav-link <?= ($active == 'video') ? 'active' : '' ?>">
            <i class="fas fa-circle nav-icon"></i>
            <p>Video</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/informasi-popup') ?>" class="nav-link <?= ($active == 'popup') ? 'active' : '' ?>">
            <i class="fas fa-circle nav-icon"></i>
            <p>Popup</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/informasi-faq') ?>" class="nav-link <?= ($active == 'faq') ? 'active' : '' ?>">
            <i class="fas fa-circle nav-icon"></i>
            <p>FAQ</p>
          </a>
        </li>
        <?php if (session()->get('level') == 1) { ?>
          <li class="nav-header">USER</li>
          <li class="nav-item">
            <a href="<?= base_url('admin/settings-user') ?>" class="nav-link <?= ($active == 'user') ? 'user' : '' ?>">
              <i class="nav-icon far fa-circle text-danger"></i>
              <p class="text">User</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('admin/settings-log') ?>" class="nav-link <?= ($active == 'log') ? 'user' : '' ?>">
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