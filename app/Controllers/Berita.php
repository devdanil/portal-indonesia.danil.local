<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\BeritaModel;
use App\Controllers\Log;
use App\Models\InstansiModel;

class Berita extends Log
{
    protected $helpers = ['url', 'form'];
    
    public function index()
    {
        $berita = new BeritaModel;
        $id = session()->get('user_id');
        $data['nama_user'] = session()->get('name');
        $data['active'] = "berita";
        $data['berita'] = $berita->findAll();
        return view('admin/informasi/berita', $data);
    }

    public function list_berita()
    {
        $berita = new BeritaModel;
        $data['berita'] = $berita->where('status', 0)->paginate(5);
        $data['active'] = "";
        $pager = \Config\Services::pager();
        $data['pager'] = $berita->pager;
        return view('web/list_berita', $data);
    }

    public function detail_berita($judul)
    {
        $berita = new BeritaModel;
        $judul = str_replace("-", " ",$judul); 
        $data['berita'] = $berita->where('judul', $judul)->findAll();
        $data['active'] = "";
        return view('web/detail_berita', $data);
    }

    public function status_berita($id)
    {
        $berita = new BeritaModel();
        $ids = session()->get('user_id');
        $get = $berita->find($id);
        if ($get->status == 1 ) {
            $status = '0';
        }else{
            $status = '1';
        } 
        
        $berita->update($id,['status'=>$status]);
        $this->add_log($ids, "Merubah status berita dengan ID : ".$id);
        session()->setFlashdata('success', 'Berhasil merubah status berita');
        return redirect()->to('/informasi-berita');
    }

    public function status_utama($id)
    {
        $berita = new BeritaModel();
        $ids = session()->get('user_id');
        $get = $berita->find($id);
        $hg = $berita->select('id')->where('utama', '1')->findAll();
        $hgs= array();
        if ($get->utama == 1 ) {
            $utama = '0';
        }else{
            $utama = '1';
        }

        if (count($hg) < 1 ) {
            $hgs = null;
        }else{
            for ($i=0; $i < count($hg); $i++) { 
                array_push($hgs, $hg[$i]->id);
            }
        }

        if($hgs != null){
            $update_old = $berita->update($hgs, ['utama'=> '0' ]);
            if($update_old){
                $berita->update($id,['utama'=>$utama, 'status'=> '0']);
                $this->add_log($ids, "Merubah utama berita dengan ID : ".$id);
                session()->setFlashdata('success', 'Berhasil merubah status utama berita');
                return redirect()->to('/informasi-berita');
            }else{
                session()->setFlashdata('gagal', 'Gagal merubah status utama berita');
                return redirect()->to('/informasi-berita');
            }
        }else{
            $berita->update($id,['utama'=>$utama, 'status'=> '0']);
            $this->add_log($ids, "Merubah utama berita dengan ID : ".$id);
            session()->setFlashdata('success', 'Berhasil merubah status utama berita');
            return redirect()->to('/informasi-berita');
        }
    }

    public function tambah_berita()
    {
        $data['active'] = "berita";
        $data['nama_user'] = session()->get('name');
        return view('admin/informasi/form_berita', $data);
    }

    public function save_berita()
    {
        if (!$this->validate([
            'judul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'keyword' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Keyword Harus diisi',
                ]
            ],
            'summary' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Summary Harus diisi',
                ]
            ],
            'isi_berita' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Isi Berita Mulai Harus diisi',
                ]
            ]
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        helper('text');
        $files = $this->request->getFile('featured_image');
        if ($files->getClientExtension() == "") {
            session()->setFlashdata('error', 'Featured Image harus diisi');
            return redirect()->back()->withInput();
        }elseif ($files->getClientExtension() != "jpg" && $files->getClientExtension() != "jpeg" && $files->getClientExtension() != "png") {
            session()->setFlashdata('error', 'File harus JPG atau PNG');
            return redirect()->back()->withInput();
        }else{
            $judul = str_replace(" ", "-",$this->request->getVar('judul'));
            $unik = random_string('numeric', 5);
            $nama_file = "featured_image_".$judul."_".$unik.".".$files->getClientExtension();
            $files->move('assets/uploads/featuredImage', $nama_file);

            $ids = session()->get('user_id');
            $berita = new BeritaModel();
            $insert = $berita->insert([
                'judul' => $this->request->getVar('judul'),
                'keyword' => $this->request->getVar('keyword'),
                'featured_image' => $nama_file,
                'summary' => $this->request->getVar('summary'),
                'isi_berita' => $this->request->getVar('isi_berita')
            ]);
        }
        
        if ($insert) {
            $this->add_log($ids, "Menambah Berita dengan judul : ".$this->request->getVar('judul'));
            session()->setFlashdata('success', 'Berhasil Menambahkan Berita');
            return redirect()->to('/informasi-berita');
        }else{
            session()->setFlashdata('error', 'Gagal insert ke Database');
            return redirect()->back()->withInput();
        }
    }

    public function update_berita($id)
    {
        if (!$this->validate([
            'judul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'keyword' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Keyword Harus diisi',
                ]
            ],
            'summary' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Summary Harus diisi',
                ]
            ],
            'isi_berita' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Isi Berita Mulai Harus diisi',
                ]
            ]
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        helper('text');
        $files = $this->request->getFile('featured_image');
        if ($files->getClientExtension() == "") {
            $ids = session()->get('user_id');
            $berita = new BeritaModel();
            $update = $berita->update($id,[
                'judul' => $this->request->getVar('judul'),
                'keyword' => $this->request->getVar('keyword'),
                'summary' => $this->request->getVar('summary'),
                'isi_berita' => $this->request->getVar('isi_berita')
            ]);
        }elseif ($files->getClientExtension() != "jpg" && $files->getClientExtension() != "jpeg" && $files->getClientExtension() != "png") {
            session()->setFlashdata('error', 'File harus JPG atau PNG');
            return redirect()->back()->withInput();
        }else{
            $judul = str_replace(" ", "-",$this->request->getVar('judul'));
            $unik = random_string('numeric', 5);
            $nama_file = "featured_image_".$judul."_".$unik.".".$files->getClientExtension();
            $files->move('assets/uploads/featuredImage', $nama_file);

            $ids = session()->get('user_id');
            $berita = new BeritaModel();
            $update = $berita->update($id,[
                'judul' => $this->request->getVar('judul'),
                'keyword' => $this->request->getVar('keyword'),
                'featured_image' => $nama_file,
                'summary' => $this->request->getVar('summary'),
                'isi_berita' => $this->request->getVar('isi_berita')
            ]);
        }
        if ($update) {
            $this->add_log($ids, "Mengedit Berita dengan Judul : ".$this->request->getVar('judul'));
            session()->setFlashdata('success', 'Berhasil Merubah Berita');
            return redirect()->to('/informasi-berita');
        }else{
            session()->setFlashdata('error', 'Gagal update ke Database');
            return redirect()->back()->withInput();
        }
    }

    public function edit_berita($id)
    {
        $berita = new BeritaModel;
        $data['active'] = "berita";
        $data['nama_user'] = session()->get('name');
        $data['model'] = $berita->find($id);
        return view('admin/informasi/form_berita', $data);
    }


}