<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\KegiatanModel;
use App\Models\PenyelanggaraModels;
use App\Models\KategoriKegiatan;
use App\Models\KategoriModel;
use App\Models\PesertaPembinaanModel;
use App\Models\PelakuUsahaModel;
use App\Models\LogModel;
use App\Models\ProvinsiModel;
use App\Models\KotaModel;
use App\Models\ProdukModel;
use App\Controllers\Log;
use CodeIgniter\I18n\Time;

class Kegiatan extends Log
{
    protected $helpers = ['url', 'form'];

    public function index()
    {
        $kegiatan = new KegiatanModel;
        $data['nama_user'] = session()->get('name');
        $data['active'] = "informasi";
        $data['kegiatan'] = $kegiatan->select('pembinaan.*, penyelenggara.nama as namaPenyelenggara')->join('penyelenggara', 'penyelenggara.id_penyelenggara = pembinaan.penyelenggara')->where('status', '1')->findAll();
        return view('admin/informasi/kegiatan', $data);
    }

    public function hapus_kegiatan($id)
    {
        $kegiatan = new KegiatanModel();
        $ids = session()->get('user_id');
        $kegiatan->update($id, ['status' => 0]);
        $this->add_log($ids, "Menghapus kegiatan dengan ID : ".$id);
        session()->setFlashdata('success', 'Berhasil merubah status kegiatan');
        return redirect()->to('/informasi-kegiatan');
    }

    public function tambah_kegiatan()
    {
        $provinsi = new ProvinsiModel;
        $penyelenggara = new PenyelanggaraModels;
        $kategori = new KategoriModel;
        $data['active'] = "informasi";
        $data['nama_user'] = session()->get('name');
        $data['provinsi'] = $provinsi->orderBy("id_provinsi", "ASC")->findAll();
        $data['penyelenggara'] = $penyelenggara->orderBy("id_penyelenggara", "ASC")->findAll();
        $data['kategori'] = $kategori->orderBy("id_kategori", "ASC")->findAll();
        return view('admin/informasi/form_kegiatan', $data);
    }

    public function save_kegiatan()
    {
        if (!$this->validate([
            'nama_kegiatan' => [
                'rules' => 'required|is_unique[pembinaan.nama_kegiatan]',
                'errors' => [
                    'required' => 'Nama Kegiatan Harus diisi',
                    'is_unique' => 'Nama Kegiatan Sudah digunakan'
                ]
            ],
            'tanggal_publikasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'tanggal publikasi Harus diisi'
                ]
            ],
            'awal_pendaftaran' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'awal pendaftaran Harus diisi'
                ]
            ],
            'wa_group' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Wa Group Harus diisi'
                ]
            ],
            'waktu_awal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            'kapasitas_peserta' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'numeric' => '{field} Harus angka'
                ]
            ],
            'lokasi_pameran' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            'penyelenggara' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            'batas_pendaftaran' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            'kontak_person' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            'ketentuan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            // 'kategori_produk' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => '{field} Harus diisi',
            //     ]
            // ],
            'waktu_akhir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Kegiatan Harus diisi',
                ]
            ],
            'id_provinsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Provinsi Harus diisi',
                ]
            ],
            'id_kota' => [
                'rules'=>'required',
                'errors' => [
                    'required' => 'Kota / Kabupaten Harus diisi',
                ]
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
        $kategori = $this->request->getVar('kategori_produk');
        if ($kategori == null) {
            session()->setFlashdata('error', "kategori harus di isi");
            return redirect()->back()->withInput();
        } else {
            $files = $this->request->getFile('pamflet');
            if ($files->getClientExtension() == "") {
                session()->setFlashdata('error', 'Foto harus diisi');
                return redirect()->back()->withInput();
            }elseif ($files->getClientExtension() != "jpg" && $files->getClientExtension() != "jpeg" && $files->getClientExtension() != "png" ) {
                session()->setFlashdata('error', 'File harus JPG atau PNG');
                return redirect()->back()->withInput();
            }else{
                $nama_kegiatan = str_replace(" ", "-",$this->request->getVar('nama_kegiatan'));
                $unik = rand(11111,99999);
                $nama_file = "pameran_".$nama_kegiatan."_".$unik.".".$files->getClientExtension();
                $files->move('assets/img/pameran', $nama_file);
    
                $kegiatan = new KegiatanModel();
                $pangan = $this->request->getVar('pangan') ?? '';
                $nonpangan = $this->request->getVar('nonpangan') ?? '';
                $pangan_non = $pangan.';'.$nonpangan;
                $insert = $kegiatan->insert([
                    'nama_kegiatan' => $this->request->getVar('nama_kegiatan'), 
                    'waktu_awal' => $this->request->getVar('waktu_awal'), 
                    'waktu_akhir' => $this->request->getVar('waktu_akhir'), 
                    'awal_pendaftaran' => $this->request->getVar('awal_pendaftaran'), 
                    'tanggal_publikasi' => $this->request->getVar('tanggal_publikasi'), 
                    'pangan_non' => $pangan_non,
                    'kapasitas_peserta' => $this->request->getVar('kapasitas_peserta'),
                    'lokasi_pameran'  => $this->request->getVar('lokasi_pameran'),
                    'penyelenggara' => $this->request->getVar('penyelenggara'),
                    'batas_pendaftaran' => $this->request->getVar('batas_pendaftaran'),
                    'pamflet' => $nama_file,
                    'kontak_person' => $this->request->getVar('kontak_person'),
                    'ketentuan' => $this->request->getVar('ketentuan'),
                    'id_provinsi' => $this->request->getVar('id_provinsi'),
                    'id_kota' => $this->request->getVar('id_kota'),
                    'status' => 1,
                    'wa_group' => $this->request->getVar('wa_group'),
                    'created_date' => date("Y-m-d H:i:s"),
                    'created_by' => session()->get('user_id'),
                    'kategori_produk' => json_encode($kategori),
                ]);
    
                if ($insert) {
                    $ids = session()->get('user_id');
                    $this->add_log($ids, "Menambah kegiatan dengan nama : ".$this->request->getVar('nama_kegiatan'));
                    session()->setFlashdata('success', 'Berhasil menambah kegiatan');
                    return redirect()->to('/informasi-kegiatan');
                } else {
                    session()->setFlashdata('error', 'Gagal menambah kegiatan');
                    return redirect()->to('/informasi-kegiatan');
                }
    
            }
        }
    }

    public function update_kegiatan($id)
    {
        if (!$this->validate([
            'nama_kegiatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Kegiatan Harus diisi'
                ]
            ],
            'tanggal_publikasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'tanggal publikasi Harus diisi'
                ]
            ],
            'awal_pendaftaran' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'awal pendaftaran Harus diisi'
                ]
            ],
            'wa_group' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Wa Group Harus diisi'
                ]
            ],
            'waktu_awal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            'kapasitas_peserta' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'numeric' => '{field} Harus angka'
                ]
            ],
            'lokasi_pameran' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            'penyelenggara' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            'batas_pendaftaran' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            'kontak_person' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            'ketentuan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            // 'kategori_produk' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => '{field} Harus diisi',
            //     ]
            // ],
            'waktu_akhir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Kegiatan Harus diisi',
                ]
            ],
            'id_provinsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Provinsi Harus diisi',
                ]
            ],
            'id_kota' => [
                'rules'=>'required',
                'errors' => [
                    'required' => 'Kota / Kabupaten Harus diisi',
                ]
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $kategori = $this->request->getVar('kategori_produk');
        if ($kategori == null) {
            session()->setFlashdata('error', "kategori harus di isi");
            return redirect()->back()->withInput();
        } else {
            $files = $this->request->getFile('pamflet');
            $kegiatan = new KegiatanModel();
            $pangan = $this->request->getVar('pangan') ?? '';
            $nonpangan = $this->request->getVar('nonpangan') ?? '';
            $pangan_non = $pangan.';'.$nonpangan;
            if ($files->getClientExtension() == "") {
                $update = $kegiatan->update($id, [
                    'nama_kegiatan' => $this->request->getVar('nama_kegiatan'), 
                    'waktu_awal' => $this->request->getVar('waktu_awal'), 
                    'waktu_akhir' => $this->request->getVar('waktu_akhir'), 
                    'awal_pendaftaran' => $this->request->getVar('awal_pendaftaran'), 
                    'tanggal_publikasi' => $this->request->getVar('tanggal_publikasi'), 
                    'pangan_non' => $pangan_non,
                    'kapasitas_peserta' => $this->request->getVar('kapasitas_peserta'),
                    'lokasi_pameran'  => $this->request->getVar('lokasi_pameran'),
                    'penyelenggara' => $this->request->getVar('penyelenggara'),
                    // 'pamflet',
                    'batas_pendaftaran' => $this->request->getVar('batas_pendaftaran'),
                    'kontak_person' => $this->request->getVar('kontak_person'),
                    'ketentuan' => $this->request->getVar('ketentuan'),
                    'id_provinsi' => $this->request->getVar('id_provinsi'),
                    'id_kota' => $this->request->getVar('id_kota'),
                    'status' => 1,
                    'wa_group' => $this->request->getVar('wa_group'),
                    'created_date' => date("Y-m-d H:i:s"),
                    'created_by' => session()->get('user_id'),
                    'kategori_produk' => json_encode($kategori),
                ]);
    
                if ($update) {
                    $ids = session()->get('user_id');
                    $this->add_log($ids, "Mengedit kegiatan dengan judul : ".$this->request->getVar('nama_kegiatan'));
                    session()->setFlashdata('success', 'Berhasil mengubah kegiatan');
                    return redirect()->to('/informasi-kegiatan');
                } else {
                    session()->setFlashdata('error', 'Gagal mengubah kegiatan');
                    return redirect()->to('/informasi-kegiatan');
                }
                
            }elseif ($files->getClientExtension() != "jpg" && $files->getClientExtension() != "jpeg" && $files->getClientExtension() != "png" ) {
                session()->setFlashdata('error', 'File harus JPG atau PNG');
                return redirect()->back()->withInput();
            }else{
                $nama_kegiatan = str_replace(" ", "-",$this->request->getVar('nama_kegiatan'));
                $unik = rand(11111,99999);
                $nama_file = "pameran_".$nama_kegiatan."_".$unik.".".$files->getClientExtension();
                $files->move('assets/img/pameran', $nama_file);
    
                $update = $kegiatan->update($id, [
                    'nama_kegiatan' => $this->request->getVar('nama_kegiatan'), 
                    'waktu_awal' => $this->request->getVar('waktu_awal'), 
                    'waktu_akhir' => $this->request->getVar('waktu_akhir'), 
                    'awal_pendaftaran' => $this->request->getVar('awal_pendaftaran'), 
                    'tanggal_publikasi' => $this->request->getVar('tanggal_publikasi'), 
                    'pangan_non' => $pangan_non,
                    'kapasitas_peserta' => $this->request->getVar('kapasitas_peserta'),
                    'lokasi_pameran'  => $this->request->getVar('lokasi_pameran'),
                    'penyelenggara' => $this->request->getVar('penyelenggara'),
                    'pamflet' => $nama_file,
                    'batas_pendaftaran' => $this->request->getVar('batas_pendaftaran'),
                    'kontak_person' => $this->request->getVar('kontak_person'),
                    'ketentuan' => $this->request->getVar('ketentuan'),
                    'id_provinsi' => $this->request->getVar('id_provinsi'),
                    'id_kota' => $this->request->getVar('id_kota'),
                    'status' => 1,
                    'wa_group' => $this->request->getVar('wa_group'),
                    'created_date' => date("Y-m-d H:i:s"),
                    'created_by' => session()->get('user_id'),
                    'kategori_produk' => json_encode($kategori),
                ]);
    
                if ($update) {
                    $ids = session()->get('user_id');
                    $this->add_log($ids, "Mengedit kegiatan dengan judul : ".$this->request->getVar('nama_kegiatan'));
                    session()->setFlashdata('success', 'Berhasil mengubah kegiatan');
                    return redirect()->to('/informasi-kegiatan');
                } else {
                    session()->setFlashdata('error', 'Gagal mengubah kegiatan');
                    return redirect()->to('/informasi-kegiatan');
                }
            }
        }
    }

    public function edit_kegiatan($id)
    {
        $kegiatan = new KegiatanModel;
        $provinsi = new ProvinsiModel;
        $kota = new KotaModel();
        $penyelenggara = new PenyelanggaraModels;
        $kategori = new KategoriModel;
        $data['active'] = "informasi";
        $data['nama_user'] = session()->get('name');
        $data['model'] = $kegiatan->find($id);
        $data['provinsi'] = $provinsi->orderBy("id_provinsi", "ASC")->findAll();
        $data['kabkot'] = $kota->where('id_provinsi', $data['model']->id_provinsi)->findAll();
        $data['penyelenggara'] = $penyelenggara->orderBy("id_penyelenggara", "ASC")->findAll();
        $data['kategori'] = $kategori->orderBy("id_kategori", "ASC")->findAll();
        $nonpangan = $data['model']->pangan_non;
        $explode = explode(";", $nonpangan);
        var_dump(count($explode));
        if ($explode[0] == 'nonpangan') {
            $data['kat1'] = $explode[0];
            $data['kat2'] = $explode[1];
        } else {
            $data['kat1'] = $explode[1];
            $data['kat2'] = $explode[0];
        }

        return view('admin/informasi/form_kegiatan', $data);
    }

    public function list_peserta_kegiatan($id)
    {
        $peserta = new PesertaPembinaanModel;
        $produk = new ProdukModel;
        $dataPeserta = $peserta->select('peserta_pembinaan.*, pembinaan.nama_kegiatan, pelaku_usaha.nama_usaha, pelaku_usaha.email')
            ->join('pembinaan', 'pembinaan.id_pembinaan = peserta_pembinaan.id_pembinaan', 'left')
            ->join('pelaku_usaha', 'pelaku_usaha.id_pelaku = peserta_pembinaan.id_pelaku', 'left')
            ->where('peserta_pembinaan.id_pembinaan', $id)->findAll();
        
        if ($dataPeserta != null) {
            for ($i=0; $i<count($dataPeserta) ; $i++) { 
                $listbarang[] = $produk->select('nama_produk, foto_produk' )->whereIn('id_produk', explode(",",$dataPeserta[$i]->list_barang))->findAll();
            }
        }
        $data = [
            'peserta' => $dataPeserta,
            'list_barang' => $listbarang,
            'active' => 'informasi',
            'nama_user' => session()->get('name')
        ];

        return view('admin/informasi/list_peserta_kegiatan', $data);
    }

    public function reject_peserta_kegiatan($id_peserta)
    {
        $peserta = new PesertaPembinaanModel();
        $pelaku_usaha = new PelakuUsahaModel();
        $ids = session()->get('user_id');
        $data_peserta = $peserta->select('peserta_pembinaan.id_pelaku, peserta_pembinaan.id_pembinaan, pembinaan.wa_group, pembinaan.nama_kegiatan')
        ->join('pembinaan', 'pembinaan.id_pembinaan = peserta_pembinaan.id_pembinaan', 'left')
        ->where('peserta_pembinaan.id_peserta', $id_peserta)->findAll();
        $datapelaku = $pelaku_usaha->select('email, nama_usaha')->find($data_peserta[0]->id_pelaku);
        if ($datapelaku->email != "") {
            $update = $peserta->update($id_peserta, [
                'status_kehadiran' => 2
            ]);
            if ($update) {
                $sendMail = $this->sendMailReject($datapelaku->email, $datapelaku->nama_usaha, $data_peserta[0]->nama_kegiatan, $data_peserta[0]->wa_group);
                if ($sendMail) {
                    $this->add_log($ids, "Mereject Pelaku Usaha dengan ID : ".$id_peserta." untuk mengikuti pameran dengan ID ".$data_peserta[0]->id_pembinaan);
                    session()->setFlashdata('sukses', 'Berhasil Mereject Pelaku Usaha ');
                    return redirect()->to('/list-peserta-kegiatan/'.$data_peserta[0]->id_pembinaan);
                }else{
                    // gagal kirim email
                    $peserta->update($id_peserta, [
                        'status_kehadiran' => 0
                    ]);
                    session()->setFlashdata('error', 'Gagal Mengirimkan email');
                    return redirect()->to('/list-peserta-kegiatan/'.$data_peserta[0]->id_pembinaan);
                }
            }else{
                // gagal update
                session()->setFlashdata('error', 'Gagal Mengupdate Status Peserta Pameran');
                return redirect()->to('/list-peserta-kegiatan/'.$data_peserta[0]->id_pembinaan);
            }
        }else{
            // gagal cause email tidak ada
            session()->setFlashdata('error', 'Gagal Mereject Pelaku Usaha, Tidak ada informasi email');
            return redirect()->to('/list-peserta-kegiatan/'.$data_peserta[0]->id_pembinaan);
        }
    }

    public function approve_peserta_kegiatan_all()
    {
        $dataid = $this->request->getVar('approvePeserta');
        if ($dataid != null) {
            $peserta = new PesertaPembinaanModel();
            $pelaku_usaha = new PelakuUsahaModel();
            $ids = session()->get('user_id');
            for ($i=0; $i<count($dataid); $i++) { 
                $data_peserta = $peserta->select('peserta_pembinaan.id_pelaku, peserta_pembinaan.id_pembinaan, pembinaan.wa_group, pembinaan.nama_kegiatan')
                ->join('pembinaan', 'pembinaan.id_pembinaan = peserta_pembinaan.id_pembinaan', 'left')
                ->where('peserta_pembinaan.id_peserta', $dataid[$i])->findAll();
                $datapelaku = $pelaku_usaha->select('email, nama_usaha')->find($data_peserta[0]->id_pelaku);
                if ($datapelaku->email != "") {
                    $data = ['status_kehadiran' => 1 ];
                    $update = $peserta->update([$dataid[$i]], $data);
                    if ($update) {
                        $sendMail = $this->sendMailApprove($datapelaku->email, $datapelaku->nama_usaha, $data_peserta[0]->nama_kegiatan, $data_peserta[0]->wa_group);
                        if ($sendMail) {
                            $this->add_log($ids, "Mengapprove Pelaku Usaha dengan ID : ".$dataid[$i]." untuk mengikuti pameran dengan ID ".$data_peserta[0]->id_pembinaan);
                        }else{
                            $peserta->update($dataid[$i], [
                                'status_kehadiran' => 0
                            ]);
                            session()->setFlashdata('error', 'Gagal Mengirimkan email');
                            return redirect()->to('/list-peserta-kegiatan/'.$data_peserta[0]->id_pembinaan);
                        }
                    }else{
                        session()->setFlashdata('error', 'Gagal Mengupdate Status Peserta Pameran');
                        return redirect()->to('/list-peserta-kegiatan/'.$data_peserta[0]->id_pembinaan);
                    }
                }else{
                    session()->setFlashdata('error', 'Gagal Mengapprove Pelaku Usaha, Tidak ada informasi email');
                    return redirect()->to('/list-peserta-kegiatan/'.$data_peserta[0]->id_pembinaan);
                }
            }
            session()->setFlashdata('sukses', 'Berhasil Mengapprove Pelaku Usaha ');
            return redirect()->to('/list-peserta-kegiatan/'.$data_peserta[0]->id_pembinaan);
        } else {
            session()->setFlashdata('error', 'Pilih peserta yang akan di approve');
            return redirect()->back();
        }
        
    }

    public function approve_peserta_kegiatan($id_peserta)
    {
        $peserta = new PesertaPembinaanModel();
        $pelaku_usaha = new PelakuUsahaModel();
        $ids = session()->get('user_id');
        $data_peserta = $peserta->select('peserta_pembinaan.id_pelaku, peserta_pembinaan.id_pembinaan, pembinaan.wa_group, pembinaan.nama_kegiatan')
        ->join('pembinaan', 'pembinaan.id_pembinaan = peserta_pembinaan.id_pembinaan', 'left')
        ->where('peserta_pembinaan.id_peserta', $id_peserta)->findAll();
        $datapelaku = $pelaku_usaha->select('email, nama_usaha')->find($data_peserta[0]->id_pelaku);
        if ($datapelaku->email != "") {
            $data = [ 'status_kehadiran' => 1 ];
            $update = $peserta->update([$id_peserta], $data);
            if ($update) {
                $sendMail = $this->sendMailApprove($datapelaku->email, $datapelaku->nama_usaha, $data_peserta[0]->nama_kegiatan, $data_peserta[0]->wa_group);
                if ($sendMail) {
                    $this->add_log($ids, "Mengapprove Pelaku Usaha dengan ID : ".$id_peserta." untuk mengikuti pameran dengan ID ".$data_peserta[0]->id_pembinaan);
                    session()->setFlashdata('sukses', 'Berhasil Mengapprove Pelaku Usaha ');
                    return redirect()->to('/list-peserta-kegiatan/'.$data_peserta[0]->id_pembinaan);
                }else{
                    // gagal kirim email
                    $peserta->update($id_peserta, [
                        'status_kehadiran' => 0
                    ]);
                    session()->setFlashdata('error', 'Gagal Mengirimkan email');
                    return redirect()->to('/list-peserta-kegiatan/'.$data_peserta[0]->id_pembinaan);
                }
            }else{
                // gagal update
                session()->setFlashdata('error', 'Gagal Mengupdate Status Peserta Pameran');
                return redirect()->to('/list-peserta-kegiatan/'.$data_peserta[0]->id_pembinaan);
            }
        }else{
            // gagal cause email tidak ada
            session()->setFlashdata('error', 'Gagal Mengapprove Pelaku Usaha, Tidak ada informasi email');
            return redirect()->to('/list-peserta-kegiatan/'.$data_peserta[0]->id_pembinaan);
        }
    }

    public function sendMailApprove($emailPelaku, $nama_peserta, $nama_pameran, $wa_group)
    {
        $message = "Kepada Yth Bpk/Ibu \ndi Tempat \n\nSelamat, ".$nama_peserta." telah lolos proses Kurasi Kepersetaan Partisipasi Pameran ".$nama_pameran.". \n\nLangkah selanjutnya silahkan klik link berikut untuk dapat bergabung dengan Group Whatsapp Peserta ".$wa_group."\n\nTerima Kasih \nOperator \nEmail : info@portal-indonesia.id";
        $email = \Config\Services::email(); 
        $email->setFrom('info@portal-indonesia.id', 'Portal Nasional Pusat Informasi Produk Indonesia');
        $email->setTo($emailPelaku);
        $email->setSubject('Etalase Produk UMKM Indonesia - Approval');
        $email->setMessage($message);
            
        $email->send();
        if ($email->send(false)){
            return false;
        }else{
            return true;
        }
    }

    public function sendMailReject($emailPelaku, $nama_peserta, $nama_pameran, $wa_group)
    {
        $message = "Kepada Yth Bpk/Ibu \ndi Tempat \n\nMohon maaf, ".$nama_peserta." belum lolos proses Kurasi Kepersetaan Partisipasi Pameran ".$nama_pameran.". \n\nSemoga dapat bergabung dikesempatan berikutnya. Terima Kasih \n\nTerima Kasih \nOperator \nEmail : info@portal-indonesia.id";
        $email = \Config\Services::email(); 
        $email->setFrom('info@portal-indonesia.id', 'Portal Nasional Pusat Informasi Produk Indonesia');
        $email->setTo($emailPelaku);
        $email->setSubject('Etalase Produk UMKM Indonesia - Reject');
        $email->setMessage($message);
            
        $email->send();
        if ($email->send(false)){
            return false;
        }else{
            return true;
        }
    }

}