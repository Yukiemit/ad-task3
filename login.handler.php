<?php
require_once 'utils/auth.util.php';
require_once 'database/connection.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (AuthUtil::login($username, $password, $pdo)) {
    header("Location: dashboard.php");
    exit;
} else {
    header("Location: login.php?error=invalid");
    exit;
}
?>