<?php

namespace App\Controllers\Pages;

use App\Models\BeritaModel;
use App\Models\KategoriModel;
use App\Models\KegiatanModel;
use App\Models\PopupModel;
use App\Models\ProdukModel;
use App\Models\SliderModel;
use CodeIgniter\Controller;

class Home extends Controller
{

  public function index()
  {
    $kategori = new KategoriModel();
    $kegiatan = new KegiatanModel();
    $popup = new PopupModel();
    $slide = new SliderModel();
    $highlight = new BeritaModel();
    $produk = new ProdukModel();
    $cek = $highlight->select('id')->where('utama', '1')->findAll();
    if (count($cek) < 1) {
      $data['highlight'] = $highlight->orderBy('id', 'desc')->findAll(1, 0);
    } else {
      $data['highlight'] = $highlight->where('utama', '1')->findAll();
    }

    $data['active'] = "home";
    $data['kategori'] = $kategori->findAll();
    $data['filter']['kategori_id'] = $this->request->getGet('kategori_id');
    $data['slide'] = $slide->findAll();
    $produk->select('produk.id_kategori,produk.id_produk,produk.foto_produk,produk.nama_produk,kategori_produk.kategori')->join('kategori_produk', 'kategori_produk.id_kategori=produk.id_kategori')->where('produk.status', 1)->where('produk.status_show', 1);

    if ($data['filter']['kategori_id']) {
      $produk->where('produk.id_kategori', $data['filter']['kategori_id']);
    }
    $data['produk'] = $produk->orderBy('produk.id_produk', 'desc')->findAll(12, 0);
    $data['kegiatan'] = $kegiatan->select('pembinaan.*, penyelenggara.nama as namaPenyelenggara')->join('penyelenggara', 'penyelenggara.id_penyelenggara = pembinaan.penyelenggara')->where('status', 1)->findAll();

    if (!empty($data['kegiatan'])) {
      if (((strtotime(date('Y-m-d')) - strtotime($data['kegiatan'][0]->tanggal_publikasi)) / 60 / 60 / 24) >= 0) {
        $data['kegiatan'] = $data['kegiatan'];
      } else {
        $data['kegiatan'] = [];
      }
    }

    $hari_ini = date('Y-m-d');
    $data['popup'] = $popup->where('start_date <=', $hari_ini)->where('end_date >=', $hari_ini)->findAll(1, 0);
    $data['view'] = 'pages/home';
    return view('layouts/app', $data);
  }
}
