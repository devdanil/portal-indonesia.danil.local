<?php

namespace App\Controllers\Pages;

use App\Models\BeritaModel;
use CodeIgniter\Controller;

class Berita extends Controller
{

  public function index()
  {
    $berita = new BeritaModel();
    $data['active'] = "berita";
    $data['berita'] = $berita->where('status', 0)->paginate(5);
    $data['pager']  = $berita->pager;
    $data['view']   = 'pages/berita/index';
    return view('layouts/app', $data);
  }

  public function show($judul)
  {
    $berita = new BeritaModel();
    $judul = str_replace("-", " ", $judul);
    $data['berita'] = $berita->where('judul', $judul)->findAll();
    $data['active'] = "";
    $data['view'] = 'pages/berita/show';
    return view('layouts/app', $data);
  }
}
