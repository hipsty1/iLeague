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
  <title>Klasemen ILeague</title>

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

    /* Table */
    .table-wrap{background:#fff;border-radius:18px;box-shadow:0 12px 24px rgba(0,0,0,.06); overflow:hidden;}
    table.standings{margin-bottom:0;}
    .standings thead th{white-space:nowrap;color:#7d7384;font-weight:700;border-bottom:1px solid #efe9f3;}
    .standings tbody td{vertical-align:middle;border-top:1px solid #f2ecf6;}
    .pos{width:56px;color:#7d7384;font-weight:700;}
    .team-cell{display:flex;align-items:center;gap:.6rem;min-width:200px;}
    .crest {width: 36px; height: 36px; border-radius: 50%; object-fit: contain; background: #fff;}
    .form-pill{width:26px;height:26px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:800;margin-right:.25rem;}
    .form-W{background:#3bc56a;color:#fff;}
    .form-D{background:#e6e2ec;color:#5f5566;}
    .form-L{background:#ff5a5a;color:#fff;}

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
              <a class="nav-link active" href="klasemen.php">Klasemen</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="tim.php">Tim</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="reward.html">Reward</a>
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

    <!-- Title (tanpa background) -->
    <header class="mb-3">
      <h1 class="page-title">Klasemen ILeague</h1>
    </header>
    
    <!-- STANDINGS TABLE -->
    <section class="table-wrap">
      <div class="table-responsive">
        <table class="table table-hover align-middle standings">
          <thead class="bg-white">
            <tr>
              <th class="pos">Pos</th>
              <th class="text-start">Team</th>
              <th>PLAY</th><th>WIN</th><th>DRAW</th><th>LOSE</th>
              <th>GF</th><th>GA</th><th>GD</th>
              <th>Points</th>
            </tr>
          </thead>
          <tbody id="tableBody">
<?php

// Ambil data tim
$sql = "SELECT id_tim, nama_tim, `Logo Tim` FROM tim";
$result = $conn->query($sql);
$klasemen = [];

while ($row = $result->fetch_assoc()) {
  $id = $row['id_tim'];
  $klasemen[$id] = [
    'id_tim' => $id,
    'nama_tim' => $row['nama_tim'],
    'logo' => $row['Logo Tim'],
    'main' => 0, 'menang' => 0, 'seri' => 0, 'kalah' => 0,
    'gol_masuk' => 0, 'gol_kemasukan' => 0, 'poin' => 0
  ];
}

// Ambil data pertandingan
$match = $conn->query("SELECT * FROM pertandingan");
while ($m = $match->fetch_assoc()) {
  $home = $m['tim_home'];
  $away = $m['tim_away'];
  $skorH = $m['skor_tim_home'];
  $skorA = $m['skor_tim_away'];

  // Main & Gol
  $klasemen[$home]['main']++;
  $klasemen[$away]['main']++;
  $klasemen[$home]['gol_masuk'] += $skorH;
  $klasemen[$home]['gol_kemasukan'] += $skorA;
  $klasemen[$away]['gol_masuk'] += $skorA;
  $klasemen[$away]['gol_kemasukan'] += $skorH;

  // Menang / Seri / Kalah / Poin
  if ($skorH > $skorA) {
    $klasemen[$home]['menang']++;
    $klasemen[$away]['kalah']++;
    $klasemen[$home]['poin'] += 3;
  } elseif ($skorH < $skorA) {
    $klasemen[$away]['menang']++;
    $klasemen[$home]['kalah']++;
    $klasemen[$away]['poin'] += 3;
  } else {
    $klasemen[$home]['seri']++;
    $klasemen[$away]['seri']++;
    $klasemen[$home]['poin']++;
    $klasemen[$away]['poin']++;
  }
}

// Urutkan
usort($klasemen, function($a, $b){
  if ($a['poin'] != $b['poin']) return $b['poin'] - $a['poin'];
  $sgA = $a['gol_masuk'] - $a['gol_kemasukan'];
  $sgB = $b['gol_masuk'] - $b['gol_kemasukan'];
  if ($sgA != $sgB) return $sgB - $sgA;
  return $b['gol_masuk'] - $a['gol_masuk'];
});

// Simpan ke tabel klasemen (optional)
$conn->query("TRUNCATE TABLE klasemen");
$pos = 1;
foreach ($klasemen as $t) {
  $sg = $t['gol_masuk'] - $t['gol_kemasukan'];
  $stmt = $conn->prepare("
    INSERT INTO klasemen (id_tim, main, menang, seri, kalah, gol_masuk, gol_kemasukan, selisih_gol, poin, peringkat)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
  ");
  $stmt->bind_param("iiiiiiiiii",
    $t['id_tim'], $t['main'], $t['menang'], $t['seri'], $t['kalah'],
    $t['gol_masuk'], $t['gol_kemasukan'], $sg, $t['poin'], $pos
  );
  $stmt->execute();

  echo "<tr>
    <td class='pos'>{$pos}</td>
    <td class='text-start'>
      <div class='team-cell'>
        <img src='{$t['logo']}' alt='logo' class='crest'>
        <span>{$t['nama_tim']}</span>
      </div>
    </td>
    <td>{$t['main']}</td>
    <td>{$t['menang']}</td>
    <td>{$t['seri']}</td>
    <td>{$t['kalah']}</td>
    <td>{$t['gol_masuk']}</td>
    <td>{$t['gol_kemasukan']}</td>
    <td>{$sg}</td>
    <td>{$t['poin']}</td>
  </tr>";
  $pos++;
}
?>
</tbody>

        </table>
      </div>
    </section>

    <!-- SPONSOR STRIP -->
    <section id="sponsors" class="sponsor-strip">
      <div class="container">
        <div class="d-flex justify-content-center align-items-center flex-wrap gap-4 gap-md-5">
          <div class="text-center">
            <img class="sponsor-logo" src="https://logo.clearbit.com/ea.com" alt="EA Sports">
            <div class="sponsor-role">Lead Partner</div>
          </div>
          <div class="text-center">
            <img class="sponsor-logo" src="https://img.logo.dev/adobe.com?token=live_6a1a28fd-6420-4492-aeb0-b297461d9de2&size=128&retina=false&format=png&theme=dark" alt="Adobe">
            <div class="sponsor-role">Official Creativity Partner</div>
          </div>
          <div class="text-center">
            <img class="sponsor-logo" src="https://logo.clearbit.com/barclays.com" alt="Barclays">
            <div class="sponsor-role">Official Bank</div>
          </div>
          <div class="text-center">
            <img class="sponsor-logo" src="https://logo.clearbit.com/coca-cola.com" alt="Coca‑Cola">
            <div class="sponsor-role">Official Soft Drink</div>
          </div>
          <div class="text-center">
            <img class="sponsor-logo" src="https://logo.clearbit.com/guinness.com" alt="Guinness">
            <div class="sponsor-role">Official Beer</div>
          </div>
          <div class="text-center">
            <img class="sponsor-logo" src="https://logo.clearbit.com/microsoft.com" alt="Microsoft">
            <div class="sponsor-role">Official Cloud &amp; AI Partner</div>
          </div>
          <div class="text-center">
            <img class="sponsor-logo" src="https://logo.clearbit.com/puma.com" alt="Puma">
            <div class="sponsor-role">Official Ball</div>
          </div>
          <div class="text-center">
            <img class="sponsor-logo" src="https://logo.clearbit.com/averydennison.com" alt="Avery Dennison">
            <div class="sponsor-role">Official Licensee</div>
          </div>
          <div class="text-center">
            <img class="sponsor-logo" src="https://logo.clearbit.com/footballmanager.com" alt="Football Manager">
            <div class="sponsor-role">Official Licensee</div>
          </div>
        </div>
      </div>
    </section>

  </main>

  <!-- FOOTER (sama seperti index) -->
  <footer class="pt-5 mt-5">
    <div class="container pb-4">
      <div class="row g-4">
        <div class="col-6 col-lg-3">
          <div class="footer-title">LIGA INDONESIA</div>
          <ul class="list-unstyled small mb-0">
            <li class="mb-2"><a href="index.html">Beranda</a></li>
            <li class="mb-2"><a href="#">Jadwal Dan Hasil Pertandingan</a></li>
            <li class="mb-2"><a href="klasemen.html">Klasemen</a></li>
            <li class="mb-2"><a href="index.html#tim">Klub</a></li>
          </ul>
        </div>
        <div class="col-6 col-lg-3">
          <div class="footer-title">MEDIA</div>
          <ul class="list-unstyled small mb-0">
            <li class="mb-2"><a href="#">Berita</a></li>
            <li class="mb-2"><a href="#">Rilis</a></li>
            <li class="mb-2"><a href="#">Foto</a></li>
            <li class="mb-2"><a href="#">Video</a></li>
          </ul>
        </div>
        <div class="col-6 col-lg-3">
          <div class="footer-title">STATS</div>
          <ul class="list-unstyled small mb-0">
            <li class="mb-2"><a href="#">Booklet Mingguan</a></li>
            <li class="mb-2"><a href="#">Aksi Top Klub</a></li>
            <li class="mb-2"><a href="#">Aksi Top Pemain</a></li>
            <li class="mb-2"><a href="#">Statistik Klub <span class="text-danger">Segera Hadir</span></a></li>
            <li class="mb-2"><a href="#">Statistik Pemain <span class="text-danger">Segera Hadir</span></a></li>
          </ul>
        </div>
        <div class="col-12 col-lg-3">
          <div class="footer-title">KONTAK KAMI</div>
          <ul class="list-unstyled small">
            <li class="mb-2 fw-semibold">PT Liga Indonesia Baru</li>
            <li class="mb-2">Menara Mandiri 2, Lt 19<br>Jl. Jend. Sudirman, Kav 54-55,<br>Jakarta 12190</li>
            <li class="mb-2"><i class="bi bi-telephone me-2"></i>+62 21 526 6777</li>
            <li class="mb-2"><i class="bi bi-telephone me-2"></i>+62 21 526 6747</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="copyright py-3">
      <div class="container small d-flex justify-content-between align-items-center">
        <div>© 2025 ILeague. All Rights Reserved</div>
        <a href="#" class="text-decoration-none"><i class="bi bi-arrow-up-circle"></i> Kembali ke atas</a>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Competition dropdown
    document.querySelectorAll('.competition-opt').forEach(function(a){
      a.addEventListener('click', function(e){
        e.preventDefault();
        document.getElementById('competitionLabel').textContent = a.dataset.comp;
      });
    });
    // Season dropdown
    document.querySelectorAll('.season-opt').forEach(function(a){
      a.addEventListener('click', function(e){
        e.preventDefault();
        document.getElementById('seasonLabel').textContent = a.dataset.season;
      });
    });
    // Reset
    document.getElementById('resetBtn').addEventListener('click', function(){
      document.getElementById('competitionLabel').textContent = 'Premier League';
      document.getElementById('seasonLabel').textContent = '2025/26';
    });
  </script>
<script>
// === Simple session using localStorage ===
function isLoggedIn(){ return localStorage.getItem('isLoggedIn') === 'true'; }
function getEmail(){ return localStorage.getItem('authEmail') || ''; }
function getPassword(){ return localStorage.getItem('authPassword') || ''; }
function isAdmin(){ return localStorage.getItem('isAdmin') === 'true'; }

function renderAuthUI(){
  const signBtn = document.querySelector('[data-auth=signin-btn]');
  const profileWrap = document.querySelector('[data-auth=profile-wrap]');
  if(signBtn && profileWrap){
    if(isLoggedIn()){
      signBtn.classList.add('d-none');
      profileWrap.classList.remove('d-none');
      document.querySelectorAll('[data-profile=email]').forEach(el => el.textContent = getEmail());
    }else{
      profileWrap.classList.add('d-none');
      signBtn.classList.remove('d-none');
    }
  }
  // Inject Admin menu item in navbar if admin
  const nav = document.querySelector('.navbar .navbar-nav');
  if(nav && isAdmin() && !document.getElementById('adminMenuItem')){
    const li = document.createElement('li');
    li.className = 'nav-item';
    li.id = 'adminMenuItem';
    li.innerHTML = '<a class="nav-link text-danger fw-bold" href="admin.html">Edit Klasemen</a>';
    nav.appendChild(li);
  }
}

function logout(){
  localStorage.removeItem('isLoggedIn');
  localStorage.removeItem('authEmail');
  localStorage.removeItem('authPassword');
  localStorage.removeItem('isAdmin');
  renderAuthUI();
}
document.addEventListener('DOMContentLoaded', renderAuthUI);
</script>
</body>
</html>
