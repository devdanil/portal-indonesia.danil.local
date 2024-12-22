<?php

namespace App\Models;

use CodeIgniter\Model;

class PelakuUsahaModel extends Model
{
    protected $table = "pelaku_usaha";
    protected $primaryKey = "id_pelaku";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_pelaku', 
        'no_reg', 
        'no_izin_pirt',
        'kelompok', 
        'jenis_usaha', 
        'nama_usaha', 
        'npwp', 
        'tdp', 
        'instansi_tdp', 
        'nama_pimpinan', 
        'identitas', 
        'security_code', 
        'captcha', 
        'nik_pimpinan', 
        'password', 
        'id_badan_usaha', 
        'id_skala', 
        'id_kepemilikan', 
        'alamat', 
        'id_kota', 
        'id_provinsi', 
        'kode_pos', 
        'telpon', 
        'fax', 
        'handphone', 
        'email', 
        'website', 
        'omset', 
        'kekayaan', 
        'karyawan', 
        'bahan_baku', 
        'asal_bahan', 
        'wilayah_pemasaran', 
        'jenis_pemasaran', 
        'file_ijin_usaha', 
        'status_registrasi', 
        'insert_date',
        'status_pelaku_usaha'
    ];
}