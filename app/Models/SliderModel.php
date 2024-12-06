<?php

namespace App\Models;

use CodeIgniter\Model;

class SliderModel extends Model
{
    protected $table = "slider";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id', 
        'nama', 
        'deskripsi',
        'nama_button',
        'link_button',
        'img'
    ];
}