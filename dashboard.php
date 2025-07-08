<?php
require_once 'utils/auth.util.php';

if (!AuthUtil::check()) {
    header("Location: login.php");
    exit;
}

$user = AuthUtil::user();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars($user['username']) ?>!</h1>
    <p>Your role: <?= htmlspecialchars($user['role']) ?></p>
    <a href="logout.php">Logout</a>
</body>
</html>
