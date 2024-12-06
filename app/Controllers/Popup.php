<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PopupModel;
use App\Controllers\Log;
use App\Models\InstansiModel;

class Popup extends Log
{
    protected $helpers = ['url', 'form'];
    
    public function index()
    {
        $popup = new PopupModel;
        $id = session()->get('user_id');
        $data['nama_user'] = session()->get('name');
        $data['active'] = "popup";
        $data['popup'] = $popup->findAll();
        return view('admin/informasi/popup', $data);
    }

    public function hapus_popup($id)
    {
        $popup = new PopupModel();
        $ids = session()->get('user_id');
        $popup->update($id,['status'=>1]);
        $this->add_log($ids, "Merubah status popup dengan ID : ".$id);
        session()->setFlashdata('success', 'Berhasil merubah status popup');
        return redirect()->to('/informasi-popup');
    }

    public function tambah_popup()
    {
        $data['active'] = "popup";
        $data['nama_user'] = session()->get('name');
        return view('admin/informasi/form_popup', $data);
    }

    public function save_popup()
    {
        if (!$this->validate([
            'judul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'link' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Link Harus diisi',
                ]
            ],
            'start_date' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Mulai Harus diisi',
                ]
            ],
            'end_date' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Selesai Harus diisi',
                ]
            ]
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        helper('text');
        $files = $this->request->getFile('img_url');
        if ($files->getClientExtension() == "") {
            session()->setFlashdata('error', 'Foto harus diisi');
            return redirect()->back()->withInput();
        }elseif ($files->getClientExtension() != "jpg" && $files->getClientExtension() != "jpeg" && $files->getClientExtension() != "png") {
            session()->setFlashdata('error', 'File harus JPG atau PNG');
            return redirect()->back()->withInput();
        }else{
            $judul = str_replace(" ", "-",$this->request->getVar('judul'));
            $unik = random_string('numeric', 5);
            $nama_file = "popup_".$judul."_".$unik.".".$files->getClientExtension();
            $files->move('assets/uploads/popup', $nama_file);

            $ids = session()->get('user_id');
            $popup = new PopupModel();
            $popup->insert([
                'judul' => $this->request->getVar('judul'),
                'img_url' => $nama_file,
                'link' => $this->request->getVar('link'),
                'start_date' => $this->request->getVar('start_date'),
                'end_date' => $this->request->getVar('end_date')
            ]);
        }

        $this->add_log($ids, "Menambah popup dengan nama : ".$this->request->getVar('judul'));
        session()->setFlashdata('success', 'Berhasil Menambahkan popup');
        return redirect()->to('/informasi-popup');
    }

    public function update_popup($id)
    {
        if (!$this->validate([
            'judul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'link' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Link Harus diisi',
                ]
            ],
            'start_date' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Mulai Harus diisi',
                ]
            ],
            'end_date' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Selesai Harus diisi',
                ]
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        helper('text');
        $files = $this->request->getFile('img_url');
        if ($files->getClientExtension() == "") {
            $ids = session()->get('user_id');
            $popup = new PopupModel();
            $popup->update($id,[
                'judul' => $this->request->getVar('judul'),
                // 'img_url' => $nama_file,
                'link' => $this->request->getVar('link'),
                'start_date' => $this->request->getVar('start_date'),
                'end_date' => $this->request->getVar('end_date')
            ]);
        }elseif ($files->getClientExtension() != "jpg" && $files->getClientExtension() != "jpeg" && $files->getClientExtension() != "png") {
            session()->setFlashdata('error', 'File harus JPG atau PNG');
            return redirect()->back()->withInput();
        }else{
            $judul = str_replace(" ", "-",$this->request->getVar('judul'));
            $unik = random_string('numeric', 5);
            $nama_file = "popup_".$judul."_".$unik.".".$files->getClientExtension();
            $files->move('assets/uploads/popup', $nama_file);

            $ids = session()->get('user_id');
            $popup = new PopupModel();
            $popup->update($id,[
                'judul' => $this->request->getVar('judul'),
                'img_url' => $nama_file,
                'link' => $this->request->getVar('link'),
                'start_date' => $this->request->getVar('start_date'),
                'end_date' => $this->request->getVar('end_date')
            ]);
        }

        $this->add_log($ids, "Mengedit Popup dengan nama : ".$this->request->getVar('judul'));
        session()->setFlashdata('success', 'Berhasil Merubah popup');
        return redirect()->to('/informasi-popup');
    }

    public function edit_popup($id)
    {
        $popup = new PopupModel;
        $data['active'] = "popup";
        $data['nama_user'] = session()->get('name');
        $data['model'] = $popup->find($id);
        return view('admin/informasi/form_popup', $data);
    }


}