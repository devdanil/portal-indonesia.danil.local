<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\PelakuUsahaModel;
use App\Models\ProdukModel;
use App\Models\KulinerModel;
use App\Models\VideoModel;

class Dashboard extends Controller
{
  function __construct()
  {
    helper('utility');
  }

  public function index()
  {
    if (!can_access([1,2])) {
      return redirect()->to(base_url());
    }
    $pelaku = new PelakuUsahaModel();
    $produk = new ProdukModel();
    $kuliner = new KulinerModel();
    $video = new VideoModel();
    $data['active'] = "dashboard";
    $data['nama_user'] = session()->get('name');
    $pelaku_total = $pelaku->select('nama_usaha')->where('status_registrasi', 2)->findAll();
    $produk_total = $produk->where('status', 1)->findAll();
    $produk_makanan = $produk->where('status', 1)->where('id_kategori', 1)->findAll();
    $produk_fashion = $produk->where('status', 1)->where('id_kategori', 2)->findAll();
    $produk_kosmetik = $produk->where('status', 1)->where('id_kategori', 3)->findAll();
    $produk_kerajinan = $produk->where('status', 1)->where('id_kategori', 6)->findAll();
    $produk_dekorasi = $produk->where('status', 1)->where('id_kategori', 17)->findAll();
    $produk_jasa = $produk->where('status', 1)->where('id_kategori', 13)->findAll();
    $produk_not_approve = $produk->join('pelaku_usaha', 'pelaku_usaha.id_pelaku = produk.id_pelaku_usaha', 'left')->where('status', 0)->orderBy('id_produk ', 'DESC')->findAll(5, 0);
    $pelaku_not_approve = $pelaku->where('status_registrasi', 1)->orderBy('id_pelaku ', 'DESC')->findAll(5, 0);
    $kuliner_total = $kuliner->select('nama')->findAll();
    $video_total = $video->select('judul_video')->findAll();
    $data['pelaku_total'] = count($pelaku_total);
    $data['produk_total'] = count($produk_total);
    $data['produk_makanan'] = count($produk_makanan);
    $data['produk_fashion'] = count($produk_fashion);
    $data['produk_kosmetik'] = count($produk_kosmetik);
    $data['produk_kerajinan'] = count($produk_kerajinan);
    $data['produk_dekorasi'] = count($produk_dekorasi);
    $data['produk_jasa'] = count($produk_jasa);
    $data['kuliner_total'] = count($kuliner_total);
    $data['video_total'] = count($video_total);
    $data['produk'] = $produk_not_approve;
    $data['pelaku_usaha'] = $pelaku_not_approve;

    //grafik
    // $query_porduk = "SELECT MONTH(insert_date) as bulan, YEAR(insert_date) as tahun, COUNT(*) as total FROM produk WHERE insert_date BETWEEN '2021-01-01' AND '2022-12-31' GROUP BY YEAR(insert_date), MONTH(insert_date)";
    // $query_pelaku_usaha = "SELECT MONTH(insert_date) as bulan, YEAR(insert_date) as tahun, COUNT(*) as total FROM pelaku_usaha WHERE insert_date BETWEEN '2021-01-01' AND '2022-12-31' GROUP BY YEAR(insert_date), MONTH(insert_date)";
    $query_pelaku = $pelaku->select('MONTH(insert_date) as bulan, YEAR(insert_date) as tahun, COUNT(*) as total')->where('insert_date >=', '2020-01-01')->where('insert_date <=', '2022-01-01')->groupBy('YEAR(insert_date), MONTH(insert_date)')->findAll();
    $array_time = array();
    $array_total = array();
    for ($i = 0; $i < count($query_pelaku); $i++) {
      if ($query_pelaku[$i]->bulan == 1) {
        $bulan = "Januari";
      } elseif ($query_pelaku[$i]->bulan == 2) {
        $bulan = "Februari";
      } elseif ($query_pelaku[$i]->bulan == 3) {
        $bulan = "Maret";
      } elseif ($query_pelaku[$i]->bulan == 4) {
        $bulan = "April";
      } elseif ($query_pelaku[$i]->bulan == 5) {
        $bulan = "Mei";
      } elseif ($query_pelaku[$i]->bulan == 6) {
        $bulan = "Juni";
      } elseif ($query_pelaku[$i]->bulan == 7) {
        $bulan = "Juli";
      } elseif ($query_pelaku[$i]->bulan == 8) {
        $bulan = "Agustus";
      } elseif ($query_pelaku[$i]->bulan == 9) {
        $bulan = "September";
      } elseif ($query_pelaku[$i]->bulan == 10) {
        $bulan = "Oktober";
      } elseif ($query_pelaku[$i]->bulan == 11) {
        $bulan = "November";
      } elseif ($query_pelaku[$i]->bulan == 12) {
        $bulan = "Desember";
      }
      $hmm = $bulan . " - " . $query_pelaku[$i]->tahun;
      $total = $query_pelaku[$i]->total;
      array_push($array_time, $hmm);
      array_push($array_total, $total);
    }
    $data['bulan'] = $array_time;
    $data['total'] = $array_total;
    // print_r($array_time);
    return view('admin/dashboard', $data);
  }
}
