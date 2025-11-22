<?php
include '../php/connect.php';
session_start();

// Proteksi hanya untuk admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
  header("Location: signin.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_tim = $_POST['id_tim'];
  $nama = $_POST['nama_tim'];
  $kota = $_POST['kotaAsal'];
  $pelatih = $_POST['pelatih'];
  $stadion = $_POST['stadion'];

  // Ambil logo lama
  $sql_logo = "SELECT `Logo Tim` FROM tim WHERE id_tim = ?";
  $stmt_logo = $conn->prepare($sql_logo);
  $stmt_logo->bind_param("i", $id_tim);
  $stmt_logo->execute();
  $result_logo = $stmt_logo->get_result();
  $oldLogo = $result_logo->fetch_assoc()['Logo Tim'];
  $stmt_logo->close();

  $logo_path = $oldLogo; // karena readonly, default tetap logo lama

  // Validasi nama tim unik
  $cekNama = $conn->prepare("SELECT id_tim FROM tim WHERE nama_tim = ? AND id_tim != ?");
  $cekNama->bind_param("si", $nama, $id_tim);
  $cekNama->execute();
  $cekHasil = $cekNama->get_result();
  if ($cekHasil->num_rows > 0) {
    echo "<script>alert('Nama tim sudah digunakan oleh tim lain!'); window.location.href='../pages/edit_tim.php?id=$id_tim';</script>";
    exit();
  }
  $cekNama->close();

  // Update database
  $update = $conn->prepare("UPDATE tim SET nama_tim=?, kotaAsal=?, pelatih=?, stadion=?, `Logo Tim`=? WHERE id_tim=?");
  $update->bind_param("sssssi", $nama, $kota, $pelatih, $stadion, $logo_path, $id_tim);

  if ($update->execute()) {
    echo "<script>alert('Data tim berhasil diperbarui!'); window.location.href='../pages/admin.php';</script>";
  } else {
    echo "<script>alert('Gagal memperbarui data tim: {$update->error}'); window.location.href='../pages/edit_tim.php?id=$id_tim';</script>";
  }

  $update->close();
  $conn->close();
} else {
  echo "Akses tidak valid!";
}
?>
