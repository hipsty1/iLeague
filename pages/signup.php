<?php
include "../php/connect.php";
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sign Up — ILeague Indonesia</title>

  <!-- Bootstrap 5 + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root{
      --deep:#002b7f;
      --deep-2:#04153f;
      --panel:rgba(255,255,255,.06);
      --border:rgba(255,255,255,.12);
      --text:#ffffff;
      --muted:#d4d4e0;
      --primary:#f2f0e7;
      --primary-text:#1a1a1a;
      --focus:#ffcc00;
    }
    html,body{height:100%;}
    body{
      font-family:'Poppins', system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
      background: radial-gradient(1200px 600px at 20% -10%, #003399 0%, transparent 60%), linear-gradient(135deg, var(--deep) 0%, var(--deep-2) 100%);
      color:var(--text);
    }
    .auth-wrap{
      min-height:100vh; display:flex; align-items:center; justify-content:center;
      padding:2.5rem 1rem;
    }
    .auth-card{
      width:100%; max-width:560px;
      background: var(--panel);
      border:1px solid var(--border);
      border-radius:24px;
      box-shadow:0 22px 70px rgba(0,0,0,.45);
      padding: clamp(1.25rem, 2vw + 1rem, 2.25rem);
      backdrop-filter: blur(6px);
    }
    .brand{
      display:flex; align-items:center; gap:.75rem; margin-bottom:1rem;
      color:#fff; font-weight:800; letter-spacing:.3px;
    }
    .brand .badge{
      width:40px;height:40px;border-radius:12px; background:var(--primary);
      display:inline-flex; align-items:center; justify-content:center;
      font-weight:800; color:var(--primary-text);
    }
    h1{ font-weight:800; line-height:1.1; margin:.25rem 0 1.5rem; }
    label{ font-weight:600; color:var(--muted); font-size:.95rem; }
    .form-control{
      background: rgba(255,255,255,.06);
      border:1px solid rgba(255,255,255,.15);
      color:#fff; height:52px; border-radius:14px;
    }
    .form-control:focus{
      border-color: var(--focus);
      box-shadow: 0 0 0 .2rem rgba(255,204,0,.25);
      background: rgba(255,255,255,.08);
      color:#fff;
    }
    .form-control::placeholder{ color:#b9a9c7; }
    .toggle-pass{
      position:absolute; right:.75rem; top:50%; transform:translateY(-50%);
      background:transparent; border:0; color:#ddd;
    }
    .btn-auth{ background: var(--primary); color: var(--primary-text); border-radius:999px; height:48px; font-weight:800; transition: all .3s ease; }
    .btn-auth:hover{ background:#ffcc00; color:#1a1a1a; filter:none;}

    .auth-meta{ color:#d7cbe1; font-size:.95rem; }
    a.auth-link{ color:#fff; text-decoration:underline; }
  </style>
</head>

<body>
  <div class="auth-wrap">
    <div class="auth-card">
      <div class="brand">
        <span class="badge"><img src="../assets/image/logo.png" alt="logo" width="32"></span>
        <span>ILeague Indonesia</span>
      </div>
      <h1>Gabung ke ILeague</h1>

      <!-- FORM SIGNUP -->
      <form action="../php/signup_controller.php" method="POST" class="mt-4">
        <div class="mb-3">
          <label for="email" class="form-label">Alamat Email</label>
          <input id="email" name="email" type="email" class="form-control" placeholder="kamu@example.com" required>
        </div>
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input id="username" name="username" type="text" class="form-control" placeholder="Username Kamu" required>
        </div>
        <div class="mb-4">
          <label for="password" class="form-label">Kata Sandi</label>
          <div class="position-relative">
            <input id="password" name="password" type="password" class="form-control" placeholder="Minimal 8 karakter" minlength="8" required>
            <button class="toggle-pass" type="button" data-target="password" aria-label="Tampilkan kata sandi"><i class="bi bi-eye"></i></button>
          </div>
        </div>
        <button class="btn btn-auth w-100" type="submit">Buat Akun</button>
      </form>

      <div class="mt-4 text-center auth-meta">
        Sudah punya akun? <a class="auth-link" href="signin.php">Masuk</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Show/hide password
    document.querySelectorAll('.toggle-pass').forEach(function(btn){
      btn.addEventListener('click', function(){
        const target = document.getElementById(btn.dataset.target);
        const eye = btn.querySelector('i');
        if(target.type === 'password'){
          target.type = 'text';
          eye.classList.replace('bi-eye','bi-eye-slash');
        } else {
          target.type = 'password';
          eye.classList.replace('bi-eye-slash','bi-eye');
        }
      });
    });
  </script>
</body>
</html>
