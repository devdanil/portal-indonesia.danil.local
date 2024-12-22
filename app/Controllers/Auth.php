<?php

namespace App\Controllers;

use App\Models\LoginAttemptModel;
use CodeIgniter\Controller;
use App\Models\UsersModel;
use App\Models\PelakuUsahaModel;
use Config\LoginConfig;

class Auth extends Controller
{
  function __construct()
  {
    $this->loginConfig = new LoginConfig();
    $this->loginAttemptModel = new LoginAttemptModel();
    helper('utility');
  }

  public function login()
  {
    $data['active'] = "login";
    $data['view'] = 'auth/login';
    return view('layouts/app', $data);
  }

  public function validation()
  {
    $users = new UsersModel();
    $pelaku_usaha = new PelakuUsahaModel();
    $username = $this->request->getVar('username');
    $password = md5($this->request->getVar('password'));
    $ipAddress = $this->request->getIPAddress();
    $timeLimit = date('Y-m-d H:i:s', time() - $this->loginConfig->lockoutTime);
    $attempts = $this->loginAttemptModel->getAttemptCount($username, $ipAddress, $timeLimit);

    if ($attempts >= $this->loginConfig->maxAttempts) {
      return redirect()->to('auth/locked');
    }
    $dataUser = $users->where('username', $username)->whereIn('level', [1, 2])->first();

    $dataPelaku = $pelaku_usaha->where([
      'email' => $username,
    ])->first();



    $validCaptcha = captcha_validation($this->request->getPost('g-recaptcha-response'));
    if ($validCaptcha['success']) {
      if ($dataUser) {
        if ($password == $dataUser->password) {
          add_log($dataUser->id, "Login Aplikasi");
          session()->set([
            'user_id' => $dataUser->id,
            'username' => $dataUser->username,
            'name' => $dataUser->fullname,
            'level' => $dataUser->level,
            'logged_in' => TRUE
          ]);
          $this->loginAttemptModel->clearAttempts($username, $ipAddress);
          return redirect()->to(base_url('admin/dashboard'));
        } else {
          $this->loginAttemptModel->recordAttempt($username, $ipAddress);
          session()->setFlashdata('error', 'Username & Password Salah');
          return redirect()->back();
        }
      } elseif ($dataPelaku) {
        if ($password == $dataPelaku->password) {
          add_log($dataPelaku->id_pelaku, "Login Aplikasi");
          session()->set([
            'user_id' => $dataPelaku->id_pelaku,
            'username' => $dataPelaku->nama_pimpinan,
            'name' => $dataPelaku->nama_usaha,
            'level' => 3,
            'logged_in' => TRUE
          ]);
          $this->loginAttemptModel->clearAttempts($username, $ipAddress);
          return redirect()->to(base_url());
        } else {
          $this->loginAttemptModel->recordAttempt($username, $ipAddress);
          session()->setFlashdata('error', 'Username / Email & Password Salah');
          return redirect()->back();
        }
      } else {
        $this->loginAttemptModel->recordAttempt($username, $ipAddress);
        session()->setFlashdata('error', 'Username / Email & Password Salah');
        return redirect()->back();
      }
    } else {
      $this->loginAttemptModel->recordAttempt($username, $ipAddress);
      session()->setFlashdata('error', 'Captcha belum benar!');
      return redirect()->back()->withInput();
    }
  }

  public function logout()
  {
    if (session()->get('user_id')) {
      add_log(session()->get('user_id'), "Logout Aplikasi");
    }
    session()->destroy();
    return redirect()->to('/');
  }

  public function locked()
  {
    return view('auth/locked_out');
  }

  public function forgot()
  {
    $data = ['active' => ''];
    $data['view'] = 'auth/forgot';
    return view('layouts/app', $data);
  }

  public function reset()
  {
    $email = $this->request->getPost('email');
    $ipAddress = $this->request->getIPAddress();
    $timeLimit = date('Y-m-d H:i:s', time() - $this->loginConfig->lockoutTime);
    $attempts = $this->loginAttemptModel->getAttemptCount('reset_' . $email, $ipAddress, $timeLimit);
    if ($attempts >= $this->loginConfig->maxAttempts) {
      session()->setFlashdata('error', 'Anda telah melakukan permintaan terlalu sering dalam waktu yang dekat, silakan coba beberapa saat lagi');
      return redirect()->back()->withInput();
    }
    $validCaptcha = captcha_validation($this->request->getPost('g-recaptcha-response'));
    if ($validCaptcha['success']) {
      $pelaku = new PelakuUsahaModel();
      $cek = $pelaku->where('email', $email)->findAll();
      if (count($cek) == 0) {
        session()->setFlashdata('error', "Email anda belum terdaftar, jika ingin mendaftar silahkan klik tombol Registrasi Pelaku Usaha");

        $this->loginAttemptModel->recordAttempt('reset_' . $email, $ipAddress);
        session()->remove('tempmail');
        return redirect()->back()->withInput();
      } else {
        $secret = getSecretCode();
        $sendMail = $this->sendMailCode($secret, $email);
        if ($sendMail) {
          $id_pelaku = $pelaku->select('id_pelaku')->where('email', $email)->findAll();
          $pelaku->update($id_pelaku[0]->id_pelaku, ['security_code' => $secret]);
          session()->setFlashdata('error', "Silahkan cek email anda untuk mendapatkan kode rahasia");
          $this->loginAttemptModel->clearAttempts('reset_' . $email, $ipAddress);
          session()->set('tempmail', $email);
          session()->markAsTempdata('tempmail', 300);
          return redirect()->to(base_url('auth/code'));
        } else {
          $this->loginAttemptModel->recordAttempt('reset_' . $email, $ipAddress);
          session()->remove('tempmail');
          session()->setFlashdata('error', "Gagal mengirim email");
          return redirect()->back()->withInput();
        }
      }
    } else {
      $this->loginAttemptModel->recordAttempt('reset_' . $email, $ipAddress);
      session()->setFlashdata('error', 'Captcha belum benar!');
      return redirect()->back()->withInput();
    }
  }
  public function code()
  {
    $data = ['active' => ''];
    $data['view'] = 'auth/code';
    return view('layouts/app', $data);
  }
  function verify()
  {
    $kode = $this->request->getPost('code');
    $ipAddress = $this->request->getIPAddress();
    $tempmail = session()->get('tempmail');
    $ipAddress = $this->request->getIPAddress();
    $timeLimit = date('Y-m-d H:i:s', time() - $this->loginConfig->lockoutTime);
    $attempts = $this->loginAttemptModel->getAttemptCount('verify_' . $tempmail, $ipAddress, $timeLimit);
    if ($attempts >= $this->loginConfig->maxAttempts) {
      session()->setFlashdata('error', 'Anda telah melakukan permintaan terlalu sering dalam waktu yang dekat, silakan coba beberapa saat lagi');
      return redirect()->back()->withInput();
    }
    $validCaptcha = captcha_validation($this->request->getPost('g-recaptcha-response'));
    if ($validCaptcha['success']) {
      $pelaku = new PelakuUsahaModel();
      if (!$tempmail) {
        return redirect()->to(base_url('auth/forgot'));
      }
      $cek = $pelaku->select('id_pelaku')->where('email', $tempmail)->where('security_code', $kode)->first();
      if (!$cek) {
        $this->loginAttemptModel->recordAttempt('verify_' . $tempmail, $ipAddress);
        session()->setFlashdata('error', "Gagal melakukan reset password, silahkan lakukan kembali");
        return redirect()->back();
      } else {
        $password_new = getSecretCode(8);
        $sendMailNew = $this->sendMailNewPassword($password_new, $tempmail);
        if ($sendMailNew) {
          $data['active'] = "login";
          session()->setFlashdata('error', "Silahkan cek email anda untuk melakukan login dengan password baru");
          $pelaku->update($cek->id_pelaku, ['password' => md5($password_new)]);
          $this->loginAttemptModel->clearAttempts('verify_' . $tempmail, $ipAddress);
          session()->remove('tempmail');
          return redirect()->to('auth/login');
        } else {

          $this->loginAttemptModel->recordAttempt('verify_' . $tempmail, $ipAddress);
          $data['active'] = "login";
          session()->setFlashdata('error', "Gagal mengirim email reset password, silakan lakukan kembali");
          return redirect()->back();
        }
      }
    } else {
      $this->loginAttemptModel->recordAttempt('verify_' . $tempmail, $ipAddress);
      session()->setFlashdata('error', 'Captcha belum benar!');
      return redirect()->back()->withInput();
    }
  }
  private function sendMailCode($secret, $emailregis)
  {
    $message = "Kode Rahasia Anda " . $secret . "\n\n";
    $email = \Config\Services::email();
    $email->setFrom('info@portal-indonesia.id', 'Portal Nasional Pusat Informasi Produk Indonesia');
    $email->setTo($emailregis);
    $email->setSubject('Etalase Produk UMKM Indonesia - Kode Secret');
    $email->setMessage($message);
    $email->send();
    if ($email->send(false)) {
      return false;
    } else {
      return true;
    }
  }
  private function sendMailNewPassword($password, $emailregis)
  {
    $message = "Terimakasih, password anda telah kami reset, silahkan login dengan menggunakan email anda dan password " . $password;
    $email = service('email');
    $email->setFrom('info@portal-indonesia.id', 'Portal Nasional Pusat Informasi Produk Indonesia');
    $email->setTo($emailregis);
    $email->setSubject('Etalase Produk UMKM Indonesia - Registrasi Berhasil');
    $email->setMessage($message);

    $email->send();
    if ($email->send(false)) {
      return false;
    } else {
      return true;
    }
  }

  // public function reset_pelaku_usaha()
  // {
  //   if (!session()->get('logged_in') || !in_array(session()->get('level'), [1, 2])) {
  //     return redirect()->to('login')->with('error', 'Anda tidak memiliki akses halaman yang diminta.');
  //   }
  //   $id_pelaku = session()->get('user_id');
  //   $pelaku_usaha = new PelakuUsahaModel();
  //   $password = $this->request->getVar('password');
  //   if (!$this->validate([
  //     'password' => [
  //       'rules' => 'required|min_length[8]|max_length[50]',
  //       'errors' => [
  //         'required' => 'Password Harus diisi',
  //         'is_unique' => 'Password Anda sama dengan sebelumnya',
  //         'min_length' => '{field} Minimal 8 Karakter',
  //         'max_length' => '{field} Maksimal 50 Karakter',
  //       ]
  //     ],
  //   ])) {
  //     session()->setFlashdata('error', $this->validator->listErrors());
  //     return redirect()->back()->withInput();
  //   }

  //   $pelaku_usaha->update($id_pelaku, [
  //     'password' => md5($password),
  //   ]);

  //   add_log($id_pelaku, "Mengubah Password User dengan ID Pelaku Usaha : " . $id_pelaku);
  //   $this->logout();
  //   return redirect()->to('/login');
  // }
}
