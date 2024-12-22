<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
  require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Pages\Home::index');
// Auth
// $routes->get('/login', 'Auth::index');
// $routes->get('/logout', 'Auth::logout');
// $routes->post('/login/process', 'Auth::auth_process');
// $routes->get('/locked-out', 'Auth::lockedOut');
// $routes->post('/reset', 'Auth::reset_pelaku_usaha', ['filter' => 'auth']);

// // admin
$routes->get('/admin', 'Admin\Dashboard::index', ['filter' => 'auth']);

// // web
// $routes->get('/', 'Pages\Home::index');
// $routes->get('/etalase', 'Web::etalase');
// $routes->get('/info', 'Web::info');
// $routes->get('/petunjuk', 'Web::petunjuk');
// $routes->get('/register', 'Web::register');
// $routes->get('/panduan', 'Web::panduan');
// $routes->get('/faq', 'Web::faq');
// $routes->get('/contact', 'Web::contact');
// $routes->post('/contact-us', 'Web::contact_us');
// $routes->get('/lokasi-kuliner', 'Web::kuliner');
// $routes->get('/video', 'Web::video');
// $routes->get('/kegiatan', 'Web::kegiatan');
// $routes->get('/daftar-kegiatan/(:any)', 'Web::daftar_kegiatan/$1');
// $routes->get('/peraturan', 'Web::peraturan');
// $routes->get('/riwayat', 'Web::riwayat', ['filter' => 'auth']);
// $routes->post('/registrasi', 'Web::registrasi_save');
// $routes->post('/update-profile', 'Web::update_profile', ['filter' => 'auth']);
// $routes->post('/cek-no-regis', 'Web::cek_regis');
// $routes->get('/profile', 'Web::profile', ['filter' => 'auth']);
// $routes->get('/detail/(:any)', 'Web::detail/$1');
// $routes->post('produk/simpan', 'Web::save_produk', ['filter' => 'auth']);
// $routes->post('produk/update/(:any)', 'Web::update_produk/$1', ['filter' => 'auth']);
// $routes->get('/produk-hapus/(:any)', 'Web::hapus_produk/$1', ['filter' => 'auth']);
// $routes->get('/pelaku-usaha', 'Web::pelaku_usaha');
// $routes->get('/blog', 'Berita::list_berita');
// $routes->get('/blog/(:any)', 'Berita::detail_berita/$1');
// $routes->get('/forget-password', 'Web::forget');
// $routes->post('/email-cek', 'Web::email_cek');
// $routes->post('/kode-cek', 'Web::cek_kode');
// $routes->get('/detail-kegiatan/(:any)', 'Web::detail_kegiatan/$1');
// $routes->get('/register-kegiatan/(:any)', 'Web::register_kegiatan/$1', ['filter' => 'auth']);
// $routes->post('/pameran/save', 'Web::save_register_kegiatan', ['filter' => 'auth']);
// // $routes->get('/pelaku-usaha/export-excel', 'PelakuUsaha::exportExcel');

//berita admin
$routes->get('admin/informasi-berita', 'Admin\Berita::index', ['filter' => 'auth']);
$routes->get('admin/tambah-berita', 'Admin\Berita::tambah_berita', ['filter' => 'auth']);
$routes->post('admin/berita/save', 'Admin\Berita::save_berita', ['filter' => 'auth']);
$routes->post('admin/berita/update/(:any)', 'Admin\Berita::update_berita/$1', ['filter' => 'auth']);
$routes->get('admin/edit-berita/(:any)', 'Admin\Berita::edit_berita/$1', ['filter' => 'auth']);
$routes->get('admin/status-berita/(:any)', 'Admin\Berita::status_berita/$1', ['filter' => 'auth']);
$routes->get('admin/sent-utama/(:any)', 'Admin\Berita::status_utama/$1', ['filter' => 'auth']);

//produk admin
$routes->get('admin/kategori', 'Admin\Produk::kategori', ['filter' => 'auth']);
$routes->get('admin/tambah-kategori', 'Admin\Produk::tambah_kategori', ['filter' => 'auth']);
$routes->post('admin/kategori/save', 'Admin\Produk::save_kategori', ['filter' => 'auth']);
$routes->post('admin/kategori/update/(:any)', 'Admin\Produk::update_kategori/$1', ['filter' => 'auth']);
$routes->get('admin/edit-kategori/(:any)', 'Admin\Produk::edit_kategori/$1', ['filter' => 'auth']);
$routes->get('admin/hapus-kategori/(:any)', 'Admin\Produk::hapus_kategori/$1', ['filter' => 'auth']);

$routes->get('admin/subkategori', 'Admin\Produk::subkategori', ['filter' => 'auth']);
$routes->get('admin/tambah-subkategori', 'Admin\Produk::tambah_subkategori', ['filter' => 'auth']);
$routes->post('admin/subkategori/save', 'Admin\Produk::save_subkategori', ['filter' => 'auth']);
$routes->post('admin/subkategori/update/(:any)', 'Admin\Produk::update_subkategori/$1', ['filter' => 'auth']);
$routes->get('admin/edit-subkategori/(:any)', 'Admin\Produk::edit_subkategori/$1', ['filter' => 'auth']);
$routes->get('admin/hapus-subkategori/(:any)', 'Admin\Produk::hapus_subkategori/$1', ['filter' => 'auth']);

$routes->get('admin/produk', 'Admin\Produk::index', ['filter' => 'auth']);
$routes->get('admin/tambah-produk', 'Admin\Produk::tambah_produk', ['filter' => 'auth']);
$routes->post('admin/produk/save', 'Admin\Produk::save_produk', ['filter' => 'auth']);
$routes->post('admin/produk/update/(:any)', 'Admin\Produk::update_produk/$1', ['filter' => 'auth']);
$routes->get('admin/edit-produk/(:any)', 'Admin\Produk::edit_produk/$1', ['filter' => 'auth']);
$routes->get('admin/hapus-produk/(:any)', 'Admin\Produk::hapus_produk/$1', ['filter' => 'auth']);
$routes->post('admin/produk/get_sub_kategori/(:any)', 'Admin\Produk::get_sub_kategori/$1');
$routes->post('admin/produk/get_city/(:any)', 'Admin\Produk::get_city/$1');
$routes->get('admin/approve-produk/(:any)', 'Admin\Produk::approve_produk/$1', ['filter' => 'auth']);
$routes->get('admin/action-produk/(:any)/(:any)', 'Admin\Produk::action_produk/$1/$2', ['filter' => 'auth']);

//pelaku admin
$routes->get('admin/pelaku-usaha-admin', 'Admin\PelakuUsaha::index', ['filter' => 'auth']);
$routes->get('admin/reject-pelaku-usaha/(:any)', 'Admin\PelakuUsaha::reject_pelaku/$1', ['filter' => 'auth']);
$routes->get('admin/approve-pelaku-usaha/(:any)', 'Admin\PelakuUsaha::approve_pelaku/$1', ['filter' => 'auth']);
$routes->get('admin/ubah-status-pelaku-usaha/(:any)/(:any)', 'Admin\PelakuUsaha::status_pelaku/$1/$2', ['filter' => 'auth']);
$routes->get('admin/detail-pelaku-usaha/(:any)', 'Admin\PelakuUsaha::detail_pelaku/$1', ['filter' => 'auth']);
$routes->get('admin/tambah-pelaku-usaha', 'Admin\PelakuUsaha::tambah_pelaku', ['filter' => 'auth']);
$routes->post('admin/pelaku-usaha/save', 'Admin\PelakuUsaha::save_pelaku', ['filter' => 'auth']);
$routes->get('admin/edit-pelaku/(:any)', 'Admin\PelakuUsaha::edit_pelaku/$1', ['filter' => 'auth']);
$routes->post('admin/pelaku-usaha/update/(:any)', 'Admin\PelakuUsaha::update_pelaku/$1', ['filter' => 'auth']);
$routes->get('admin/pelaku-usaha-admin/export-excel', 'Admin\PelakuUsaha::exportExcel');
$routes->get('admin/pelaku-usaha-admin/reset-password/(:any)', 'Admin\PelakuUsaha::reset_user/$1', ['filter' => 'auth']);
$routes->post('admin/pelaku-usaha-admin/update-password/(:any)', 'Admin\PelakuUsaha::update_password_user/$1', ['filter' => 'auth']);

//informasi slider
$routes->get('admin/informasi-slider', 'Admin\Slider::index', ['filter' => 'auth']);
$routes->get('admin/tambah-slider', 'Admin\Slider::tambah_slider', ['filter' => 'auth']);
$routes->post('admin/slider/save', 'Admin\Slider::save_slider', ['filter' => 'auth']);
$routes->post('admin/slider/update/(:any)', 'Admin\Slider::update_slider/$1', ['filter' => 'auth']);
$routes->get('admin/edit-slider/(:any)', 'Admin\Slider::edit_slider/$1', ['filter' => 'auth']);
$routes->get('admin/hapus-slider/(:any)', 'Admin\Slider::hapus_slider/$1', ['filter' => 'auth']);

//informasi panduan
$routes->get('admin/informasi-panduan', 'Admin\Panduan::index', ['filter' => 'auth']);
$routes->get('admin/tambah-panduan', 'Admin\Panduan::tambah_panduan', ['filter' => 'auth']);
$routes->post('admin/panduan/save', 'Admin\Panduan::save_panduan', ['filter' => 'auth']);
$routes->post('admin/panduan/update/(:any)', 'Admin\Panduan::update_panduan/$1', ['filter' => 'auth']);
$routes->get('admin/edit-panduan/(:any)', 'Admin\Panduan::edit_panduan/$1', ['filter' => 'auth']);
$routes->get('admin/hapus-panduan/(:any)', 'Admin\Panduan::hapus_panduan/$1', ['filter' => 'auth']);

//kegiatan admin
$routes->get('admin/informasi-kegiatan', 'Admin\Kegiatan::index', ['filter' => 'auth']);
$routes->get('admin/tambah-kegiatan', 'Admin\Kegiatan::tambah_kegiatan', ['filter' => 'auth']);
$routes->post('admin/kegiatan/save', 'Admin\Kegiatan::save_kegiatan', ['filter' => 'auth']);
$routes->post('admin/kegiatan/update/(:any)', 'Admin\Kegiatan::update_kegiatan/$1', ['filter' => 'auth']);
$routes->get('admin/edit-kegiatan/(:any)', 'Admin\Kegiatan::edit_kegiatan/$1', ['filter' => 'auth']);
$routes->get('admin/hapus-kegiatan/(:any)', 'Admin\Kegiatan::hapus_kegiatan/$1', ['filter' => 'auth']);
$routes->get('admin/list-peserta-kegiatan/(:any)', 'Admin\Kegiatan::list_peserta_kegiatan/$1', ['filter' => 'auth']);
$routes->get('admin/reject-peserta/(:any)', 'Admin\Kegiatan::reject_peserta_kegiatan/$1', ['filter' => 'auth']);
$routes->get('admin/approve-peserta/(:any)', 'Admin\Kegiatan::approve_peserta_kegiatan/$1', ['filter' => 'auth']);
$routes->post('admin/approve-peserta-all', 'Admin\Kegiatan::approve_peserta_kegiatan_all', ['filter' => 'auth']);

//tatacara admin
$routes->get('admin/informasi-tatacara', 'Admin\TataCara::index', ['filter' => 'auth']);
$routes->get('admin/tambah-tatacara', 'Admin\TataCara::tambah_tatacara', ['filter' => 'auth']);
$routes->post('admin/tatacara/save', 'Admin\TataCara::save_tatacara', ['filter' => 'auth']);
$routes->post('admin/tatacara/update/(:any)', 'Admin\TataCara::update_tatacara/$1', ['filter' => 'auth']);
$routes->get('admin/edit-tatacara/(:any)', 'Admin\TataCara::edit_tatacara/$1', ['filter' => 'auth']);
$routes->get('admin/hapus-tatacara/(:any)', 'Admin\TataCara::hapus_tatacara/$1', ['filter' => 'auth']);

//penyelenggara admin
$routes->get('admin/informasi-penyelenggara', 'Admin\PenyelenggaraController::index', ['filter' => 'auth']);
$routes->get('admin/tambah-penyelenggara', 'Admin\PenyelenggaraController::tambah_penyelenggara', ['filter' => 'auth']);
$routes->post('admin/penyelenggara/save', 'Admin\PenyelenggaraController::save_penyelenggara', ['filter' => 'auth']);
$routes->post('admin/penyelenggara/update/(:any)', 'Admin\PenyelenggaraController::update_penyelenggara/$1', ['filter' => 'auth']);
$routes->get('admin/edit-penyelenggara/(:any)', 'Admin\PenyelenggaraController::edit_penyelenggara/$1', ['filter' => 'auth']);
$routes->get('admin/hapus-penyelenggara/(:any)', 'Admin\PenyelenggaraController::hapus_penyelenggara/$1', ['filter' => 'auth']);

//video admin
$routes->get('admin/informasi-video', 'Admin\Video::index', ['filter' => 'auth']);
$routes->get('admin/tambah-video', 'Admin\Video::tambah_video', ['filter' => 'auth']);
$routes->post('admin/video/save', 'Admin\Video::save_video', ['filter' => 'auth']);
$routes->post('admin/video/update/(:any)', 'Admin\Video::update_video/$1', ['filter' => 'auth']);
$routes->get('admin/edit-video/(:any)', 'Admin\Video::edit_video/$1', ['filter' => 'auth']);
$routes->get('admin/hapus-video/(:any)', 'Admin\Video::hapus_video/$1', ['filter' => 'auth']);

// popup
$routes->get('admin/informasi-popup', 'Admin\Popup::index', ['filter' => 'auth']);
$routes->get('admin/tambah-popup', 'Admin\Popup::tambah_popup', ['filter' => 'auth']);
$routes->post('admin/popup/save', 'Admin\Popup::save_popup', ['filter' => 'auth']);
$routes->post('admin/popup/update/(:any)', 'Admin\Popup::update_popup/$1', ['filter' => 'auth']);
$routes->get('admin/edit-popup/(:any)', 'Admin\Popup::edit_popup/$1', ['filter' => 'auth']);
$routes->get('admin/hapus-popup/(:any)', 'Admin\Popup::hapus_popup/$1', ['filter' => 'auth']);

// Faq
$routes->get('admin/informasi-faq', 'Admin\Faq::index', ['filter' => 'auth']);
$routes->get('admin/tambah-faq', 'Admin\Faq::tambah_faq', ['filter' => 'auth']);
$routes->post('admin/faq/save', 'Admin\Faq::save_faq', ['filter' => 'auth']);
$routes->post('admin/faq/update/(:any)', 'Admin\Faq::update_faq/$1', ['filter' => 'auth']);
$routes->get('admin/edit-faq/(:any)', 'Admin\Faq::edit_faq/$1', ['filter' => 'auth']);
$routes->get('admin/status-faq/(:any)', 'Admin\Faq::status_faq/$1', ['filter' => 'auth']);

// user
$routes->get('admin/settings-user', 'Admin\User::index', ['filter' => 'auth']);
$routes->get('admin/tambah-user', 'Admin\User::tambah_user', ['filter' => 'auth']);
$routes->post('admin/user/save', 'Admin\User::save_user', ['filter' => 'auth']);
$routes->post('admin/user/update/(:any)', 'Admin\User::update_user/$1', ['filter' => 'auth']);
$routes->get('admin/edit-user/(:any)', 'Admin\User::edit_user/$1', ['filter' => 'auth']);
$routes->get('admin/hapus-user/(:any)', 'Admin\User::hapus_user/$1', ['filter' => 'auth']);
$routes->get('admin/reset-user/(:any)', 'Admin\User::reset_user/$1', ['filter' => 'auth']);
$routes->post('admin/user/update_password/(:any)', 'Admin\User::update_password_user/$1', ['filter' => 'auth']);

// kuliner
$routes->get('admin/kuliner', 'Admin\Kuliner::index', ['filter' => 'auth']);
$routes->get('admin/tambah-kuliner', 'Admin\Kuliner::tambah_kuliner', ['filter' => 'auth']);
$routes->post('admin/kuliner/save', 'Admin\Kuliner::save_kuliner', ['filter' => 'auth']);
$routes->post('admin/kuliner/update/(:any)', 'Admin\Kuliner::update_kuliner/$1', ['filter' => 'auth']);
$routes->get('admin/edit-kuliner/(:any)', 'Admin\Kuliner::edit_kuliner/$1', ['filter' => 'auth']);
$routes->get('admin/hapus-kuliner/(:any)', 'Admin\Kuliner::hapus_kuliner/$1', ['filter' => 'auth']);

// settings log
$routes->get('admin/settings-log', 'Admin\Log::show', ['filter' => 'auth']);

// $routes->get('pages/(:any)', 'Pages::view/$1');

// $routes->get('/script', 'Script::index');
// $routes->post('admin/script/import-file', 'Script::import_file');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
  require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
