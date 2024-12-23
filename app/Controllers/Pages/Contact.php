<?php

namespace App\Controllers\Pages;

use App\Models\LoginAttemptModel;
use CodeIgniter\Controller;
use Config\LoginConfig;

class Contact extends Controller
{
  function __construct()
  {
    $this->loginConfig = new LoginConfig();
    $this->loginAttemptModel = new LoginAttemptModel();
    helper('utility');
  }

  public function index()
  {
    $data['active'] = "contact_us";
    $data['view'] = 'pages/contact';
    return view('layouts/app', $data);
  }

  public function store()
  {
    $name = $_POST['name'];
    $emails = $_POST['email'];
    $message = $_POST['message'];
    $ipAddress = $this->request->getIPAddress();
    $timeLimit = date('Y-m-d H:i:s', time() - $this->loginConfig->lockoutTime);
    $attempts = $this->loginAttemptModel->getAttemptCount('contact_us', $ipAddress, $timeLimit);

    if ($attempts >= $this->loginConfig->maxAttempts) {
      session()->setFlashdata('error', 'Anda telah melakukan permintaan terlalu sering dalam waktu yang dekat, silakan coba beberapa saat lagi');
      return redirect()->back()->withInput();
    }
    $message = "Nama : " . $name . "\nEmail : " . $emails . "\nMessage : " . $message;
    $email = \Config\Services::email();
    $email->setFrom('info@portal-indonesia.id', 'Portal Nasional Pusat Informasi Produk Indonesia');
    $email->setTo("info@portal-indonesia.id");
    $email->setSubject('Etalase Produk UMKM Indonesia - Send Contact Us');
    $email->setMessage($message);
    $status = captcha_validation($this->request->getPost('g-recaptcha-response'));
    $this->loginAttemptModel->recordAttempt('contact_us', $ipAddress);
    if ($status['success']) {
      $email->send();
      if ($email->send(false)) {
        session()->setFlashdata('errorSend', 'Your message has not benn sent.');
        return redirect()->back()->withInput();
      } else {
        session()->setFlashdata('success', 'Your message has been sent. Thank you!');
        return redirect()->to('/pages/contact');
      }
    } else {
      session()->setFlashdata('errorSend', 'Captcha tidak benar!');
      return redirect()->back()->withInput();
    }
  }
}
