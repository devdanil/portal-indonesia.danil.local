<?php

namespace App\Controllers\Pages;

use App\Models\TataCaraModel;
use CodeIgniter\Controller;

class Peraturan extends Controller
{

  public function index()
  {
    $data['active'] = "publikasi";
    $tatacara = new TataCaraModel();
    $data['filter'] = $filter = [
      'limit' => $this->request->getGet('limit') ?? 10,
      'page' => $this->request->getGet('page') ?? 1,
      'search' => $this->request->getGet('search'),
    ];
    $tatacara->select('tatacara.judul,kategori_tatacara.kategori,tatacara.url')->join('kategori_tatacara', 'kategori_tatacara.id_kategori = tatacara.id_kategori');
    if ($filter['search']) {
      $tatacara->like('tatacara.judul', $filter['search'], 'both')->orLike('kategori_tatacara.kategori', $filter['search'], 'both');
    }
    $data['tatacara'] = $tatacara->orderBy('id_tatacara', 'desc')->paginate($filter['limit']);
    $data['pager'] = $tatacara->pager;
    $data['view'] = 'pages/peraturan';
    return view('layouts/app', $data);
  }
}
