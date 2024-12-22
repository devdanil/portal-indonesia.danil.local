<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class LoginConfig extends BaseConfig
{
  public $maxAttempts = 5;      // Maximum allowed attempts
  public $lockoutTime = 300;    // Lockout time in seconds (5 minutes)
}
