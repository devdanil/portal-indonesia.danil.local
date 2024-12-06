<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table = "pembinaan";
    protected $primaryKey = "id_pembinaan";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_pembinaan', 
        'nama_kegiatan', 
        'tanggal_publikasi',
        'waktu_awal', 
        'waktu_akhir', 
        'pangan_non',
        'kapasitas_peserta',
        'lokasi_pameran',
        'penyelenggara',
        'pamflet',
        'awal_pendaftaran',
        'batas_pendaftaran',
        'kontak_person',
        'ketentuan',
        'id_instansi',
        'id_provinsi',
        'id_kota',
        'status',
        'wa_group',
        'created_date',
        'created_by',
        'kategori_produk'
    ];
}