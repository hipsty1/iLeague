<?php
include "../php/connect.php";
session_start();

// Validasi login
$timeout_duration = 600;
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda Belum Login!'); window.location.href='signin.php';</script>";
    exit();
}
if (isset($_SESSION['start_time']) && (time() - $_SESSION['start_time']) > $timeout_duration) {
    session_unset();
    session_destroy();
    echo "<script>alert('Sesi Anda Telah Berakhir. Silakan Login Kembali.'); window.location.href='signin.php';</script>";
    exit();
}
$_SESSION['start_time'] = time();

// Validasi ID tim
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p class='text-danger text-center mt-5'>ID tim tidak ditemukan.</p>";
    exit();
}
$id_tim = $_GET['id'];

// Ambil data tim profil
$sql_tim = "SELECT id_tim, nama_tim, kotaAsal, pelatih, stadion, `Logo Tim` AS logo 
            FROM tim WHERE id_tim = ?";
$stmt = $conn->prepare($sql_tim);
$stmt->bind_param("i", $id_tim);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "<p class='text-danger text-center mt-5'>Tim tidak ditemukan.</p>";
    exit();
}
$tim = $result->fetch_assoc();
$stmt->close();

// Warna tim (gradasi)
$warna_tim = [
    'AREMA FC' => ['#007BFF', '#0047AB'],
    'BALI UNITED FC' => ['#E30613', '#8B0000'],
    'BHAYANGKARA PRESISI LAMPUNG FC' => ['#FFD700', '#DAA520'],
    'BORNEO FC' => ['#FF7F11', '#CC5500'],
    'DEWA UNITED FC' => ['#C2A23A', '#8B8000'],
    'MADURA UNITED FC' => ['#E60026', '#8B0000'],
    'MALUT UNITED FC' => ['#E60026', '#8B0000'],
    'PERSEBAYA SURABAYA' => ['#008037', '#004d1a'],
    'PERSIB BANDUNG' => ['#0056B3', '#003580'],
    'PERSIJA JAKARTA' => ['#E30613', '#8B0000'],
    'PERSIJAP JEPARA' => ['#E30613', '#8B0000'],
    'PERSIK KEDIRI' => ['#7F00FF', '#4B0082'],
    'PERSIS SOLO' => ['#E30613', '#8B0000'],
    'PERSITA' => ['#7F00FF', '#4B0082'],
    'PSBS BIAK' => ['#00BFFF', '#0077B6'],
    'PSIM YOGYAKARTA' => ['#002366', '#001A4D'],
    'PSM MAKASSAR' => ['#E60026', '#8B0000'],
    'SEMEN PADANG FC' => ['#8B4513', '#5C3317']
];

// Default warna
$primary = ['#007BFF', '#0047AB'];
$namaTimUpper = strtoupper(trim($tim['nama_tim']));
if (array_key_exists($namaTimUpper, $warna_tim)) {
    $primary = $warna_tim[$namaTimUpper];
}

// --- PERBAIKAN UTAMA DISINI ---
// Mengambil 5 pertandingan terakhir berdasarkan ID PERTANDINGAN (Input Terakhir)
// Bukan berdasarkan tanggal.
$sql_match = "SELECT 
                p.id_pertandingan,
                p.tim_home,
                p.tim_away,
                p.skor_tim_home,
                p.skor_tim_away
              FROM pertandingan p
              WHERE p.tim_home = ? OR p.tim_away = ?
              ORDER BY p.id_pertandingan DESC 
              LIMIT 5";

$stmt2 = $conn->prepare($sql_match);
$stmt2->bind_param("ii", $id_tim, $id_tim);
$stmt2->execute();
$result2 = $stmt2->get_result();

$matches = [];
$gol_masuk = 0;
$gol_kebobolan = 0;
$menang = 0;
$seri = 0;
$kalah = 0;

while ($row = $result2->fetch_assoc()) {
    // Tentukan posisi tim kita (Home atau Away)
    $isHome = ($row['tim_home'] == $id_tim);
    
    // Tentukan gol kita dan gol lawan
    $gol_for = $isHome ? $row['skor_tim_home'] : $row['skor_tim_away'];
    $gol_against = $isHome ? $row['skor_tim_away'] : $row['skor_tim_home'];
    
    // Hitung total statistik
    $gol_masuk += $gol_for;
    $gol_kebobolan += $gol_against;

    // Tentukan W/D/L
    if ($gol_for > $gol_against) {
        $hasil = 'W';
        $menang++;
    } elseif ($gol_for == $gol_against) {
        $hasil = 'D';
        $seri++;
    } else {
        $hasil = 'L';
        $kalah++;
    }

    $matches[] = $hasil;
}
$stmt2->close();
$conn->close();

$total_main = count($matches);
$winrate = $total_main > 0 ? round(($menang / $total_main) * 100, 1) : 0;
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Klub - <?= htmlspecialchars($tim['nama_tim']); ?> | ILeague</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      background: #f5f6fa;
      font-family: 'Poppins', sans-serif;
    }
    .card {
      border: none;
      border-radius: 18px;
      overflow: hidden;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    }
    .card-header-custom {
      background: linear-gradient(135deg, <?= $primary[0]; ?>, <?= $primary[1]; ?>);
      color: #fff;
      padding: 20px;
      font-weight: 600;
      letter-spacing: 0.5px;
    }
    .logo-tim {
      width: 180px;
      height: 180px;
      object-fit: contain;
      display: block;
      margin: 0 auto;
    }
    .team-info h2 {
      font-weight: 700;
      font-size: 1.8rem;
    }
    .team-info p {
      margin-bottom: 6px;
      font-size: 0.95rem;
    }
    .icon {
      color: <?= $primary[0]; ?>;
      margin-right: 6px;
    }
    
    /* CSS KOTAK WDL */
    .stat-box {
      width: 40px;
      height: 40px;
      border-radius: 8px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-weight: bold;
      margin-right: 8px;
    }
    .W { background: #28a745; } /* hijau */
    .D { background: #adb5bd; color:#000; } /* abu/putih */
    .L { background: #dc3545; } /* merah */

    .stat-card {
      text-align: center;
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      padding: 15px;
    }

    /* CSS Match Sisa */
    .match-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 15px;
      font-size: 0.9rem;
      background-color: #fff;
      border: 1px solid #e9ecef;
      border-radius: 10px;
      margin-bottom: 10px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .team-side { display: flex; align-items: center; width: 45%; }
    .team-side.home { justify-content: flex-start; }
    .team-side.away { justify-content: flex-end; text-align: right; }
    .vs-badge { font-weight: bold; color: #adb5bd; font-size: 0.8rem; width: 10%; text-align: center; }
    .match-mini-logo { width: 30px; height: 30px; object-fit: contain; }
    .match-team-name { font-weight: 600; margin: 0 8px; line-height: 1.2; }
  </style>
</head>
<body>
<div class="container py-5">
  <a href="tim.php" class="btn btn-outline-secondary mb-4">
    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Tim
  </a>

  <div class="card mb-5">
    <div class="card-header-custom">Profil Tim</div>
    <div class="card-body">
      <div class="row align-items-center">
        <div class="col-md-3 text-center">
          <img src="<?= $tim['logo']; ?>" alt="Logo Tim" class="logo-tim">
        </div>
        <div class="col-md-9 team-info">
          <h2><?= htmlspecialchars($tim['nama_tim']); ?></h2>
          <p><i class="bi bi-geo-alt icon"></i><?= htmlspecialchars($tim['kotaAsal']); ?></p>
          <p><i class="bi bi-person-badge icon"></i>Pelatih: <?= htmlspecialchars($tim['pelatih']); ?></p>
          <p><i class="bi bi-building icon"></i>Stadion: <?= htmlspecialchars($tim['stadion']); ?></p>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4">
    
    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-header-custom">5 Pertandingan Terakhir</div>
        <div class="card-body text-center">
          
          <div class="mb-4">
            <?php
            if ($total_main > 0) {
                // Tampilkan kotak W D L
                foreach ($matches as $h) {
                    echo "<div class='stat-box $h'>$h</div>";
                }
            } else {
                echo "<p class='text-muted'>Belum ada data pertandingan.</p>";
            }
            ?>
          </div>

          <?php if ($total_main > 0): ?>
          <div class="row justify-content-center">
            <div class="col-4 stat-card border-0 shadow-none">
              <h5 class="text-success fw-bold mb-0"><?= $gol_masuk; ?></h5>
              <small class="text-muted">Gol</small>
            </div>
            <div class="col-4 stat-card border-0 shadow-none">
              <h5 class="text-danger fw-bold mb-0"><?= $gol_kebobolan; ?></h5>
              <small class="text-muted">Kebobolan</small>
            </div>
            <div class="col-4 stat-card border-0 shadow-none">
              <h5 class="fw-bold mb-0"><?= $winrate; ?>%</h5>
              <small class="text-muted">Win Rate</small>
            </div>
          </div>
          <?php endif; ?>

        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-header-custom">Pertandingan Selanjutnya</div>
        <div class="card-body">
          <?php
          include "../php/connect.php";
          // Data tim profil
          $my_name = $tim['nama_tim'];
          $my_logo = $tim['logo'];

          $sql_sisa = "
            SELECT t.nama_tim AS musuh_nama, t.`Logo Tim` AS musuh_logo, 'home' AS posisi_kita
            FROM tim t
            WHERE t.id_tim != ? 
            AND NOT EXISTS (SELECT 1 FROM pertandingan p WHERE p.tim_home = ? AND p.tim_away = t.id_tim)
            UNION ALL
            SELECT t.nama_tim AS musuh_nama, t.`Logo Tim` AS musuh_logo, 'away' AS posisi_kita
            FROM tim t
            WHERE t.id_tim != ? 
            AND NOT EXISTS (SELECT 1 FROM pertandingan p WHERE p.tim_home = t.id_tim AND p.tim_away = ?)
            ORDER BY musuh_nama ASC LIMIT 3 
          ";

          $stmt = $conn->prepare($sql_sisa);
          $stmt->bind_param("iiii", $id_tim, $id_tim, $id_tim, $id_tim);
          $stmt->execute();
          $result_sisa = $stmt->get_result();

          if ($result_sisa->num_rows > 0) {
            echo "<div>";
            while ($row = $result_sisa->fetch_assoc()) {
                if ($row['posisi_kita'] == 'home') {
                    $home_name = $my_name; $home_logo = $my_logo;
                    $away_name = $row['musuh_nama']; $away_logo = $row['musuh_logo'];
                } else {
                    $home_name = $row['musuh_nama']; $home_logo = $row['musuh_logo'];
                    $away_name = $my_name; $away_logo = $my_logo;
                }
              ?>
              <div class="match-item">
                <div class="team-side home">
                    <img src="<?= htmlspecialchars($home_logo); ?>" class="match-mini-logo" alt="Logo">
                    <span class="match-team-name"><?= htmlspecialchars($home_name); ?></span>
                </div>
                <div class="vs-badge">VS</div>
                <div class="team-side away">
                    <span class="match-team-name"><?= htmlspecialchars($away_name); ?></span>
                    <img src="<?= htmlspecialchars($away_logo); ?>" class="match-mini-logo" alt="Logo">
                </div>
              </div>
              <?php
            }
            echo "</div>";
          } else {
            echo "<div class='d-flex align-items-center justify-content-center h-100'><p class='text-muted mb-0'>Semua pertandingan sudah dimainkan.</p></div>";
          }
          $stmt->close();
          $conn->close();
          ?>
        </div>
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>