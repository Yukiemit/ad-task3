<?php
require_once UTILS_PATH . '/envSetter.util.php';

$host = $typeConfig['pg_host'];
$port = $typeConfig['pg_port'];
$username = $typeConfig['pg_user'];
$password = $typeConfig['pg_pass'];
$dbname = $typeConfig['pg_db'];

$conn_string = "host=$host port=$port dbname=$dbname user=$username password=$password";

$dbconn = pg_connect($conn_string);

if (!$dbconn) {
    
    exit();
} else {
    
    pg_close($dbconn);
}