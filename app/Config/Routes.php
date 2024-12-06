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
$routes->get('/', 'Web::index');
$routes->get('/login', 'Auth::index');
$routes->get('/admin', 'Admin::index',['filter' => 'auth']);
$routes->get('/logout', 'Auth::logout');
$routes->get('/register/admin', 'Auth::register');
$routes->post('/register/process', 'Auth::process');
$routes->post('/login/process', 'Auth::auth_process');
// web
$routes->get('/etalase', 'Web::etalase');
$routes->get('/info', 'Web::info');
$routes->get('/petunjuk', 'Web::petunjuk');
$routes->get('/register', 'Web::register');
$routes->get('/panduan', 'Web::panduan');
$routes->get('/faq', 'Web::faq');
$routes->get('/contact', 'Web::contact');
$routes->post('/contact-us', 'Web::contact_us');
$routes->get('/lokasi-kuliner', 'Web::kuliner');
$routes->get('/video', 'Web::video');
$routes->get('/kegiatan', 'Web::kegiatan');
$routes->get('/daftar-kegiatan/(:any)', 'Web::daftar_kegiatan/$1');
$routes->get('/peraturan', 'Web::peraturan');     
$routes->get('/riwayat', 'Web::riwayat');
$routes->post('/registrasi', 'Web::registrasi_save'); 
$routes->post('/update-profile', 'Web::update_profile');
$routes->post('/cek-no-regis', 'Web::cek_regis');
$routes->get('/profile', 'Web::profile');  
$routes->get('/detail/(:any)', 'Web::detail/$1'); 
$routes->post('/reset', 'Auth::reset_pelaku_usaha');   
$routes->post('produk/simpan', 'Web::save_produk');
$routes->post('produk/update/(:any)', 'Web::update_produk/$1');
$routes->get('/produk-hapus/(:any)', 'Web::hapus_produk/$1');
$routes->get('/pelaku-usaha', 'Web::pelaku_usaha');      
$routes->get('/blog', 'Berita::list_berita');  
$routes->get('/blog/(:any)', 'Berita::detail_berita/$1');
$routes->get('/forget-password', 'Web::forget');
$routes->post('/email-cek', 'Web::email_cek');
$routes->post('/kode-cek', 'Web::cek_kode');
$routes->get('/pelaku-usaha/export-excel', 'PelakuUsaha::exportExcel');
$routes->get('/detail-kegiatan/(:any)', 'Web::detail_kegiatan/$1');
$routes->get('/register-kegiatan/(:any)', 'Web::register_kegiatan/$1');
$routes->post('/pameran/save', 'Web::save_register_kegiatan');

//berita admin
$routes->get('/informasi-berita', 'Berita::index',['filter' => 'auth']);
$routes->get('/tambah-berita', 'Berita::tambah_berita',['filter' => 'auth']);
$routes->post('berita/save', 'Berita::save_berita', ['filter' => 'auth']);
$routes->post('berita/update/(:any)', 'Berita::update_berita/$1', ['filter' => 'auth']);
$routes->get('/edit-berita/(:any)', 'Berita::edit_berita/$1',['filter' => 'auth']);
$routes->get('/status-berita/(:any)', 'Berita::status_berita/$1',['filter' => 'auth']);
$routes->get('/sent-utama/(:any)', 'Berita::status_utama/$1',['filter' => 'auth']);

//produk admin
$routes->get('/kategori', 'Produk::kategori',['filter' => 'auth']);
$routes->get('/tambah-kategori', 'Produk::tambah_kategori',['filter' => 'auth']);
$routes->post('kategori/save', 'Produk::save_kategori', ['filter' => 'auth']);
$routes->post('kategori/update/(:any)', 'Produk::update_kategori/$1', ['filter' => 'auth']);
$routes->get('/edit-kategori/(:any)', 'Produk::edit_kategori/$1',['filter' => 'auth']);
$routes->get('/hapus-kategori/(:any)', 'Produk::hapus_kategori/$1',['filter' => 'auth']);

$routes->get('/subkategori', 'Produk::subkategori',['filter' => 'auth']);
$routes->get('/tambah-subkategori', 'Produk::tambah_subkategori',['filter' => 'auth']);
$routes->post('subkategori/save', 'Produk::save_subkategori', ['filter' => 'auth']);
$routes->post('subkategori/update/(:any)', 'Produk::update_subkategori/$1', ['filter' => 'auth']);
$routes->get('/edit-subkategori/(:any)', 'Produk::edit_subkategori/$1',['filter' => 'auth']);
$routes->get('/hapus-subkategori/(:any)', 'Produk::hapus_subkategori/$1',['filter' => 'auth']);

$routes->get('/produk', 'Produk::index',['filter' => 'auth']);
$routes->get('/tambah-produk', 'Produk::tambah_produk',['filter' => 'auth']);
$routes->post('produk/save', 'Produk::save_produk', ['filter' => 'auth']);
$routes->post('produk/update/(:any)', 'Produk::update_produk/$1', ['filter' => 'auth']);
$routes->get('/edit-produk/(:any)', 'Produk::edit_produk/$1',['filter' => 'auth']);
$routes->get('/hapus-produk/(:any)', 'Produk::hapus_produk/$1',['filter' => 'auth']);
$routes->post('/produk/get_sub_kategori/(:any)', 'Produk::get_sub_kategori/$1');
$routes->post('/produk/get_city/(:any)', 'Produk::get_city/$1');
$routes->get('/approve-produk/(:any)', 'Produk::approve_produk/$1', ['filter' => 'auth']);
$routes->get('/action-produk/(:any)/(:any)', 'Produk::action_produk/$1/$2', ['filter' => 'auth']);

//pelaku admin
$routes->get('/pelaku-usaha-admin', 'PelakuUsaha::index',['filter' => 'auth']);
$routes->get('/reject-pelaku-usaha/(:any)', 'PelakuUsaha::reject_pelaku/$1',['filter' => 'auth']);
$routes->get('/approve-pelaku-usaha/(:any)', 'PelakuUsaha::approve_pelaku/$1',['filter' => 'auth']);
$routes->get('/ubah-status-pelaku-usaha/(:any)/(:any)', 'PelakuUsaha::status_pelaku/$1/$2',['filter' => 'auth']);
$routes->get('/detail-pelaku-usaha/(:any)', 'PelakuUsaha::detail_pelaku/$1',['filter' => 'auth']);
$routes->get('/tambah-pelaku-usaha', 'PelakuUsaha::tambah_pelaku',['filter' => 'auth']);
$routes->post('/pelaku-usaha/save', 'PelakuUsaha::save_pelaku',['filter' => 'auth']);
$routes->get('/edit-pelaku/(:any)', 'PelakuUsaha::edit_pelaku/$1',['filter' => 'auth']);
$routes->post('/pelaku-usaha/update/(:any)', 'PelakuUsaha::update_pelaku/$1',['filter' => 'auth']);
$routes->get('/pelaku-usaha-admin/export-excel', 'PelakuUsaha::exportExcel');
$routes->get('/pelaku-usaha-admin/reset-password/(:any)', 'PelakuUsaha::reset_user/$1',['filter' => 'auth']);
$routes->post('/pelaku-usaha-admin/update-password/(:any)', 'PelakuUsaha::update_password_user/$1',['filter' => 'auth']);

//informasi slider
$routes->get('/informasi-slider', 'Slider::index',['filter' => 'auth']);
$routes->get('/tambah-slider', 'Slider::tambah_slider',['filter' => 'auth']);
$routes->post('slider/save', 'Slider::save_slider', ['filter' => 'auth']);
$routes->post('slider/update/(:any)', 'Slider::update_slider/$1', ['filter' => 'auth']);
$routes->get('/edit-slider/(:any)', 'Slider::edit_slider/$1',['filter' => 'auth']);
$routes->get('/hapus-slider/(:any)', 'Slider::hapus_slider/$1',['filter' => 'auth']);

//informasi panduan
$routes->get('/informasi-panduan', 'Panduan::index',['filter' => 'auth']);
$routes->get('/tambah-panduan', 'Panduan::tambah_panduan',['filter' => 'auth']);
$routes->post('panduan/save', 'Panduan::save_panduan', ['filter' => 'auth']);
$routes->post('panduan/update/(:any)', 'Panduan::update_panduan/$1', ['filter' => 'auth']);
$routes->get('/edit-panduan/(:any)', 'Panduan::edit_panduan/$1',['filter' => 'auth']);
$routes->get('/hapus-panduan/(:any)', 'Panduan::hapus_panduan/$1',['filter' => 'auth']);

//kegiatan admin
$routes->get('/informasi-kegiatan', 'Kegiatan::index',['filter' => 'auth']);
$routes->get('/tambah-kegiatan', 'Kegiatan::tambah_kegiatan',['filter' => 'auth']);
$routes->post('kegiatan/save', 'Kegiatan::save_kegiatan', ['filter' => 'auth']);
$routes->post('kegiatan/update/(:any)', 'Kegiatan::update_kegiatan/$1', ['filter' => 'auth']);
$routes->get('/edit-kegiatan/(:any)', 'Kegiatan::edit_kegiatan/$1',['filter' => 'auth']);
$routes->get('/hapus-kegiatan/(:any)', 'Kegiatan::hapus_kegiatan/$1',['filter' => 'auth']);
$routes->get('/list-peserta-kegiatan/(:any)', 'Kegiatan::list_peserta_kegiatan/$1',['filter' => 'auth']);
$routes->get('/reject-peserta/(:any)', 'Kegiatan::reject_peserta_kegiatan/$1',['filter' => 'auth']);
$routes->get('/approve-peserta/(:any)', 'Kegiatan::approve_peserta_kegiatan/$1',['filter' => 'auth']);
$routes->post('/approve-peserta-all', 'Kegiatan::approve_peserta_kegiatan_all',['filter' => 'auth']);

//tatacara admin
$routes->get('/informasi-tatacara', 'TataCara::index',['filter' => 'auth']);
$routes->get('/tambah-tatacara', 'TataCara::tambah_tatacara',['filter' => 'auth']);
$routes->post('tatacara/save', 'TataCara::save_tatacara', ['filter' => 'auth']);
$routes->post('tatacara/update/(:any)', 'TataCara::update_tatacara/$1', ['filter' => 'auth']);
$routes->get('/edit-tatacara/(:any)', 'TataCara::edit_tatacara/$1',['filter' => 'auth']);
$routes->get('/hapus-tatacara/(:any)', 'TataCara::hapus_tatacara/$1',['filter' => 'auth']);

//penyelenggara admin
$routes->get('/informasi-penyelenggara', 'PenyelenggaraController::index',['filter' => 'auth']);
$routes->get('/tambah-penyelenggara', 'PenyelenggaraController::tambah_penyelenggara',['filter' => 'auth']);
$routes->post('penyelenggara/save', 'PenyelenggaraController::save_penyelenggara', ['filter' => 'auth']);
$routes->post('penyelenggara/update/(:any)', 'PenyelenggaraController::update_penyelenggara/$1', ['filter' => 'auth']);
$routes->get('/edit-penyelenggara/(:any)', 'PenyelenggaraController::edit_penyelenggara/$1',['filter' => 'auth']);
$routes->get('/hapus-penyelenggara/(:any)', 'PenyelenggaraController::hapus_penyelenggara/$1',['filter' => 'auth']);

//video admin
$routes->get('/informasi-video', 'Video::index',['filter' => 'auth']);
$routes->get('/tambah-video', 'Video::tambah_video',['filter' => 'auth']);
$routes->post('video/save', 'Video::save_video', ['filter' => 'auth']);
$routes->post('video/update/(:any)', 'Video::update_video/$1', ['filter' => 'auth']);
$routes->get('/edit-video/(:any)', 'Video::edit_video/$1',['filter' => 'auth']);
$routes->get('/hapus-video/(:any)', 'Video::hapus_video/$1',['filter' => 'auth']);

// popup
$routes->get('/informasi-popup', 'Popup::index',['filter' => 'auth']);
$routes->get('/tambah-popup', 'Popup::tambah_popup',['filter' => 'auth']);
$routes->post('popup/save', 'Popup::save_popup', ['filter' => 'auth']);
$routes->post('popup/update/(:any)', 'Popup::update_popup/$1', ['filter' => 'auth']);
$routes->get('/edit-popup/(:any)', 'Popup::edit_popup/$1',['filter' => 'auth']);
$routes->get('/hapus-popup/(:any)', 'Popup::hapus_popup/$1',['filter' => 'auth']);

// Faq
$routes->get('/informasi-faq', 'Faq::index',['filter' => 'auth']);
$routes->get('/tambah-faq', 'Faq::tambah_faq',['filter' => 'auth']);
$routes->post('faq/save', 'Faq::save_faq', ['filter' => 'auth']);
$routes->post('faq/update/(:any)', 'Faq::update_faq/$1', ['filter' => 'auth']);
$routes->get('/edit-faq/(:any)', 'Faq::edit_faq/$1',['filter' => 'auth']);
$routes->get('/status-faq/(:any)', 'Faq::status_faq/$1',['filter' => 'auth']);

// user
$routes->get('/settings-user', 'User::index',['filter' => 'auth']);
$routes->get('/tambah-user', 'User::tambah_user',['filter' => 'auth']);
$routes->post('user/save', 'User::save_user', ['filter' => 'auth']);
$routes->post('user/update/(:any)', 'User::update_user/$1', ['filter' => 'auth']);
$routes->get('/edit-user/(:any)', 'User::edit_user/$1',['filter' => 'auth']);
$routes->get('/hapus-user/(:any)', 'User::hapus_user/$1',['filter' => 'auth']);
$routes->get('/reset-user/(:any)', 'User::reset_user/$1',['filter' => 'auth']);
$routes->post('/user/update_password/(:any)', 'User::update_password_user/$1', ['filter' => 'auth']);

// kuliner
$routes->get('/kuliner', 'Kuliner::index',['filter' => 'auth']);
$routes->get('/tambah-kuliner', 'Kuliner::tambah_kuliner',['filter' => 'auth']);
$routes->post('kuliner/save', 'Kuliner::save_kuliner', ['filter' => 'auth']);
$routes->post('kuliner/update/(:any)', 'Kuliner::update_kuliner/$1', ['filter' => 'auth']);
$routes->get('/edit-kuliner/(:any)', 'Kuliner::edit_kuliner/$1',['filter' => 'auth']);
$routes->get('/hapus-kuliner/(:any)', 'Kuliner::hapus_kuliner/$1',['filter' => 'auth']);

// settings log
$routes->get('/settings-log', 'Log::show',['filter' => 'auth']);

$routes->get('pages/(:any)', 'Pages::view/$1');

$routes->get('/script', 'Script::index');
$routes->post('/script/import-file', 'Script::import_file');
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
