<?php

namespace App\Controllers\Pages;

use App\Models\KotaModel;
use App\Models\PelakuUsahaModel;
use App\Models\ProvinsiModel;
use CodeIgniter\Controller;

class PelakuUsaha extends Controller
{

  public function index()
  {
    $pelaku_usaha = new PelakuUsahaModel();
    $provinsi = new ProvinsiModel();
    $kota = new KotaModel();
    $filter = [
      'search' => $this->request->getGet('search'),
      'provinsi_id' => $this->request->getGet('provinsi_id'),
      'kota_id' => $this->request->getGet('kota_id'),
      'page' => $this->request->getGet('page') ?? 1,
    ];

    $query_pelaku = $pelaku_usaha->join('mst_kota', 'mst_kota.id = pelaku_usaha.id_kota', 'left')
      ->join('provinsi', 'provinsi.id_provinsi = pelaku_usaha.id_provinsi', 'left')
      ->where('status_registrasi', 2)->orderBy('nama_produk', 'desc');

    if ($filter['provinsi_id']) {
      $query_pelaku->where('pelaku_usaha.id_provinsi', $filter['provinsi_id']);
      if ($filter['kota_id']) {
        $query_pelaku->where('pelaku_usaha.id_kota', $filter['kota_id']);
      }
      $kota->select('id,id_provinsi,nama')->where('id_provinsi', $filter['provinsi_id']);
    }

    if ($filter['search']) {
      $query_pelaku->like('nama_usaha', $filter['search'], 'both');
    }

    $data = [
      'provinsi' => $provinsi->select('id_provinsi,nama_provinsi')->orderBy("id_provinsi", "ASC")->findAll(),
      'pelaku_usaha' => $query_pelaku->paginate(10),
      'pager' => $pelaku_usaha->pager,
      'active' => "pelaku_usaha",
      'kota' => $kota->orderBy('nama', 'asc')->findAll(),
      'filter' => $filter,
      'total' => $pelaku_usaha->where('status_registrasi', 2)->countAllResults()
    ];
    $data['view'] = 'pages/pelaku_usaha';
    return view('layouts/app', $data);
  }
}
