<?php

namespace App\Controllers\Pages;

use App\Models\KotaModel;
use App\Models\KulinerModel;
use App\Models\ProvinsiModel;
use CodeIgniter\Controller;

class Katalog extends Controller
{

  public function Kuliner()
  {
    $kuliner = new KulinerModel();
    $provinsi = new ProvinsiModel();
    $kota = new KotaModel();
    $filter = [
      'search' => $this->request->getGet('search'),
      'kota_id' => $this->request->getGet('kota_id'),
      'provinsi_id' => $this->request->getGet('provinsi_id'),
      'page' => $this->request->getGet('page') ?? 1,
    ];
    $kuliner->select('kuliner.*, provinsi.nama_provinsi, mst_kota.nama as nama_kota, sub_kategori_produk.nama as nama_kategori')->join('provinsi', 'provinsi.id_provinsi = kuliner.id_provinsi')->join('mst_kota', 'mst_kota.id = kuliner.id_kota')->join('sub_kategori_produk', 'sub_kategori_produk.id_sub = kuliner.kategori');

    if ($filter['provinsi_id']) {
      $kuliner->where('kuliner.id_provinsi', $filter['provinsi_id']);
      $kota->where('id_provinsi', $filter['provinsi_id'])->findAll();
      if ($filter['kota_id']) {
        $kuliner->where('kuliner.id_kota', $filter['kota_id']);
      }
    }

    if ($filter['search']) {
      $kuliner->like('kuliner.nama', $filter['search'], 'both');
    }

    $data = [
      'kuliner' => $kuliner->paginate(12),
      'provinsi' => $provinsi->select('id_provinsi,nama_provinsi')->orderBy('id_provinsi', 'ASC')->findAll(),
      'kota' => $kota->select('id,nama')->orderBy('nama', 'asc')->findAll(),
      'pager' => $kuliner->pager,
      'active' => "kuliner",
      'filter' =>  $filter,
    ];
    $data['view'] = 'pages/katalog/kuliner';
    return view('layouts/app', $data);
  }
}
