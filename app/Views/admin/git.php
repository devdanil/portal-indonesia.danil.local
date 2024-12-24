<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Git Pull Utility</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      padding: 20px;
    }

    .card {
      margin-top: 50px;
    }

    .output-box {
      background-color: #f1f1f1;
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      overflow-x: auto;
      max-height: 300px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-header text-center">
            <h3>Git Pull Utility</h3>
          </div>
          <div class="card-body">
            <?php if (!empty($error)): ?>
              <div class="alert alert-danger" role="alert">
                <?= esc($error) ?>
              </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
              <div class="alert alert-success" role="alert">
                <?= esc($success) ?>
              </div>
            <?php endif; ?>

            <?php if (!empty($output)): ?>
              <div class="output-box">
                <pre><?= esc(implode("\n", $output)) ?></pre>
              </div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('admin/git/store') ?>">
              <?= csrf_field() ?>
              <div class="mb-3">
                <label for="username" class="form-label">Git Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="token" class="form-label">Personal Access Token</label>
                <input type="password" id="token" name="token" class="form-control" required>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Run Git Pull</button>
              </div>
            </form>
          </div>
          <div class="card-footer text-center">
            <small class="text-muted">© <?= date('Y') ?> Git Utility Tool</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>