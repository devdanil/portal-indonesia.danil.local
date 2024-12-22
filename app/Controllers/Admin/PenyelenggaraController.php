<?php

namespace App\Controllers\Admin;

use App\Models\PenyelanggaraModels;

class PenyelenggaraController extends Log
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
    $penyelenggara = new PenyelanggaraModels;
    $id = session()->get('user_id');
    $data['nama_user'] = session()->get('name');
    $data['active'] = "penyelenggara";
    $data['penyelenggara'] = $penyelenggara->orderBy('penyelenggara.id_penyelenggara')->findAll();
    $this->add_log($id, "Melihat menu penyelenggara");
    return view('admin/informasi/penyelenggara', $data);
  }

  public function hapus_penyelenggara($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $penyelenggara = new PenyelanggaraModels();
    $ids = session()->get('user_id');
    $penyelenggara->delete($id);
    $this->add_log($ids, "Menghapus penyelenggara dengan ID : " . $id);
    return redirect()->to('/admin/informasi-penyelenggara');
  }

  public function tambah_penyelenggara()
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $data['active'] = "penyelenggara";
    $data['nama_user'] = session()->get('name');
    $ids = session()->get('user_id');
    $this->add_log($ids, "Membuka form tambah penyelenggara");
    return view('admin/informasi/form_penyelenggara', $data);
  }

  public function save_penyelenggara()
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    helper('text');
    if (!$this->validate([
      'nama' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi'
        ]
      ],
      'deskripsi' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi',
        ]
      ],
      'alamat' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi',
        ]
      ],
      'kontak' => [
        'rules' => 'required|numeric',
        'errors' => [
          'required' => '{field} Harus diisi',
          'numeric' => '{field} Harus angka',
        ]
      ],
    ])) {
      session()->setFlashdata('error', $this->validator->listErrors());
      return redirect()->back()->withInput();
    }

    $ids = session()->get('user_id');
    $penyelenggara = new PenyelanggaraModels();
    $penyelenggara->insert([
      'nama' => $this->request->getVar('nama'),
      'deskripsi' => $this->request->getVar('deskripsi'),
      'alamat' => $this->request->getVar('alamat'),
      'kontak' => $this->request->getVar('kontak'),
      'inserted_by' => $ids,
      'created_at' => date("Y-m-d H:i:s"),
      'update_at' => date("Y-m-d H:i:s")
    ]);

    session()->setFlashdata('success', 'Berhasil menambah penyelenggara ' . $this->request->getVar('nama'));
    $this->add_log($ids, "Menambah penyelenggara dengan nama : " . $this->request->getVar('nama'));
    return redirect()->to('/admin/informasi-penyelenggara');
  }

  public function update_penyelenggara($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    helper('text');
    if (!$this->validate([
      'nama' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi'
        ]
      ],
      'deskripsi' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi',
        ]
      ],
      'alamat' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi',
        ]
      ],
      'kontak' => [
        'rules' => 'required|numeric',
        'errors' => [
          'required' => '{field} Harus diisi',
          'numeric' => '{field} Harus angka',
        ]
      ],
    ])) {
      session()->setFlashdata('error', $this->validator->listErrors());
      return redirect()->back()->withInput();
    }

    $penyelenggara = new PenyelanggaraModels();
    $penyelenggara->update($id, [
      'nama' => $this->request->getVar('nama'),
      'deskripsi' => $this->request->getVar('deskripsi'),
      'alamat' => $this->request->getVar('alamat'),
      'kontak' => $this->request->getVar('kontak'),
      'update_at' => date("Y-m-d H:i:s")
    ]);

    $ids = session()->get('user_id');
    session()->setFlashdata('success', 'Berhasil merubah penyelenggara ' . $this->request->getVar('nama'));
    $this->add_log($ids, "Mengedit penyelenggara dengan nama : " . $this->request->getVar('nama'));
    return redirect()->to('/admin/informasi-penyelenggara');
  }

  public function edit_penyelenggara($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $penyelenggara = new PenyelanggaraModels;
    $data['active'] = "penyelenggara";
    $data['nama_user'] = session()->get('name');
    $data['model'] = $penyelenggara->find($id);
    $ids = session()->get('user_id');
    $this->add_log($ids, "Membuka form edit Penyelanggara dengan ID: " . $id);
    return view('admin/informasi/form_penyelenggara', $data);
  }
}
