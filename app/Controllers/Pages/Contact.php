<?php

namespace App\Controllers\Pages;
use CodeIgniter\Controller;

class Contact extends Controller
{

  public function index()
  {
    $data['active'] = "contact_us";
    $data['view'] = 'pages/contact';
    return view('layouts/app', $data);
  }
}
