<?php

namespace App\Controllers\Admin;

use App\Models\TataCaraModel;
use App\Models\KategoriTataCaraModel;

class TataCara extends Log
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
    $tatacara = new TataCaraModel;
    $id = session()->get('user_id');
    $data['nama_user'] = session()->get('name');
    $data['active'] = "tatacara";
    $data['tatacara'] = $tatacara->join('kategori_tatacara', 'kategori_tatacara.id_kategori = tatacara.id_kategori')->orderBy('tatacara.id_tatacara')->findAll();
    $this->add_log($id, "Melihat menu tatacara");
    return view('admin/informasi/tatacara', $data);
  }

  public function hapus_tatacara($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $tatacara = new TataCaraModel();
    $ids = session()->get('user_id');
    $tatacara->delete($id);
    $this->add_log($ids, "Menghapus tatacara dengan ID : " . $id);
    return redirect()->to('/admin/informasi-tatacara');
  }

  public function tambah_tatacara()
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $kategori_tatacara = new KategoriTataCaraModel;
    $data['active'] = "tatacara";
    $data['nama_user'] = session()->get('name');
    $data['kategori_tatacara'] = $kategori_tatacara->findAll();
    $ids = session()->get('user_id');
    $this->add_log($ids, "Membuka form tambah tatacara");
    return view('admin/informasi/form_tatacara', $data);
  }

  public function save_tatacara()
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    helper('text');
    if (!$this->validate([
      'kategori' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi'
        ]
      ],
      'judul' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi',
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

    $files = $this->request->getFile('url');
    if ($files->getClientExtension() == "") {
      session()->setFlashdata('error', 'File harus diisi');
      return redirect()->back()->withInput();
    } elseif ($files->getClientExtension() != "pdf") {
      session()->setFlashdata('error', 'File harus PDF');
      return redirect()->back()->withInput();
    } else {
      $nama = str_replace(" ", "-", $this->request->getVar('judul'));
      $unik = random_string('numeric', 5);
      $nama_file = $nama . "_" . $unik . "." . $files->getClientExtension();
      $files->move('assets/regulasi', $nama_file);

      $ids = session()->get('user_id');
      $tatacara = new TataCaraModel();
      $tatacara->insert([
        'judul' => $this->request->getVar('judul'),
        'id_kategori' => $this->request->getVar('kategori'),
        'content' => $this->request->getVar('content'),
        'url' => "/assets/regulasi/" . $nama_file,
        'keyword' => $this->request->getVar('keyword'),
        'inserted_by' => $ids,
        'created_date' => date("Y-m-d H:i:s"),
        'last_update' => date("Y-m-d H:i:s")
      ]);

      session()->setFlashdata('success', 'Berhasil menambah tatacara ' . $this->request->getVar('judul'));
      $this->add_log($ids, "Menambah tatacara dengan nama : " . $this->request->getVar('judul'));
      return redirect()->to('/admin/informasi-tatacara');
    }
  }

  public function update_tatacara($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    helper('text');
    if (!$this->validate([
      'kategori' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi'
        ]
      ],
      'judul' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi',
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

    $files = $this->request->getFile('url');
    if ($files->getClientExtension() == "") {
      $tatacara = new TataCaraModel();
      $tatacara->update($id, [
        'judul' => $this->request->getVar('judul'),
        'id_kategori' => $this->request->getVar('kategori'),
        'content' => $this->request->getVar('content'),
        // 'url' => $this->request->getVar('url'),
        'keyword' => $this->request->getVar('keyword'),
        'inserted_by' => $ids,
        'created_date' => date("Y-m-d H:i:s"),
        'last_update' => date("Y-m-d H:i:s")
      ]);
    } elseif ($files->getClientExtension() != "pdf") {
      session()->setFlashdata('error', 'File harus PDF');
      return redirect()->back()->withInput();
    } else {
      $nama = str_replace(" ", "-", $this->request->getVar('judul'));
      $unik = random_string('numeric', 5);
      $nama_file = $nama . "_" . $unik . "." . $files->getClientExtension();
      $files->move('assets/regulasi', $nama_file);

      $tatacara = new TataCaraModel();
      $tatacara->update($id, [
        'judul' => $this->request->getVar('judul'),
        'id_kategori' => $this->request->getVar('kategori'),
        'content' => $this->request->getVar('content'),
        'url' => "/assets/regulasi/" . $nama_file,
        'keyword' => $this->request->getVar('keyword'),
        'inserted_by' => $ids,
        'created_date' => date("Y-m-d H:i:s"),
        'last_update' => date("Y-m-d H:i:s")
      ]);
    }

    $ids = session()->get('user_id');
    session()->setFlashdata('success', 'Berhasil merubah tatacara ' . $this->request->getVar('judul'));
    $this->add_log($ids, "Mengedit Tatacara dengan judul : " . $this->request->getVar('judul'));
    return redirect()->to('/admin/informasi-tatacara');
  }

  public function edit_tatacara($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $kategori_tatacara = new KategoriTataCaraModel;
    $tatacara = new TataCaraModel;
    $data['active'] = "tatacara";
    $data['nama_user'] = session()->get('name');
    $data['model'] = $tatacara->find($id);
    $data['kategori_tatacara'] = $kategori_tatacara->findAll();
    $ids = session()->get('user_id');
    $this->add_log($ids, "Membuka form edit tatacara dengan ID: " . $id);
    return view('admin/informasi/form_tatacara', $data);
  }
}
