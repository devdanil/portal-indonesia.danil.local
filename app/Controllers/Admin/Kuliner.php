<?php

namespace App\Controllers\Admin;

use App\Models\KulinerModel;
use App\Models\ProvinsiModel;
use App\Models\KotaModel;
use App\Models\SubKategoriModel;

class Kuliner extends Log
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
    $kuliner = new KulinerModel;
    $data['nama_user'] = session()->get('name');
    $data['active'] = "kuliner";
    $data['kuliner'] = $kuliner->select('kuliner.*, mst_kota.nama as nama_kota, provinsi.nama_provinsi')
      ->join('mst_kota', 'mst_kota.id = kuliner.id_kota')
      ->join('provinsi', 'provinsi.id_provinsi = kuliner.id_provinsi')
      ->findAll();
    return view('admin/informasi/kuliner', $data);
  }

  public function hapus_kuliner($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $kuliner = new KulinerModel();
    $ids = session()->get('user_id');

    $kuliner->delete($id);
    $this->add_log($ids, "Menghapus kuliner dengan ID : " . $id);
    session()->setFlashdata('success', 'Berhasil menghapus kuliner');
    return redirect()->to('/admin/kuliner');
  }

  public function tambah_kuliner()
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $provinsi = new ProvinsiModel;
    $kategori = new SubKategoriModel();
    $data['kategori'] = $kategori->where('id_kategori', '1')->findAll();
    $data['active'] = "kuliner";
    $data['nama_user'] = session()->get('name');
    $data['provinsi'] = $provinsi->orderBy("id_provinsi", "ASC")->findAll();
    return view('admin/informasi/form_kuliner', $data);
  }

  public function save_kuliner()
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    if (!$this->validate([
      'nama' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi'
        ]
      ],
      'alamat' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Alamat Harus diisi',
        ]
      ],
      'jam_buka' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Jam Buka Harus diisi',
        ]
      ],
      'jam_tutup' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Jam Tutup Harus diisi',
        ]
      ],
      'deskripsi' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Deskripsi Harus diisi',
        ]
      ],
      'id_provinsi' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Provinsi Harus diisi',
        ]
      ],
      'id_kota' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Kota Harus diisi',
        ]
      ],
      'kategori' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Kategori Harus diisi',
        ]
      ],
    ])) {
      session()->setFlashdata('error', $this->validator->listErrors());
      return redirect()->back()->withInput();
    }

    helper('text');
    $files = $this->request->getFile('image');
    if ($files->getClientExtension() == "") {
      session()->setFlashdata('error', 'Gambar Harus di Isi!');
      return redirect()->back()->withInput();
    } elseif ($files->getClientExtension() != "jpg" && $files->getClientExtension() != "jpeg" && $files->getClientExtension() != "png") {
      session()->setFlashdata('error', 'File harus JPG atau PNG');
      return redirect()->back()->withInput();
    } else {
      $judul = str_replace(" ", "-", $this->request->getVar('nama'));
      $unik = random_string('numeric', 5);
      $nama_file = "kuliner_" . $judul . "_" . $unik . "." . $files->getClientExtension();
      $files->move('assets/uploads/kuliner', $nama_file);

      $ids = session()->get('user_id');
      $kuliner = new KulinerModel();
      if ($this->request->getVar('instagram') == "") {
        $instagram = $this->request->getVar('instagram');
      } else {
        $instagram = "";
      }

      if ($this->request->getVar('facebook') == "") {
        $facebook = $this->request->getVar('facebook');
      } else {
        $facebook = "";
      }

      if ($this->request->getVar('instagram') == "") {
        $maps = $this->request->getVar('maps');
      } else {
        $maps = "";
      }

      $kuliner->insert([
        'nama' => $this->request->getVar('nama'),
        'alamat' => $this->request->getVar('alamat'),
        'jam_buka' => $this->request->getVar('jam_buka'),
        'jam_tutup' => $this->request->getVar('jam_tutup'),
        'deskripsi' => $this->request->getVar('deskripsi'),
        'id_provinsi' => $this->request->getVar('id_provinsi'),
        'id_kota' => $this->request->getVar('id_kota'),
        'kategori' => $this->request->getVar('kategori'),
        'instagram' => $instagram,
        'facebook' => $facebook,
        'maps' => $maps,
        'image' => $nama_file
      ]);

      if ($kuliner) {
        $this->add_log($ids, "Menambah kuliner dengan nama : " . $this->request->getVar('nama'));
        session()->setFlashdata('success', 'Berhasil Menambahkan Kuliner');
        return redirect()->to('/admin/kuliner');
      } else {
        session()->setFlashdata('error', 'Gagal menyimpan data kuliner');
        return redirect()->back()->withInput();
      }
    }
  }

  public function update_kuliner($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    if (!$this->validate([
      'nama' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi'
        ]
      ],
      'alamat' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Alamat Harus diisi',
        ]
      ],
      'jam_buka' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Jam Buka Harus diisi',
        ]
      ],
      'jam_tutup' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Jam Tutup Harus diisi',
        ]
      ],
      'deskripsi' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Deskripsi Harus diisi',
        ]
      ],
      'id_provinsi' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Provinsi Harus diisi',
        ]
      ],
      'id_kota' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Kota Harus diisi',
        ]
      ],
      'kategori' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Kategori Harus diisi',
        ]
      ],
    ])) {
      session()->setFlashdata('error', $this->validator->listErrors());
      return redirect()->back()->withInput();
    }

    helper('text');
    $files = $this->request->getFile('image');
    $ids = session()->get('user_id');
    $kuliner = new KulinerModel();
    if ($this->request->getVar('instagram') == "") {
      $instagram = $this->request->getVar('instagram');
    } else {
      $instagram = "";
    }

    if ($this->request->getVar('facebook') == "") {
      $facebook = $this->request->getVar('facebook');
    } else {
      $facebook = "";
    }

    if ($this->request->getVar('instagram') == "") {
      $maps = $this->request->getVar('maps');
    } else {
      $maps = "";
    }

    if ($files->getClientExtension() == "") {
      $kuliner->update($id, [
        'nama' => $this->request->getVar('nama'),
        'alamat' => $this->request->getVar('alamat'),
        'jam_buka' => $this->request->getVar('jam_buka'),
        'jam_tutup' => $this->request->getVar('jam_tutup'),
        'deskripsi' => $this->request->getVar('deskripsi'),
        'id_provinsi' => $this->request->getVar('id_provinsi'),
        'id_kota' => $this->request->getVar('id_kota'),
        'kategori' => $this->request->getVar('kategori'),
        'instagram' => $instagram,
        'facebook' => $facebook,
        'maps' => $maps
      ]);

      if ($kuliner) {
        $this->add_log($ids, "Mengubah kuliner dengan nama : " . $this->request->getVar('nama'));
        session()->setFlashdata('success', 'Berhasil Mengubah Kuliner');
        return redirect()->to('/admin/kuliner');
      } else {
        session()->setFlashdata('error', 'Gagal menyimpan data kuliner');
        return redirect()->back()->withInput();
      }
    } elseif ($files->getClientExtension() != "jpg" && $files->getClientExtension() != "jpeg" && $files->getClientExtension() != "png") {
      session()->setFlashdata('error', 'File harus JPG atau PNG');
      return redirect()->back()->withInput();
    } else {
      $judul = str_replace(" ", "-", $this->request->getVar('nama'));
      $unik = random_string('numeric', 5);
      $nama_file = "kuliner_" . $judul . "_" . $unik . "." . $files->getClientExtension();
      $files->move('assets/uploads/kuliner', $nama_file);

      $kuliner->update($id, [
        'nama' => $this->request->getVar('nama'),
        'alamat' => $this->request->getVar('alamat'),
        'jam_buka' => $this->request->getVar('jam_buka'),
        'jam_tutup' => $this->request->getVar('jam_tutup'),
        'deskripsi' => $this->request->getVar('deskripsi'),
        'id_provinsi' => $this->request->getVar('id_provinsi'),
        'id_kota' => $this->request->getVar('id_kota'),
        'kategori' => $this->request->getVar('kategori'),
        'instagram' => $instagram,
        'facebook' => $facebook,
        'maps' => $maps,
        'image' => $nama_file
      ]);

      if ($kuliner) {
        $this->add_log($ids, "Mengubah kuliner dengan nama : " . $this->request->getVar('nama'));
        session()->setFlashdata('success', 'Berhasil Mengubah Kuliner');
        return redirect()->to('/admin/kuliner');
      } else {
        session()->setFlashdata('error', 'Gagal menyimpan data kuliner');
        return redirect()->back()->withInput();
      }
    }
  }

  public function edit_kuliner($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $kuliner = new KulinerModel;
    $provinsi = new ProvinsiModel;
    $kota = new KotaModel();
    $kategori = new SubKategoriModel();
    $data['kategori'] = $kategori->where('id_kategori', '1')->findAll();
    $data['active'] = "kuliner";
    $data['nama_user'] = session()->get('name');
    $data['model'] = $kuliner->find($id);
    $data['provinsi'] = $provinsi->orderBy("id_provinsi", "ASC")->findAll();
    $data['kabkot'] = $kota->where('id_provinsi', $data['model']->id_provinsi)->findAll();
    return view('admin/informasi/form_kuliner', $data);
  }
}
