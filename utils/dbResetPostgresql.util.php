<?php
declare(strict_types=1);

// 1) Composer autoload
require 'vendor/autoload.php';

// 2) Bootstrap constants
require 'bootstrap.php';

// 3) Load env variables
require_once UTILS_PATH . '/envSetter.util.php';

// ✅ PostgreSQL connection config from .env
$pgConfig = [
  'host' => $_ENV['PG_HOST'] ?? 'postgresql',
  'port' => $_ENV['PG_PORT'] ?? '5432',
  'db'   => $_ENV['PG_DB'] ?? 'act3database',
  'user' => $_ENV['PG_USER'] ?? 'user',
  'pass' => $_ENV['PG_PASS'] ?? 'password',
];

// ✅ Connect to PostgreSQL
$dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['db']}";
$pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);


$modelFiles = [
  BASE_PATH . '/database/user.model.sql',
  BASE_PATH . '/database/meeting.model.sql',
  BASE_PATH . '/database/meeting_users.model.sql',
  BASE_PATH . '/database/task.model.sql'
];


foreach ($modelFiles as $file) {
  echo "📄 Applying schema from $file…\n";
  $sql = file_get_contents($file);

  if ($sql === false) {
    echo "❌ Failed to read $file\n";
    continue;
  }

  try {
    $pdo->exec($sql);
    echo "✅ Created tables from $file\n";
  } catch (PDOException $e) {
    echo "❌ Error creating from $file: " . $e->getMessage() . "\n";
  }
}
