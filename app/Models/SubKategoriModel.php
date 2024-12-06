<?php

namespace App\Models;

use CodeIgniter\Model;

class SubKategoriModel extends Model
{
    protected $table = "sub_kategori_produk";
    protected $primaryKey = "id_sub";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['id_sub', 'id_kategori', 'nama'];
}