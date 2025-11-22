<?php
include '../php/connect.php';
session_start();

// Proteksi admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
  header("Location: signin.php");
  exit();
}

if (!isset($_GET['id'])) {
  die("ID tim tidak ditemukan.");
}
$id_tim = $_GET['id'];

// Ambil data tim berdasarkan ID
$sql = "SELECT * FROM tim WHERE id_tim = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_tim);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
  die("Tim tidak ditemukan.");
}
$tim = $result->fetch_assoc();
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Tim — ILeague</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body { background:#f7f5fb; font-family:'Poppins',sans-serif; }
    .card { border-radius:14px; box-shadow:0 6px 16px rgba(0,0,0,0.05); }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header fw-bold text-white bg-primary">Edit Tim</div>
          <div class="card-body">
            <form action="../php/update_tim.php" method="POST" enctype="multipart/form-data">
              <div class="mb-3">
                <label class="form-label">ID Tim</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($tim['id_tim']) ?>" readonly>
                <input type="hidden" name="id_tim" value="<?= htmlspecialchars($tim['id_tim']) ?>">
              </div>

              <div class="mb-3">
                <label class="form-label">Nama Tim</label>
                <input type="text" name="nama_tim" class="form-control" value="<?= htmlspecialchars($tim['nama_tim']) ?>" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Kota Asal</label>
                <input type="text" name="kotaAsal" class="form-control" value="<?= htmlspecialchars($tim['kotaAsal']) ?>" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Pelatih</label>
                <input type="text" name="pelatih" class="form-control" value="<?= htmlspecialchars($tim['pelatih']) ?>">
              </div>

              <div class="mb-3">
                <label class="form-label">Stadion</label>
                <input type="text" name="stadion" class="form-control" value="<?= htmlspecialchars($tim['stadion']) ?>">
              </div>

              <div class="mb-3">
                <label class="form-label">Logo Tim</label><br>
                <img src="<?= $tim['Logo Tim'] ?>" alt="Logo" width="64" height="64" class="rounded border mb-2"><br>
                <input type="text" class="form-control" value="<?= htmlspecialchars($tim['Logo Tim']) ?>" readonly>
              </div>

              <div class="d-flex justify-content-between">
                <a href="admin.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
