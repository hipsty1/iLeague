<?php
// auth.php — basic session helpers (no DB yet)
if (session_status() === PHP_SESSION_NONE) { session_start(); }

function is_logged_in(){ return isset($_SESSION['user']); }
function current_user(){ return $_SESSION['user'] ?? null; }
function is_admin(){ return isset($_SESSION['user']) && ($_SESSION['user']['email'] ?? '') === 'admin@admin.com'; }

function require_login(){
  if(!is_logged_in()){
    header('Location: signin.html');
    exit;
  }
}
?>
