<?php

namespace App\Controllers\Pages;

use App\Models\KotaModel;
use App\Models\LoginAttemptModel;
use App\Models\PelakuUsahaModel;
use App\Models\ProvinsiModel;
use CodeIgniter\Controller;
use Config\LoginConfig;

class Registrasi extends Controller
{
  function __construct()
  {
    $this->loginConfig = new LoginConfig();
    $this->loginAttemptModel = new LoginAttemptModel();
    helper('utility');
  }
  public function index()
  {
    $provinsi = new ProvinsiModel();
    $pelaku_usaha = new PelakuUsahaModel();
    $kota = new KotaModel();
    $id_params = $this->request->getGet('id');
    if (session()->get('logged_in')) {
      $data['model_cek'] = null;
      $data['pesan'] = "Anda sudah melakukan registrasi";
    } elseif (isset($id_params)) {
      $data['showKodeRegis'] = 'true';
      $data['model'] = $pelaku_usaha->find($id_params);
      if (session()->get('logged_in')) {
        $data['model_cek'] = null;
        $data['pesan'] = "Anda sudah melakukan registrasi";
      } else {
        if ($data['model'] == null) {
          $data['model_cek'] = null;
          $data['pesan'] = "Mohon Maaf Halaman Tidak Ada";
        } else {
          if ($data['model']->status_registrasi > 0) {
            $data['model_cek'] = null;
            $data['pesan'] = "Mohon Maaf Halaman Tidak Ada";
          } else {
            $data['kabkot'] = $kota->where('id_provinsi', $data['model']->id_provinsi)->findAll();
            $data['tab_active'] = "kode_regis";
            $data['model_cek'] = "notnull";
            $data['id'] = $id_params;
          }
        }
      }
    } else {
      $data['tab_active'] = "regispelaku";
      $data['model_cek'] = "notnull";
    }
    $data['active'] = "register";
    $data['provinsi'] = $provinsi->orderBy('id_provinsi', 'ASC')->findAll();
    $data['view'] = 'pages/registrasi/index';
    return view('layouts/app', $data);
  }

  public function store()
  {
    if (session()->get('logged_in')) {
      return redirect()->to('login')->with('error', 'Anda telah terdaftar');
    }

    $pelaku = new PelakuUsahaModel();
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
        'rules' => 'required|is_unique[pelaku_usaha.email]',
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
    $attempts = $this->loginAttemptModel->getAttemptCount('registrasi', $ipAddress, $timeLimit);
    if ($attempts >= $this->loginConfig->maxAttempts) {
      session()->setFlashdata('error', 'Anda telah melakukan pendaftaran terlalu sering dalam waktu yang dekat, silakan coba beberapa saat lagi');
      return redirect()->back()->withInput();
    }
    if ($status['success']) {
      $kodeRegis = getSecretCode(5);
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
        'no_reg' => $kodeRegis,
        'insert_date' => date('Y-m-d H:i:s')
      ];

      $files = $this->request->getFile('identitas');
      $file_ext = $files->getClientExtension();
      if ($file_ext == "jpg" || $file_ext == "jpeg" || $file_ext == "png") {
        $nama_pimpinan = str_replace(" ", "-", $data['nama_pimpinan']);
        $nama_file = "registrasi_" . $nama_pimpinan . "_" . $kodeRegis . "." . $file_ext;
        $files->move('assets/uploads/ktp', $nama_file);
        $data['identitas'] = $nama_file;
      }

      $ins = $pelaku->insert($data);
      if ($ins) {
        $this->loginAttemptModel->recordAttempt('registrasi', $ipAddress);
        $user_id = $pelaku->getInsertID();
        $send = $this->sendMailKodeRegis($kodeRegis, $data['email'], $user_id);
        if ($send) {
          return redirect()->to('pages/registrasi?id=' . $user_id);
        } else {
          session()->setFlashdata('error', 'Gagal insert db');
          return redirect()->back()->withInput();
        }
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

  public function update($id_params)
  {
    $status = captcha_validation($this->request->getPost('g-recaptcha-response'));
    $ipAddress = $this->request->getIPAddress();
    $timeLimit = date('Y-m-d H:i:s', time() - $this->loginConfig->lockoutTime);
    $attempts = $this->loginAttemptModel->getAttemptCount('registrasi_' . $id_params, $ipAddress, $timeLimit);
    if ($attempts >= $this->loginConfig->maxAttempts) {
      return redirect()->to('auth/locked');
    }
    if ($status['success']) {
      $pelaku_usaha = new PelakuUsahaModel();
      $kode_regis = $this->request->getPost('no_reg');
      $cek = $pelaku_usaha->find($id_params);
      if ($cek && $cek->no_reg == $kode_regis) {
        $password = getSecretCode(8);
        $update = $pelaku_usaha->update($id_params, ['status_registrasi' => 1, 'password' => md5($password)]);
        if ($update) {
          $this->sendMailUserLogin($password, $cek->email);
          add_log($cek->id_pelaku, "Login Aplikasi");
          session()->set([
            'user_id' => $cek->id_pelaku,
            'username' => $cek->nama_pimpinan,
            'name' => $cek->nama_usaha,
            'level' => 3,
            'logged_in' => TRUE
          ]);
        }
        $this->loginAttemptModel->clearAttempts('registrasi_' . $id_params, $ipAddress);
        return redirect()->to(base_url('user/profile'));
      } else {
        $this->loginAttemptModel->recordAttempt('registrasi_' . $id_params, $ipAddress);
        session()->setFlashdata('errorcek', 'Kode Registrasi Salah');
        return redirect()->back()->withInput();
      }
    }
  }
  private function sendMailKodeRegis($kodeRegis, $emailregis, $user_id)
  {
    if (!session()->get('logged_in') || !in_array(session()->get('level'), [3])) {
      return redirect()->to('login')->with('error', 'Anda tidak memiliki akses halaman yang diminta.');
    }
    $message = "Kepada Yth Bpk/Ibu\ndi Tempat\n\nTerima kasih telah melakukan pendaftaran pada Etalase Produk UMKM. Berikut kami sampaikan Kode Registrasi Perusahaan Anda\n\nKode Registrasi : " . $kodeRegis . "\nLink Aktivasi Pendaftaran adalah : \nhttps://portal-indonesia.id/register?id=" . $user_id . " \n\nKode Registrasi adalah bersifat Rahasia, mohon untuk tidak diberitahukan kepada pihak yang tidak berkepentingan. \n\nTerima kasih \nOperator\nEmail : info@portal-indonesia.id ";
    $email = \Config\Services::email();
    $email->setFrom('info@portal-indonesia.id', 'Portal Nasional Pusat Informasi Produk Indonesia');
    $email->setTo($emailregis);
    $email->setSubject('Etalase Produk UMKM Indonesia - Kode Registrasi');
    $email->setMessage($message);
    $email->send();
    if ($email->send(false)) {
      return false;
    } else {
      return true;
    }
  }

  private function sendMailUserLogin($password, $emailregis)
  {
    $message = "Terimakasih telah melakukan Registrasi, silahkan login dengan menggunakan email anda dan password " . $password;
    $email = \Config\Services::email();
    $email->setFrom('info@portal-indonesia.id', 'Portal Nasional Pusat Informasi Produk Indonesia');
    $email->setTo($emailregis);
    $email->setSubject('Etalase Produk UMKM Indonesia - Registrasi Berhasil');
    $email->setMessage($message);
    $email->send();
  }
}
