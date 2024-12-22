<?php

namespace App\Controllers\Pages;

use App\Models\FaqModel;
use CodeIgniter\Controller;

class Faq extends Controller
{

  public function index()
  {
    $data['active'] = "faq";
    $faq = new FaqModel();
    $data['faq'] = $faq->where('status', '0')->findAll();
    $data['view'] = 'pages/faq';
    return view('layouts/app', $data);
  }
}
