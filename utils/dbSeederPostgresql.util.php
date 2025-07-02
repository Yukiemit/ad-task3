<?php
define('BASE_PATH', 'C:/Users/legion/Downloads/ad-task3-1'); // ✅ Use your actual project root
require_once BASE_PATH . '/utils/envSetter.util.php';

try {
    $dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['dbname']}";
    $pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    echo "✅ Connected to PostgreSQL!" . PHP_EOL;
    echo "📂 DUMMIES_PATH: " . DUMMIES_PATH . PHP_EOL;

    // Example SQL seeding
    $pdo->exec("CREATE TABLE IF NOT EXISTS test_seed (
        id SERIAL PRIMARY KEY,
        name VARCHAR(100) NOT NULL
    );");

    echo "📄 Dummy table created successfully." . PHP_EOL;

    // Example insert
    $pdo->exec("INSERT INTO test_seed (name) VALUES ('Example Dummy');");
    echo "✅ Inserted dummy data successfully." . PHP_EOL;

} catch (PDOException $e) {
    die("❌ Connection failed: " . $e->getMessage());
}
