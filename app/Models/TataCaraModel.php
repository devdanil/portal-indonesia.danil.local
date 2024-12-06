<?php

namespace App\Models;

use CodeIgniter\Model;

class TataCaraModel extends Model
{
    protected $table = "tatacara";
    protected $primaryKey = "id_tatacara";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_tatacara', 
        'id_kategori',
        'judul', 
        'content',
        'url', 
        'keyword',
        'inserted_by', 
        'last_update',
    ];
}