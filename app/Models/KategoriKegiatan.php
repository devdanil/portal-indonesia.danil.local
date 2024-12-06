<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriKegiatan extends Model
{
    protected $table = "kategori_kegiatan";
    protected $primaryKey = "id_kategori";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_kategori', 
        'kategori'
    ];
}