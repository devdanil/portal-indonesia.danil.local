<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriTataCaraModel extends Model
{
    protected $table = "kategori_tatacara";
    protected $primaryKey = "id_kategori";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_kategori', 
        'kategori'
    ];
}