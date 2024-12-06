<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = "app_users";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id',
        'username', 
        'password', 
        'fullname',
        'instansi',
        'jabatan',
        'hp',
        'email',
        'level',
        'level_name',
        'created_date'
    ];
}