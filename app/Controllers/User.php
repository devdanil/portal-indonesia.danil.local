<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsersModel;
use App\Controllers\Log;
use App\Models\InstansiModel;

class User extends Log
{
    protected $helpers = ['url', 'form'];
    
    public function index()
    {
        $user = new UsersModel;
        $id = session()->get('user_id');
        $data['nama_user'] = session()->get('name');
        $data['active'] = "user";
        $data['user'] = $user->where('id !=', 0 )->findAll();
        $this->add_log($id, "Melihat menu user");
        return view('admin/settings/user', $data);
    }

    public function hapus_user($id)
    {
        $user = new UsersModel();
        $ids = session()->get('user_id');
        $user->delete($id);
        $this->add_log($ids, "Menghapus user dengan ID : ".$id);
        return redirect()->to('/settings-user');
    }

    public function tambah_user()
    {
        $user = new UsersModel;
        $instansi = new InstansiModel;
        $data['active'] = "user";
        $data['nama_user'] = session()->get('name');
        $data['instansi'] = $instansi->findAll();
        return view('admin/settings/form_user', $data);
    }

    public function save_user()
    {
        if (!$this->validate([
            'username' => [
                'rules' => 'required|is_unique[app_users.username]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'is_unique' => 'Username sudah digunakan sebelumnya'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]|max_length[50]',
                'errors' => [
                    'required' => 'Password Harus diisi',
                    'min_length' => '{field} Minimal 8 Karakter',
                    'max_length' => '{field} Maksimal 50 Karakter',
                ]
            ],
            'fullname' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Lengkap Video Harus diisi',
                ]
            ],
            // 'instansi' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'Instansi Harus diisi',
            //     ]
            // ],
            'level' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            'hp' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'No Hp harus diisi',
                    'numeric' => 'No Hp harus angka'
                ]
            ],
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $ids = session()->get('user_id');
        $user = new UsersModel();

        if ($this->request->getVar('level') == 1) {
            $level_name = "Admin";
        }elseif ($this->request->getVar('level') == 2) {
            $level_name = "Operator";
        }else{
            $level_name = "";
        }

        $user->insert([
            'username' => $this->request->getVar('username'),
            'password' => md5($this->request->getVar('password')),
            'fullname' => $this->request->getVar('fullname'),
            'instansi' => $this->request->getVar('instansi'),
            'jabatan' => $this->request->getVar('jabatan'),
            'hp' => $this->request->getVar('hp'),
            'email' => $this->request->getVar('email'),
            'level' => $this->request->getVar('level'),
            'level_name' => $level_name,
            'created_date' => date("Y-m-d H:i:s")
        ]);

        $this->add_log($ids, "Menambah user dengan nama : ".$this->request->getVar('fullname'));

        return redirect()->to('/settings-user');
    }

    public function update_user($id)
    {
        if (!$this->validate([
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            // 'password' => [
            //     'rules' => 'required|min_length[8]|max_length[50]',
            //     'errors' => [
            //         'required' => 'Password Harus diisi',
            //         'min_length' => '{field} Minimal 8 Karakter',
            //         'max_length' => '{field} Maksimal 50 Karakter',
            //     ]
            // ],
            'fullname' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Lengkap Video Harus diisi',
                ]
            ],
            // 'instansi' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'Instansi Harus diisi',
            //     ]
            // ],
            'level' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            'hp' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'No Hp harus diisi',
                    'numeric' => 'No Hp harus angka'
                ]
            ],
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        if ($this->request->getVar('level') == 1) {
            $level_name = "Admin";
        }elseif ($this->request->getVar('level') == 2) {
            $level_name = "Operator";
        }else{
            $level_name = "";
        }

        $ids = session()->get('user_id');
        $user = new UsersModel();
        $user->update($id,[
            'username' => $this->request->getVar('username'),
            // 'password' => md5($this->request->getVar('password')),
            'fullname' => $this->request->getVar('fullname'),
            'instansi' => $this->request->getVar('instansi'),
            'jabatan' => $this->request->getVar('jabatan'),
            'hp' => $this->request->getVar('hp'),
            'email' => $this->request->getVar('email'),
            'level' => $this->request->getVar('level'),
            'level_name' => $level_name,
            'created_date' => date("Y-m-d H:i:s")
        ]);

        $this->add_log($ids, "Mengedit User dengan nama : ".$this->request->getVar('fullname'));
        return redirect()->to('/settings-user');
    }

    public function edit_user($id)
    {
        $user = new UsersModel;
        $instansi = new InstansiModel;
        $data['active'] = "user";
        $data['is_edit'] = "true";
        $data['nama_user'] = session()->get('name');
        $data['instansi'] = $instansi->findAll();
        $data['model'] = $user->find($id);
        return view('admin/settings/form_user', $data);
    }

    public function reset_user($id)
    {
        $user = new UsersModel;
        $data['active'] = "user";
        $data['nama_user'] = session()->get('name');
        $data['model'] = $user->find($id);
        return view('admin/settings/form_reset', $data);
    }

    public function update_password_user($id)
    {
        if (!$this->validate([
            'password' => [
                'rules' => 'required|min_length[8]|max_length[50]',
                'errors' => [
                    'required' => 'Password Harus diisi',
                    'min_length' => '{field} Minimal 8 Karakter',
                    'max_length' => '{field} Maksimal 50 Karakter',
                ]
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $ids = session()->get('user_id');
        $user = new UsersModel();
        $user->update($id,[
            'password' => md5($this->request->getVar('password'))
        ]);
        $username_session = session()->get('username');
        $this->add_log($ids, "Mengedit Password User dengan username : ".$this->request->getVar('username'));
        if ($username_session == $this->request->getVar('username') ) {
            return redirect()->to('/logout');
        }else{
            return redirect()->to('/settings-user');
        }
    }

}