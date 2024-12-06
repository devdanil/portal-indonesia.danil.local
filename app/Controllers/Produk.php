<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsersModel;
use App\Models\KategoriModel;
use App\Models\SubKategoriModel;
use App\Models\ProdukModel;
use App\Models\ProvinsiModel;
use App\Models\KotaModel;
use App\Models\PelakuUsahaModel;
use App\Controllers\Log;

class Produk extends Log
{
    protected $helpers = ['url', 'form'];
    public function index()
    {
        $produk = new ProdukModel;
        $data['nama_user'] = session()->get('name');
        $data['active'] = "produk";
        $data['produk'] = $produk->select(['produk.*','pelaku_usaha.nama_usaha','kategori_produk.kategori'])
            ->join('kategori_produk', 'kategori_produk.id_kategori = produk.id_kategori')
            ->join('pelaku_usaha', 'pelaku_usaha.id_pelaku = produk.id_pelaku_usaha')
            ->orderBy('produk.id_produk DESC')->findAll();
        $ids = session()->get('user_id');
        $this->add_log($ids, "Membuka menu produk");
        return view('admin/produk/index', $data);
    }

    public function get_sub_kategori($kat){
        $subkategori = new SubKategoriModel();
        $data = $subkategori->select('id_sub, nama')->where('id_kategori',$kat)->findAll();
        $sub = array();
        $option = '<option value="0">- Pilih Sub Kategori -</option>';
        if($data){
            foreach ($data as $s) {
                $sub[$s->id_sub] = $s->nama;
                $option .='<option value="'.$s->id_sub.'">'.$s->nama .'</option>';
            }
        } else {
            //return FALSE;
        }
        echo $option;
        //print_r($cities);
        //header('Content-Type: application/x-json; charset=utf-8');
        // echo(json_encode($cities));
    }

    public function get_city($id_prov){
        $subkategori = new KotaModel();
        $provinsi = new ProvinsiModel();

        $cek = $provinsi->find($id_prov);
        if($cek == null){
            $option = '<option value="">Semua Kota/Kabupaten</option>';
            if ($id_prov == "all") {
                $new_id_prov = 0;
            }else{
                $get_data = $provinsi->where('nama_provinsi', $id_prov)->findAll();
                $new_id_prov = $get_data[0]->id_provinsi;;
            }
        }else{
            $new_id_prov = $id_prov;
            $option = '<option value="0">- Pilih Kota/Kabupaten -</option>';
        }

        $data = $subkategori->select('id, nama')->where('id_provinsi',$new_id_prov)->findAll();
        $kota = array();
        if($data){
            foreach ($data as $s) {
                $kota[$s->id] = $s->nama;
                if($cek == null){
                    $option .='<option value="'.$s->nama.'">'.$s->nama .'</option>';
                }else{
                    $option .='<option value="'.$s->id.'">'.$s->nama .'</option>';
                }
            }
        } else {
            // echo(json_encode($new_id_prov));
        }
        echo $option;
        //print_r($cities);
        //header('Content-Type: application/x-json; charset=utf-8');
        // echo(json_encode($cities));
    }

    public function tambah_produk()
    {
        $kategori = new KategoriModel();
        $subkategori = new SubKategoriModel();
        $provinsi = new ProvinsiModel();
        $kota = new KotaModel();
        $pelaku_usaha = new PelakuUsahaModel();
        $data['active'] = "produk";
        $data['nama_user'] = session()->get('name');
        $data['kategori'] = $kategori->findAll();
        $data['provinsi']= $provinsi->orderBy('id_provinsi', 'ASC')->findAll();
        $data['pelaku_usaha']= $pelaku_usaha->select('id_pelaku, nama_usaha')->where('status_registrasi', 2)->orderBy('id_pelaku', 'DESC')->findAll();
        $ids = session()->get('user_id');
        $this->add_log($ids, "Membuka form tambah produk");
        return view('admin/produk/form_produk', $data);
    }

    public function save_produk()
    {
        helper('text');
        $produk = new ProdukModel();
        if (!$this->validate([
            'kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            'subkategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            'provinsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'provinsi Harus diisi',
                ]
            ],
            'kabkot' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kabkot Harus diisi',
                ]
            ],
            'pelaku_usaha' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pelaku Usaha Harus diisi',
                ]
            ],
            'nama_produk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Produk Harus diisi',
                ]
            ],
            'no_registrasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No Registrasi Harus diisi',
                ]
            ],
            'tahun_reg' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Tahun Registrasi Harus diisi',
                    'numeric' => 'Tahun Registrasi Harus angka',
                ]
            ],
            'deskripsi_in' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi Harus diisi',
                ]
            ],
            'deskripsi_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi dalam bahasa inggris Harus diisi',
                ]
            ],
            'spesifikasi_in' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Spesifikasi Harus diisi',
                ]
            ],
            'spesifikasi_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Spesifikasi dalam bahasa inggris Harus diisi',
                ]
            ],
            'berat_dg_kemasan' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Berat dengan kemasan Harus diisi',
                    'numeric' => 'Berat dengan kemasan Harus angka',
                ]
            ],
            'berat' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'numeric' => '{field} Harus angka',
                ]
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $files = $this->request->getFile('foto_produk');
        if ($files->getClientExtension() == "") {
            session()->setFlashdata('error', 'Foto harus diisi');
            return redirect()->back()->withInput();
        }elseif ($files->getClientExtension() != "jpg" && $files->getClientExtension() != "jpeg" && $files->getClientExtension() != "png" ) {
            session()->setFlashdata('error', 'File harus JPG atau PNG');
            return redirect()->back()->withInput();
        }else{
            $nama_produk = str_replace(" ", "-",$this->request->getVar('nama_produk'));
            $unik = random_string('numeric', 5);
            $nama_file = "produk_".$nama_produk."_".$unik.".".$files->getClientExtension();
            $files->move('assets/uploads', $nama_file);

            $produk->insert([
                'id_kategori' => $this->request->getVar('kategori'), 
                'id_sub' => $this->request->getVar('subkategori'),
                'id_pelaku_usaha' => $this->request->getVar('pelaku_usaha'),
                'nama_produk' => $this->request->getVar('nama_produk'),
                'deskripsi_in' => $this->request->getVar('deskripsi_in'),
                'deskripsi_en' => $this->request->getVar('deskripsi_en'),
                'spesifikasi_in' => $this->request->getVar('spesifikasi_in'),
                'spesifikasi_en' => $this->request->getVar('spesifikasi_en'),
                'berat_dg_kemasan' => $this->request->getVar('berat_dg_kemasan'),
                'berat' => $this->request->getVar('berat'),
                'no_registrasi' => $this->request->getVar('no_registrasi'),
                'tahun_reg' => $this->request->getVar('tahun_reg'),
                'foto_produk' => $nama_file,
                'id_provinsi' => $this->request->getVar('provinsi'),
                'id_kota' => $this->request->getVar('kabkot'),
                'insert_date' => date('Y-m-d H:i:s')
            ]);
            $ids = session()->get('user_id');
            $this->add_log($ids, "Menambah produk dengan nama : ".$this->request->getVar('nama_produk'));
            session()->setFlashdata('success', 'Berhasil menambah produk '.$this->request->getVar('nama_produk'));
            return redirect()->to('/produk');
        }
    }

    public function edit_produk($id)
    {
        $kategori = new KategoriModel();
        $subkategori = new SubKategoriModel();
        $provinsi = new ProvinsiModel();
        $kota = new KotaModel();
        $pelaku_usaha = new PelakuUsahaModel();
        $produk = new ProdukModel();
        $data['active'] = "produk";
        $data['nama_user'] = session()->get('name');
        $data['kategori'] = $kategori->findAll();
        $data['provinsi']= $provinsi->orderBy('id_provinsi', 'ASC')->findAll();
        $data['pelaku_usaha']= $pelaku_usaha->where('status_registrasi', 1)->orderBy('id_pelaku', 'DESC')->findAll();
        $data['subkategori'] = $subkategori->findAll();
        $data['kabkot'] = $kota->findAll();
        $data['model'] = $produk->find($id);
        $ids = session()->get('user_id');
        $this->add_log($ids, "Membuka form edit produk dengan ID : ".$id);
        return view('admin/produk/form_produk', $data);
    }

    public function update_produk($id)
    {
        helper('text');
        $produk = new ProdukModel();
        if (!$this->validate([
            'kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            'subkategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            'provinsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'provinsi Harus diisi',
                ]
            ],
            'kabkot' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kabkot Harus diisi',
                ]
            ],
            'pelaku_usaha' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pelaku Usaha Harus diisi',
                ]
            ],
            'nama_produk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Produk Harus diisi',
                ]
            ],
            'no_registrasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No Registrasi Harus diisi',
                ]
            ],
            'tahun_reg' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Tahun Registrasi Harus diisi',
                    'numeric' => 'Tahun Registrasi Harus angka',
                ]
            ],
            'deskripsi_in' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi Harus diisi',
                ]
            ],
            'deskripsi_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi dalam bahasa inggris Harus diisi',
                ]
            ],
            'spesifikasi_in' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Spesifikasi Harus diisi',
                ]
            ],
            'spesifikasi_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Spesifikasi dalam bahasa inggris Harus diisi',
                ]
            ],
            'berat_dg_kemasan' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Berat dengan kemasan Harus diisi',
                    'numeric' => 'Berat dengan kemasan Harus angka',
                ]
            ],
            'berat' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'numeric' => '{field} Harus angka',
                ]
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $files = $this->request->getFile('foto_produk');
        if ($files->getClientExtension() == "") {
            $produk->update($id, [
                'id_kategori' => $this->request->getVar('kategori'), 
                'id_sub' => $this->request->getVar('subkategori'),
                'id_pelaku_usaha' => $this->request->getVar('pelaku_usaha'),
                'nama_produk' => $this->request->getVar('nama_produk'),
                'deskripsi_in' => $this->request->getVar('deskripsi_in'),
                'deskripsi_en' => $this->request->getVar('deskripsi_en'),
                'spesifikasi_in' => $this->request->getVar('spesifikasi_in'),
                'spesifikasi_en' => $this->request->getVar('spesifikasi_en'),
                'berat_dg_kemasan' => $this->request->getVar('berat_dg_kemasan'),
                'berat' => $this->request->getVar('berat'),
                'no_registrasi' => $this->request->getVar('no_registrasi'),
                'tahun_reg' => $this->request->getVar('tahun_reg'),
                // 'foto_produk' => $nama_file,
                'id_provinsi' => $this->request->getVar('provinsi'),
                'id_kota' => $this->request->getVar('kabkot'),
                'insert_date' => date('Y-m-d H:i:s')
            ]);
        }elseif ($files->getClientExtension() != "jpg" && $files->getClientExtension() != "jpeg" && $files->getClientExtension() != "png" ) {
            session()->setFlashdata('error', 'File harus JPG atau PNG');
            return redirect()->back()->withInput();
        }else{
            $nama_produk = str_replace(" ", "-",$this->request->getVar('nama_produk'));
            $unik = random_string('numeric', 5);
            $nama_file = "produk_".$nama_produk."_".$unik.".".$files->getClientExtension();
            $files->move('assets/uploads', $nama_file);

            $produk->update($id, [
                'id_kategori' => $this->request->getVar('kategori'), 
                'id_sub' => $this->request->getVar('subkategori'),
                'id_pelaku_usaha' => $this->request->getVar('pelaku_usaha'),
                'nama_produk' => $this->request->getVar('nama_produk'),
                'deskripsi_in' => $this->request->getVar('deskripsi_in'),
                'deskripsi_en' => $this->request->getVar('deskripsi_en'),
                'spesifikasi_in' => $this->request->getVar('spesifikasi_in'),
                'spesifikasi_en' => $this->request->getVar('spesifikasi_en'),
                'berat_dg_kemasan' => $this->request->getVar('berat_dg_kemasan'),
                'berat' => $this->request->getVar('berat'),
                'no_registrasi' => $this->request->getVar('no_registrasi'),
                'tahun_reg' => $this->request->getVar('tahun_reg'),
                'foto_produk' => $nama_file,
                'id_provinsi' => $this->request->getVar('provinsi'),
                'id_kota' => $this->request->getVar('kabkot'),
                'insert_date' => date('Y-m-d H:i:s')
            ]);
        }

        $ids = session()->get('user_id');
        $this->add_log($ids, "Merubah produk dengan nama : ".$this->request->getVar('nama_produk'));
        session()->setFlashdata('success', 'Berhasil merubah produk '.$this->request->getVar('nama_produk'));
        return redirect()->to('/produk');
    }

    public function hapus_produk($id)
    {
        $produk = new ProdukModel();
        $produk->delete($id);
        $ids = session()->get('user_id');
        $this->add_log($ids, "Menghapus produk dengan ID : ".$id);
        return redirect()->to('/produk');
    }

    public function approve_produk($id)
    {
        $produk = new ProdukModel();
        $produk->update($id, [
            'status' => 1
        ]);
        $ids = session()->get('user_id');
        $this->add_log($ids, "Mengapprove produk dengan ID : ".$id);
        session()->setFlashdata('success', 'Berhasil mengaprove produk');
        return redirect()->to('/produk');
    }

    public function action_produk($id,$status)
    {
        $produk = new ProdukModel();
        $produk->update($id, [
            'status_show' => $status
        ]);
        $ids = session()->get('user_id');
        if($status){
            $this->add_log($ids, "Menampilkan produk dengan ID : ".$id);
        }else{
            $this->add_log($ids, "Menyembunyikan produk dengan ID : ".$id);
        }
        session()->setFlashdata('success', 'Berhasil mengubah status produk');
        return redirect()->to('/produk');
    }

    public function kategori()
    {
        $kategori = new KategoriModel();
        $data['nama_user'] = session()->get('name');
        $data['active'] = "kategori";
        $data['kategori'] = $kategori->findAll();
        $ids = session()->get('user_id');
        $this->add_log($ids, "Melihat menu kategori");
        return view('admin/produk/kategori', $data);
    }

    public function tambah_kategori()
    {
        $data['active'] = "kategori";
        $data['nama_user'] = session()->get('name');
        $ids = session()->get('user_id');
        $this->add_log($ids, "Membuka form tambah kategori");
        return view('admin/produk/tambah_kategori', $data);
    }

    public function save_kategori()
    {
        $kategoris = new KategoriModel();
        if (!$this->validate([
            'kategori' => [
                'rules' => 'required|is_unique[kategori_produk.kategori]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'is_unique' => 'Kategori sudah digunakan sebelumnya'
                ]
            ],
            'kelompok_usaha' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $kategoris->insert([
            'kategori' => $this->request->getVar('kategori'),
            'kelompok_usaha' => $this->request->getVar('kelompok_usaha')
        ]);
        $ids = session()->get('user_id');
        $this->add_log($ids, "Menambahkan kategori dengan nama : ".$this->request->getVar('kategori'));
        return redirect()->to('/kategori');
    }

    public function edit_kategori($id)
    {
        $data['active'] = "kategori";
        $kategori = new KategoriModel();
        $data['nama_user'] = session()->get('name');
        $data['model'] = $kategori->find($id);
        $ids = session()->get('user_id');
        $this->add_log($ids, "Membuka form edit kategori dengan ID : ".$id);
        return view('admin/produk/tambah_kategori', $data);
    }

    public function update_kategori($id)
    {
        $kategoris = new KategoriModel();
        $nama_kategori = $kategoris->find($id)->kategori;
        if ($nama_kategori == $this->request->getVar('kategori')) {
            if (!$this->validate([
                'kategori' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus diisi'
                    ]
                ],
                'kelompok_usaha' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus diisi',
                    ]
                ],
            ])) {
                session()->setFlashdata('error', $this->validator->listErrors());
                return redirect()->back()->withInput();
            }
    
            $kategoris->update($id,[
                'kategori' => $this->request->getVar('kategori'),
                'kelompok_usaha' => $this->request->getVar('kelompok_usaha')
            ]);

            $ids = session()->get('user_id');
            $this->add_log($ids, "Mengubah subkategori dengan ID : ".$this->request->getVar('kategori'));

            return redirect()->to('/kategori');
        }else{
            if (!$this->validate([
                'kategori' => [
                    'rules' => 'required|is_unique[kategori_produk.kategori]',
                    'errors' => [
                        'required' => '{field} Harus diisi',
                        'is_unique' => 'Kategori sudah digunakan sebelumnya'
                    ]
                ],
                'kelompok_usaha' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus diisi',
                    ]
                ],
            ])) {
                session()->setFlashdata('error', $this->validator->listErrors());
                return redirect()->back()->withInput();
            }
    
            $kategoris->update($id,[
                'kategori' => $this->request->getVar('kategori'),
                'kelompok_usaha' => $this->request->getVar('kelompok_usaha')
            ]);

            $ids = session()->get('user_id');
            $this->add_log($ids, "Merubah kategori dengan nama : ".$this->request->getVar('kategori'));

            return redirect()->to('/kategori');
        }
    }

    public function hapus_kategori($id)
    {
        $kategoris = new KategoriModel();
        $kategoris->delete($id);
        $ids = session()->get('user_id');
        $this->add_log($ids, "Menghapus kategori dengan ID : ".$id);
        return redirect()->to('/kategori');
    }

    public function subkategori()
    {
        $subkategori = new SubKategoriModel();
        $data['nama_user'] = session()->get('name');
        $data['active'] = "subkategori";
        $data['subkategori'] = $subkategori->join('kategori_produk', 'kategori_produk.id_kategori = sub_kategori_produk.id_kategori')->where('id_sub !=', 0)->orderBy('id_sub', 'DESC')->findAll();
        $ids = session()->get('user_id');
        $this->add_log($ids, "Melihat menu subkategori");
        return view('admin/produk/subkategori', $data);
    }

    public function tambah_subkategori()
    {
        $kategori = new KategoriModel();
        $data['active'] = "subkategori";
        $data['nama_user'] = session()->get('name');
        $data['kategori'] = $kategori->findAll();
        $ids = session()->get('user_id');
        $this->add_log($ids, "Membuka form tambah subkategori");
        return view('admin/produk/form_subkategori', $data);
    }

    public function edit_subkategori($id)
    {
        $data['active'] = "subkategori";
        $kategori = new KategoriModel();
        $subkategori = new SubKategoriModel();
        $data['nama_user'] = session()->get('name');
        $data['model'] = $subkategori->find($id);
        $data['kategori'] = $kategori->findAll();
        $ids = session()->get('user_id');
        $this->add_log($ids, "Membuka form edit subkategori");
        return view('admin/produk/form_subkategori', $data);
    }

    public function save_subkategori()
    {
        $subkategori = new SubKategoriModel();
        if (!$this->validate([
            'kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'subkategori' => [
                'rules' => 'required|is_unique[sub_kategori_produk.nama]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'is_unique' => 'SubKategori sudah digunakan sebelumnya'
                ]
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $subkategori->insert([
            'id_kategori' => $this->request->getVar('kategori'),
            'nama' => $this->request->getVar('subkategori')
        ]);

        $ids = session()->get('user_id');
        $this->add_log($ids, "Menambahkan subkategori dengan nama : ".$this->request->getVar('nama'));
        return redirect()->to('/subkategori');
    }

    public function update_subkategori($id)
    {
        $subkategori = new SubKategoriModel();
        $nama_subkategori = $subkategori->find($id)->nama;
        if ($nama_subkategori == $this->request->getVar('subkategori')) {
            if (!$this->validate([
                'kategori' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus diisi'
                    ]
                ],
                'subkategori' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus diisi',
                    ]
                ],
            ])) {
                session()->setFlashdata('error', $this->validator->listErrors());
                return redirect()->back()->withInput();
            }
    
            $subkategori->update($id,[
                'id_kategori' => $this->request->getVar('kategori'),
                'nama' => $this->request->getVar('subkategori')
            ]);

            $ids = session()->get('user_id');
            $this->add_log($ids, "Mengubah subkategori dengan ID : ".$id);

            return redirect()->to('/subkategori');
        }else{
            if (!$this->validate([
                'kategori' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus diisi'
                    ]
                ],
                'subkategori' => [
                    'rules' => 'required|is_unique[sub_kategori_produk.nama]',
                    'errors' => [
                        'required' => '{field} Harus diisi',
                        'is_unique' => 'SubKategori sudah digunakan sebelumnya'
                    ]
                ],
            ])) {
                session()->setFlashdata('error', $this->validator->listErrors());
                return redirect()->back()->withInput();
            }
    
            $subkategori->update($id,[
                'id_kategori' => $this->request->getVar('kategori'),
                'nama' => $this->request->getVar('subkategori')
            ]);

            $ids = session()->get('user_id');
            $this->add_log($ids, "Mengubah subkategori dengan ID : ".$id);

            return redirect()->to('/subkategori');
        }
    }

    public function hapus_subkategori($id)
    {
        $subkategori = new SubKategoriModel();
        $subkategori->delete($id);
        $ids = session()->get('user_id');
        $this->add_log($ids, "Menghapus subkategori dengan ID : ".$id);
        return redirect()->to('/subkategori');
    }

}