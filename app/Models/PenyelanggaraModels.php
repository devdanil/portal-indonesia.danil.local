<?php

namespace App\Models;

use CodeIgniter\Model;

class PenyelanggaraModels extends Model
{
    protected $table = "penyelenggara";
    protected $primaryKey = "id_penyelenggara";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_penyelenggara  ', 
        'nama',
        'deskripsi',
        'alamat',
        'summary',
        'kontak'
    ];
}