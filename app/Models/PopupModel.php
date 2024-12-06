<?php

namespace App\Models;

use CodeIgniter\Model;

class PopupModel extends Model
{
    protected $table = "popup";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id', 
        'judul', 
        'img_url', 
        'link', 
        'start_date', 
        'end_date',
        'status'
    ];
}