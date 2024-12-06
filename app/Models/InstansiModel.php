<?php

namespace App\Models;

use CodeIgniter\Model;

class InstansiModel extends Model
{
    protected $table = "instansi ";
    protected $primaryKey = "id_instansi ";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_instansi ', 
        'nama_instansi',
        'alamat',
        'id_kota',
        'id_provinsi',
        'tlp',
        'fax',
        'email_instansi',
        'created_date'
    ];
}