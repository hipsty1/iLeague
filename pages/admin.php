<?php
include '../php/connect.php';
session_start();

// proteksi admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
  header("Location: signin.php");
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
    .table-scroll{max-height:400px;overflow-y:auto;}
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top shadow-sm">
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

    <!-- ====== ROW UNTUK TAMBAH DAN CEK ====== -->
    <div class="row g-4 mb-4">
      
      <!-- TAMBAH PERTANDINGAN (KIRI) -->
      <div class="col-lg-7">
        <form method="POST" action="../php/create.php">
          <div class="card border-0">
            <div class="card-header bg-primary text-white fw-bold">
              <i class="bi bi-calendar-event me-2"></i> Tambah Pertandingan
            </div>
            <div class="card-body">
              <div class="row g-3 align-items-center">
                <div class="col-md-4">
                  <label class="form-label fw-semibold">Tanggal</label>
                  <input type="date" name="tanggal" class="form-control" required>
                </div>

                <div class="col-md-4">
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

                <div class="col-md-4">
                  <label class="form-label fw-semibold">Tim Away</label>
                  <select name="timAway" class="form-select" required>
                    <option value="">Pilih Tim Away</option>
                    <?php
                    $tim->data_seek(0);
                    while($t = $tim->fetch_assoc()){
                      echo "<option value='{$t['id_tim']}'>{$t['nama_tim']}</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="col-md-3">
                  <label class="form-label fw-semibold">Skor Home</label>
                  <input name="skor_home" type="number" class="form-control text-center" min="0" required>
                </div>

                <div class="col-md-3">
                  <label class="form-label fw-semibold">Skor Away</label>
                  <input name="skor_away" type="number" class="form-control text-center" min="0" required>
                </div>

                <div class="col-md-3 d-flex align-items-end mt-5">
                  <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-plus-lg"></i> Tambah
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <!-- CEK TIM BELUM DIHADAPI (KANAN) -->
      <div class="col-lg-5">
        <div class="card border-0">
          <div class="card-header bg-secondary text-white fw-bold">
            <i class="bi bi-search me-2"></i> Cek Tim yang Belum Dihadapi
          </div>
          <div class="card-body">
            <form method="GET" class="row g-2 align-items-end mb-3">
              <div class="col-md-8">
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
              <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
              </div>
            </form>

            <?php
            if (isset($_GET['tim'])) {
              $namaTim = $_GET['tim'];
              $stmt = $conn->prepare("SELECT id_tim FROM tim WHERE nama_tim = ?");
              $stmt->bind_param("s", $namaTim);
              $stmt->execute();
              $result = $stmt->get_result();
              if($result->num_rows > 0){
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
                  ORDER BY t2.nama_tim;";
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
                  ORDER BY t2.nama_tim;";
                $stmt = $conn->prepare($sqlBelumAway);
                $stmt->bind_param("i", $idTim);
                $stmt->execute();
                $belumAway = $stmt->get_result();

                echo "
                <div class='row mt-3'>
                  <div class='col-md-6'>
                    <h6 class='text-primary mb-2'>🏠 Belum Home:</h6>
                    <ul class='list-group list-group-flush small'>";
                    if ($belumHome->num_rows > 0) {
                      while ($row = $belumHome->fetch_assoc()) echo "<li class='list-group-item'>{$row['calon_lawan']}</li>";
                    } else { echo "<li class='list-group-item text-muted'>Sudah semua.</li>"; }
                echo "</ul></div>

                  <div class='col-md-6'>
                    <h6 class='text-success mb-2'>🚍 Belum Away:</h6>
                    <ul class='list-group list-group-flush small'>";
                    if ($belumAway->num_rows > 0) {
                      while ($row = $belumAway->fetch_assoc()) echo "<li class='list-group-item'>{$row['calon_lawan']}</li>";
                    } else { echo "<li class='list-group-item text-muted'>Sudah semua.</li>"; }
                echo "</ul></div>
                </div>";
              }
            }
            ?>
          </div>
        </div>
      </div>
    </div>
    <!-- END ROW TAMBAH + CEK -->

    <!-- === DAFTAR & HAPUS PERTANDINGAN === -->
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-success text-white fw-bold">
        <i class="bi bi-list-check me-2"></i> Daftar & Hapus Pertandingan
      </div>
      <div class="card-body p-0">
        <div class="table-scroll">
          <table class="table table-hover table-striped mb-0 align-middle">
            <thead class="table-light sticky-top">
              <tr>
                <th>Tanggal</th>
                <th class="text-end">Home</th>
                <th class="text-center">Skor</th>
                <th>Away</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql_matches = "SELECT p.id_pertandingan, p.tanggal_pertandingan, 
                                     p.skor_tim_home, p.skor_tim_away,
                                     th.nama_tim AS home, ta.nama_tim AS away
                              FROM pertandingan p
                              JOIN tim th ON p.tim_home = th.id_tim
                              JOIN tim ta ON p.tim_away = ta.id_tim
                              ORDER BY p.tanggal_pertandingan DESC, p.id_pertandingan DESC";
              $res_matches = $conn->query($sql_matches);

              if ($res_matches->num_rows > 0) {
                while ($m = $res_matches->fetch_assoc()) {
                  $tgl = date('d/m/Y', strtotime($m['tanggal_pertandingan']));
                  echo "<tr>
                          <td class='small text-muted'>{$tgl}</td>
                          <td class='text-end fw-semibold'>{$m['home']}</td>
                          <td class='text-center'><span class='badge bg-dark'>{$m['skor_tim_home']} - {$m['skor_tim_away']}</span></td>
                          <td class='fw-semibold'>{$m['away']}</td>
                          <td class='text-center'>
                            <a href='../php/delete_match.php?id_pertandingan={$m['id_pertandingan']}' 
                               class='btn btn-danger btn-sm' 
                               onclick='return confirm(\"Anda yakin ingin menghapus pertandingan ini?\")'>
                               <i class='bi bi-trash'></i>
                            </a>
                          </td>
                        </tr>";
                }
              } else {
                echo "<tr><td colspan='5' class='text-center py-3 text-muted'>Belum ada data pertandingan.</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- === EDIT TIM === -->
    <div class="card shadow-sm">
      <div class="card-header bg-dark text-white fw-bold">
        <i class="bi bi-people-fill me-2"></i> Edit Tim
      </div>
      <div class="card-body p-0">
        <div class="table-responsive" style="max-height: 400px; overflow-y:auto;">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light sticky-top">
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
                            <a href='edit_tim.php?id={$row['id_tim']}' class='btn btn-warning btn-sm'>
                              <i class='bi bi-pencil-square'></i>
                            </a>
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

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
