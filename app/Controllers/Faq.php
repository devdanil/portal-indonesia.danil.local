<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\FaqModel;
use App\Controllers\Log;
use App\Models\InstansiModel;

class Faq extends Log
{
    protected $helpers = ['url', 'form'];
    
    public function index()
    {
        $faq = new FaqModel;
        $id = session()->get('user_id');
        $data['nama_user'] = session()->get('name');
        $data['active'] = "faq";
        $data['faq'] = $faq->findAll();
        return view('admin/informasi/faq', $data);
    }

    public function status_faq($id)
    {
        $faq = new FaqModel();
        $ids = session()->get('user_id');
        $get = $faq->find($id);
        if ($get->status == 1 ) {
            $status = '0';
        }else{
            $status = '1';
        }

        $faq->update($id,['status'=>$status]);
        $this->add_log($ids, "Merubah status faq dengan ID : ".$id);
        session()->setFlashdata('success', 'Berhasil merubah status faq');
        return redirect()->to('/informasi-faq');
    }

    public function tambah_faq()
    {
        $data['active'] = "popup";
        $data['nama_user'] = session()->get('name');
        return view('admin/informasi/form_faq', $data);
    }

    public function save_faq()
    {
        if (!$this->validate([
            'question' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'answer' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Answer Harus diisi',
                ]
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $ids = session()->get('user_id');
        $faq = new FaqModel();
        $faq->insert([
            'question' => $this->request->getVar('question'),
            'answer' => $this->request->getVar('answer')
        ]);

        $this->add_log($ids, "Menambah faq dengan pertanyaan : ".$this->request->getVar('question'));
        session()->setFlashdata('success', 'Berhasil Menambahkan Faq');
        return redirect()->to('/informasi-faq');
    }

    public function update_faq($id)
    {
        if (!$this->validate([
            'question' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'answer' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Answer Harus diisi',
                ]
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $ids = session()->get('user_id');
        $faq = new FaqModel();
        $faq->update($id,[
            'question' => $this->request->getVar('question'),
            'answer' => $this->request->getVar('answer')
        ]);

        $this->add_log($ids, "Mengedit Faq dengan nama : ".$this->request->getVar('question'));
        session()->setFlashdata('success', 'Berhasil Merubah faq');
        return redirect()->to('/informasi-faq');
    }

    public function edit_faq($id)
    {
        $faq = new FaqModel;
        $data['active'] = "faq";
        $data['nama_user'] = session()->get('name');
        $data['model'] = $faq->find($id);
        return view('admin/informasi/form_faq', $data);
    }


}