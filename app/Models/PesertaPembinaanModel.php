<?php

namespace App\Models;

use CodeIgniter\Model;

class PesertaPembinaanModel extends Model
{
    protected $table = "peserta_pembinaan";
    protected $primaryKey = "id_peserta";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_peserta',
        'id_pembinaan', 
        'id_pelaku',
        'konfirmasi',
        'tgl_konfirmasi', 
        'status_kehadiran',
        'tanggal',
        'list_barang',
        'nama_pj',
        'jabatan_pj',
        'kontak_pj'
    ];
}