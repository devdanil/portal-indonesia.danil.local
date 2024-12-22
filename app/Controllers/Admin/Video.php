<?php

namespace App\Controllers\Admin;

use App\Models\VideoModel;
use App\Models\KategoriModel;

class Video extends Log
{
  protected $helpers = ['url', 'form'];

  function __construct()
  {
    helper('utility');
  }

  public function index()
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $video = new VideoModel;
    $id = session()->get('user_id');
    $data['nama_user'] = session()->get('name');
    $data['active'] = "video";
    $data['video'] = $video->join('kategori_produk', 'kategori_produk.id_kategori = video.id_kategori')->orderBy('video.id_video', 'DESC')->findAll();
    return view('admin/informasi/video', $data);
  }

  public function hapus_video($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $video = new VideoModel();
    $ids = session()->get('user_id');
    $video->delete($id);
    $this->add_log($ids, "Menghapus video dengan ID : " . $id);
    return redirect()->to('/informasi-video');
  }

  public function tambah_video()
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $kategori_produk = new KategoriModel;
    $data['active'] = "video";
    $data['nama_user'] = session()->get('name');
    $data['kategori_produk'] = $kategori_produk->findAll();
    $ids = session()->get('user_id');
    $this->add_log($ids, "Membuka form tambah video");
    return view('admin/informasi/form_video', $data);
  }

  public function save_video()
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    if (!$this->validate([
      'kategori' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi'
        ]
      ],
      'judul_video' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Judul Video Harus diisi',
        ]
      ],
      'url_video' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Url Video Harus diisi',
        ]
      ],
      'publish_date' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Tahun Harus diisi',
        ]
      ],
      'keyword' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi',
        ]
      ],
    ])) {
      session()->setFlashdata('error', $this->validator->listErrors());
      return redirect()->back()->withInput();
    }

    helper('text');
    $files = $this->request->getFile('img_preview');
    if ($files->getClientExtension() == "") {
      session()->setFlashdata('error', 'Foto harus diisi');
      return redirect()->back()->withInput();
    } elseif ($files->getClientExtension() != "jpg" && $files->getClientExtension() != "jpeg" && $files->getClientExtension() != "png") {
      session()->setFlashdata('error', 'File harus JPG atau PNG');
      return redirect()->back()->withInput();
    } else {
      $judul_video = str_replace(" ", "-", $this->request->getVar('judul_video'));
      $unik = random_string('numeric', 5);
      $nama_file = "video_" . $judul_video . "_" . $unik . "." . $files->getClientExtension();
      $files->move('assets/uploads/video', $nama_file);

      $ids = session()->get('user_id');
      $video = new VideoModel();
      $video->insert([
        'judul_video' => $this->request->getVar('judul_video'),
        'id_kategori' => $this->request->getVar('kategori'),
        'publish_date' => $this->request->getVar('publish_date'),
        'url_video' => $this->request->getVar('url_video'),
        'img_preview' => $nama_file,
        'keyword' => $this->request->getVar('keyword'),
        'inserted_by' => $ids,
        'created_date' => date("Y-m-d H:i:s"),
        'last_update' => date("Y-m-d H:i:s")
      ]);
    }

    $this->add_log($ids, "Menambah video dengan nama : " . $this->request->getVar('judul_video'));
    session()->setFlashdata('success', 'Berhasil menambah video ' . $this->request->getVar('judul_video'));
    return redirect()->to('/informasi-video');
  }

  public function update_video($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    if (!$this->validate([
      'kategori' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi'
        ]
      ],
      'judul_video' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Judul Video Harus diisi',
        ]
      ],
      'url_video' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Url Video Harus diisi',
        ]
      ],
      'publish_date' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Tahun Harus diisi',
        ]
      ],
      'keyword' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi',
        ]
      ],
    ])) {
      session()->setFlashdata('error', $this->validator->listErrors());
      return redirect()->back()->withInput();
    }

    helper('text');
    $files = $this->request->getFile('img_preview');
    if ($files->getClientExtension() == "") {
      $ids = session()->get('user_id');
      $video = new VideoModel();
      $video->update($id, [
        'judul_video' => $this->request->getVar('judul_video'),
        'id_kategori' => $this->request->getVar('kategori'),
        'publish_date' => $this->request->getVar('publish_date'),
        'url_video' => $this->request->getVar('url_video'),
        // 'img_preview' => $nama_file,
        'keyword' => $this->request->getVar('keyword'),
        'inserted_by' => $ids,
        'created_date' => date("Y-m-d H:i:s"),
        'last_update' => date("Y-m-d H:i:s")
      ]);
    } elseif ($files->getClientExtension() != "jpg" && $files->getClientExtension() != "jpeg" && $files->getClientExtension() != "png") {
      session()->setFlashdata('error', 'File harus JPG atau PNG');
      return redirect()->back()->withInput();
    } else {
      $judul_video = str_replace(" ", "-", $this->request->getVar('judul_video'));
      $unik = random_string('numeric', 5);
      $nama_file = "video_" . $judul_video . "_" . $unik . "." . $files->getClientExtension();
      $files->move('assets/uploads/video', $nama_file);

      $ids = session()->get('user_id');
      $video = new VideoModel();
      $video->update($id, [
        'judul_video' => $this->request->getVar('judul_video'),
        'id_kategori' => $this->request->getVar('kategori'),
        'publish_date' => $this->request->getVar('publish_date'),
        'url_video' => $this->request->getVar('url_video'),
        // 'img_preview' => $nama_file,
        'keyword' => $this->request->getVar('keyword'),
        'inserted_by' => $ids,
        'created_date' => date("Y-m-d H:i:s"),
        'last_update' => date("Y-m-d H:i:s")
      ]);
    }

    $this->add_log($ids, "Mengedit Video dengan judul : " . $this->request->getVar('judul_video'));
    session()->setFlashdata('success', 'Berhasil Mengedit video ' . $this->request->getVar('judul_video'));
    return redirect()->to('/informasi-video');
  }

  public function edit_video($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $kategori_produk = new KategoriModel;
    $video = new VideoModel;
    $data['active'] = "video";
    $data['nama_user'] = session()->get('name');
    $data['model'] = $video->find($id);
    $data['kategori_produk'] = $kategori_produk->findAll();
    return view('admin/informasi/form_video', $data);
  }
}
