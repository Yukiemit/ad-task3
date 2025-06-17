<?php
// Enable error reporting (optional, helpful for debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define the path to your handler files
define('HANDLER_PATH', __DIR__ . '/handlers');

// Include PostgreSQL checker
include_once HANDLER_PATH . '/postgreChecker.handler.php';

// Include MongoDB checker
include_once HANDLER_PATH . '/mongodbChecker.handler.php';
?>
