<?php

namespace App\Controllers\Pages;

use App\Models\KategoriModel;
use App\Models\KegiatanModel;
use App\Models\PesertaPembinaanModel;
use App\Models\ProdukModel;
use CodeIgniter\Controller;

class Kegiatan extends Controller
{

  public function index()
  {
    $data['active'] = "publikasi";
    $data['filter'] = $filter = [
      'limit' => $this->request->getGet('limit') ?? 10,
      'page' => $this->request->getGet('page') ?? 1,
      'search' => $this->request->getGet('search'),
    ];
    $kegiatan = new KegiatanModel();
    $kegiatan->select('pembinaan.*, penyelenggara.nama as namaPenyelenggara, provinsi.nama_provinsi, mst_kota.nama as namakota, kategori_produk.kategori as namakategori')
      ->join('penyelenggara', 'penyelenggara.id_penyelenggara = pembinaan.penyelenggara', 'left')
      ->join('provinsi', 'provinsi.id_provinsi = pembinaan.id_provinsi', 'left')
      ->join('mst_kota', 'mst_kota.id = pembinaan.id_kota', 'left')
      ->join('kategori_produk', 'kategori_produk.id_kategori = pembinaan.kategori_produk', 'left')
      ->where('pembinaan.status', 1);

    if ($filter['search']) {
      $kegiatan->like('pembinaan.nama_kegiatan', $filter['search'])->orLike('penyelenggara.nama', $filter['search']);
    }

    // if (!empty($data['kegiatan'])) {
    //   if (((strtotime(date('Y-m-d')) - strtotime($data['kegiatan'][0]->tanggal_publikasi)) / 60 / 60 / 24) >= 0) {
    //     $data['kegiatan'] = $data['kegiatan'];
    //   } else {
    //     $data['kegiatan'] = [];
    //   }
    // }
    $data['kegiatan'] = $kegiatan->paginate($filter['limit']);
    $data['pager'] = $kegiatan->pager;
    $data['view']   = 'pages/kegiatan/index';
    return view('layouts/app', $data);
  }

  public function show($namakegiatan)
  {

    $kegiatan = new KegiatanModel;
    $peserta = new PesertaPembinaanModel();
    $produk = new ProdukModel();
    $kategori = new KategoriModel();
    $namakegiatan = str_replace("-", " ", $namakegiatan);
    $data['kegiatan'] = $kegiatan->select('pembinaan.*, penyelenggara.nama as namaPenyelenggara, provinsi.nama_provinsi, mst_kota.nama as namakota')
      ->join('penyelenggara', 'penyelenggara.id_penyelenggara = pembinaan.penyelenggara', 'left')
      ->join('provinsi', 'provinsi.id_provinsi = pembinaan.id_provinsi', 'left')
      ->join('mst_kota', 'mst_kota.id = pembinaan.id_kota', 'left')
      ->where('pembinaan.nama_kegiatan', $namakegiatan)->findAll();
    $data['active'] = "info";
    $data['kategori'] = $kategori->select('kategori as nama_kategori')->whereIn('id_kategori', json_decode($data['kegiatan'][0]->kategori_produk))->findAll();
    $dataPeserta = $peserta->select('peserta_pembinaan.list_barang, pelaku_usaha.nama_usaha, peserta_pembinaan.nama_pj')
      ->join('pelaku_usaha', 'pelaku_usaha.id_pelaku = peserta_pembinaan.id_pelaku', 'left')
      ->where('peserta_pembinaan.status_kehadiran', 1)
      ->where('peserta_pembinaan.id_pembinaan', $data['kegiatan'][0]->id_pembinaan)->findAll();

    $datapesertanew = [
      'dataPeserta' => $dataPeserta,
      'produk' => []
    ];
    if (!empty($dataPeserta)) {
      foreach ($dataPeserta as $key => $value) {
        $explode = explode(",", $value->list_barang);
        $dataproduk = $produk->select('nama_produk')->whereIn('id_produk', $explode)->findAll();
        array_push($datapesertanew['produk'], $dataproduk);
      }
    }
    $data['peserta'] = $dataPeserta;
    $data['datapesertanew'] = $datapesertanew;
    $nonpangan = $data['kegiatan'][0]->pangan_non;
    $explode = explode(";", $nonpangan);
    if ($explode[0] == 'nonpangan') {
      $data['kat1'] = $explode[0];
      $data['kat2'] = $explode[1];
    } else {
      $data['kat1'] = $explode[1];
      $data['kat2'] = $explode[0];
    }
    $data['active'] = "publikasi";
    $data['view']   = 'pages/kegiatan/show';
    return view('layouts/app', $data);
  }
}
