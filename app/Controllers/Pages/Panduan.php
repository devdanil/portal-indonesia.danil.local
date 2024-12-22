<?php

namespace App\Controllers\Pages;

use CodeIgniter\Controller;

class Panduan extends Controller
{

  public function index()
  {
    $data['active'] = "panduan";
    $data['view'] = 'pages/panduan';
    return view('layouts/app', $data);
  }
}
