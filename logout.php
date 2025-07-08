<?php
require_once 'utils/auth.util.php';
AuthUtil::logout();
header("Location: login.php");
exit;
?>