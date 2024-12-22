<?php

namespace App\Controllers\Pages;

use App\Models\VideoModel;
use CodeIgniter\Controller;

class Video extends Controller
{

  public function index()
  {
    $data['active'] = "publikasi";
    $video = new VideoModel();
    $data['video'] = $video->orderBy('id_video', 'DESC')->findAll();
    $data['view'] = 'pages/video';
    return view('layouts/app', $data);
  }
}
