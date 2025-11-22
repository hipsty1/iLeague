<?php
include '../php/connect.php';
session_start();

// proteksi admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
  header("Location: signin.php");
  exit();
}

// === Tambah TIM ===
if (isset($_POST['add_tim'])) {
  $nama = $_POST['nama_tim'];
  $kota = $_POST['kota'];
  $pelatih = $_POST['pelatih'];
  $stadion = $_POST['stadion'];

  $sql = "INSERT INTO tim (nama_tim, kota_asal, pelatih, stadion) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssss", $nama, $kota, $pelatih, $stadion);
  $stmt->execute();
  header("Location: admin.php");
  exit();
}

// === Hapus TIM ===
if (isset($_GET['hapus_tim'])) {
  $id_tim = $_GET['hapus_tim'];
  $sql = "DELETE FROM tim WHERE id_tim = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id_tim);
  $stmt->execute();
  header("Location: admin.php");
  exit();
}

// === Simpan PERTANDINGAN ===
if (isset($_POST['add_match'])) {
  $tanggal = $_POST['tanggal'];
  $home = $_POST['id_home'];
  $away = $_POST['id_away'];
  $skor_home = $_POST['skor_home'];
  $skor_away = $_POST['skor_away'];

  $sql = "INSERT INTO pertandingan (tanggal_pertandingan, tim_home, tim_away, skor_tim_home, skor_tim_away)
          VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("siiii", $tanggal, $home, $away, $skor_home, $skor_away);
  $stmt->execute();
  header("Location: admin.php");
  exit();
}
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin — ILeague</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body{background:#f7f5fb;font-family:'Poppins',sans-serif;}
    .card{border-radius:14px;box-shadow:0 6px 16px rgba(0,0,0,0.05);}
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold text-danger" href="#"><i class="bi bi-shield-lock-fill me-2"></i>Panel Admin</a>
      <div class="collapse navbar-collapse show">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="../index.php">Kembali ke Beranda</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container my-4">
      <!-- === FORM TAMBAH PERTANDINGAN === -->
<div class="col-12 mb-4">
  <form method="POST" action="../php/create.php">
    <div class="card shadow-sm border-0">
      <div class="card-header bg-primary text-white fw-bold">
        <i class="bi bi-calendar-event me-2"></i> Tambah Pertandingan
      </div>
      <div class="card-body">
        <div class="row g-3 align-items-center">
          <div class="col-md-3">
            <label class="form-label fw-semibold">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
          </div>

          <div class="col-md-3">
            <label class="form-label fw-semibold">Tim Home</label>
            <select name="timHome" class="form-select" required>
              <option value="">Pilih Tim Home</option>
              <?php
              $tim = $conn->query("SELECT id_tim, nama_tim FROM tim ORDER BY nama_tim ASC");
              while($t = $tim->fetch_assoc()){
                echo "<option value='{$t['id_tim']}'>{$t['nama_tim']}</option>";
              }
              ?>
            </select>
          </div>

          <div class="col-md-3">
            <label class="form-label fw-semibold">Tim Away</label>
            <select name="timAway" class="form-select" required>
              <option value="">Pilih Tim Away</option>
              <?php
              $tim2 = $conn->query("SELECT id_tim, nama_tim FROM tim ORDER BY nama_tim ASC");
              while($t = $tim2->fetch_assoc()){
                echo "<option value='{$t['id_tim']}'>{$t['nama_tim']}</option>";
              }
              ?>
            </select>
          </div>

          <div class="col-md-1">
            <label class="form-label fw-semibold">Skor H</label>
            <input name="skor_home" type="number" class="form-control text-center" min="0" required>
          </div>

          <div class="col-md-1">
            <label class="form-label fw-semibold">Skor A</label>
            <input name="skor_away" type="number" class="form-control text-center" min="0" required>
          </div>

          <div class="col-md-1 d-flex align-items-end">
            <button type="submit" class="btn btn-success" name="add_match">
              <i class="bi bi-plus-circle"></i> Tambah
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>



      <!-- === DAFTAR TIM === -->
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white fw-bold">Daftar Tim Liga 1</div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                    <th>No</th>
                    <th>Tim</th>
                    <th>Kota</th>
                    <th>Pelatih</th>
                    <th>Stadion</th>
                    <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT id_tim, nama_tim, kotaAsal, pelatih, stadion, `Logo Tim` AS logo FROM tim ORDER BY id_tim ASC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                        <td>{$row['id_tim']}</td>
                        <td>
                            <div class='d-flex align-items-center gap-2'>
                            <img src='{$row['logo']}' alt='logo' style='width:32px; height:32px; border-radius:50%; object-fit:cover;'>
                            <span class='fw-semibold'>{$row['nama_tim']}</span>
                            </div>
                        </td>
                        <td>{$row['kotaAsal']}</td>
                        <td>{$row['pelatih']}</td>
                        <td>{$row['stadion']}</td>
                        <td>
                            <a href='edit_tim.php?id={$row['id_tim']}' class='btn btn-warning btn-sm'><i class='bi bi-pencil-square'></i></a>
                            <a href='admin.php?hapus_tim={$row['id_tim']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus tim ini? (Degradasi)\")'><i class='bi bi-trash'></i></a>
                        </td>
                        </tr>";
                    }
                    } else {
                    echo "<tr><td colspan='6' class='text-center text-muted'>Belum ada tim terdaftar.</td></tr>";
                    }
                    ?>
                </tbody>
                </table>
            </div>
            </div>
            </div>
    </div>

   <!-- === CEK LAWAN YANG BELUM DIHADAPI (HOME / AWAY) === -->
<div class="card shadow-sm mt-4">
  <div class="card-header fw-bold">Cek Tim yang Belum Dihadapi</div>
  <div class="card-body">
    <form method="GET" class="row g-2 align-items-end mb-3">
      <div class="col-md-6">
        <select name="tim" class="form-select" required>
          <option value="">Pilih Tim</option>
          <?php
          $timList = $conn->query("SELECT nama_tim FROM tim ORDER BY nama_tim ASC");
          while ($t = $timList->fetch_assoc()) {
            $sel = (isset($_GET['tim']) && $_GET['tim'] == $t['nama_tim']) ? 'selected' : '';
            echo "<option $sel>{$t['nama_tim']}</option>";
          }
          ?>
        </select>
      </div>
      <div class="col-md-3">
        <button type="submit" class="btn btn-primary">Tampilkan</button>
      </div>
    </form>

    <?php
    if (isset($_GET['tim'])) {
      $namaTim = $_GET['tim'];

      // ambil ID tim utama
      $stmt = $conn->prepare("SELECT id_tim FROM tim WHERE nama_tim = ?");
      $stmt->bind_param("s", $namaTim);
      $stmt->execute();
      $result = $stmt->get_result();
      $dataTim = $result->fetch_assoc();
      $idTim = $dataTim['id_tim'];
      $stmt->close();

      // belum home
      $sqlBelumHome = "
        SELECT t2.nama_tim AS calon_lawan
        FROM tim t1
        JOIN tim t2 ON t1.id_tim <> t2.id_tim
        WHERE t1.id_tim = ?
        AND NOT EXISTS (
          SELECT 1 FROM pertandingan p
          WHERE p.tim_home = t1.id_tim AND p.tim_away = t2.id_tim
        )
        ORDER BY t2.nama_tim;
      ";
      $stmt = $conn->prepare($sqlBelumHome);
      $stmt->bind_param("i", $idTim);
      $stmt->execute();
      $belumHome = $stmt->get_result();

      // belum away
      $sqlBelumAway = "
        SELECT t2.nama_tim AS calon_lawan
        FROM tim t1
        JOIN tim t2 ON t1.id_tim <> t2.id_tim
        WHERE t1.id_tim = ?
        AND NOT EXISTS (
          SELECT 1 FROM pertandingan p
          WHERE p.tim_home = t2.id_tim AND p.tim_away = t1.id_tim
        )
        ORDER BY t2.nama_tim;
      ";
      $stmt = $conn->prepare($sqlBelumAway);
      $stmt->bind_param("i", $idTim);
      $stmt->execute();
      $belumAway = $stmt->get_result();

     echo "
<div class='row mt-4'>
  <!-- Belum Jadi Tuan Rumah -->
  <div class='col-md-6'>
    <h6 class='text-primary mb-3'>🏠 Belum Jadi Tuan Rumah</h6>
    <div class='table-responsive'>
      <table class='table table-bordered table-striped text-center align-middle'>
        <thead class='table-primary'>
          <tr><th style='width:60px'>#</th><th>Calon Lawan</th></tr>
        </thead>
        <tbody>";
if ($belumHome->num_rows > 0) {
  $i = 1;
  while ($row = $belumHome->fetch_assoc()) {
    echo "<tr><td>{$i}</td><td>{$row['calon_lawan']}</td></tr>";
    $i++;
  }
} else {
  echo "<tr><td colspan='2' class='text-muted text-center'>Sudah main kandang dengan semua tim.</td></tr>";
}
echo "
        </tbody>
      </table>
    </div>
  </div>

  <!-- Belum Jadi Tamu -->
  <div class='col-md-6'>
    <h6 class='text-success mb-3'>🚍 Belum Jadi Tamu</h6>
    <div class='table-responsive'>
      <table class='table table-bordered table-striped text-center align-middle'>
        <thead class='table-success'>
          <tr><th style='width:60px'>#</th><th>Calon Lawan</th></tr>
        </thead>
        <tbody>";
if ($belumAway->num_rows > 0) {
  $i = 1;
  while ($row = $belumAway->fetch_assoc()) {
    echo "<tr><td>{$i}</td><td>{$row['calon_lawan']}</td></tr>";
    $i++;
  }
} else {
  echo "<tr><td colspan='2' class='text-muted text-center'>Sudah main tandang dengan semua tim.</td></tr>";
}
echo "
        </tbody>
      </table>
    </div>
  </div>
</div>";

    }
    ?>
  </div>
</div>



    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
