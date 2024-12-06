<?php

namespace App\Models;

use CodeIgniter\Model;

class KulinerModel extends Model
{
    protected $table = "kuliner";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id',
        'nama', 
        'image',
        'alamat', 
        'jam_buka',
        'jam_tutup', 
        'kategori',
        'deskripsi', 
        'facebook',
        'instagram',
        'maps',
        'id_provinsi',
        'id_kota'
    ];
}