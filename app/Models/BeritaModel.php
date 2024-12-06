<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table = "berita";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id ', 
        'judul',
        'isi_berita',
        'keyword',
        'summary',
        'featured_image',
        'utama',
        'status'
    ];
}