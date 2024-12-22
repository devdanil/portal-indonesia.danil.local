<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\LogModel;

class Log extends Controller
{
  protected $helpers = ['url', 'form'];
  function __construct()
  {
    helper('utility');
  }

  public function add_log($user_id, $activity)
  {
    if (!can_access([1])) {
      return redirect()->to(base_url());
    }
    $user_log = new LogModel;
    $user_log->insert(['user_id' => $user_id, 'activity' => $activity, 'time' => date("Y-m-d H:i:s")]);
  }

  public function show()
  {
    if (!can_access([1])) {
      return redirect()->to(base_url());
    }
    $user_log = new LogModel;
    $data['nama_user'] = session()->get('name');
    $data['active'] = "log";
    $data['log_aktivitas'] = $user_log->select([
      'user_log.id',
      'app_users.username',
      'app_users.fullname',
      'user_log.activity',
      'user_log.time',
    ])->join('app_users', 'app_users.id = user_log.user_id')->orderBy('time', 'DESC')->findAll();
    return view('admin/settings/log', $data);
  }
}
