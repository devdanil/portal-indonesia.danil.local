<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\LogModel;

class Log extends Controller
{
    protected $helpers = ['url', 'form'];

    public function add_log($user_id, $activity)
    {
        $user_log = new LogModel;
        $user_log->insert(['user_id'=> $user_id, 'activity' => $activity, 'time' => date("Y-m-d H:i:s") ]);
    }

    public function show()
    {
        $user_log = new LogModel;
        $data['nama_user'] = session()->get('name');
        $data['active'] = "log";
        $data['log_aktivitas'] = $user_log->select([
            'user_log.id',
            'app_users.username',
            'app_users.fullname',
            'user_log.activity',
            'user_log.time',
        ])->join('app_users', 'app_users.id = user_log.user_id')->orderBy('time','DESC')->findAll();
        return view('admin/settings/log', $data);
    }

}