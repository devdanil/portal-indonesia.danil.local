<?php

namespace App\Controllers\Pages;

use App\Models\KategoriModel;
use App\Models\ProdukModel;
use App\Models\ProvinsiModel;
use App\Models\SubKategoriModel;
use CodeIgniter\Controller;

class Etalase extends Controller
{

  public function index()
  {
    $data['active'] = "etalase";
    $kategoris = new KategoriModel();
    $produk = new ProdukModel();
    $provinsi = new ProvinsiModel();
    $subkategori = new SubKategoriModel();

    $data['filter'] = $filter = [
      'search' => $this->request->getGet('search'),
      'kategori_id' => $this->request->getGet('kategori_id'),
      'subkategori_id' => $this->request->getGet('subkategori_id'),
      'provinsi_id' => $this->request->getGet('provinsi_id'),
      'page' => $this->request->getGet('page') ?? 1,
    ];

    $queryProduk = $produk->select([
      'produk.id_produk',
      'produk.foto_produk',
      'produk.tokopedia',
      'produk.bukalapak',
      'produk.shoope',
      'produk.insert_date',
      'produk.id_kategori',
      'produk.nama_produk',
      'kategori_produk.kategori',
      'pelaku_usaha.jenis_usaha',
      'pelaku_usaha.email',
      'pelaku_usaha.handphone'
    ])->join('kategori_produk', 'kategori_produk.id_kategori = produk.id_kategori')
      ->join('pelaku_usaha', 'pelaku_usaha.id_pelaku = produk.id_pelaku_usaha');

    $queryKategori = $kategoris->select([
      'kategori_produk.id_kategori',
      'kategori_produk.kategori',
      'COUNT(produk.id_kategori) AS total'
    ])->join('produk', 'produk.id_kategori = kategori_produk.id_kategori', 'left');

    $queryProvinsi = $provinsi->select([
      'provinsi.id_provinsi',
      'provinsi.nama_provinsi',
      'COUNT(produk.id_produk) as total'
    ])
      ->join('produk ', 'produk.id_provinsi = provinsi.id_provinsi', 'left')
      ->where('produk.status', '1')
      ->where('produk.status_show', '1')
      ->groupBy('produk.id_provinsi')
      ->orderBy('provinsi.id_provinsi', 'ASC');

    $querySubKategori = $subkategori->where('id_sub !=', '0');

    if ($filter['search']) {
      $queryProduk->like('produk.nama_produk', $filter['search'], 'after');
    }
    if ($filter['kategori_id']) {
      $queryProduk->where('produk.id_kategori', $filter['kategori_id']);
      $querySubKategori->where('id_kategori', $filter['kategori_id']);
      if ($filter['subkategori_id']) {
        $queryProduk->where('produk.id_sub', $filter['subkategori_id']);
      }
    }
    if ($filter['provinsi_id']) {
      $queryProduk->where('produk.id_provinsi', $filter['provinsi_id']);
      $queryKategori->where('produk.id_provinsi', $filter['provinsi_id']);
    }



    $data['produk'] = $queryProduk->where('produk.status', '1')->where('produk.status_show', '1')->orderBy('produk.id_produk', 'DESC')->paginate(12);
    $queryKategori->where('produk.status', 1)->where('produk.status_show', '1')->groupBy('kategori_produk.id_kategori');

    $data['kategori'] =  $queryKategori->findAll();
    $data['subkategori'] =  $querySubKategori->findAll();
    $data['provinsi'] =   $queryProvinsi->orderBy('id_provinsi', 'ASC')->findAll();
    $data['pager'] = $produk->pager;
    $data['view'] = 'pages/etalase/index';
    return view('layouts/app', $data);
  }

  public function show($id)
  {
    $data['active'] = "etalase";
    $produk = new ProdukModel();
    $data['produk'] = $produk->select([
      'produk.nama_produk',
      'mst_kota.nama as nama_kota',
      'provinsi.nama_provinsi',
      'produk.insert_date',
      'produk.spesifikasi_in',
      'pelaku_usaha.nama_usaha',
      'pelaku_usaha.alamat',
      'pelaku_usaha.handphone',
      'pelaku_usaha.email',
      'produk.tokopedia',
      'produk.bukalapak',
      'produk.shoope',
      'produk.foto_produk'
    ])->join('pelaku_usaha', 'pelaku_usaha.id_pelaku = produk.id_pelaku_usaha', 'left')
      ->join('mst_kota', 'mst_kota.id = produk.id_kota', 'left')
      ->join('provinsi', 'provinsi.id_provinsi = produk.id_provinsi', 'left')
      ->where('produk.id_produk', $id)->findAll();
    $data['view'] = 'pages/etalase/show';
    return view('layouts/app', $data);
  }
}
