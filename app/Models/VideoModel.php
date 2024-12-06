<?php

namespace App\Models;

use CodeIgniter\Model;

class VideoModel extends Model
{
    protected $table = "video";
    protected $primaryKey = "id_video";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_video', 
        'judul_video',
        'publish_date', 
        'id_kategori',
        'url_video',
        'img_preview', 
        'keyword',
        'created_date',
        'inserted_by', 
        'last_update',
    ];
}