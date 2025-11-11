<?php
require_once 'auth.php';
require_login();
$u = current_user();
?><!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profil (PHP)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <h2 class="fw-bold mb-3">Profil</h2>
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" value="<?php echo htmlspecialchars($u['email']); ?>" readonly>
            </div>
            <form method="post" action="update_password.php">
              <div class="mb-3">
                <label class="form-label">Password baru</label>
                <div class="input-group">
                  <input id="pwd" type="password" name="password" class="form-control" required>
                  <button class="btn btn-outline-secondary" type="button" onclick="togglePwd()"><i id="eye" class="bi bi-eye"></i></button>
                </div>
              </div>
              <div class="d-flex justify-content-end gap-2">
                <a class="btn btn-outline-danger" href="logout.php">Logout</a>
                <button class="btn btn-primary" type="submit">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function togglePwd(){
      const input=document.getElementById('pwd'); const eye=document.getElementById('eye');
      input.type = input.type==='password' ? 'text':'password';
      eye.classList.toggle('bi-eye-slash'); eye.classList.toggle('bi-eye');
    }
  </script>
</body>
</html>
