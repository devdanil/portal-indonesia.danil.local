<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = "produk";
    protected $primaryKey = "id_produk";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_produk', 
        'id_kategori', 
        'id_sub',
        'id_pelaku_usaha',
        'nama_produk',
        'jenis_makanan',
        'no_halal',
        'deskripsi_in',
        'deskripsi_en',
        'spesifikasi_in',
        'spesifikasi_en',
        'berat_dg_kemasan',
        'security_code',
        'captcha',
        'berat',
        'kapasitas_produksi',
        'tkdn',
        'satuan_kapasitas',
        'no_registrasi',
        'tahun_reg',
        'foto_produk',
        'id_provinsi',
        'id_kota',
        'website',
        'e-coomerce',
        'status',
        'insert_date',
        'status_show'
    ];
}