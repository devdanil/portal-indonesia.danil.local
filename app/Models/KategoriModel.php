<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = "kategori_produk";
    protected $primaryKey = "id_kategori";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['id_kategori', 'kategori', 'icon', 'kelompok_usaha'];
}