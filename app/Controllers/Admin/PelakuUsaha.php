<?php

namespace App\Controllers\Admin;

use App\Models\ProdukModel;
use App\Models\ProvinsiModel;
use App\Models\KotaModel;
use App\Models\PelakuUsahaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PelakuUsaha extends Log
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

    $pelaku_usaha = new PelakuUsahaModel;
    $provinsi = new ProvinsiModel();
    $kota = new KotaModel();
    $request = service('request');
    $pager = \Config\Services::pager();
    $provinsi_params = $request->getGet('provinsi');
    $kota_params = $request->getGet('kota');
    $status_params = $request->getGet('status');
    $email_params = $request->getGet('email');
    $status_pelaku_usaha = $request->getGet('status_pelaku_usaha');
    $start_date_params = $request->getGet('start_date');
    $end_date_params = $request->getGet('end_date');
    $active_params_prov = "";
    $active_params_kota = "";
    $active_params_status = "";
    $active_params_email = "";
    $query_kota = $kota;
    $link = base_url() . "/pelaku-usaha-admin/export-excel?type=export";

    $query_pelaku = $pelaku_usaha->select(['pelaku_usaha.*', 'mst_kota.nama as nama_kota_kab', 'provinsi.nama_provinsi'])
      ->select('(SELECT GROUP_CONCAT(nama_produk) FROM produk WHERE id_pelaku_usaha = id_pelaku) AS produk_data', false)
      ->join('mst_kota', 'mst_kota.id = pelaku_usaha.id_kota', 'left')
      ->join('provinsi', 'provinsi.id_provinsi = pelaku_usaha.id_provinsi', 'left')
      ->orderBy('nama_produk', 'desc');

    if (isset($kota_params) && $kota_params != '') {
      $active_params_kota = $kota_params;
      $link = $link . "&kota=" . $kota_params;
      $query_pelaku->where('mst_kota.nama', $kota_params);
    }

    if (isset($provinsi_params) && $provinsi_params != '') {
      $active_params_prov = $provinsi_params;
      $query_pelaku->where('provinsi.nama_provinsi', $provinsi_params);
      $data_prov = $provinsi->where('nama_provinsi', $provinsi_params)->findAll();
      $id_prov = $data_prov[0]->id_provinsi;
      $query_kota->where('id_provinsi', $id_prov);
      $link = $link . "&provinsi=" . $provinsi_params;
    }

    if (isset($status_params)  && $status_params != '') {
      $active_params_status = $status_params;
      $query_pelaku->where('status_registrasi', $status_params);
      $link = $link . "&status=" . $status_params;
    }

    if (isset($email_params) && $email_params != '') {
      $active_params_email = $email_params;
      $query_pelaku->like('email', $email_params, 'both');
      $query_pelaku->orLike('nama_usaha', '%' . $email_params . '%');
      $link = $link . "&email=" . $email_params;
    }

    if (isset($status_pelaku_usaha) && $status_pelaku_usaha != '') {
      if ($status_pelaku_usaha != 0) {
        $query_pelaku->where('status_pelaku_usaha', $status_pelaku_usaha);
      } else {
        $query_pelaku->where('status_pelaku_usaha IS NULL', null, false);
      }
      $link = $link . "&status_pelaku_usaha=" . $status_pelaku_usaha;
    }

    if (!empty($start_date_params)) {
      $query_pelaku->where('DATE(pelaku_usaha.created_at) >=', date('Y-m-d', strtotime($start_date_params)));
      $query_pelaku->where('DATE(pelaku_usaha.created_at) <=', date('Y-m-d', strtotime($end_date_params)));
      $link = $link . "&start_date=" . $start_date_params . "&end_date=" . $end_date_params;
    }

    $data = [
      'provinsi' => $provinsi->orderBy("id_provinsi", "ASC")->findAll(),
      'pelaku_usaha' => $query_pelaku->paginate(10),
      'pager' => $pelaku_usaha->pager,
      'active' => "pelaku_usaha",
      'kota' => $query_kota->findAll(),
      'params_prov' => $active_params_prov,
      'params_kota' => $active_params_kota,
      'params_status' => $active_params_status,
      'params_email' => $active_params_email,
      'status_pelaku_usaha' => $status_pelaku_usaha,
      'params_start_date' => $start_date_params,
      'params_end_date' => $end_date_params,
      'nama_user' => session()->get('name'),
      'total' => count($pelaku_usaha->findAll()),
      'link' => $link,
    ];

    array_push($data, ['tampil_data' => count($data['pelaku_usaha'])]);
    return view('admin/pelakuUsaha/index', $data);
  }

  public function exportExcel()
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $pelaku_usaha = new PelakuUsahaModel;
    $request = service('request');
    $provinsi_params = $request->getGet('provinsi');
    $kota_params = $request->getGet('kota');
    $status_params = $request->getGet('status');
    $keyword_params = $request->getGet('keyword');
    $status_pelaku_usaha = $request->getGet('status_pelaku_usaha');
    $start_date_params = $request->getGet('start_date');
    $end_date_params = $request->getGet('end_date');

    $query_pelaku = $pelaku_usaha->select(['pelaku_usaha.*', 'badan_usaha', 'skala_usaha.skala', 'mst_kota.nama as nama_kota', 'nama_provinsi', 'kepemilikan_usaha.kepemilikan'])
      ->join('badan_usaha', 'badan_usaha.id_badan_usaha = pelaku_usaha.id_badan_usaha', 'left')
      ->join('skala_usaha', 'skala_usaha.id_skala = pelaku_usaha.id_skala', 'left')
      ->join('mst_kota', 'mst_kota.id = pelaku_usaha.id_kota', 'left')
      ->join('provinsi', 'provinsi.id_provinsi = pelaku_usaha.id_provinsi', 'left')
      ->join('kepemilikan_usaha', 'kepemilikan_usaha.id_kepemilikan = pelaku_usaha.id_kepemilikan', 'left')
      ->orderBy('pelaku_usaha.nama_produk', 'desc');

    if (isset($kota_params)) {
      $query_pelaku->where('mst_kota.nama', $kota_params);
    }

    if (isset($provinsi_params)) {
      $query_pelaku->where('provinsi.nama_provinsi', $provinsi_params);
    }

    if (isset($status_params)) {
      $query_pelaku->where('status_registrasi', $status_params);
    }

    if (isset($keyword_params)) {
      $query_pelaku->like('nama_usaha', $keyword_params, 'both');
    }

    if (isset($status_params)  && $status_params != '') {
      $query_pelaku->where('status_registrasi', $status_params);
    }

    if (isset($status_pelaku_usaha)) {
      if ($status_pelaku_usaha != 0) {
        $query_pelaku->where('status_pelaku_usaha', $status_pelaku_usaha);
      } else {
        $query_pelaku->where('status_pelaku_usaha IS NULL', null, false);
      }
    }

    if (!empty($start_date_params)) {
      $query_pelaku->where('DATE(pelaku_usaha.created_at) >=', date('Y-m-d', strtotime($start_date_params)));
      $query_pelaku->where('DATE(pelaku_usaha.created_at) <=', date('Y-m-d', strtotime($end_date_params)));
    }

    $data_pelaku = $query_pelaku->findAll();
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->setActiveSheetIndex(0);

    $sheet->setCellValue('A1', 'No Registrasi')
      ->setCellValue('B1', 'Nama Usaha')
      ->setCellValue('C1', 'Kelompok')
      ->setCellValue('D1', 'Jeni Usaha')
      ->setCellValue('E1', 'NPWP')
      ->setCellValue('F1', 'Tanda Daftar Perusahaan (TDP)')
      ->setCellValue('G1', 'Instansi TDP')
      ->setCellValue('H1', 'Nama Pimpinan')
      ->setCellValue('I1', 'NIK Pimpinan')
      ->setCellValue('J1', 'Badan Usaha')
      ->setCellValue('K1', 'Nama Skala')
      ->setCellValue('L1', 'Kepemilikan')
      ->setCellValue('M1', 'Alamat')
      ->setCellValue('N1', 'Provinsi')
      ->setCellValue('O1', 'Kota / Kabupaten')
      ->setCellValue('P1', 'Kode Pos')
      ->setCellValue('Q1', 'No Telepon')
      ->setCellValue('R1', 'No Fax')
      ->setCellValue('S1', 'No Hanphone')
      ->setCellValue('T1', 'Email')
      ->setCellValue('U1', 'Website')
      ->setCellValue('V1', 'Omset')
      ->setCellValue('W1', 'Kekayaan')
      ->setCellValue('X1', 'Bahan Baku')
      ->setCellValue('Y1', 'Asal Bahan')
      ->setCellValue('Z1', 'Wilayah Pemasaran')
      ->setCellValue('AA1', 'Jenis Pemasaran')
      ->setCellValue('AB1', 'Status Registrasi')
      ->setCellValue('AC1', 'Last Update')
      ->setCellValue('AD1', 'No Izin PIRT')
      ->setCellValue('AE1', 'Status Pelaku Usaha');

    $titleRange = 'A1:AE1';

    // Apply styles to the title row
    $sheet->getStyle($titleRange)
      ->getFont()
      ->setBold(true); // Set font to bold

    $sheet->getStyle($titleRange)
      ->getAlignment()
      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Center align text


    $column = 2;

    $statusRegistrsi = ['0' => 'Belum Verifikasi', '1' => 'Prosess Verifikasi Admin', '2' => 'Approve', '3' => 'Reject'];
    $statusPelaku = ['' => '', '1' => 'Aktif', '2' => 'Tidak Aktif'];

    foreach ($data_pelaku as $data) {
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A' . $column, $data->no_reg)
        ->setCellValue('B' . $column, $data->nama_usaha)
        ->setCellValue('C' . $column, $data->kelompok)
        ->setCellValue('D' . $column, $data->jenis_usaha)
        ->setCellValue('E' . $column, $data->npwp)
        ->setCellValue('F' . $column, $data->tdp)
        ->setCellValue('G' . $column, $data->instansi_tdp)
        ->setCellValue('H' . $column, $data->nama_pimpinan)
        ->setCellValueExplicit('I' . $column, $data->nik_pimpinan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
        ->setCellValue('J' . $column, $data->badan_usaha)
        ->setCellValue('K' . $column, $data->skala)
        ->setCellValue('L' . $column, $data->kepemilikan)
        ->setCellValue('M' . $column, $data->alamat)
        ->setCellValue('N' . $column, $data->nama_provinsi)
        ->setCellValue('O' . $column, $data->nama_kota)
        ->setCellValue('P' . $column, $data->kode_pos)
        ->setCellValueExplicit('Q' . $column, $data->telpon, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
        ->setCellValue('R' . $column, $data->fax)
        ->setCellValueExplicit('S' . $column, $data->handphone, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
        ->setCellValue('T' . $column, $data->email)
        ->setCellValue('U' . $column, $data->website)
        ->setCellValue('V' . $column, $data->omset)
        ->setCellValue('W' . $column, $data->kekayaan)
        ->setCellValue('X' . $column, $data->bahan_baku)
        ->setCellValue('Y' . $column, $data->asal_bahan)
        ->setCellValue('Z' . $column, $data->wilayah_pemasaran)
        ->setCellValue('AA' . $column, $data->jenis_pemasaran)
        ->setCellValue('AB' . $column, $statusRegistrsi[$data->status_registrasi])
        ->setCellValue('AC' . $column, $data->updated_at)
        ->setCellValueExplicit('AD' . $column, $data->no_izin_pirt, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
        ->setCellValue('AE' . $column, $statusPelaku[$data->status_pelaku_usaha]);

      $column++;
    }

    $writer = new Xlsx($spreadsheet);
    $fileName = 'Data Pelaku Usaha';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
  }

  public function reject_pelaku($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $pelaku_usaha = new PelakuUsahaModel();
    $pelaku_usaha->update($id, [
      'status_registrasi' => 3
    ]);
    $ids = session()->get('user_id');
    $this->add_log($ids, "Mereject Pelaku Usaha dengan ID : " . $id);
    return redirect()->to('/admin/pelaku-usaha-admin');
  }

  public function approve_pelaku($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $pelaku_usaha = new PelakuUsahaModel();
    $ids = session()->get('user_id');
    $email = $pelaku_usaha->select('email')->find($id);
    if ($email->email != "") {
      $sendMail = $this->sendMailApprove($email->email);
      $update = $pelaku_usaha->update($id, [
        'status_registrasi' => 2
      ]);
      if ($update) {
        if ($sendMail) {
          $this->add_log($ids, "Mengapprove Pelaku Usaha dengan ID : " . $id);
          session()->setFlashdata('sukses', 'Berhasil Mengapprove Pelaku Usaha ');
          return redirect()->to('/admin/pelaku-usaha-admin');
        } else {
          // gagal kirim email
          $pelaku_usaha->update($id, [
            'status_registrasi' => 1
          ]);
          session()->setFlashdata('error', 'Gagal Mengirimkan email');
          return redirect()->to('/admin/pelaku-usaha-admin');
        }
      } else {
        // gagal update
        session()->setFlashdata('error', 'Gagal Mengupdate Status Pelaku Usaha');
        return redirect()->to('/admin/pelaku-usaha-admin');
      }
    } else {
      // gagal cause email tidak ada
      session()->setFlashdata('error', 'Gagal Mengapprove Pelaku Usaha, Tidak ada informasi email');
      return redirect()->to('/admin/pelaku-usaha-admin');
    }
  }

  public function status_pelaku($id, $status)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $pelaku_usaha = new PelakuUsahaModel();
    $ids = session()->get('user_id');
    $update = $pelaku_usaha->update($id, [
      'status_pelaku_usaha' => $status
    ]);
    if ($update) {
      if ($status == '1') {
        $this->add_log($ids, "Mengaktifkan Status Pelaku Usaha dengan ID : " . $id);
      } else {
        $this->add_log($ids, "Menonaktifkan Status Pelaku Usaha dengan ID : " . $id);
      }
      session()->setFlashdata('sukses', 'Berhasil Mengupdate Status Pelaku Usaha');
      return redirect()->to('/admin/pelaku-usaha-admin');
    } else {
      // gagal update
      session()->setFlashdata('error', 'Gagal Mengupdate Status Pelaku Usaha');
      return redirect()->to('/admin/pelaku-usaha-admin');
    }
  }

  public function sendMailApprove($emailPelaku)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $message = "Selamat akun anda telah di approve oleh admin. Anda dapat mendaftarkan produk Anda!";
    $email = \Config\Services::email();
    $email->setFrom('info@portal-indonesia.id', 'Portal Nasional Pusat Informasi Produk Indonesia');
    $email->setTo($emailPelaku);
    $email->setSubject('Etalase Produk UMKM Indonesia - Approval');
    $email->setMessage($message);

    $email->send();
    if ($email->send(false)) {
      return false;
    } else {
      return true;
    }
  }

  public function tambah_pelaku()
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $provinsi = new ProvinsiModel();
    $data['provinsi'] = $provinsi->orderBy('id_provinsi', 'ASC')->findAll();
    $data['active'] = "pelaku_usaha";
    $data['nama_user'] = session()->get('name');
    return view('admin/pelakuUsaha/form_pelaku_usaha', $data);
  }

  public function detail_pelaku($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $pelaku_usaha = new PelakuUsahaModel();
    $produk = new ProdukModel();
    $data['nama_user'] = session()->get('name');
    $data['active'] = "pelaku_usaha";
    $data['pelaku_usaha'] = $pelaku_usaha->find($id);
    $data['produk'] = $produk->where('id_pelaku_usaha', $id)->findAll();
    $ids = session()->get('user_id');
    $this->add_log($ids, "Membuka menu detail Pelaku Usaha");
    return view('admin/pelakuUsaha/detail', $data);
  }

  public function edit_pelaku($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $provinsi = new ProvinsiModel();
    $kota = new KotaModel();
    $pelaku = new PelakuUsahaModel();
    $data['provinsi'] = $provinsi->orderBy('id_provinsi', 'ASC')->findAll();
    $data['model'] = $pelaku->find($id);
    $data['kabkot'] = $kota->where('id_provinsi', $data['model']->id_provinsi)->findAll();
    $data['active'] = "pelaku_usaha";
    $data['nama_user'] = session()->get('name');
    return view('admin/pelakuUsaha/form_pelaku_usaha', $data);
  }

  public function update_pelaku($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
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

    // $status = $this->googleCaptcha();
    $jenis_usaha = $this->request->getVar('jenis_usaha');
    if (is_array($jenis_usaha)) {
      $jenis_usaha = implode(",", $jenis_usaha);
    } else {
      $jenis_usaha = $jenis_usaha;
    }

    // if($status['success']){ 
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
    } elseif ($files->getClientExtension() != "jpg" && $files->getClientExtension() != "jpeg" && $files->getClientExtension() != "png") {
      session()->setFlashdata('error', 'File harus JPG atau PNG');
      return redirect()->back()->withInput();
    } else {
      $nama_pimpinan = str_replace(" ", "-", $this->request->getVar('nama_pimpinan'));
      $kodeRegis = $this->generateKodeRegis();
      $nama_file = "registrasi_" . $nama_pimpinan . "_" . $kodeRegis . "." . $files->getClientExtension();
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
    // }else{
    //     session()->setFlashdata('error', 'Captcha belum benar!');
    //     return redirect()->back()->withInput();
    // }

    $update = $pelaku->update($id, $set_data);
    if ($update) {
      return redirect()->to('/admin/pelaku-usaha-admin');
    } else {
      session()->setFlashdata('error', 'Gagal kirim email');
      return redirect()->back()->withInput();
    }
  }

  public function save_pelaku()
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
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

    if ($status['success']) {
      $password = $this->generatePassword();
      $kodeRegis = $this->generateKodeRegis();
      $files = $this->request->getFile('identitas');
      $jenis_usaha = $this->request->getVar('jenis_usaha');
      if (is_array($jenis_usaha)) {
        $jenis_usaha = implode(",", $jenis_usaha);
      } else {
        $jenis_usaha = $jenis_usaha;
      }
      $data = [
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
        'status_registrasi' => 1,
        'password' => md5($password),
        'insert_date' => date('Y-m-d H:i:s')
      ];
      if (in_array($files->getClientExtension(), ['jpg', 'png', 'jpeg'])) {
        $nama_pimpinan = str_replace(" ", "-", $data['nama_pimpinan']);
        $nama_file = "registrasi_" . $nama_pimpinan . "_" . $kodeRegis . "." . $files->getClientExtension();
        $files->move('assets/uploads/ktp', $nama_file);
        $data['identitas'] =  $nama_file;
      }
      $pelaku->insert($data);
      return redirect()->to('/admin/pelaku-usaha-admin');
    } else {
      session()->setFlashdata('error', 'Captcha belum benar!');
      return redirect()->back()->withInput();
    }
  }

  public function generateKodeRegis($length = 5)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  public function generatePassword($length = 8)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  public function googleCaptcha()
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    // $userIp=$this->request->ip_address();
    $secret_code = '6LektGgpAAAAALCFdpq6f0ij1fAxQLI2-TpjZZh8';
    $credential = array(
      'secret' => $secret_code,
      'response' => $this->request->getPost('g-recaptcha-response')
    );
    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
    curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($verify);

    $status = json_decode($response, true);
    return $status;
  }

  public function reset_user($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
    $user = new PelakuUsahaModel();
    $data['active'] = "user";
    $data['nama_user'] = session()->get('name');
    $data['model'] = $user->find($id);
    return view('admin/settings/form_reset_pelaku', $data);
  }

  public function update_password_user($id)
  {
    if (!can_access([1, 2])) {
      return redirect()->to(base_url());
    }
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
    $user = new PelakuUsahaModel();
    $user->update($id, [
      'password' => md5($this->request->getVar('password'))
    ]);

    $this->add_log($ids, "Mengedit Password Pelaku Usaha dengan email : " . $this->request->getVar('email'));

    session()->setFlashdata('sukses', 'Berhasil mengubah password');
    return redirect()->to('/admin/pelaku-usaha-admin');
  }
}
