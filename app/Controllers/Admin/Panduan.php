<?php

namespace App\Controllers\Admin;

use App\Models\PanduanModel;

class Panduan extends Log
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
    $panduan = new PanduanModel;
    $data['nama_user'] = session()->get('name');
    $data['active'] = "panduan";
    $data['panduan'] = $panduan->findAll();
    return view('admin/informasi/panduan', $data);
  }

  public function hapus_panduan($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $panduan = new PanduanModel();
    $ids = session()->get('user_id');
    $panduan->update($id, ['status' => 0]);
    $this->add_log($ids, "Menghapus panduan dengan ID : " . $id);
    session()->setFlashdata('success', 'Berhasil merubah status panduan');
    return redirect()->to('/admin/informasi-panduan');
  }

  // public function tambah_panduan()
  // {
  //     $provinsi = new ProvinsiModel;
  //     $data['active'] = "informasi";
  //     $data['nama_user'] = session()->get('name');
  //     $data['provinsi'] = $provinsi->orderBy("id_provinsi", "ASC")->findAll();
  //     return view('admin/informasi/form_kegiatan', $data);
  // }

  // public function save_panduan()
  // {
  //     if (!$this->validate([
  //         'nama_kegiatan' => [
  //             'rules' => 'required',
  //             'errors' => [
  //                 'required' => 'Nama Kegiatan Harus diisi'
  //             ]
  //         ],
  //         'waktu' => [
  //             'rules' => 'required',
  //             'errors' => [
  //                 'required' => '{field} Harus diisi',
  //             ]
  //         ],
  //         'tempat' => [
  //             'rules' => 'required',
  //             'errors' => [
  //                 'required' => '{field} Harus diisi',
  //             ]
  //         ],
  //         'tgl_kegiatan' => [
  //             'rules' => 'required',
  //             'errors' => [
  //                 'required' => 'Tanggal Kegiatan Harus diisi',
  //             ]
  //         ],
  //         'id_provinsi' => [
  //             'rules' => 'required',
  //             'errors' => [
  //                 'required' => 'Provinsi Harus diisi',
  //             ]
  //         ],
  //         'id_kota' => [
  //             'rules'=>'required',
  //             'errors' => [
  //                 'required' => 'Kota / Kabupaten Harus diisi',
  //             ]
  //         ],
  //     ])) {
  //         session()->setFlashdata('error', $this->validator->listErrors());
  //         return redirect()->back()->withInput();
  //     }

  //     $kegiatan = new KegiatanModel();
  //     $tgl = $this->request->getVar('tgl_kegiatan');
  //     $pecah = explode('-',$tgl);
  //     $mulai = Time::parse($pecah[0], 'Asia/Jakarta');
  //     $berakhir = Time::parse($pecah[1], 'Asia/Jakarta');
  //     $format_mulai = $mulai->toLocalizedString('d MMMM yyyy');
  //     $format_akhir = $berakhir->toLocalizedString('d MMMM yyyy');
  //     $final = $format_mulai."-".$format_akhir;

  //     $kegiatan->insert([
  //         'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
  //         'waktu' => $this->request->getVar('waktu'),
  //         'tempat' => $this->request->getVar('tempat'),
  //         'id_provinsi' => $this->request->getVar('id_provinsi'),
  //         'id_kota' => $this->request->getVar('id_kota'),
  //         'tgl_kegiatan' => $final,
  //         'id_instansi' => 5,
  //         'penyelenggara' => session()->get('username'),
  //         'created_by' => session()->get('user_id'),
  //         'created_date' => date("Y-m-d H:i:s"),
  //         'status' => 1
  //     ]);

  //     $ids = session()->get('user_id');
  //     $this->add_log($ids, "Menambah kegiatan dengan nama : ".$this->request->getVar('nama_kegiatan'));
  //     session()->setFlashdata('success', 'Berhasil menambah kegiatan');
  //     return redirect()->to('/informasi-kegiatan');
  // }

  // public function update_panduan($id)
  // {
  //     if (!$this->validate([
  //         'nama_kegiatan' => [
  //             'rules' => 'required',
  //             'errors' => [
  //                 'required' => 'Nama Kegiatan Harus diisi'
  //             ]
  //         ],
  //         'waktu' => [
  //             'rules' => 'required',
  //             'errors' => [
  //                 'required' => '{field} Harus diisi',
  //             ]
  //         ],
  //         'tempat' => [
  //             'rules' => 'required',
  //             'errors' => [
  //                 'required' => '{field} Harus diisi',
  //             ]
  //         ],
  //         'tgl_kegiatan' => [
  //             'rules' => 'required',
  //             'errors' => [
  //                 'required' => 'Tanggal Kegiatan Harus diisi',
  //             ]
  //         ],
  //         'id_provinsi' => [
  //             'rules' => 'required',
  //             'errors' => [
  //                 'required' => 'Provinsi Harus diisi',
  //             ]
  //         ],
  //         'id_kota' => [
  //             'rules'=>'required',
  //             'errors' => [
  //                 'required' => 'Kota / Kabupaten Harus diisi',
  //             ]
  //         ],
  //     ])) {
  //         session()->setFlashdata('error', $this->validator->listErrors());
  //         return redirect()->back()->withInput();
  //     }

  //     $kegiatan = new KegiatanModel();
  //     $tgl = $this->request->getVar('tgl_kegiatan');
  //     $pecah = explode('-',$tgl);
  //     $mulai = Time::parse($pecah[0], 'Asia/Jakarta');
  //     $berakhir = Time::parse($pecah[1], 'Asia/Jakarta');
  //     $format_mulai = $mulai->toLocalizedString('d MMMM yyyy');
  //     $format_akhir = $berakhir->toLocalizedString('d MMMM yyyy');
  //     $final = $format_mulai."-".$format_akhir;

  //     $kegiatan->update($id,[
  //         'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
  //         'waktu' => $this->request->getVar('waktu'),
  //         'tempat' => $this->request->getVar('tempat'),
  //         'id_provinsi' => $this->request->getVar('id_provinsi'),
  //         'id_kota' => $this->request->getVar('id_kota'),
  //         'tgl_kegiatan' => $final,
  //         'id_instansi' => 5,
  //         'penyelenggara' => session()->get('username'),
  //         'created_by' => session()->get('user_id'),
  //         'created_date' => date("Y-m-d H:i:s"),
  //         'status' => 1
  //     ]);

  //     $ids = session()->get('user_id');
  //     $this->add_log($ids, "Mengedit kegiatan dengan judul : ".$this->request->getVar('nama_kegiatan'));
  //     session()->setFlashdata('success', 'Berhasil mengubah kegiatan');
  //     return redirect()->to('/informasi-kegiatan');
  // }

  // public function edit_panduan($id)
  // {
  //     $kegiatan = new KegiatanModel;
  //     $provinsi = new ProvinsiModel;
  //     $kota = new KotaModel();
  //     $data['active'] = "informasi";
  //     $data['nama_user'] = session()->get('name');
  //     $data['model'] = $kegiatan->find($id);
  //     $data['provinsi'] = $provinsi->orderBy("id_provinsi", "ASC")->findAll();
  //     $data['kabkot'] = $kota->where('id_provinsi', $data['model']->id_provinsi)->findAll();
  //     return view('admin/informasi/form_kegiatan', $data);
  // }


}
