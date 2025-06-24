<?php

require_once UTILS_PATH . '/envSetter.util.php';

try {
    $mongo = new MongoDB\Driver\Manager($_ENV['MONGO_URI']);
    $command = new MongoDB\Driver\Command(["ping" => 1]);
    $mongo->executeCommand($_ENV['MONGO_DB'], $command);

    echo "✅ Connected to MongoDB successfully.  <br>";
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "❌ MongoDB connection failed: " . $e->getMessage() . "  <br>";
}
