<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class LoginConfig extends BaseConfig
{
  public $maxAttempts = 3;      // Maximum allowed attempts
  public $lockoutTime = 300;    // Lockout time in seconds (5 minutes)
}
