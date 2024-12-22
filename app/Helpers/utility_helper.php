<?php

function statusPelkauUsaaha($payload)
{

  $status = "-";

  switch ($payload) {
    case '1':
      $status = '<span class="badge badge-success">Aktif</span>';
      break;
    case '2':
      $status = '<span class="badge badge-secondary">Tidak Aktif</span>';
      break;
  }

  return $status;
}

function getSecretCode($length = 6)
{
  $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

function add_log($user_id, $activity)
{
  $user_log = new App\Models\LogModel();
  $user_log->insert(['user_id' => $user_id, 'activity' => $activity, 'time' => date("Y-m-d H:i:s")]);
}

function captcha_validation($response)
{
  $secret = '6LektGgpAAAAALCFdpq6f0ij1fAxQLI2-TpjZZh8';
  $credential = array(
    'secret' => $secret,
    'response' => $response
  );
  $verify = curl_init();
  curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
  curl_setopt($verify, CURLOPT_POST, true);
  curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
  curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($verify);

  return json_decode($response, true);
}

function can_access(array $level): bool
{
  return session()->get('logged_in') && in_array(session()->get('level'), $level);
}
