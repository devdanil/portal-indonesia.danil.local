<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsersModel;
use App\Models\LogModel;
use App\Models\PelakuUsahaModel;

class Auth extends Controller
{
    public function index()
    {
        $data['active'] = "login";
        return view('admin/login',$data);
    }

    public function register()
    {
        return view('admin/register');
    }

    public function add_log($user_id, $activity)
    {
        $user_log = new LogModel;
        $user_log->insert(['user_id'=> $user_id, 'activity' => $activity, 'time' => date("Y-m-d H:i:s") ]);
    }

    public function reset_pelaku_usaha()
    {
        $id_pelaku = session()->get('user_id');
        $pelaku_usaha = new PelakuUsahaModel();
        $password = $this->request->getVar('password');
        if (!$this->validate([
            'password' => [
                'rules' => 'required|is_unique[pelaku_usaha.real_password]|min_length[8]|max_length[50]',
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

        $pelaku_usaha->update($id_pelaku,[
            'real_password' => $this->request->getVar('password'),
            'password' => md5($this->request->getVar('password')),
        ]);

        $this->add_log($id_pelaku, "Mengubah Password User dengan ID Pelaku Usaha : ".$id_pelaku );
        $this->logout();
        return redirect()->to('/login');
    }

    public function auth_process_regis($email,$password)
    {
        $pelaku_usaha = new PelakuUsahaModel();
        $dataPelaku = $pelaku_usaha->where([
            'email' => $email,
        ])->first();

        if ($dataPelaku) {
            if (md5($password) == $dataPelaku->password) {
                $this->add_log($dataPelaku->id_pelaku, "Login Aplikasi");
                session()->set([
                    'user_id'=> $dataPelaku->id_pelaku,
                    'username' => $dataPelaku->nama_pimpinan,
                    'name' => $dataPelaku->nama_usaha,
                    'level' => 3,
                    'logged_in' => TRUE
                ]);
                return true;
            }
        }
    }

    public function auth_process()
    {
        $users = new UsersModel();
        $pelaku_usaha = new PelakuUsahaModel();
        $username = $this->request->getVar('username');
        $password = md5($this->request->getVar('password'));
        $dataUser = $users->where([
            'username' => $username,
        ])->first();
        
        $dataPelaku = $pelaku_usaha->where([
            'email' => $username,
        ])->first();
        
        $secret='6LektGgpAAAAALCFdpq6f0ij1fAxQLI2-TpjZZh8'; 
        $credential = array(
                'secret' => $secret,
                'response' => $this->request->getVar('g-recaptcha-response')
            );
        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($verify);

        $status= json_decode($response, true);
        if($status['success']){ 
            if ($dataUser) {
                if ($password == $dataUser->password) {
                    $this->add_log($dataUser->id, "Login Aplikasi");
                    session()->set([
                        'user_id'=> $dataUser->id,
                        'username' => $dataUser->username,
                        'name' => $dataUser->fullname,
                        'level' => $dataUser->level,
                        'logged_in' => TRUE
                    ]);
                    return redirect()->to(base_url('admin'));
                } else {
                    session()->setFlashdata('error', 'Username & Password Salah');
                    return redirect()->back();
                }
            }elseif ($dataPelaku) {
                if ($password == $dataPelaku->password) {
                    $this->add_log($dataPelaku->id_pelaku, "Login Aplikasi");
                    session()->set([
                        'user_id'=> $dataPelaku->id_pelaku,
                        'username' => $dataPelaku->nama_pimpinan,
                        'name' => $dataPelaku->nama_usaha,
                        'level' => 3,
                        'logged_in' => TRUE
                    ]);
                    return redirect()->to(base_url());
                } else {
                    session()->setFlashdata('error', 'Email & Password Salah');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('error', 'Username / Email & Password Salah');
                return redirect()->back();
            }
        }else{
            session()->setFlashdata('error', 'Captcha belum benar!');
            return redirect()->back()->withInput();
        }
    }

    function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function process()
    {
        if (!$this->validate([
            'username' => [
                'rules' => 'required|min_length[4]|max_length[20]|is_unique[users.username]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'min_length' => '{field} Minimal 4 Karakter',
                    'max_length' => '{field} Maksimal 20 Karakter',
                    'is_unique' => 'Username sudah digunakan sebelumnya'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[4]|max_length[50]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'min_length' => '{field} Minimal 4 Karakter',
                    'max_length' => '{field} Maksimal 50 Karakter',
                ]
            ],
            'password_conf' => [
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'Konfirmasi Password tidak sesuai dengan password',
                ]
            ],
            'name' => [
                'rules' => 'required|min_length[4]|max_length[100]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'min_length' => '{field} Minimal 4 Karakter',
                    'max_length' => '{field} Maksimal 100 Karakter',
                ]
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
        $users = new UsersModel();
        $users->insert([
            'username' => $this->request->getVar('username'),
            'password' => md5($this->request->getVar('password')),
            'name' => $this->request->getVar('name')
        ]);
        return redirect()->to('/login');
    }
}