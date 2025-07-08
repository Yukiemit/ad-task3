<?php
declare(strict_types=1);

// Load bootstrap to get BASE_PATH
require_once __DIR__ . '/../bootstrap.php';

// Load Composer autoload using BASE_PATH
require_once BASE_PATH . '/vendor/autoload.php';
// Now you can use BASE_PATH, UTILS_PATH, etc.


// 3) Load environment variables (.env or .env.docker depending on ENV_emit)
$envFile = ($_ENV['ENV_emit'] ?? 'local') === 'docker' ? '.env.docker' : '.env';

// Use Dotenv with your defined BASE_PATH
$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH, $envFile);
$dotenv->load();

// 4) PostgreSQL config safely with fallbacks
$pgConfig = [
    'host' => $_ENV['PG_HOST'] ?? 'localhost',
    'port' => $_ENV['PG_PORT'] ?? '5432',
    'db'   => $_ENV['PG_DB'] ?? 'act3database',
    'user' => $_ENV['PG_USER'] ?? 'user',
    'pass' => $_ENV['PG_PASS'] ?? '',
];

echo "🔌 Connecting to PostgreSQL at DSN: pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['db']}\n";

$dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['db']}";

try {
    $pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    //echo "✅ Connected to PostgreSQL\n";
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Your migration SQL files loading example
$modelFiles = [
    BASE_PATH . '/database/user.model.sql',
    BASE_PATH . '/database/meeting.model.sql',
    BASE_PATH . '/database/meeting_users.model.sql',
    BASE_PATH . '/database/task.model.sql'
];

foreach ($modelFiles as $file) {
    $sql = file_get_contents($file);
    if ($sql === false) {
        echo "❌ Failed to read SQL file: $file\n";
        continue;
    }

    try {
        $pdo->exec($sql);
        echo "✅ Executed $file\n";
    } catch (PDOException $e) {
        echo "❌ Error executing $file: " . $e->getMessage() . "\n";
    }
}

echo "🏁 Database migration complete.\n";
