<?php 
    include "../php/connect.php";
    session_start();
    // Cek apakah user sudah login
    $timeout_duration = 600; // durasi timeout dalam detik
    if(!isset($_SESSION['username'])){
        echo "<script>alert('Anda Belum Login!'); window.location.href='signin.php';</script>";
        exit();
    }
    // Cek Timeout Session
    if(isset($_SESSION['start_time']) && (time() - $_SESSION['start_time']) > $timeout_duration){
        session_unset();
        session_destroy();
        echo "<script>alert('Sesi Anda Telah Berakhir. Silakan Login Kembali.'); window.location.href='signin.php';</script>";
        exit();
    }
    $_SESSION['start_time'] = time();
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tim ILeague</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root{
      --pl-purple:#37003c;
      --pl-pink:#ff2882;
      --pl-bg:#f7f5fb;
      --pl-surface:#ffffff;
      --border:#ece6f0;
      --text:#2b2b2b;
    }
    html,body{height:100%;}
    body{
      font-family:'Poppins',system-ui,-apple-system,'Segoe UI',Roboto,Arial,sans-serif;
      background:var(--pl-bg); color:var(--text);
    }
    /* === NAVBAR: sama seperti index.html === */
    .pl-navbar{ background:#fff; }
    .brand-badge{ display:inline-flex; align-items:center; gap:.6rem; font-weight:800; color:var(--pl-purple); }
    .brand-badge .lion{
      width:28px; height:28px; display:inline-block;
      background: linear-gradient(135deg, var(--pl-purple), var(--pl-pink)); border-radius:6px; position:relative;
    }
    .brand-badge .lion::after{
      content:"🦁"; position:absolute; inset:0; display:flex; align-items:center; justify-content:center; font-size:20px;
    }

    /* Heading (tanpa background) */
    .page-title{font-weight:800;}

    /* Filter chips */
    .filters{display:flex;flex-wrap:wrap;gap:.75rem;align-items:center;}
    .chip-icon{border:1px solid var(--border);background:#fff;border-radius:10px;padding:.5rem .65rem;display:inline-flex;align-items:center;gap:.35rem;color:#5c4c62;}
    .chip-btn{border:1px solid var(--border);background:#fff;border-radius:14px;padding:.6rem .9rem;font-weight:700;color:#3b2e42;}
    .chip-btn .caret{margin-left:.35rem;font-weight:800;}
    .chip-reset{border:1px solid var(--border);background:#fff;border-radius:12px;padding:.5rem .9rem;color:#6b5b71;display:inline-flex;align-items:center;gap:.35rem;}
    .chip-reset:hover,.chip-btn:hover,.chip-icon:hover{filter:brightness(.98);}

    /* Team Cards */
    .team-card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
      overflow: hidden;
      background: #fff;
      transition: all .3s ease;
    }
    .team-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }
    .team-photo {
      width: 100%;
      height: 180px;
      object-fit: cover;
      position: relative;
    }
    .logo-overlay {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      background: #111;
      display: flex;
      align-items: center;
      justify-content: center;
      position: absolute;
      left: 50%;
      bottom: -35px;
      transform: translateX(-50%);
      border: 3px solid #fff;
      overflow: hidden;
    }
    .logo-overlay img {
      width: 55px;
      height: 55px;
      object-fit: contain;
    }
    .team-info {
      padding-top: 50px;
    }
    .team-info h5 {
      font-weight: 700;
      color: #000;
      font-size: 1rem;
    }
    .team-info p {
      color: #666;
      margin-bottom: 0.3rem;
      font-size: 0.9rem;
    }
    .btn-profile {
      background: #002b7f;
      color: #fff;
      border: none;
      border-radius: 0;
      padding: 10px;
      font-weight: 600;
    }
    .btn-profile:hover {
      background: #0039b3;
    }

    /* Supaya semua card sejajar tingginya */
    .row.g-4 {
    display: flex;
    flex-wrap: wrap;
    align-items: stretch;
    }

    /* Setiap card punya tinggi penuh */
    .team-card {
    display: flex;
    flex-direction: column;
    height: 100%;
    }

    /* Isi card ikut menyesuaikan tinggi */
    .team-card .card-body {
    flex-grow: 1;
    }

    /* Tombol selalu di bagian bawah */
    .btn-profile {
    margin-top: auto;
    }

   
    /* Sponsors */
    .sponsor-strip{
      background:#fff; border-radius:18px; box-shadow:0 12px 22px rgba(0,0,0,.06);
      padding:1.5rem 1rem; margin:2.5rem 0 2.5rem;
    }
    .sponsor-logo{ filter:grayscale(100%); opacity:.9; transition:all .2s; height:38px; max-width:140px; object-fit:contain; }
    .sponsor-logo:hover{ filter:none; opacity:1; }
    .sponsor-role{ font-size:.75rem; color:#8b8595; margin-top:.35rem; white-space:nowrap; }

    /* Footer */
    footer{ background:#0c0c12; color:#c8c8d0; }
    footer a{ color:#c8c8d0; text-decoration:none; }
    footer a:hover{ color:#fff; }
    .footer-title{ font-weight:800; color:#fff; font-size:1.05rem; margin-bottom:1rem; }
    .copyright{ border-top:1px solid #1e1e28; color:#8f90a6; }
  </style>
</head>

<body>
  <!-- NAVBAR (copy gaya dari index) -->
  <nav class="navbar navbar-expand-lg pl-navbar border-bottom sticky-top">
      <div class="container">
        <a class="navbar-brand brand-badge d-flex align-items-center" href="../index.php">
          <img src="../assets/image/logo.png" alt="ILeague Logo" width="35" height="35" class="me-2">
          <span>ILeague</span>
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navMain"
          aria-controls="navMain"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="klasemen.php">Klasemen</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="tim.php">Tim</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="reward.php">Reward</a>
            </li>
          </ul>
          <div class="d-flex align-items-center gap-3">
          <?php if (isset($_SESSION['username'])): ?>
           <!-- Profile dropdown (shown after login) -->
            <div class="dropdown" data-auth="profile-wrap">
                <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAxMjggMTI4Jz48ZGVmcz48bGluZWFyR3JhZGllbnQgaWQ9J2cnIHgxPScwJyB4Mj0nMScgeTE9JzAnIHkyPScxJz48c3RvcCBvZmZzZXQ9JzAnIHN0b3AtY29sb3I9JyNkOWQ5ZDknLz48c3RvcCBvZmZzZXQ9JzEnIHN0b3AtY29sb3I9JyNmMmYyZjInLz48L2xpbmVhckdyYWRpZW50PjwvZGVmcz48Y2lyY2xlIGN4PSc2NCcgY3k9JzY0JyByPSc2NCcgZmlsbD0ndXJsKCNnKScvPjxjaXJjbGUgY3g9JzY0JyBjeT0nNTAnIHI9JzI2JyBmaWxsPScjYjViNWI1Jy8+PHBhdGggZD0nTTIwLDExNmE0NCw0NCAwIDAgMSA4OCwwJyBmaWxsPScjYjViNWI1Jy8+PC9zdmc+" 
                      alt="avatar" class="rounded-circle" width="32" height="32" style="border:1px solid #ced4da;"/>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li class="px-3 py-2">
                    <div class="small text-muted">Signed in</div>
                    <div class="fw-semibold" data-profile="email">
                      <?= htmlspecialchars($_SESSION['username']); ?>
                    </div>
                  </li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="../php/profile.php"><i class="bi bi-person-gear me-2"></i>Profil</a></li>
                  <li><a class="dropdown-item text-danger" href="../php/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                </ul>
              </div>
            <?php else: ?>
              <i class="bi bi-search"></i>
              <a class="btn btn-outline-dark rounded-pill px-3" href="pages/signin.php" data-auth="signin-btn">Sign in</a>
          <?php endif; ?>
          </div>
        </div>
      </div>
    </nav>

  <main class="container my-4">
    <h1 class="fw-bold text-center mb-5">Daftar Tim ILeague</h1>

    <div class="row g-4 justify-content-center">
        <?php
        $sql = "SELECT * FROM tim";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
            // Gunakan URL langsung dari kolom foto_tim, atau default jika kosong
            $foto_tim = !empty($row['foto_tim'])
                ? $row['foto_tim']
                : 'https://images.unsplash.com/photo-1601987077927-7b61b90e5c34?auto=format&fit=crop&w=1200&q=80';

            echo '
            <div class="col-12 col-sm-6 col-lg-3 d-flex">
                <div class="card team-card w-100">
                <div class="position-relative">
                    <img src="'.$foto_tim.'" class="team-photo" alt="'.$row['nama_tim'].'">
                    <div class="logo-overlay">
                    <img src="'.$row['Logo Tim'].'" alt="logo">
                    </div>
                </div>
                <div class="card-body text-center team-info">
                    <h5>'.strtoupper($row['nama_tim']).'</h5>
                    <p><i class="bi bi-geo-alt-fill me-1"></i>'.$row['stadion'].'</p>
                    <p><i class="bi bi-person-fill me-1"></i>'.$row['pelatih'].'</p>
                </div>
                <a href="profil_tim.php?id='.$row['id_tim'].'" class="btn btn-profile w-100 mt-auto">Profil Klub</a>
                </div>
            </div>';
            }
        } else {
            echo '<p class="text-center text-muted">Belum ada data tim.</p>';
        }
        ?>
    </div>

    <!-- SPONSOR STRIP (baru, sebelum footer) -->
    <section class="container my-5">
      <div class="sponsor-strip py-4 px-2 px-md-3">
        <div
          class="d-flex justify-content-center align-items-center flex-wrap gap-4 gap-md-5"
        >
          <div class="text-center">
            <img
              class="sponsor-logo"
              src="https://logo.clearbit.com/ea.com"
              alt="EA Sports"
            />
            <div class="sponsor-role">Lead Partner</div>
          </div>
          <div class="text-center">
            <img
              class="sponsor-logo"
              src="https://logo.clearbit.com/barclays.com"
              alt="Barclays"
            />
            <div class="sponsor-role">Official Bank</div>
          </div>
          <div class="text-center">
            <img
              class="sponsor-logo"
              src="https://logo.clearbit.com/coca-cola.com"
              alt="Coca‑Cola"
            />
            <div class="sponsor-role">Official Soft Drink</div>
          </div>
          <div class="text-center">
            <img
              class="sponsor-logo"
              src="https://logo.clearbit.com/microsoft.com"
              alt="Microsoft"
            />
            <div class="sponsor-role">Official Cloud &amp; AI Partner</div>
          </div>
          <div class="text-center">
            <img
              class="sponsor-logo"
              src="https://logo.clearbit.com/puma.com"
              alt="Puma"
            />
            <div class="sponsor-role">Official Ball</div>
          </div>
          <div class="text-center">
            <img
              class="sponsor-logo"
              src="https://logo.clearbit.com/averydennison.com"
              alt="Avery Dennison"
            />
            <div class="sponsor-role">Official Licensee</div>
          </div>
          <div class="text-center">
            <img
              class="sponsor-logo"
              src="https://logo.clearbit.com/footballmanager.com"
              alt="Football Manager"
            />
            <div class="sponsor-role">Official Licensee</div>
          </div>
        </div>
      </div>
    </section>

    <!-- FOOTER (tanpa 'Unduh' & 'Media Sosial') -->
    <footer class="pt-5 mt-5">
      <div class="container pb-4">
        <div class="row g-4">
          <div class="col-6 col-lg-3">
            <div class="footer-title">LIGA INDONESIA</div>
            <ul class="list-unstyled small mb-0">
              <li class="mb-2"><a href="index.php">Beranda</a></li>
              <li class="mb-2">
                <a href="pages/match.php">Jadwal Dan Hasil Pertandingan</a>
              </li>
              <li class="mb-2"><a href="pages/klasemen.php">Klasemen</a></li>
              <li class="mb-2"><a href="pages/tim.php">Klub</a></li>
            </ul>
          </div>
          <div class="col-12 col-lg-3">
            <div class="footer-title">KONTAK KAMI</div>
            <ul class="list-unstyled small">
              <li class="mb-2 fw-semibold">PT Liga Indonesia Baru</li>
              <li class="mb-2">
                Menara Mandiri 2, Lt 19<br />Jl. Jend. Sudirman, Kav 54-55,<br />Jakarta
                12190
              </li>
              <li class="mb-2">
                <i class="bi bi-telephone me-2"></i>+62 21 526 6777
              </li>
              <li class="mb-2">
                <i class="bi bi-telephone me-2"></i>+62 21 526 6747
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="copyright py-3">
        <div
          class="container small d-flex justify-content-between align-items-center"
        >
          <div>© 2025 ILeague. All Rights Reserved</div>
          <a href="#" class="text-decoration-none"
            ><i class="bi bi-arrow-up-circle"></i> Kembali ke atas</a
          >
        </div>
      </div>
    </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
