<?php
session_start();
include "connect.php";

// Proteksi: hanya bisa diakses jika sudah login
if (!isset($_SESSION['username'])) {
  header("Location: signin.php");
  exit();
}

// Ambil data user dari database
$username = $_SESSION['username'];
$sql = "SELECT email, password FROM user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($email, $password);
$stmt->fetch();
$stmt->close();
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profil — ILeague</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body{font-family:'Poppins',system-ui,-apple-system,'Segoe UI',Roboto,Arial,sans-serif;background:#f7f5fb;}
    .card{border-radius:16px;border:1px solid #eee;box-shadow:0 10px 24px rgba(0,0,0,.04);}
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h2 class="fw-bold mb-0">Profil</h2>
          <a class="btn btn-outline-secondary btn-sm" href="../index.php"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
        <div class="card">
          <div class="card-body">
            <form action="update_password.php" method="POST">
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" value="<?= htmlspecialchars($email) ?>" readonly>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                  <input id="password" name="password" type="password" class="form-control" value="<?= htmlspecialchars($password) ?>">
                  <button class="btn btn-outline-secondary" type="button" onclick="togglePwd()">
                    <i id="eye" class="bi bi-eye"></i>
                  </button>
                </div>
                <div class="form-text">Klik ikon mata untuk show/hide.</div>
              </div>
              <div class="d-flex justify-content-end gap-2">
                <a class="btn btn-outline-danger" href="logout.php">Logout</a>
                <button class="btn btn-primary" type="submit">Simpan</button>
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
      const input = document.getElementById('password');
      const eye = document.getElementById('eye');
      input.type = input.type === 'password' ? 'text' : 'password';
      eye.classList.toggle('bi-eye-slash');
      eye.classList.toggle('bi-eye');
    }
  </script>
</body>
</html>
