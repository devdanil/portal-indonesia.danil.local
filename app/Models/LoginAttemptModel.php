<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginAttemptModel extends Model
{
  protected $table = 'login_attempts';
  protected $primaryKey = 'id';
  protected $allowedFields = ['ip_address', 'key', 'attempt_time'];

  /**
   * Get the count of login attempts within a time frame.
   */
  public function getAttemptCount($key, $ipAddress, $timeLimit)
  {
    return $this->where('key', $key)
      ->where('ip_address', $ipAddress)
      ->where('attempt_time >', $timeLimit)
      ->countAllResults();
  }

  /**
   * Record a login attempt.
   */
  public function recordAttempt($key, $ipAddress)
  {
    $this->insert([
      'ip_address' => $ipAddress,
      'key' => $key,
      'attempt_time' => date('Y-m-d H:i:s'),
    ]);
  }

  /**
   * Clear login attempts for a specific key and IP address.
   */
  public function clearAttempts($key, $ipAddress)
  {
    $this->where('key', $key)
      ->where('ip_address', $ipAddress)
      ->delete();
  }

  /**
   * Clean up old login attempts.
   */
  public function deleteOldAttempts($timeLimit)
  {
    $this->where('attempt_time <', $timeLimit)->delete();
  }
}
