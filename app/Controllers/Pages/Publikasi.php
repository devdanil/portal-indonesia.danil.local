<?php

namespace App\Controllers\Pages;

use CodeIgniter\Controller;

class Publikasi extends Controller
{

  public function index()
  {
    $data['active'] = "publikasi";
    $data['view'] = 'pages/publikasi';
    return view('layouts/app', $data);
  }
 
}
