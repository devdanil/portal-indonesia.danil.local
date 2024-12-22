<?php

namespace App\Controllers\User;

use App\Models\KategoriModel;
use App\Models\KotaModel;
use App\Models\LoginAttemptModel;
use App\Models\PelakuUsahaModel;
use App\Models\ProdukModel;
use App\Models\ProvinsiModel;
use App\Models\SubKategoriModel;
use CodeIgniter\Controller;
use Config\LoginConfig;

class Profile extends Controller
{
  function __construct()
  {
    $this->loginConfig = new LoginConfig();
    $this->loginAttemptModel = new LoginAttemptModel();
    helper('utility');
  }
  public function index()
  {
    if (!can_access([3])) {
      return redirect()->to(base_url());
    }
    $pelaku_usaha = new PelakuUsahaModel();
    $provinsi = new ProvinsiModel();
    $kota = new KotaModel();
    $produk = new ProdukModel();
    $kategori = new KategoriModel();
    $subkategori = new SubKategoriModel();
    $id_pelaku = session()->get('user_id');
    $request = service('request');
    $data['produk'] = $produk->select([
      'produk.id_produk',
      'produk.id_kategori',
      'produk.nama_produk',
      'produk.foto_produk',
      'produk.status',
      'kategori_produk.kategori',
      'pelaku_usaha.jenis_usaha',
      'pelaku_usaha.email',
      'pelaku_usaha.handphone'
    ])
      ->join('kategori_produk', 'kategori_produk.id_kategori = produk.id_kategori')
      ->join('pelaku_usaha', 'pelaku_usaha.id_pelaku = produk.id_pelaku_usaha')
      ->where('produk.id_pelaku_usaha', $id_pelaku)
      // ->where('produk.status', 1)
      ->paginate(3);

    $data['model'] = $pelaku_usaha->find($id_pelaku);
    $data['kabkot'] = $kota->where('id_provinsi', $data['model']->id_provinsi)->findAll();
    if ($data['model']->status_registrasi == 2) {
      $data['showRegisProduk'] = 'true';
      $data['tab_active'] = "regisproduk";
    } elseif ($data['model']->status_registrasi == 1) {
      $data['tab_active'] = "regispelaku";
    }
    $data['status_registrasi'] = $data['model']->status_registrasi;
    $data['kode_regis'] = $data['model']->no_reg;
    $data['id'] = $id_pelaku;
    $data['active'] = "logging_in";
    $data['provinsi'] = $provinsi->orderBy('id_provinsi', 'ASC')->findAll();
    $data['kategori'] = $kategori->findAll();
    $data['pager'] = $produk->pager;
    $edit_params = $request->getGet('edit');

    if (isset($edit_params) && $edit_params != "") {
      $produknya = $produk->where('id_produk', $edit_params)->where('id_pelaku_usaha', $id_pelaku)->first();
      if ($produknya) {
        $data['edit'] = $produk->find($edit_params);
        $data['subkategori'] = $subkategori->where('id_kategori', $produknya->id_kategori)->findAll();
      } else {
        session()->setFlashdata('errorproduk', 'Bukan Produk Anda!');
      }
    }
    $data['view'] = 'user/profile';
    return view('layouts/app', $data);
  }

  public function change_password()
  {
    if (!can_access([3])) {
      return redirect()->to(base_url());
    }
    $id_pelaku = session()->get('user_id');
    $pelaku_usaha = new PelakuUsahaModel();
    $password = $this->request->getVar('password');
    if (!$this->validate([
      'password' => [
        'rules' => 'required|min_length[8]|max_length[50]',
        'errors' => [
          'required' => 'Password Harus diisi',
          'is_unique' => 'Password Anda sama dengan sebelumnya',
          'min_length' => '{field} Minimal 8 Karakter',
          'max_length' => '{field} Maksimal 50 Karakter',
        ]
      ],
    ])) {
      session()->setFlashdata('error', $this->validator->listErrors());
      return redirect()->back()->withInput();
    }

    $pelaku_usaha->update($id_pelaku, [
      'password' => md5($password),
    ]);

    add_log($id_pelaku, "Mengubah Password User dengan ID Pelaku Usaha : " . $id_pelaku);
    return redirect()->to('auth/logout');
  }

  public function update()
  {
    $pelaku = new PelakuUsahaModel();
    $user = $pelaku->where('id_pelaku', session()->get('user_id'))->first();
    if (!can_access([3]) || !$user) {
      return redirect()->to(base_url());
    }

    if (!$this->validate([
      'nama_usaha' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Nama Kelompok Usaha/Perusahaan Harus diisi',
        ]
      ],
      'nama_pimpinan' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Nama Penanggung Jawab Harus diisi',
        ]
      ],
      'nik_pimpinan' => [
        'rules' => 'required|min_length[16]|max_length[16]',
        'errors' => [
          'required' => 'NIK (No.KTP Penanggung Jawab) Harus diisi',
          'min_length' => 'NIK (No.KTP Penanggung Jawab) Harus 16 Karakter',
          'max_length' => 'NIK (No.KTP Penanggung Jawab) Harus 16 Karakter',
        ]
      ],
      'alamat' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Alamat Usaha Harus diisi',
        ]
      ],
      'kekayaan' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Kekayaan Bersih yang dimiliki Harus diisi',
        ]
      ],
      'jenis_usaha' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Jenis Usaha Harus diisi',
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
          'required' => 'Kota / Kabupaten Harus diisi'
        ]
      ],
      'handphone' => [
        'rules' => 'required|numeric',
        'errors' => [
          'required' => 'Spesifikasi Harus diisi',
          'numeric' => 'handphone Harus angka',
        ]
      ],
      'email' => [
        'rules' => 'required|is_unique[pelaku_usaha.email,id_pelaku,' . $user->id_pelaku . ']',
        'errors' => [
          'required' => 'Email Harus diisi',
          'is_unique' => 'Email sudah digunakan',
        ]
      ],
      'setuju' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Pernyataan Harus diisi',
        ]
      ],
    ])) {
      session()->setFlashdata('error', $this->validator->listErrors());
      return redirect()->back()->withInput();
    }
    $jenis_usaha = $this->request->getVar('jenis_usaha');
    if (is_array($jenis_usaha)) {
      $jenis_usaha = implode(",", $jenis_usaha);
    }
    $status = captcha_validation($this->request->getPost('g-recaptcha-response'));
    $ipAddress = $this->request->getIPAddress();
    $timeLimit = date('Y-m-d H:i:s', time() - $this->loginConfig->lockoutTime);
    $attempts = $this->loginAttemptModel->getAttemptCount('update_profile', $ipAddress, $timeLimit);
    if ($attempts >= $this->loginConfig->maxAttempts) {
      session()->setFlashdata('error', 'Anda telah melakukan mengubah data terlalu sering dalam waktu yang dekat, silakan coba beberapa saat lagi');
      return redirect()->back()->withInput();
    }
    if ($status['success']) {
      $data = [
        'nama_pimpinan' => $this->request->getVar('nama_pimpinan'),
        'no_izin_pirt' => $this->request->getVar('no_izin_pirt'),
        'nama_usaha' => $this->request->getVar('nama_usaha'),
        'nik_pimpinan' => $this->request->getVar('nik_pimpinan'),
        'alamat' => $this->request->getVar('alamat'),
        'kekayaan' => $this->request->getVar('kekayaan'),
        'jenis_usaha' => $jenis_usaha,
        'id_provinsi' => $this->request->getVar('id_provinsi'),
        'id_kota' => (int)$this->request->getVar('id_kota'),
        'kode_pos' => $this->request->getVar('kode_pos'),
        'telpon' => $this->request->getVar('telpon'),
        'handphone' => $this->request->getVar('handphone'),
        'email' => $this->request->getVar('email'),
        'website' => $this->request->getVar('website'),
      ];
      $files = $this->request->getFile('identitas');
      $file_ext = $files->getClientExtension();
      if ($file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "png") {
        $nama_pimpinan = str_replace(" ", "-", $data['nama_pimpinan']);
        $nama_file = "registrasi_" . $nama_pimpinan . "_" . $user->no_regis . "." . $file_ext;
        $files->move('assets/uploads/ktp', $nama_file);
        $data['identitas'] = $nama_file;
      }

      $update = $pelaku->update($user->id_pelaku, $data);
      if ($update) {
        $this->loginAttemptModel->recordAttempt('update_profile', $ipAddress);
        session()->setFlashdata('error', 'Data berhasil diubah');
        return redirect()->to(base_url('user/profile'));
      } else {
        session()->setFlashdata('error', 'Gagal insert db');
        return redirect()->back()->withInput();
      }
    } else {

      session()->setFlashdata('error', 'Captcha belum benar!');
      return redirect()->back()->withInput();
    }

    // $this->add_log("Regsitrasi dengan nama : ".$this->request->getVar('nama_usaha'));
  }
  public function store_produk()
  {
    $pelaku_usaha = new PelakuUsahaModel();
    $ids = session()->get('user_id');
    $pelaku = $pelaku_usaha->find($ids);
    if (!can_access([3]) || !$pelaku) {
      return redirect()->to(base_url());
    }
    helper('text');
    $produk = new ProdukModel();

    if (!$this->validate([
      'kategori' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi',
        ]
      ],
      'subkategori' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi',
        ]
      ],
      'nama_produk' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Nama Produk Harus diisi',
        ]
      ],
      'spesifikasi_in' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Spesifikasi Harus diisi',
        ]
      ],
      // 'spesifikasi_en' => [
      //     'rules' => 'required',
      //     'errors' => [
      //         'required' => 'Spesifikasi dalam bahasa inggris Harus diisi',
      //     ]
      // ],
      'kapasitas_produksi' => [
        'rules' => 'required|numeric',
        'errors' => [
          'required' => 'Kapasitas Produksi Perbulan (Volume) Harus diisi',
          'numeric' => 'Kapasitas Produksi Perbulan (Volume) Harus angka',
        ]
      ],
      'satuan_kapasitas' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Satuan Kapasitas Produksi Perbulan Harus diisi',
        ]
      ],
      'tkdn' => [
        'rules' => 'required|numeric',
        'errors' => [
          'required' => '{field} Harus diisi',
          'numeric' => '{field} Harus angka',
        ]
      ],
      'setuju' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Pernyataan Harus diisi',
        ]
      ],
      'foto_produk' => [
        'rules' => 'uploaded[foto_produk]|is_image[foto_produk]|ext_in[foto_produk,png,jpg]',
        'errors' => [
          'required' => 'Foto Harus diisi',
        ]
      ],
    ])) {
      session()->setFlashdata('error_cek', $this->validator->listErrors());
      return redirect()->back()->withInput();
    }


    $status = captcha_validation($this->request->getPost('g-recaptcha-response'));

    if ($this->request->getPost('kategori') == 1 && $this->request->getPost('jenis_makanan') == "") {
      session()->setFlashdata('error_cek', "Sertifikasi Halal Harus di Isi");
      return redirect()->back()->withInput();
    } elseif ($this->request->getPost('kategori') == 1 && $this->request->getPost('jenis_makanan') != "") {
      $jenis_makanan = $this->request->getPost('jenis_makanan');
    } else {
      $jenis_makanan = "";
    }

    if ($this->request->getPost('kategori') == 1 && $this->request->getPost('jenis_makanan') == "Bersertifikasi Halal" && $this->request->getPost('no_halal') == "") {
      session()->setFlashdata('error_cek', "No. Sertifikasi Halal Harus di Isi");
      return redirect()->back()->withInput();
    } elseif ($this->request->getPost('kategori') == 1 && $this->request->getPost('jenis_makanan') == "Bersertifikasi Halal" && $this->request->getPost('no_halal') != "") {
      $no_halal = $this->request->getPost('no_halal');
    } else {
      $no_halal = "";
    }

    if ($status['success']) {
      $files = $this->request->getFile('foto_produk');
      $nama_produk = str_replace(" ", "-", $this->request->getPost('nama_produk'));
      $unik = random_string('numeric', 5);
      $nama_file = "produk_" . $nama_produk . "_" . $unik . "." . $files->getClientExtension();
      $files->move('assets/uploads', $nama_file);
      $data = [
        'id_kategori' => $this->request->getPost('kategori'),
        'id_sub' => $this->request->getPost('subkategori'),
        'id_pelaku_usaha' => $ids,
        'nama_produk' => $this->request->getPost('nama_produk'),
        'jenis_makanan' => $jenis_makanan,
        'no_halal' => $no_halal,
        'deskripsi_in' => $this->request->getPost('deskripsi_in'),
        'deskripsi_en' => $this->request->getPost('deskripsi_en'),
        'spesifikasi_in' => $this->request->getPost('spesifikasi_in'),
        'spesifikasi_en' => $this->request->getPost('spesifikasi_en'),
        'kapasitas_produksi' => $this->request->getPost('kapasitas_produksi'),
        'satuan_kapasitas' => $this->request->getPost('satuan_kapasitas'),
        'tkdn' => $this->request->getPost('tkdn'),
        'no_registrasi' => $pelaku->no_reg,
        'tahun_reg' => date('Y'),
        'foto_produk' => $nama_file,
        'id_provinsi' => $pelaku->id_provinsi,
        'id_kota' => $pelaku->id_kota,
        'insert_date' => date('Y-m-d H:i:s')
      ];
      $produk->insert($data);

      add_log($ids, "Menambah produk dengan nama : " . $data['nama_produk']);
      session()->setFlashdata('sukses', 'Berhasil menambahkan produk ' . $data['nama_produk'] . '. Produk akan muncul di etalase setelah diverifikasi oleh admin. Terimakasih!');
      return redirect()->to(base_url('user/profile'));
    } else {
      session()->setFlashdata('error_cek', 'Captcha belum benar!');
      return redirect()->back()->withInput();
    }
  }

  public function update_produk($id_produk)
  {
    $pelaku_usaha = new PelakuUsahaModel();
    $produk = new ProdukModel();
    $ids = session()->get('user_id');
    $pelaku = $pelaku_usaha->find($ids);
    $check_produk = $produk->where('id_pelaku_usaha', $ids)->where('id_produk', $id_produk)->first();
    if (!can_access([3]) || !$pelaku || !$check_produk) {
      return redirect()->to(base_url());
    }
    helper('text');

    if (!$this->validate([
      'kategori' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi',
        ]
      ],
      'subkategori' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Harus diisi',
        ]
      ],
      'nama_produk' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Nama Produk Harus diisi',
        ]
      ],
      /* 'spesifikasi_in' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Spesifikasi Harus diisi',
                ]
            ], */
      'kapasitas_produksi' => [
        'rules' => 'required|numeric',
        'errors' => [
          'required' => 'Kapasitas Produksi Perbulan (Volume) Harus diisi',
          'numeric' => 'Kapasitas Produksi Perbulan (Volume) Harus angka',
        ]
      ],
      'satuan_kapasitas' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Satuan Kapasitas Produksi Perbulan Harus diisi',
        ]
      ],
      'tkdn' => [
        'rules' => 'required|numeric',
        'errors' => [
          'required' => '{field} Harus diisi',
          'numeric' => '{field} Harus angka',
        ]
      ],
      'setuju' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Pernyataan Harus diisi',
        ]
      ],
    ])) {
      session()->setFlashdata('error_cek', $this->validator->listErrors());
      return redirect()->back()->withInput();
    }


    $status = captcha_validation($this->request->getPost('g-recaptcha-response'));

    if ($this->request->getPost('kategori') == 1 && $this->request->getPost('jenis_makanan') == "") {
      session()->setFlashdata('error_cek', "Jenis Makanan Harus di Isi");
      return redirect()->back()->withInput();
    } elseif ($this->request->getPost('kategori') == 1 && $this->request->getPost('jenis_makanan') != "") {
      $jenis_makanan = $this->request->getPost('jenis_makanan');
    } else {
      $jenis_makanan = "";
    }

    if ($this->request->getPost('kategori') == 1 && $this->request->getPost('jenis_makanan') == "Bersertifikasi Halal" && $this->request->getPost('no_halal') == "") {
      session()->setFlashdata('error_cek', "No. Sertifikasi Halal Harus di Isi");
      return redirect()->back()->withInput();
    } elseif ($this->request->getPost('kategori') == 1 && $this->request->getPost('jenis_makanan') == "Bersertifikasi Halal" && $this->request->getPost('no_halal') != "") {
      $no_halal = $this->request->getPost('no_halal');
    } else {
      $no_halal = "";
    }

    if ($status['success']) {
      $files = $this->request->getFile('foto_produk');
      $data = [
        'id_kategori' => $this->request->getPost('kategori'),
        'id_sub' => $this->request->getPost('subkategori'),
        'id_pelaku_usaha' => $ids,
        'nama_produk' => $this->request->getPost('nama_produk'),
        'jenis_makanan' => $jenis_makanan,
        'no_halal' => $no_halal,
        'deskripsi_in' => $this->request->getPost('deskripsi_in'),
        'deskripsi_en' => $this->request->getPost('deskripsi_en'),
        'spesifikasi_in' => $this->request->getPost('spesifikasi_in'),
        'spesifikasi_en' => $this->request->getPost('spesifikasi_en'),
        'kapasitas_produksi' => $this->request->getPost('kapasitas_produksi'),
        'satuan_kapasitas' => $this->request->getPost('satuan_kapasitas'),
        'tkdn' => $this->request->getPost('tkdn'),
        'no_registrasi' => $pelaku->no_reg,
        'tahun_reg' => date('Y'),
        // 'foto_produk' => $nama_file,
        'id_provinsi' => $pelaku->id_provinsi,
        'id_kota' => $pelaku->id_kota,
        'insert_date' => date('Y-m-d H:i:s')
      ];

      $file_ext = $files->getClientExtension();
      if ($file_ext && ($file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "png")) {
        $nama_produk = str_replace(" ", "-", $this->request->getPost('nama_produk'));
        $unik = random_string('numeric', 5);
        $nama_file = "produk_" . $nama_produk . "_" . $unik . "." . $file_ext;
        $files->move('assets/uploads', $nama_file);
        $data['foto_produk'] = $nama_file;
      }
      session()->setFlashdata('sukses', 'Berhasil mengubah produk ' . $data['nama_produk']);
      $produk->update($id_produk, $data);
      return redirect()->to(base_url('user/profile'));
    } else {
      session()->setFlashdata('error', 'Captcha belum benar!');
      return redirect()->back()->withInput();
    }
  }
}
