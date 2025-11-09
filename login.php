<?php
// login.php — demo login handler (no DB verification for non-admin)
require_once 'auth.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
  http_response_code(400);
  echo "Email dan password wajib diisi.";
  exit;
}

// Hardcoded admin
if ($email === 'admin@admin.com' && $password === 'admin123') {
  $_SESSION['user'] = ['email'=>$email, 'name'=>'Administrator', 'password_hash'=>password_hash($password, PASSWORD_DEFAULT)];
  header('Location: admin.html');
  exit;
}

// NOTE: tanpa database, kita terima user lain apa adanya (DEMO SAJA).
$_SESSION['user'] = ['email'=>$email, 'name'=>'User', 'password_hash'=>password_hash($password, PASSWORD_DEFAULT)];
header('Location: index.html');
exit;
?>
