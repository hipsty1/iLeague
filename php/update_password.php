<?php
session_start();
include "connect.php";

if (!isset($_SESSION['username'])) {
  header("Location: ../pages/signin.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_SESSION['username'];
  $new_password = $_POST['password'];

  $sql = "UPDATE user SET password = ? WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $new_password, $username);

  if ($stmt->execute()) {
    echo "<script>alert('Password berhasil diperbarui!'); window.location.href='profile.php';</script>";
  } else {
    echo "<script>alert('Gagal memperbarui password.'); window.location.href='profile.php';</script>";
  }
  $stmt->close();
}
?>
