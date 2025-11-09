<?php
// update_password.php — demo endpoint (session only; no DB write)
require_once 'auth.php';
require_login();

$new = $_POST['password'] ?? '';
if (!$new) {
  http_response_code(400);
  echo "Password wajib diisi";
  exit;
}
$_SESSION['user']['password_hash'] = password_hash($new, PASSWORD_DEFAULT);

// If request is AJAX, return JSON, else redirect
if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
  header('Content-Type: application/json');
  echo json_encode(['ok'=>true]);
  exit;
}
header('Location: profile.php');
exit;
?>
