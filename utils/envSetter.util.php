<?php

require_once BASE_PATH . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

// Example of env variable mapping (optional but useful)
$typeConfig = [
    'env' => $_ENV['ENV_emit'],
    'pg_host' => $_ENV['PG_HOST'],
    'pg_port' => $_ENV['PG_PORT'],
    'pg_db' => $_ENV['PG_DB'],
    'pg_user' => $_ENV['PG_USER'],
    'pg_pass' => $_ENV['PG_PASS'],
    'mongo_uri' => $_ENV['MONGO_URI'],
    'mongo_db' => $_ENV['MONGO_DB'],
];
