<?php
declare(strict_types=1);

// 1) Composer autoload
require 'vendor/autoload.php';

// 2) Bootstrap constants
require 'bootstrap.php';

// 3) Load env variables
require_once UTILS_PATH . '/envSetter.util.php'; // Ensure this loads .env or .env.docker

// ✅ PostgreSQL connection config
$pgConfig = [
  'host' => $_ENV['PG_HOST'] ?? 'localhost',
  'port' => $_ENV['PG_PORT'] ?? '5432',
  'db'   => $_ENV['PG_DB'] ?? 'act3database',
  'user' => $_ENV['PG_USER'] ?? 'user',
  'pass' => $_ENV['PG_PASS'] ?? 'password',
];

$dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['db']}";
echo "🔌 Connecting to PostgreSQL at DSN: $dsn\n";

try {
  $pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  ]);
  //echo "✅ Connected to PostgreSQL\n";
} catch (PDOException $e) {
  // "❌ Connection failed: " . $e->getMessage() . "\n";
  exit(1);
}

// ✅ List of schema files
$modelFiles = [
  BASE_PATH . '/database/user.model.sql',
  BASE_PATH . '/database/meeting.model.sql',
  BASE_PATH . '/database/meeting_users.model.sql',
  BASE_PATH . '/database/task.model.sql'
];

foreach ($modelFiles as $modelFile) {
  $sql = file_get_contents($modelFile);
  if ($sql === false) {
    echo "❌ Failed to read $modelFile\n";
    continue;
  }

  try {
    $pdo->exec($sql);
    echo "✅ Created tables from $modelFile\n";
  } catch (PDOException $e) {
    echo "❌ Error creating from $modelFile: " . $e->getMessage() . "\n";
  }
}


echo "🏁 Database reset complete.\n";
