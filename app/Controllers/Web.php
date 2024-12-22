<?php

namespace App\Controllers;
use App\Models\KategoriModel;
use App\Models\ProdukModel;
use App\Models\KegiatanModel;
use App\Models\ProvinsiModel;
use App\Models\PopupModel;
use App\Models\PelakuUsahaModel;
use App\Models\KotaModel;
use App\Models\FaqModel;
use App\Models\TataCaraModel;
use App\Models\VideoModel;
use App\Models\KulinerModel;
use App\Models\PesertaPembinaanModel;
use App\Models\SubKategoriModel;
use App\Models\SliderModel;
use App\Models\BeritaModel;
use App\Controllers\Auth;
use CodeIgniter\HTTP\IncomingRequest;

class Web extends Auth
{
    protected $helpers = ['url', 'form'];
    public function index()
    {
        $kategori = new KategoriModel();
        $produk = new ProdukModel();
        $kegiatan = new KegiatanModel();
        $popup = new PopupModel();
        $slide = new SliderModel();
        $highlight = new BeritaModel();
        $cek = $highlight->select('id')->where('utama', '1')->findAll();
        if (count($cek) < 1 ) {
            $data['highlight'] = $highlight->orderBy('id', 'desc')->findAll(1,0);
        }else{
            $data['highlight'] = $highlight->where('utama', '1')->findAll();
        }

        $dataProduk = array();
        $data['active'] = "home";
        $data['kategori'] = $kategori->findAll();
        // $queryKategori = $kategori->select([
        //     'kategori_produk.id_kategori',
        //     'kategori_produk.kategori', 
        //     'COUNT(produk.id_kategori) AS total'
        // ])->join('produk', 'produk.id_kategori = kategori_produk.id_kategori', 'left');
        // $queryKategori->where('produk.status', 1)->groupBy('kategori_produk.id_kategori');
        // $data['kategori'] = $queryKategori->findAll();
        $data['slide'] = $slide->findAll();
        foreach ($data['kategori'] as $value) {
            $dataGet = $kategori->select([
                'produk.id_produk',
                'produk.foto_produk',
                'produk.id_kategori', 
                'produk.nama_produk', 
                'kategori_produk.kategori'
                ])
                ->join('produk', 'produk.id_kategori = kategori_produk.id_kategori', 'left')
                ->where('produk.id_kategori',$value->id_kategori)
                ->where('produk.status', 1)
                ->where('produk.status_show', 1)
                ->orderBy('produk.id_produk', 'DESC')
                ->findAll(2,0);
            array_push($dataProduk, $dataGet);
        }
        $data['produk'] = $dataProduk;
        $data['kegiatan'] = $kegiatan->select('pembinaan.*, penyelenggara.nama as namaPenyelenggara')->join('penyelenggara', 'penyelenggara.id_penyelenggara = pembinaan.penyelenggara')->where('status', 1)->findAll();
       
        if (!empty($data['kegiatan'])) {
            if (((strtotime(date('Y-m-d')) - strtotime($data['kegiatan'][0]->tanggal_publikasi)) / 60 / 60 / 24) >= 0) {
                $data['kegiatan'] = $data['kegiatan'];
            } else {
                $data['kegiatan'] = [];
            }
        }
        
        $hari_ini = date('Y-m-d');
        $data['popup'] = $popup->where('start_date <=', $hari_ini)->where('end_date >=', $hari_ini)->findAll(1,0);
        return view('web/index', $data);
    }

    public function detail_kegiatan($namakegiatan)
    {
        $kegiatan = new KegiatanModel;
        $peserta = new PesertaPembinaanModel;
        $produk = new ProdukModel;
        $kategori = new KategoriModel;
        $namakegiatan = str_replace("-", " ",$namakegiatan);
        $data['kegiatan'] = $kegiatan->select('pembinaan.*, penyelenggara.nama as namaPenyelenggara, provinsi.nama_provinsi, mst_kota.nama as namakota')
            ->join('penyelenggara', 'penyelenggara.id_penyelenggara = pembinaan.penyelenggara', 'left')
            ->join('provinsi', 'provinsi.id_provinsi = pembinaan.id_provinsi', 'left')
            ->join('mst_kota', 'mst_kota.id = pembinaan.id_kota', 'left')
            ->where('pembinaan.nama_kegiatan', $namakegiatan)->findAll();
        $data['active'] = "info";
        $data['kategori'] = $kategori->select('kategori as nama_kategori')->whereIn('id_kategori', json_decode($data['kegiatan'][0]->kategori_produk))->findAll();
        $dataPeserta = $peserta->select('peserta_pembinaan.list_barang, pelaku_usaha.nama_usaha, peserta_pembinaan.nama_pj')
            ->join('pelaku_usaha', 'pelaku_usaha.id_pelaku = peserta_pembinaan.id_pelaku', 'left')
            ->where('peserta_pembinaan.status_kehadiran', 1)
            ->where('peserta_pembinaan.id_pembinaan', $data['kegiatan'][0]->id_pembinaan)->findAll();
            
        $datapesertanew = [
            'dataPeserta' => $dataPeserta,
            'produk' => []
        ];
        if (!empty($dataPeserta)) {
            foreach ($dataPeserta as $key => $value) {
                $explode = explode(",", $value->list_barang);
                $dataproduk = $produk->select('nama_produk')->whereIn('id_produk', $explode)->findAll();
                array_push($datapesertanew['produk'], $dataproduk);
            }
        }
        $data['peserta'] = $dataPeserta;
        $data['datapesertanew'] = $datapesertanew;
        $nonpangan = $data['kegiatan'][0]->pangan_non;
        $explode = explode(";", $nonpangan);
        if ($explode[0] == 'nonpangan') {
            $data['kat1'] = $explode[0];
            $data['kat2'] = $explode[1];
        } else {
            $data['kat1'] = $explode[1];
            $data['kat2'] = $explode[0];
        }
        return view('web/detail_kegiatan', $data);
    }

    public function forget()
    {
        $data = ['active' => ''];
        return view('web/forgot', $data); 
    }

    public function email_cek()
    {
        $pelaku = new PelakuUsahaModel();
        $email = $this->request->getVar('email');
        $cek = $pelaku->where('email', $email)->findAll();
        $base_url = base_url('register');
        if (count($cek) == 0) {
            session()->setFlashdata('error', "Email anda belum terdaftar, jika ingin mendaftar silahkan klik <a href='$base_url'>Registrasi</a>");
            return redirect()->back()->withInput();
        }else{
            $secret = $this->generateKodeSecret();
            $sendMail = $this->sendMailKodeSecret($secret, $email);
            if ($sendMail) {
                $data = ['active' => '', 'email'=>$email];
                $id_pelaku = $pelaku->select('id_pelaku')->where('email', $email)->findAll();
                $update_code_secret = $pelaku->update($id_pelaku[0]->id_pelaku,['security_code'=>$secret]);
                session()->setFlashdata('error', "Silahkan cek email anda untuk mendapatkan kode rahasia");
                return view('web/forgot', $data);
            }else{
                $data = ['active' => ''];
                session()->setFlashdata('error', "Gagal mengirim email");
                return view('web/forgot', $data);
            }
        }
    }

    public function cek_kode()
    {
        $pelaku = new PelakuUsahaModel();
        $kode = $this->request->getVar('code_secret');
        $email = $this->request->getVar('email');
        $password_new = $this->generatePassword();
        $cek = $pelaku->select('id_pelaku')->where('email', $email)->where('security_code', $kode)->findAll();
        if (count($cek) == 0 ) {
            $data['active'] = "login";
            session()->setFlashdata('error', "Gagal melakukan reset password, silahkan lakukan kembali");
            return view('admin/login',$data);
        }else{
            $update_code_secret = $pelaku->update($cek[0]->id_pelaku,['password'=> md5($password_new)]);
            $sendMailNew = $this->sendMailNewPassword($password_new, $email);
            if ($sendMailNew) {
                $data['active'] = "login";
                session()->setFlashdata('error', "Silahkan cek email anda untuk melakukan login dengan password baru");
                return redirect()->to('/login');
            }else{
                $data['active'] = "login";
                session()->setFlashdata('error', "Gagal melakukan reset password, silahkan lakukan kembali");
                return redirect()->to('/login');
            }
        }
    }

    public function generateKodeSecret($length = 6) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function sendMailNewPassword($password,$emailregis)
    {
        $message = "Terimakasih, password anda telah kami reset, silahkan login dengan menggunakan email anda dan password ".$password;
        $email = \Config\Services::email(); 
        $email->setFrom('info@portal-indonesia.id', 'Portal Nasional Pusat Informasi Produk Indonesia');
        $email->setTo($emailregis);
        $email->setSubject('Etalase Produk UMKM Indonesia - Registrasi Berhasil');
        $email->setMessage($message);
            
        $email->send();
        if ($email->send(false)){
            return false;
        }else{
            return true;
        }
    }

    public function sendMailKodeSecret($secret,$emailregis)
    {
        $message = "Kode Rahasia Anda ".$secret."\n\n"; 
        $email = \Config\Services::email(); 
        $email->setFrom('info@portal-indonesia.id', 'Portal Nasional Pusat Informasi Produk Indonesia');
        $email->setTo($emailregis);
        $email->setSubject('Etalase Produk UMKM Indonesia - Kode Secret');
        $email->setMessage($message);
        
        // $email->setCC('another@emailHere');
        // $email->setBCC('thirdEmail@emialHere');
        // $filename = '/img/yourPhoto.jpg';
        // $email->attach($filename);
            
        $email->send();
        if ($email->send(false)){
            return false;
        }else{
            return true;
        }
    }

    public function etalase()
    {
        $kategoris = new KategoriModel();
        $pelaku = new PelakuUsahaModel();
        $produk = new ProdukModel();
        $provinsi = new ProvinsiModel();
        $subkategori = new SubKategoriModel();
        $request = service('request');
        $pager = \Config\Services::pager();
        $kategori_params = $request->getGet('kategori');                                                                                                                                                                                                                                    
        $provinsi_params = $request->getGet('provinsi');
        $keyword_params = $request->getGet('keyword');
        $sub_kategori_params = $request->getGet('subkategori');
        $where = array('status' => 1);
        $active_params = "all";
        $active_params_prov = "";
        $active_params_keywords = "";
        $active_params_sub = "all";
        $queryProduk = $produk->select(['produk.id_produk',
            'produk.foto_produk',
            'produk.tokopedia',
            'produk.bukalapak',
            'produk.shoope',
            'produk.insert_date',
            'produk.id_kategori', 
            'produk.nama_produk', 
            'kategori_produk.kategori',
            'pelaku_usaha.jenis_usaha',
            'pelaku_usaha.email',
            'pelaku_usaha.handphone'
            ])->join('kategori_produk', 'kategori_produk.id_kategori = produk.id_kategori')
            ->join('pelaku_usaha', 'pelaku_usaha.id_pelaku = produk.id_pelaku_usaha');

        $queryKategori = $kategoris->select([
            'kategori_produk.id_kategori',
            'kategori_produk.kategori', 
            'COUNT(produk.id_kategori) AS total'
        ])->join('produk', 'produk.id_kategori = kategori_produk.id_kategori', 'left');
        
        $queryProvinsi = $provinsi->select([
            'provinsi.id_provinsi',
            'provinsi.nama_provinsi',
            'COUNT(produk.id_produk) as total'
        ])
        ->join('produk ', 'produk.id_provinsi = provinsi.id_provinsi', 'left')
        ->where('produk.status','1')
        ->where('produk.status_show','1')
        ->groupBy('produk.id_provinsi')
        ->orderBy('provinsi.id_provinsi', 'ASC');
        
        $querySubKategori = $subkategori->where('id_sub !=','0');

        if(isset($kategori_params) ){
            $active_params = $kategori_params;
            $queryProduk->where('produk.id_kategori', $kategori_params);
            $querySubKategori->where('id_kategori', $kategori_params);
        }
        if(isset($provinsi_params) ){
            $active_params_prov = $provinsi_params;
            $queryProduk->where('produk.id_provinsi',$provinsi_params);
            $queryKategori->where('produk.id_provinsi',$provinsi_params);
        }
        if(isset($keyword_params) ){
            $active_params_keywords = $keyword_params;
            $queryProduk->like('produk.nama_produk', $keyword_params, 'after');
        }
        if(isset($sub_kategori_params) ){
            $active_params_sub = $sub_kategori_params;
            $queryProduk->where('produk.id_sub', $sub_kategori_params);
        }

        $queryProduk->where('produk.status','1')->where('produk.status_show','1')->orderBy('produk.id_produk', 'DESC');
        $queryKategori->where('produk.status', 1)->where('produk.status_show','1')->groupBy('kategori_produk.id_kategori');

        $data = [
            'produk' => $queryProduk->paginate(12),
            'pager' => $produk->pager,
            'provinsi' => $queryProvinsi->orderBy('id_provinsi', 'ASC')->findAll(),
            'kategori' => $queryKategori->findAll(),
            'subkategori' => $querySubKategori->findAll(),
            'active' => 'etalase',
            'active_params' => $active_params,
            'active_params_prov' => $active_params_prov,
            'active_params_keywords' => $active_params_keywords,
            'active_params_sub' => $active_params_sub
        ];
        
        return view('web/etalase', $data);
    }

    public function googleCaptcha()
    {
        $recaptchaResponse = trim($this->request->getVar('g-recaptcha-response'));
        // $userIp=$this->request->ip_address();
        $secret_code='6LfGesopAAAAAKBYfLJ6WZ-e6f5-lBR4dTMUgW2T'; //with email portal: portal.nasional.id@gmail.com
        $credential = array(
                'secret' => $secret_code,
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
        return $status;
    }

    public function update_profile()
    {
        helper('text');
        $pelaku = new PelakuUsahaModel();
        if (!$this->validate([
            'nama_usaha' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Kelompok Usaha/Perusahaan Harus diisi',
                ]
            ],
            'nama_pimpinan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Penanggung Jawab Harus diisi',
                ]
            ],
            'nik_pimpinan' => [
                'rules' => 'required|min_length[16]|max_length[16]',
                'errors' => [
                    'required' => 'NIK (No.KTP Penanggung Jawab) Harus diisi',
                    'min_length' => 'NIK (No.KTP Penanggung Jawab) Harus 16 Karakter',
                    'max_length' => 'NIK (No.KTP Penanggung Jawab) Harus 16 Karakter',
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat Usaha Harus diisi',
                ]
            ],
            'kekayaan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kekayaan Bersih yang dimiliki Harus diisi',
                ]
            ],
            'jenis_usaha' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Usaha Harus diisi',
                ]
            ],
            'id_provinsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Provinsi Harus diisi',
                ]
            ],
            'id_kota' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kota / Kabupaten Harus diisi'
                ]
            ],
            'handphone' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Spesifikasi Harus diisi',
                    'numeric' => 'handphone Harus angka',
                ]
            ],
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email Harus diisi',
                ]
            ],
            'setuju' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pernyataan Harus diisi',
                ]
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $status = $this->googleCaptcha();
        $jenis_usaha = $this->request->getVar('jenis_usaha');
        if (is_array($jenis_usaha)) {
            $jenis_usaha = implode(",",$jenis_usaha);
        }else{
            $jenis_usaha = $jenis_usaha;
        }

        if($status['success']){ 
            $files = $this->request->getFile('identitas');
            if ($files->getClientExtension() == "") {
                $kodeRegis = $this->generateKodeRegis();
                $emailregis = $this->request->getVar('email');
                $set_data = [
                    'nama_pimpinan' => $this->request->getVar('nama_pimpinan'),
                    'no_izin_pirt' => $this->request->getVar('no_izin_pirt'),
                    'nama_usaha' => $this->request->getVar('nama_usaha'),
                    'nik_pimpinan' => $this->request->getVar('nik_pimpinan'),
                    'alamat' => $this->request->getVar('alamat'),
                    'kekayaan' => $this->request->getVar('kekayaan'),
                    'jenis_usaha' => $jenis_usaha,
                    'id_provinsi' => $this->request->getVar('id_provinsi'),
                    'id_kota' => (int)$this->request->getVar('id_kota'),
                    'kode_pos' => $this->request->getVar('kode_pos'),
                    'telpon' => $this->request->getVar('telpon'),
                    'handphone' => $this->request->getVar('handphone'),
                    'email' => $this->request->getVar('email'),
                    'website' => $this->request->getVar('website'),
                    'no_reg' => $kodeRegis,
                    'insert_date' => date('Y-m-d H:i:s')
                ];
            }elseif ($files->getClientExtension() != "jpg" && $files->getClientExtension() != "jpeg" && $files->getClientExtension() != "png" ) {
                session()->setFlashdata('error', 'File harus JPG atau PNG');
                return redirect()->back()->withInput();
            }else{
                $nama_pimpinan = str_replace(" ", "-",$this->request->getVar('nama_pimpinan'));
                $kodeRegis = $this->generateKodeRegis();
                $nama_file = "registrasi_".$nama_pimpinan."_".$kodeRegis.".".$files->getClientExtension();
                $files->move('assets/uploads/ktp', $nama_file);
                $emailregis = $this->request->getVar('email');
                $set_data = [
                    'nama_pimpinan' => $this->request->getVar('nama_pimpinan'),
                    'no_izin_pirt' => $this->request->getVar('no_izin_pirt'),
                    'nama_usaha' => $this->request->getVar('nama_usaha'),
                    'nik_pimpinan' => $this->request->getVar('nik_pimpinan'),
                    'alamat' => $this->request->getVar('alamat'),
                    'kekayaan' => $this->request->getVar('kekayaan'),
                    'jenis_usaha' => $jenis_usaha,
                    'id_provinsi' => $this->request->getVar('id_provinsi'),
                    'id_kota' => (int)$this->request->getVar('id_kota'),
                    'kode_pos' => $this->request->getVar('kode_pos'),
                    'identitas' => $nama_file,
                    'telpon' => $this->request->getVar('telpon'),
                    'handphone' => $this->request->getVar('handphone'),
                    'email' => $this->request->getVar('email'),
                    'website' => $this->request->getVar('website'),
                    'no_reg' => $kodeRegis,
                    'insert_date' => date('Y-m-d H:i:s')
                ];
            }
        }else{
            session()->setFlashdata('error', 'Captcha belum benar!');
            return redirect()->back()->withInput();
        }

        $id_pelaku = session()->get('user_id');
        $update = $pelaku->update($id_pelaku, $set_data);
        if ($update) {
            return redirect()->to('/profile');
        }else{
            session()->setFlashdata('error', 'Gagal kirim email');
            return redirect()->back()->withInput();
        }
    }

    public function registrasi_save()
    {
        helper('text');
        $pelaku = new PelakuUsahaModel();
        if (!$this->validate([
            'nama_usaha' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Kelompok Usaha/Perusahaan Harus diisi',
                ]
            ],
            'nama_pimpinan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Penanggung Jawab Harus diisi',
                ]
            ],
            'nik_pimpinan' => [
                'rules' => 'required|min_length[16]|max_length[16]',
                'errors' => [
                    'required' => 'NIK (No.KTP Penanggung Jawab) Harus diisi',
                    'min_length' => 'NIK (No.KTP Penanggung Jawab) Harus 16 Karakter',
                    'max_length' => 'NIK (No.KTP Penanggung Jawab) Harus 16 Karakter',
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat Usaha Harus diisi',
                ]
            ],
            'kekayaan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kekayaan Bersih yang dimiliki Harus diisi',
                ]
            ],
            'jenis_usaha' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Usaha Harus diisi',
                ]
            ],
            'id_provinsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Provinsi Harus diisi',
                ]
            ],
            'id_kota' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kota / Kabupaten Harus diisi'
                ]
            ],
            // 'kode_pos' => [
            //     'rules' => 'required|numeric',
            //     'errors' => [
            //         'required' => 'Kode Post Harus diisi',
            //         'numeric' => 'Kode Post Harus angka',
            //     ]
            // ],
            // 'telpon' => [
            //     'rules' => 'required|numeric',
            //     'errors' => [
            //         'required' => 'Deskripsi dalam bahasa inggris Harus diisi',
            //         'numeric' => 'telpon Harus angka',
            //     ]
            // ],
            'handphone' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Spesifikasi Harus diisi',
                    'numeric' => 'handphone Harus angka',
                ]
            ],
            // 'website' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'Website Harus diisi',
            //     ]
            // ],
            'email' => [
                'rules' => 'required|is_unique[pelaku_usaha.email]',
                'errors' => [
                    'required' => 'Email Harus diisi',
                    'is_unique' => 'Email sudah digunakan',
                ]
            ],
            'setuju' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pernyataan Harus diisi',
                ]
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $status = $this->googleCaptcha();
        $jenis_usaha = $this->request->getVar('jenis_usaha');
        if (is_array($jenis_usaha)) {
            $jenis_usaha = implode(",",$jenis_usaha);
        }else{
            $jenis_usaha = $jenis_usaha;
        }

        if($status['success']){ 
            $files = $this->request->getFile('identitas');
            if ($files->getClientExtension() == "") {
                $kodeRegis = $this->generateKodeRegis();
                $emailregis = $this->request->getVar('email');
                $set_data = [
                    'nama_pimpinan' => $this->request->getVar('nama_pimpinan'),
                    'no_izin_pirt' => $this->request->getVar('no_izin_pirt'),
                    'nama_usaha' => $this->request->getVar('nama_usaha'),
                    'nik_pimpinan' => $this->request->getVar('nik_pimpinan'),
                    'alamat' => $this->request->getVar('alamat'),
                    'kekayaan' => $this->request->getVar('kekayaan'),
                    'jenis_usaha' => $jenis_usaha,
                    'id_provinsi' => $this->request->getVar('id_provinsi'),
                    'id_kota' => (int)$this->request->getVar('id_kota'),
                    'kode_pos' => $this->request->getVar('kode_pos'),
                    'telpon' => $this->request->getVar('telpon'),
                    'handphone' => $this->request->getVar('handphone'),
                    'email' => $this->request->getVar('email'),
                    'website' => $this->request->getVar('website'),
                    'no_reg' => $kodeRegis,
                    'insert_date' => date('Y-m-d H:i:s')
                ];

                $ins = $pelaku->insert($set_data);
                if ($ins) {
                    $user_id = $pelaku->getInsertID();
                    $send = $this->sendMailKodeRegis($kodeRegis,$emailregis,$user_id);
                    if ($send) {
                        return redirect()->to('/register?id='.$user_id);
                    }else{
                        session()->setFlashdata('error', 'Gagal insert db');
                        return redirect()->back()->withInput();    
                    }
                }else{
                    session()->setFlashdata('error', 'Gagal insert db');
                    return redirect()->back()->withInput();
                }

            }elseif ($files->getClientExtension() != "jpg" && $files->getClientExtension() != "jpeg" && $files->getClientExtension() != "png" ) {
                session()->setFlashdata('error', 'File harus JPG atau PNG');
                return redirect()->back()->withInput();
            }else{

                $nama_pimpinan = str_replace(" ", "-",$this->request->getVar('nama_pimpinan'));
                $kodeRegis = $this->generateKodeRegis();
                $nama_file = "registrasi_".$nama_pimpinan."_".$kodeRegis.".".$files->getClientExtension();
                $files->move('assets/uploads/ktp', $nama_file);
                $emailregis = $this->request->getVar('email');
                $set_data = [
                    'nama_pimpinan' => $this->request->getVar('nama_pimpinan'),
                    'no_izin_pirt' => $this->request->getVar('no_izin_pirt'),
                    'nama_usaha' => $this->request->getVar('nama_usaha'),
                    'nik_pimpinan' => $this->request->getVar('nik_pimpinan'),
                    'alamat' => $this->request->getVar('alamat'),
                    'kekayaan' => $this->request->getVar('kekayaan'),
                    'jenis_usaha' => $jenis_usaha,
                    'id_provinsi' => $this->request->getVar('id_provinsi'),
                    'id_kota' => (int)$this->request->getVar('id_kota'),
                    'kode_pos' => $this->request->getVar('kode_pos'),
                    'identitas' => $nama_file,
                    'telpon' => $this->request->getVar('telpon'),
                    'handphone' => $this->request->getVar('handphone'),
                    'email' => $this->request->getVar('email'),
                    'website' => $this->request->getVar('website'),
                    'no_reg' => $kodeRegis,
                    'insert_date' => date('Y-m-d H:i:s')
                ];

                $ins = $pelaku->insert($set_data);
                if ($ins) {
                    $user_id = $pelaku->getInsertID();
                    $send = $this->sendMailKodeRegis($kodeRegis, $emailregis,$user_id);
                    if ($send) {
                        return redirect()->to('/register?id='.$user_id);
                    }else{
                        session()->setFlashdata('error', 'Gagal insert db');
                        return redirect()->back()->withInput();    
                    }
                }else{
                    session()->setFlashdata('error', 'Gagal insert db');
                    return redirect()->back()->withInput();
                }
            }
        }else{
            session()->setFlashdata('error', 'Captcha belum benar!');
            return redirect()->back()->withInput();
        }

        // $this->add_log("Regsitrasi dengan nama : ".$this->request->getVar('nama_usaha'));
    }

    public function generateKodeRegis($length = 5) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function generatePassword($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function sendMailKodeRegis($kodeRegis,$emailregis,$user_id)
    {
        $message = "Kepada Yth Bpk/Ibu\ndi Tempat\n\nTerima kasih telah melakukan pendaftaran pada Etalase Produk UMKM. Berikut kami sampaikan Kode Registrasi Perusahaan Anda\n\nKode Registrasi : ".$kodeRegis."\nLink Aktivasi Pendaftaran adalah : \nhttps://portal-indonesia.id/register?id=".$user_id." \n\nKode Registrasi adalah bersifat Rahasia, mohon untuk tidak diberitahukan kepada pihak yang tidak berkepentingan. \n\nTerima kasih \nOperator\nEmail : info@portal-indonesia.id "; 
        $email = \Config\Services::email(); 
        $email->setFrom('info@portal-indonesia.id', 'Portal Nasional Pusat Informasi Produk Indonesia');
        $email->setTo($emailregis);
        $email->setSubject('Etalase Produk UMKM Indonesia - Kode Registrasi');
        $email->setMessage($message);
        
        // $email->setCC('another@emailHere');
        // $email->setBCC('thirdEmail@emialHere');
        // $filename = '/img/yourPhoto.jpg';
        // $email->attach($filename);
            
        $email->send();
        if ($email->send(false)){
            return false;
        }else{
            return true;
        }
    }

    public function sendMailUserLogin($password,$emailregis)
    {
        $message = "Terimakasih telah melakukan Registrasi, silahkan login dengan menggunakan email anda dan password ".$password;
        $email = \Config\Services::email(); 
        $email->setFrom('info@portal-indonesia.id', 'Portal Nasional Pusat Informasi Produk Indonesia');
        $email->setTo($emailregis);
        $email->setSubject('Etalase Produk UMKM Indonesia - Registrasi Berhasil');
        $email->setMessage($message);
        
        // $email->setCC('another@emailHere');
        // $email->setBCC('thirdEmail@emialHere');
        // $filename = '/img/yourPhoto.jpg';
        // $email->attach($filename);
            
        $email->send();
    }

    public function cek_regis()
    {
        $request = service('request');
        $pelaku_usaha = new PelakuUsahaModel();
        $provinsi = new ProvinsiModel();
        $kota = new KotaModel();
        $kode_regis = $this->request->getVar('no_reg');
        $id_params = $request->getGet('id');
        $cek = $pelaku_usaha->where('id_pelaku', $id_params)->where('no_reg', $kode_regis)->get()->getNumRows();
        if ($cek <= 0) {
            session()->setFlashdata('errorcek', 'Kode Registrasi Salah');
            return redirect()->back()->withInput();
        }else{
            $data['showRegisProduk'] = 'true';
            $data['showKodeRegis'] = 'true';
            $data['model'] = $pelaku_usaha->find($id_params);
            $data['kabkot'] = $kota->where('id_provinsi', $data['model']->id_provinsi)->findAll();
            $data['tab_active'] = "regisproduk";
            $data['kode_regis'] = $kode_regis;
            $data['id'] = $id_params;
            $data['active'] = "register";
            $data['provinsi'] = $provinsi->orderBy('id_provinsi', 'ASC')->findAll();
            $password = $this->generatePassword();
            
            $update = $pelaku_usaha->update($id_params, ['status_registrasi'=> 1, 'password' => md5($password), 'real_password'=> $password]);
            if ($update) {
                $emailregis = $data['model']->email;
                $this->sendMailUserLogin($password,$emailregis);
                $this->auth_process_regis($emailregis, $password);
            }

            return redirect()->to(base_url('profile'));

        }
    }

    public function info()
    {
        $data['active'] = "info";
        return view('web/info', $data);
    }

    public function profile()
    {
        $pelaku_usaha = new PelakuUsahaModel();
        $provinsi = new ProvinsiModel();
        $kota = new KotaModel();
        $produk = new ProdukModel();
        $kategori = new KategoriModel();
        $subkategori = new SubKategoriModel();
        $id_pelaku = session()->get('user_id');
        $request = service('request');
        $data['produk'] = $produk->select([
            'produk.id_produk',
            'produk.id_kategori',
            'produk.nama_produk',
            'produk.foto_produk',
            'produk.status',
            'kategori_produk.kategori',
            'pelaku_usaha.jenis_usaha',
            'pelaku_usaha.email',
            'pelaku_usaha.handphone'
        ])
        ->join('kategori_produk', 'kategori_produk.id_kategori = produk.id_kategori')
        ->join('pelaku_usaha', 'pelaku_usaha.id_pelaku = produk.id_pelaku_usaha')
        ->where('produk.id_pelaku_usaha', $id_pelaku)
        // ->where('produk.status', 1)
        ->paginate(3);
        
        $pager = \Config\Services::pager();
        $data['model'] = $pelaku_usaha->find($id_pelaku);
        $data['kabkot'] = $kota->where('id_provinsi', $data['model']->id_provinsi)->findAll();
        if($data['model']->status_registrasi == 2){
            $data['showRegisProduk'] = 'true';
            $data['tab_active'] = "regisproduk";
        }elseif($data['model']->status_registrasi == 1){
            $data['tab_active'] = "regispelaku";
        }
        $data['status_registrasi'] = $data['model']->status_registrasi;
        $data['kode_regis'] = $data['model']->no_reg;
        $data['id'] = $id_pelaku;
        $data['active'] = "logging_in";
        $data['provinsi'] = $provinsi->orderBy('id_provinsi', 'ASC')->findAll();
        $data['kategori'] = $kategori->findAll();
        $data['pager'] = $produk->pager;
        $edit_params = $request->getGet('edit');
        
        if(isset($edit_params) && $edit_params != "" ){
            $produknya = $produk->where('id_produk', $edit_params)->where('id_pelaku_usaha', $id_pelaku)->first();
            if ($produknya) {
                $data['edit'] = $produk->find($edit_params);
                $data['subkategori'] = $subkategori->where('id_kategori', $produknya->id_kategori)->findAll();
            }else{
                session()->setFlashdata('errorproduk', 'Bukan Produk Anda!');
            }
        }
        return view('web/profile', $data);
    }

    public function update_produk($id_produk)
    {
        helper('text');
        $produk = new ProdukModel();
        $pelaku_usaha = new PelakuUsahaModel();
        
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
            'nama_produk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Produk Harus diisi',
                ]
            ],
            /* 'spesifikasi_in' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Spesifikasi Harus diisi',
                ]
            ], */
            'kapasitas_produksi' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Kapasitas Produksi Perbulan (Volume) Harus diisi',
                    'numeric' => 'Kapasitas Produksi Perbulan (Volume) Harus angka',
                ]
            ],
            'satuan_kapasitas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Satuan Kapasitas Produksi Perbulan Harus diisi',
                ]
            ],
            'tkdn' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'numeric' => '{field} Harus angka',
                ]
            ],
            'setuju' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pernyataan Harus diisi',
                ]
            ],
        ])) {
            session()->setFlashdata('error_cek', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $ids = session()->get('user_id');
        $pelaku = $pelaku_usaha->find($ids);
        $status = $this->googleCaptcha();

        if ($this->request->getVar('kategori') == 1 && $this->request->getVar('jenis_makanan') == "") {
            session()->setFlashdata('error_cek', "Jenis Makanan Harus di Isi");
            return redirect()->back()->withInput();
        }elseif($this->request->getVar('kategori') == 1 && $this->request->getVar('jenis_makanan') != ""){
            $jenis_makanan = $this->request->getVar('jenis_makanan');
        }else{
            $jenis_makanan = "";
        }

        if ($this->request->getVar('kategori') == 1 && $this->request->getVar('jenis_makanan') == "Bersertifikasi Halal" && $this->request->getVar('no_halal') == "") {
            session()->setFlashdata('error_cek', "No. Sertifikasi Halal Harus di Isi");
            return redirect()->back()->withInput();
        }elseif ($this->request->getVar('kategori') == 1 && $this->request->getVar('jenis_makanan') == "Bersertifikasi Halal" && $this->request->getVar('no_halal') != "") {
            $no_halal = $this->request->getVar('no_halal');
        }else{
            $no_halal = "";
        }

        if($status['success']){
            $files = $this->request->getFile('foto_produk');
            if ($files->getClientExtension() == "") {
                $produk->update($id_produk, [
                    'id_kategori' => $this->request->getVar('kategori'), 
                    'id_sub' => $this->request->getVar('subkategori'),
                    'id_pelaku_usaha' => $ids,
                    'nama_produk' => $this->request->getVar('nama_produk'),
                    'jenis_makanan' => $jenis_makanan,
                    'no_halal' => $no_halal,
                    'deskripsi_in' => $this->request->getVar('deskripsi_in'),
                    'deskripsi_en' => $this->request->getVar('deskripsi_en'),
                    'spesifikasi_in' => $this->request->getVar('spesifikasi_in'),
                    'spesifikasi_en' => $this->request->getVar('spesifikasi_en'),
                    'kapasitas_produksi' => $this->request->getVar('kapasitas_produksi'),
                    'satuan_kapasitas' => $this->request->getVar('satuan_kapasitas'),
                    'tkdn' => $this->request->getVar('tkdn'),
                    'no_registrasi' => $pelaku->no_reg,
                    'tahun_reg' => date('Y'),
                    // 'foto_produk' => $nama_file,
                    'id_provinsi' => $pelaku->id_provinsi,
                    'id_kota' => $pelaku->id_kota,
                    'insert_date' => date('Y-m-d H:i:s')
                ]);

                session()->setFlashdata('sukses', 'Berhasil mengubah produk '.$this->request->getVar('nama_produk'));
                return redirect()->to('/profile');

            }elseif ($files->getClientExtension() != "jpg" && $files->getClientExtension() != "jpeg" && $files->getClientExtension() != "png" ) {
                session()->setFlashdata('error_cek', 'File harus JPG atau PNG');
                return redirect()->back()->withInput();
            }else{
                $nama_produk = str_replace(" ", "-",$this->request->getVar('nama_produk'));
                $unik = random_string('numeric', 5);
                $nama_file = "produk_".$nama_produk."_".$unik.".".$files->getClientExtension();
                $files->move('assets/uploads', $nama_file);
    
                $produk->update($id_produk, [
                    'id_kategori' => $this->request->getVar('kategori'), 
                    'id_sub' => $this->request->getVar('subkategori'),
                    'id_pelaku_usaha' => $ids,
                    'nama_produk' => $this->request->getVar('nama_produk'),
                    'jenis_makanan' => $jenis_makanan,
                    'no_halal' => $no_halal,
                    'deskripsi_in' => $this->request->getVar('deskripsi_in'),
                    'deskripsi_en' => $this->request->getVar('deskripsi_en'),
                    'spesifikasi_in' => $this->request->getVar('spesifikasi_in'),
                    'spesifikasi_en' => $this->request->getVar('spesifikasi_en'),
                    'kapasitas_produksi' => $this->request->getVar('kapasitas_produksi'),
                    'satuan_kapasitas' => $this->request->getVar('satuan_kapasitas'),
                    'tkdn' => $this->request->getVar('tkdn'),
                    'no_registrasi' => $pelaku->no_reg,
                    'tahun_reg' => date('Y'),
                    'foto_produk' => $nama_file,
                    'id_provinsi' => $pelaku->id_provinsi,
                    'id_kota' => $pelaku->id_kota,
                    'insert_date' => date('Y-m-d H:i:s')
                ]);
    
                // $this->add_log($ids, "Menambah produk dengan nama : ".$this->request->getVar('nama_produk'));
                session()->setFlashdata('sukses', 'Berhasil mengubah produk '.$this->request->getVar('nama_produk'));
                return redirect()->to('/profile');
            }
        }else{
            session()->setFlashdata('error', 'Captcha belum benar!');
            return redirect()->back()->withInput();
        }
    }

    public function save_produk()
    {
        helper('text');
        $produk = new ProdukModel();
        $pelaku_usaha = new PelakuUsahaModel();

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
            'nama_produk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Produk Harus diisi',
                ]
            ],
            'spesifikasi_in' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Spesifikasi Harus diisi',
                ]
            ],
            // 'spesifikasi_en' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'Spesifikasi dalam bahasa inggris Harus diisi',
            //     ]
            // ],
            'kapasitas_produksi' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Kapasitas Produksi Perbulan (Volume) Harus diisi',
                    'numeric' => 'Kapasitas Produksi Perbulan (Volume) Harus angka',
                ]
            ],
            'satuan_kapasitas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Satuan Kapasitas Produksi Perbulan Harus diisi',
                ]
            ],
            'tkdn' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'numeric' => '{field} Harus angka',
                ]
            ],
            'setuju' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pernyataan Harus diisi',
                ]
            ],
        ])) {
            session()->setFlashdata('error_cek', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $ids = session()->get('user_id');
        $pelaku = $pelaku_usaha->find($ids);
        $status = $this->googleCaptcha();
        
        if ($this->request->getVar('kategori') == 1 && $this->request->getVar('jenis_makanan') == "") {
            session()->setFlashdata('error_cek', "Sertifikasi Halal Harus di Isi");
            return redirect()->back()->withInput();
        }elseif($this->request->getVar('kategori') == 1 && $this->request->getVar('jenis_makanan') != ""){
            $jenis_makanan = $this->request->getVar('jenis_makanan');
        }else{
            $jenis_makanan = "";
        }

        if ($this->request->getVar('kategori') == 1 && $this->request->getVar('jenis_makanan') == "Bersertifikasi Halal" && $this->request->getVar('no_halal') == "") {
            session()->setFlashdata('error_cek', "No. Sertifikasi Halal Harus di Isi");
            return redirect()->back()->withInput();
        }elseif ($this->request->getVar('kategori') == 1 && $this->request->getVar('jenis_makanan') == "Bersertifikasi Halal" && $this->request->getVar('no_halal') != "") {
            $no_halal = $this->request->getVar('no_halal');
        }else{
            $no_halal = "";
        }

        if($status['success']){
            $files = $this->request->getFile('foto_produk');
            if ($files->getClientExtension() == "") {
                session()->setFlashdata('error_cek', 'Foto harus diisi');
                return redirect()->back()->withInput();
            }elseif ($files->getClientExtension() != "jpg" && $files->getClientExtension() != "jpeg" && $files->getClientExtension() != "png" ) {
                session()->setFlashdata('error_cek', 'File harus JPG atau PNG');
                return redirect()->back()->withInput();
            }else{
                $nama_produk = str_replace(" ", "-",$this->request->getVar('nama_produk'));
                $unik = random_string('numeric', 5);
                $nama_file = "produk_".$nama_produk."_".$unik.".".$files->getClientExtension();
                $files->move('assets/uploads', $nama_file);
    
                $produk->insert([
                    'id_kategori' => $this->request->getVar('kategori'), 
                    'id_sub' => $this->request->getVar('subkategori'),
                    'id_pelaku_usaha' => $ids,
                    'nama_produk' => $this->request->getVar('nama_produk'),
                    'jenis_makanan' => $jenis_makanan,
                    'no_halal' => $no_halal,
                    'deskripsi_in' => $this->request->getVar('deskripsi_in'),
                    'deskripsi_en' => $this->request->getVar('deskripsi_en'),
                    'spesifikasi_in' => $this->request->getVar('spesifikasi_in'),
                    'spesifikasi_en' => $this->request->getVar('spesifikasi_en'),
                    'kapasitas_produksi' => $this->request->getVar('kapasitas_produksi'),
                    'satuan_kapasitas' => $this->request->getVar('satuan_kapasitas'),
                    'tkdn' => $this->request->getVar('tkdn'),
                    'no_registrasi' => $pelaku->no_reg,
                    'tahun_reg' => date('Y'),
                    'foto_produk' => $nama_file,
                    'id_provinsi' => $pelaku->id_provinsi,
                    'id_kota' => $pelaku->id_kota,
                    'insert_date' => date('Y-m-d H:i:s')
                ]);
    
                // $this->add_log($ids, "Menambah produk dengan nama : ".$this->request->getVar('nama_produk'));
                session()->setFlashdata('sukses', 'Berhasil menambahkan produk '.$this->request->getVar('nama_produk').'. Produk akan muncul di etalase setelah diverifikasi oleh admin. Terimakasih!' );
                return redirect()->to('/profile');
            }
        }else{
            session()->setFlashdata('error_cek', 'Captcha belum benar!');
            return redirect()->back()->withInput();
        }
    }

    public function hapus_produk($id)
    {
        $produk = new ProdukModel();
        $produk->delete($id);
        $ids = session()->get('user_id');
        $this->add_log($ids, "Menghapus produk dengan ID : ".$id);
        session()->setFlashdata('sukses', 'Berhasil menghapus produk');
        return redirect()->to('/profile');
    }

    public function panduan()
    {
        $data['active'] = "panduan";
        return view('web/panduan', $data);
    }

    public function register()
    {
        $request = service('request');
        $provinsi = new ProvinsiModel();
        $pelaku_usaha = new PelakuUsahaModel();
        $kota = new KotaModel();
        $id_params = $request->getGet('id');
        if (isset($id_params)) {
            $data['showKodeRegis'] = 'true';
            $data['model'] = $pelaku_usaha->find($id_params);
            if(session()->get('logged_in')  ){
                $data['model_cek'] = null;
                $data['pesan'] = "Anda sudah melakukan registrasi";
            }else{
                if ($data['model'] == null) {
                    $data['model_cek'] = null;
                    $data['pesan'] = "Mohon Maaf Halaman Tidak Ada";
                }else{
                    if ($data['model']->status_registrasi > 0 ) {
                        $data['model_cek'] = null;
                        $data['pesan'] = "Mohon Maaf Halaman Tidak Ada";
                    }else{
                        $data['kabkot'] = $kota->where('id_provinsi', $data['model']->id_provinsi)->findAll();
                        $data['tab_active'] = "kode_regis";
                        $data['model_cek'] = "notnull";
                        $data['id'] = $id_params;
                    }
                }
            }
        }elseif(session()->get('logged_in')){
            // $data['showRegisProduk'] = 'true';
            // $data['showKodeRegis'] = 'true';
            // $data['model'] = $pelaku_usaha->find($id_params);
            // if ($data['model'] == null) {
            //     $data['model_cek'] == null;
            // }else{
            //     if ($data['model'][0]->status_registrasi <= 1) {
            //         $data['model_cek'] = null;
            //     }else{
            //         $data['kabkot'] = $kota->where('id_provinsi', $data['model'][0]->id_provinsi)->findAll();
            //         $data['tab_active'] = "regisproduk";
            //         $data['kode_regis'] = $data['model'][0]->no_reg;
            //         $data['id'] = $id_params;
            //         $data['model_cek'] = "notnull";
            //     }
            // }
            $data['model_cek'] = null;
            $data['pesan'] = "Anda sudah melakukan registrasi";
        }else{
            $data['tab_active'] = "regispelaku";
            $data['model_cek'] = "notnull";
        }
        $data['active'] = "register";
        $data['provinsi'] = $provinsi->orderBy('id_provinsi', 'ASC')->findAll();
        return view('web/register', $data);
    }

    public function faq()
    {
        $data['active'] = "faq";
        $faq = new FaqModel();
        $data['faq'] = $faq->where('status','0')->findAll();
        return view('web/faq', $data);
    }

    public function contact_us()
    {
        $name = $_POST['name'];
        $emails = $_POST['email'];
        $message = $_POST['message'];

        $message = "Nama : ".$name."\nEmail : ".$emails."\nMessage : ".$message;
        $email = \Config\Services::email(); 
        $email->setFrom('info@portal-indonesia.id', 'Portal Nasional Pusat Informasi Produk Indonesia');
        $email->setTo("info@portal-indonesia.id");
        $email->setSubject('Etalase Produk UMKM Indonesia - Send Contact Us');
        $email->setMessage($message);
        $status = $this->googleCaptcha();
        
        if($status['success']){
            $email->send();
            if ($email->send(false)){
                session()->setFlashdata('errorSend', 'Your message has not benn sent.');
                return redirect()->back()->withInput();
            }else{
                session()->setFlashdata('success', 'Your message has been sent. Thank you!');
                return redirect()->to('/contact');
            }
        }else{
            session()->setFlashdata('errorSend', 'Captcha tidak benar!');
            return redirect()->back()->withInput();
        }
        // $email->setCC('another@emailHere');
        // $email->setBCC('thirdEmail@emialHere');
        // $filename = '/img/yourPhoto.jpg';
        // $email->attach($filename);
    }

    public function contact()
    {
        $data['active'] = "contact_us";
        return view('web/contact', $data);
    }

    public function kuliner()
    {
        $pager = \Config\Services::pager();
        $kuliner = new KulinerModel();
        $provinsi = new ProvinsiModel();
        $kota = new KotaModel();
        $request = service('request');
        $keyword_params = $request->getGet('keyword');
        $provinsi_params = $request->getGet('provinsi');
        $kota_params = $request->getGet('kota');
        $value_params="";
        $prov_params="";
        $kot_params="";
        $queryKuliner = $kuliner;
        $kotas = $kota->findAll();
        $queryKuliner->select('kuliner.*, provinsi.nama_provinsi, mst_kota.nama as nama_kota, sub_kategori_produk.nama as nama_kategori');

        
        if(isset($provinsi_params) ){
            $queryKuliner->where('kuliner.id_provinsi', $provinsi_params);
            $kotas = $kota->where('id_provinsi', $provinsi_params)->findAll();
            $prov_params=$provinsi_params;
        }
        
        if(isset($kota_params) ){
            $queryKuliner->where('kuliner.id_kota', $kota_params);
            $kot_params=$kota_params;
        }
        
        if(isset($keyword_params) ){
            $queryKuliner->like('kuliner.nama', $keyword_params, 'both');
            $queryKuliner->orLike('kuliner.alamat', $keyword_params, 'both');
            $value_params=$keyword_params;
        }

        $queryKuliner->join('provinsi', 'provinsi.id_provinsi = kuliner.id_provinsi')->join('mst_kota', 'mst_kota.id = kuliner.id_kota')->join('sub_kategori_produk', 'sub_kategori_produk.id_sub = kuliner.kategori');
        $data = [
            'kuliner' => $queryKuliner->paginate(12),
            'provinsi' => $provinsi->orderBy('id_provinsi', 'ASC')->findAll(),
            'kota' => $kotas,
            'pager' => $kuliner->pager,
            'active' => "lokasi_kuliner",
            'value_params'=> $value_params,
            'prov_params' => $prov_params,
            'kot_params' => $kot_params
        ];
        // var_dump($data['kota']);
        return view('web/kuliner', $data);
    }

    function detail($id)
    {
        $data['active'] = "etalase";
        $produk = new ProdukModel();
        $data['produk'] = $produk->select([
            'produk.nama_produk',
            'mst_kota.nama as nama_kota',
            'provinsi.nama_provinsi',
            'produk.insert_date',
            'produk.spesifikasi_in',
            'pelaku_usaha.nama_usaha',
            'pelaku_usaha.alamat',
            'pelaku_usaha.handphone',
            'pelaku_usaha.email',
            'produk.tokopedia',
            'produk.bukalapak',
            'produk.shoope',
            'produk.foto_produk'
        ])->join('pelaku_usaha', 'pelaku_usaha.id_pelaku = produk.id_pelaku_usaha', 'left')
        ->join('mst_kota', 'mst_kota.id = produk.id_kota','left')
        ->join('provinsi', 'provinsi.id_provinsi = produk.id_provinsi', 'left')
        ->where('produk.id_produk', $id)->findAll();
        // var_dump($data['produk']);
        return view('web/detail_page', $data);
    }

    public function video()
    {
        $data['active'] = "info";
        $video = new VideoModel();
        $data['video'] = $video->orderBy('id_video', 'DESC')->findAll();
        return view('web/video', $data);
    }

    public function kegiatan()
    {
        $data['active'] = "info";
        $kegiatan = new KegiatanModel();
        $data['kegiatan'] = $kegiatan->select('pembinaan.*, penyelenggara.nama as namaPenyelenggara, provinsi.nama_provinsi, mst_kota.nama as namakota, kategori_produk.kategori as namakategori')
            ->join('penyelenggara', 'penyelenggara.id_penyelenggara = pembinaan.penyelenggara', 'left')
            ->join('provinsi', 'provinsi.id_provinsi = pembinaan.id_provinsi', 'left')
            ->join('mst_kota', 'mst_kota.id = pembinaan.id_kota', 'left')
            ->join('kategori_produk', 'kategori_produk.id_kategori = pembinaan.kategori_produk', 'left')
            ->where('pembinaan.status', 1)->findAll();
        

        if (!empty($data['kegiatan'])) {
            if (((strtotime(date('Y-m-d')) - strtotime($data['kegiatan'][0]->tanggal_publikasi)) / 60 / 60 / 24) >= 0) {
                $data['kegiatan'] = $data['kegiatan'];
            } else {
                $data['kegiatan'] = [];
            }
        }
        return view('web/kegiatan', $data);
    }

    public function register_kegiatan($namakegiatan)
    {
        $kegiatan = new KegiatanModel;
        $pelaku_usaha = new PelakuUsahaModel;
        $produk = new ProdukModel;
        $peserta = new PesertaPembinaanModel;

        $namakegiatan = str_replace("-", " ",$namakegiatan);
        $data['kegiatan'] = $kegiatan->select('pembinaan.*, penyelenggara.nama as namaPenyelenggara')
            ->join('penyelenggara', 'penyelenggara.id_penyelenggara = pembinaan.penyelenggara', 'left')
            ->where('pembinaan.nama_kegiatan', $namakegiatan)->findAll();
        $dataPeserta = $peserta->select('peserta_pembinaan.list_barang, pelaku_usaha.nama_usaha')
            ->join('pelaku_usaha', 'pelaku_usaha.id_pelaku = peserta_pembinaan.id_pelaku', 'left')
            ->where('peserta_pembinaan.status_kehadiran', 1)
            ->where('peserta_pembinaan.id_pembinaan', $data['kegiatan'][0]->id_pembinaan)->findAll();
        $sudahDaftar = $peserta->select('')->where('id_pelaku', session()->get('user_id'))->where('id_pembinaan', $data['kegiatan'][0]->id_pembinaan)->findAll();
        
        if(session()->get('logged_in') == null){
            return redirect('login');
        } elseif(count($dataPeserta) == $data['kegiatan'][0]->kapasitas_peserta || ((strtotime(date('Y-m-d')) - strtotime($data['kegiatan'][0]->batas_pendaftaran)) / 60 / 60 / 24) > 0){
            session()->setFlashdata('errorDaftar', 'Mohon maaf anda belum bisa melakukan pendaftaran kuota peserta sudah penuh. Terima kasih');
            return redirect()->to('/detail-kegiatan/'.str_replace(" ", "-",$namakegiatan));
        } elseif(!empty($sudahDaftar)){
            session()->setFlashdata('errorDaftar', 'MOHON MAAF ANDA SUDAH MENDAFTAR '.$namakegiatan.'. Terima kasih');
            return redirect()->to('/riwayat');
        } else {
            $id_pelaku = session()->get('user_id');
            $namakegiatan = str_replace("-", " ",$namakegiatan);
            $data_pembinaan = $kegiatan->select('pembinaan.id_pembinaan, pembinaan.lokasi_pameran, pembinaan.waktu_akhir, pembinaan.waktu_awal, pembinaan.kategori_produk, kategori_produk.kategori as namakategori')->join('kategori_produk', 'kategori_produk.id_kategori = pembinaan.kategori_produk', 'left')->where('pembinaan.nama_kegiatan', $namakegiatan)->findAll();
            $data_pelaku_usaha = $pelaku_usaha->select('id_pelaku, nama_usaha, no_izin_pirt, nama_pimpinan, alamat, telpon, handphone')->find($id_pelaku);
            $dataproduk = $produk->select('produk.id_produk, produk.nama_produk, produk.kapasitas_produksi, produk.satuan_kapasitas, kategori_produk.kategori as jenis')
            ->join('kategori_produk', 'kategori_produk.id_kategori = produk.id_kategori', 'left')
            ->where('produk.id_pelaku_usaha', $id_pelaku)
            ->whereIn('produk.id_kategori', json_decode($data_pembinaan[0]->kategori_produk))->where('produk.status', 1)->findAll();
            $data['level'] = session()->get('level');
            $data['active'] = "info";
            $data['namakegiatan'] = $namakegiatan;
            $data['tempat'] = $data_pembinaan[0]->lokasi_pameran;
            $data['waktu_akhir'] = date('d F Y', strtotime($data_pembinaan[0]->waktu_akhir));
            $data['waktu_awal'] = date('d', strtotime($data_pembinaan[0]->waktu_awal));
            $data['id_pembinaan'] = $data_pembinaan[0]->id_pembinaan;
            $data['namakategori'] = $data_pembinaan[0]->namakategori;
            $data['id_pelaku'] = $id_pelaku;
            $data['pelaku_usaha'] = $data_pelaku_usaha;
            $data['produk'] = $dataproduk;
            return view('web/register_kegiatan', $data);
        }
    }

    public function save_register_kegiatan()
    {
        helper('text');
        $peserta_pembinaan = new PesertaPembinaanModel();
        $pelaku_usaha = new PelakuUsahaModel();
        $pembinaan = new KegiatanModel();
        if (!$this->validate([
            
            'nama_pj' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Penanggung Jawab Harus diisi',
                ]
            ],
            'jabatan_pj' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jabatan Penanggung Jawab Harus diisi',
                ]
            ],
            'kontak_pj' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'No HP Harus diisi',
                    'numeric' => 'No HP Harus angka',
                ]
            ],
            'syarat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pernyataan Harus diisi',
                ]
            ],
            'produkpilihan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Produk yang dipamerkan Harus diisi',
                ]
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $produkpilihan = implode(",",$this->request->getVar('produkpilihan'));
        $nama_pj = $this->request->getVar('nama_pj');
        $jabatan_pj = $this->request->getVar('jabatan_pj');
        $kontak_pj = $this->request->getVar('kontak_pj');
        $id_pembinaan = $this->request->getVar('id_pembinaan');
        $id_pelaku = session()->get('user_id');

        $sudahDaftar = $peserta_pembinaan->where('id_pembinaan', $id_pembinaan)->where('id_pelaku', $id_pelaku)->first();
        $datapelaku = $pelaku_usaha->select('email')->find($id_pelaku);
        $datapembinaan = $pembinaan->select('nama_kegiatan')->find($id_pembinaan);

        if ($sudahDaftar) {
            session()->setFlashdata('errorDaftar', 'Anda sudah mendaftar pameran!');
            return redirect()->to('/riwayat');
        } else {
            $q = $peserta_pembinaan->insert([
                'id_pembinaan' => $id_pembinaan,
                'id_pelaku' => $id_pelaku, 
                'status_kehadiran' => 0,
                'tanggal' => date('Y-m-d H:i:s'),
                'list_barang' => $produkpilihan,
                'nama_pj' => $nama_pj,
                'jabatan_pj' => $jabatan_pj,
                'kontak_pj' => $kontak_pj
            ]);

            if ($q) {
                $send_email = $this->sendMailRegistrasiPeserta($datapelaku->email, $datapembinaan->nama_kegiatan);
                if ($send_email) {
                    session()->setFlashdata('sukses', 'Berhasil mendaftarkan pameran ');
                    return redirect()->to('/riwayat');
                } else {
                    session()->setFlashdata('errorDaftar', 'Gagal mengirim email ');
                    return redirect()->to('/riwayat');
                }
            } else {
                session()->setFlashdata('errorDaftar', 'Gagal mendaftarkan pameran ');
                return redirect()->to('/riwayat');
            }
        }
    }

    public function sendMailRegistrasiPeserta($emailregis,$nama_kegiatan)
    {
        $message = "Terima kasih telah melakukan pendaftaran pada Kegiatan Pameran ".$nama_kegiatan.".\n\nMohon menunggu keputusan panitia untuk hasil peserta yang lolos pada kegiatan Pameran ".$nama_kegiatan."\n\nTerima Kasih \nOperator \nEmail : info@portal-indonesia.id";
        $email = \Config\Services::email(); 
        $email->setFrom('info@portal-indonesia.id', 'Portal Nasional Pusat Informasi Produk Indonesia');
        $email->setTo($emailregis);
        $email->setSubject('Etalase Produk UMKM Indonesia - Kode Registrasi');
        $email->setMessage($message);
        
        // $email->setCC('another@emailHere');
        // $email->setBCC('thirdEmail@emialHere');
        // $filename = '/img/yourPhoto.jpg';
        // $email->attach($filename);
            
        $email->send();
        if ($email->send(false)){
            return false;
        }else{
            return true;
        }
    }

    public function daftar_kegiatan($id_pembinaan)
    {
        $user_id = session()->get('user_id');
        $peserta_pembinaan = new PesertaPembinaanModel();
        $kegiatan = new KegiatanModel();
        $pelaku_usaha = new PelakuUsahaModel();
        $data_pelaku_usaha = $pelaku_usaha->where('id_pelaku', $user_id)->first();
        $data_kegiatan = $kegiatan->where('id_pembinaan',$id_pembinaan)->first();
        $set_data = [
            'id_pembinaan' => $id_pembinaan,
            'id_pelaku' => $user_id
        ];
        $url = base_url()."/riwayat";
        $sudahDaftar = $peserta_pembinaan->where('id_pembinaan', $id_pembinaan)->where('id_pelaku', $user_id)->first();
        if ($sudahDaftar) {
            session()->setFlashdata('errorDaftar', 'Anda sudah mendaftar kegiatan '.$data_kegiatan->nama_kegiatan.'! <br/> Untuk melihat informasi kegiatan <a href='.$url.' >Klik disini</a>');
            return redirect()->to('/kegiatan');
        }else{
            $insert = $peserta_pembinaan->insert($set_data);
            if ($insert) {
                $send_email = $this->sendMailDaftarKegiatan($data_pelaku_usaha->email, $data_kegiatan->nama_kegiatan);
                if ($send_email) {
                    session()->setFlashdata('success', 'Selamat anda berhasil mendaftar kegiatan '.$data_kegiatan->nama_kegiatan.'!');
                    return redirect()->to('/kegiatan');
                }
            }else{
                session()->setFlashdata('errorDaftar', 'Gagal melakukan pendaftaran');
                return redirect()->to('/kegiatan');
            }
        }
    }

    public function sendMailDaftarKegiatan($emailregis,$nama_kegiatan)
    {
        $message = "Terimakasih telah mendaftar kegiatan ".$nama_kegiatan;
        $email = \Config\Services::email(); 
        $email->setFrom('info@portal-indonesia.id', 'Portal Nasional Pusat Informasi Produk Indonesia');
        $email->setTo($emailregis);
        $email->setSubject('Etalase Produk UMKM Indonesia - Kode Registrasi');
        $email->setMessage($message);
        
        // $email->setCC('another@emailHere');
        // $email->setBCC('thirdEmail@emialHere');
        // $filename = '/img/yourPhoto.jpg';
        // $email->attach($filename);
            
        $email->send();
        if ($email->send(false)){
            return false;
        }else{
            return true;
        }
    }

    public function peraturan()
    {
        $data['active'] = "info";
        $tatacara = new TataCaraModel();
        $tatacara = new TataCaraModel();
        $tatacara = new TataCaraModel();
        $data['tatacara'] = $tatacara->join('kategori_tatacara', 'kategori_tatacara.id_kategori = tatacara.id_kategori')->orderBy('id_tatacara', 'desc')->findALl();
        return view('web/peraturan', $data);
    }
    
    public function pelaku_usaha()
    {
        $pelaku_usaha = new PelakuUsahaModel();
        $provinsi = new ProvinsiModel();
        $kota = new KotaModel();
        // $data['kota'] = $kota->findAll();
        $request = service('request');
        $pager = \Config\Services::pager();
        $provinsi_params = $request->getGet('provinsi');
        $kota_params = $request->getGet('kota');
        $keyword_params = $request->getGet('keyword');
        $active_params_prov="";
        $active_params_kota= "";
        $active_params_keyword="";
        $query_kota = $kota;
        $link = base_url()."/pelaku-usaha/export-excel?type=export";
        $query_pelaku = $pelaku_usaha->join('mst_kota', 'mst_kota.id = pelaku_usaha.id_kota', 'left')
        ->join('provinsi', 'provinsi.id_provinsi = pelaku_usaha.id_provinsi', 'left')
        ->where('status_registrasi', 2)->orderBy('nama_produk', 'desc');

        if(isset($kota_params) ){
            $active_params_kota = $kota_params;
            $link = $link."&kota=".$kota_params;
            $query_pelaku->where('mst_kota.nama',$kota_params);
        }

        if(isset($provinsi_params) ){
            $active_params_prov = $provinsi_params;
            $query_pelaku->where('provinsi.nama_provinsi',$provinsi_params);
            $data_prov = $provinsi->where('nama_provinsi', $provinsi_params)->findAll();
            $id_prov = $data_prov[0]->id_provinsi;
            $query_kota->where('id_provinsi',$id_prov);
            $link = $link."&provinsi=".$provinsi_params;
        }

        if(isset($keyword_params) ){
            $active_params_keyword = $keyword_params;
            $query_pelaku->like('nama_usaha', $keyword_params, 'both');
            $link = $link."&keyword=".$keyword_params;
        }

        // $count['pelaku'] = $query_pelaku->paginate(10);
        $data = [
            'provinsi' => $provinsi->orderBy("id_provinsi", "ASC")->findAll(),
            'pelaku_usaha' => $query_pelaku->paginate(10),
            'pager' => $pelaku_usaha->pager,
            'active' => "pelaku_usaha",
            'kota' => $query_kota->findAll(),
            'params_prov' => $active_params_prov,
            'params_kota' => $active_params_kota,
            'params_keyword' => $active_params_keyword,
            // 'tampil_data' => count($count['pelaku']),
            'link' => $link,
            'total' => count($pelaku_usaha->where('status_registrasi', 2)->findAll())
        ];
        array_push($data, ['tampil_data' => count($data['pelaku_usaha']) ]);
        // var_dump($data[0]['tampil_data']);
        return view('web/pelaku_usaha', $data);
    }

    public function riwayat()
    {
        $data['active'] = "riwayat";
        $user_id = session()->get('user_id');
        $peserta_pembinaan = new PesertaPembinaanModel();
        $data['pembinaan'] = $peserta_pembinaan
        ->select([
            'pembinaan.id_pembinaan',
            'pembinaan.nama_kegiatan',
            'pembinaan.waktu_awal',
            'pembinaan.waktu_akhir',
            'pembinaan.lokasi_pameran',
            'pembinaan.penyelenggara',
            'peserta_pembinaan.status_kehadiran',
            'peserta_pembinaan.nama_pj',
            'peserta_pembinaan.jabatan_pj',
            'peserta_pembinaan.kontak_pj',
            'peserta_pembinaan.list_barang',
            'penyelenggara.nama as namapenyelenggara'
        ])
        ->join('pembinaan','pembinaan.id_pembinaan = peserta_pembinaan.id_pembinaan', 'left')
        ->join('penyelenggara','penyelenggara.id_penyelenggara = pembinaan.penyelenggara', 'left')
        ->where('peserta_pembinaan.id_pelaku', $user_id)
        ->findAll();
        return view('web/riwayat', $data);
    }
}
