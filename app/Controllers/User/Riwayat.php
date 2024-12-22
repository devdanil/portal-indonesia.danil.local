<?php

namespace App\Controllers\User;

use App\Models\PesertaPembinaanModel;
use CodeIgniter\Controller;

class Riwayat extends Controller
{
  function __construct()
  {
    helper('utility');
  }
  public function index()
  {
    if (!can_access([3])) {
      return redirect()->to(base_url());
    }
    $data['active'] = "riwayat";
    $data['filter'] = $filter = [
      'limit' => $this->request->getGet('limit') ?? 10,
      'page' => $this->request->getGet('page') ?? 1,
      'search' => $this->request->getGet('search'),
    ];
    $user_id = session()->get('user_id');
    $peserta_pembinaan = new PesertaPembinaanModel();
    $peserta_pembinaan
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
      ->join('pembinaan', 'pembinaan.id_pembinaan = peserta_pembinaan.id_pembinaan', 'left')
      ->join('penyelenggara', 'penyelenggara.id_penyelenggara = pembinaan.penyelenggara', 'left')->where('peserta_pembinaan.id_pelaku', $user_id)->where('peserta_pembinaan.id_pelaku', $user_id);
    if ($filter['search']) {
      $peserta_pembinaan->like('pembinaan.nama_kegiatan', $filter['search'], 'both')->where('peserta_pembinaan.id_pelaku', $user_id)->orLike('pembinaan.lokasi_pameran', $filter['search'], 'both')->where('peserta_pembinaan.id_pelaku', $user_id)->orLike('pembinaan.penyelenggara', $filter['search'], 'both')->where('peserta_pembinaan.id_pelaku', $user_id)->orLike('peserta_pembinaan.nama_pj', $filter['search'], 'both')->where('peserta_pembinaan.id_pelaku', $user_id)->orLike('peserta_pembinaan.jabatan_pj', $filter['search'], 'both')->where('peserta_pembinaan.id_pelaku', $user_id)->orLike('peserta_pembinaan.kontak_pj', $filter['search'], 'both')->where('peserta_pembinaan.id_pelaku', $user_id)->orLike('penyelenggara.nama', $filter['search'], 'both');
    }
    $data['pembinaan'] = $peserta_pembinaan->paginate($filter['limit']);
    $data['pager'] = $peserta_pembinaan->pager;
    $data['view'] = 'user/riwayat';
    return view('layouts/app', $data);
  }
}
