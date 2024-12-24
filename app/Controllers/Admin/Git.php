<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;

class Git extends Controller
{
  // Maximum attempts and reset time
  private const MAX_ATTEMPTS = 3;
  private const RESET_TIME = 300; // 5 minutes
  function __construct()
  {
    helper('utility');
  }
  public function index()
  {
    if (!can_access([1])) {
      return redirect()->to(base_url());
    }
    return view('admin/git');
  }

  function store()
  {
    if (!can_access([1])) {
      return redirect()->to(base_url());
    } // Initialize session variables
    if (!session()->has('login_attempts')) {
      session()->set('login_attempts', 0);
      session()->set('last_attempt_time', time());
    }

    $currentTime = time();

    // Reset attempts after RESET_TIME
    if ($currentTime - session('last_attempt_time') > self::RESET_TIME) {
      session()->set('login_attempts', 0);
      session()->set('last_attempt_time', $currentTime);
    }

    // Check if max attempts are reached
    if (session('login_attempts') >= self::MAX_ATTEMPTS) {
      return view('admin/git', ['error' => 'Maximum attempts reached. Please try again after 5 minutes.']);
    }
    // Handle POST request
    if ($this->request->getMethod() === 'post') {
      $username = trim($this->request->getPost('username'));
      $token = trim($this->request->getPost('token'));

      // Validate input
      if (empty($username) || empty($token)) {
        return view('admin/git', ['error' => 'Both username and token are required.']);
      }

      $repoDir = getenv('REPO_DIR');
      $repoUrl = getenv('REPO_URL'); // Replace with your repository URL

      // Ensure repository directory exists
      if (!is_dir($repoDir)) {
        return view('admin/git', ['error' => 'Repository directory does not exist.']);
      }

      // Execute git pull
      chdir($repoDir);
      $authUrl = sprintf('https://%s:%s@%s', $username, $token, $repoUrl);
      $output = [];
      $returnVar = 0;

      exec("git pull $authUrl 2>&1", $output, $returnVar);

      if ($returnVar !== 0) {
        // Increment login attempts on failure
        session()->set('login_attempts', session('login_attempts') + 1);
        session()->set('last_attempt_time', $currentTime);

        return view('admin/git', [
          'error' => 'Git pull failed. Attempt ' . session('login_attempts') . ' of ' . self::MAX_ATTEMPTS,
          'output' => $output,
        ]);
      } else {
        // Reset login attempts on success
        session()->set('login_attempts', 0);
        session()->set('last_attempt_time', $currentTime);

        return view('admin/git', ['success' => 'Git pull successful!', 'output' => $output]);
      }
    }
  }
}
