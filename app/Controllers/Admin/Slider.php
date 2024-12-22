<?php

namespace App\Controllers\Admin;

use App\Models\SliderModel;

class Slider extends Log
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
    $slider = new SliderModel;
    $data['nama_user'] = session()->get('name');
    $data['active'] = "slider";
    $data['slider'] = $slider->findAll();
    return view('admin/informasi/slider', $data);
  }

  public function hapus_slider($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $slider = new SliderModel();
    $ids = session()->get('user_id');
    $slider->delete($id);
    $this->add_log($ids, "Menghapus slider dengan ID : " . $id);
    session()->setFlashdata('success', 'Berhasil menghapus slider');
    return redirect()->to('/admin/informasi-slider');
  }

  public function tambah_slider()
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $data['active'] = "slider";
    $data['nama_user'] = session()->get('name');
    return view('admin/informasi/form_slider', $data);
  }

  public function save_slider()
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    if (!$this->validate([
      'nama' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Nama Harus diisi'
        ]
      ],
      // 'deskripsi' => [
      //     'rules' => 'required',
      //     'errors' => [
      //         'required' => '{field} Harus diisi',
      //     ]
      // ],
    ])) {
      session()->setFlashdata('error', $this->validator->listErrors());
      return redirect()->back()->withInput();
    }

    helper('text');
    $slider = new SliderModel();
    $files = $this->request->getFile('img');
    if ($files->getClientExtension() == "") {
      session()->setFlashdata('error', 'Foto harus diisi');
      return redirect()->back()->withInput();
    } elseif ($files->getClientExtension() != "jpg" && $files->getClientExtension() != "jpeg" && $files->getClientExtension() != "png") {
      session()->setFlashdata('error', 'File harus JPG atau PNG');
      return redirect()->back()->withInput();
    } else {
      $nama = str_replace(" ", "-", $this->request->getVar('nama'));
      $unik = random_string('numeric', 5);
      $nama_file = "slider_" . $nama . "_" . $unik . "." . $files->getClientExtension();

      $insert = $slider->insert([
        'nama' => $this->request->getVar('nama'),
        'deskripsi' => $this->request->getVar('deskripsi'),
        'nama_button' => $this->request->getVar('nama_button'),
        'link_button' => $this->request->getVar('link_button'),
        'img' => $nama_file
      ]);

      if ($insert) {
        $files->move('assets/uploads/slider', $nama_file);
        $ids = session()->get('user_id');
        $this->add_log($ids, "Menambah slide dengan nama : " . $this->request->getVar('nama'));
        session()->setFlashdata('success', 'Berhasil menambah slide ' . $this->request->getVar('nama'));
        return redirect()->to('/admin/informasi-slider');
      } else {
        session()->setFlashdata('error', 'Gagal insert to Database');
        return redirect()->back()->withInput();
      }
    }
  }

  public function update_slider($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    if (!$this->validate([
      'nama' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Nama Harus diisi'
        ]
      ],
    ])) {
      session()->setFlashdata('error', $this->validator->listErrors());
      return redirect()->back()->withInput();
    }

    helper('text');
    $slider = new SliderModel();
    $files = $this->request->getFile('img');

    if ($files->getClientExtension() == "") {
      $update = $slider->update($id, [
        'nama' => $this->request->getVar('nama'),
        'deskripsi' => $this->request->getVar('deskripsi'),
        'nama_button' => $this->request->getVar('nama_button'),
        'link_button' => $this->request->getVar('link_button')
        // 'img' => $nama_file
      ]);
    } elseif ($files->getClientExtension() != "jpg" && $files->getClientExtension() != "jpeg" && $files->getClientExtension() != "png") {
      session()->setFlashdata('error', 'File harus JPG atau PNG');
      return redirect()->back()->withInput();
    } else {
      $nama = str_replace(" ", "-", $this->request->getVar('nama'));
      $unik = random_string('numeric', 5);
      $nama_file = "slider_" . $nama . "_" . $unik . "." . $files->getClientExtension();

      $update = $slider->update($id, [
        'nama' => $this->request->getVar('nama'),
        'deskripsi' => $this->request->getVar('deskripsi'),
        'nama_button' => $this->request->getVar('nama_button'),
        'link_button' => $this->request->getVar('link_button'),
        'img' => $nama_file
      ]);
    }

    if ($update) {
      if ($files->getClientExtension() != "") {
        $files->move('assets/uploads/slider', $nama_file);
      }
      $ids = session()->get('user_id');
      $this->add_log($ids, "Mengubah slide dengan nama : " . $this->request->getVar('nama'));
      session()->setFlashdata('success', 'Berhasil Mengubah slide ' . $this->request->getVar('nama'));
      return redirect()->to('/admin/informasi-slider');
    } else {
      session()->setFlashdata('error', 'Gagal insert to Database');
      return redirect()->back()->withInput();
    }
  }

  public function edit_slider($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $slider = new SliderModel;
    $data['active'] = "slider";
    $data['nama_user'] = session()->get('name');
    $data['model'] = $slider->find($id);
    return view('admin/informasi/form_slider', $data);
  }
}
