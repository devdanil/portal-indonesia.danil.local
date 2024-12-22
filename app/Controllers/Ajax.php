<?php

namespace App\Controllers;

use App\Models\KotaModel;
use App\Models\ProdukModel;
use App\Models\SubKategoriModel;
use CodeIgniter\Controller;

class Ajax extends Controller
{

  function getKota()
  {
    $provinsi_id = $this->request->getPost('provinsi_id');
    $kota = new KotaModel();
    $result = $kota->select('id,nama')->orderBy('nama', 'asc')->where('id_provinsi', $provinsi_id)->findAll();
    echo json_encode($result);
  }

  function getSubKategori()
  {
    $kategori_id = $this->request->getPost('kategori_id');
    $sub = new SubKategoriModel();
    $result = $sub->select('id_sub,nama')->orderBy('nama', 'asc')->where('id_kategori', $kategori_id)->findAll();
    echo json_encode($result);
  }

  function deleteProduk()
  {
    helper('utility');
    $produk_id = base64_decode($this->request->getPost('produk_id'));
    $pelaku_id = session()->get('user_id');
    if (!can_access([3]) || !$produk_id || !$pelaku_id) {
      echo json_decode(false);
    }
    $produk_model = new ProdukModel();
    session()->setFlashdata('sukses', 'Berhasil menghapus produk');
    echo json_encode($produk_model->where('id_produk', $produk_id)->where('id_pelaku_usaha', $pelaku_id)->delete());
  }
}
