<?php
$dbPath = __DIR__ . '/../storage/database.sqlite';
echo "DB Path: $dbPath\n";
echo "DB Exists: " . (file_exists($dbPath) ? 'YES' : 'NO') . "\n";
echo "DB Readable: " . (is_readable($dbPath) ? 'YES' : 'NO') . "\n\n";

try {
    $db = new PDO("sqlite:$dbPath");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // List all tables
    $tables = $db->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables found: " . implode(', ', $tables) . "\n\n";

    // If users table exists, show columns and row count
    if (in_array('users', $tables)) {
        $cols = $db->query("PRAGMA table_info(users)")->fetchAll(PDO::FETCH_ASSOC);
        echo "users columns:\n";
        foreach ($cols as $col) {
            echo "  - {$col['name']} ({$col['type']})\n";
        }
        $count = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
        echo "\nusers row count: $count\n";

        if ($count > 0) {
            $rows = $db->query("SELECT * FROM users LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
            echo "\nSample rows:\n";
            foreach ($rows as $row) {
                print_r($row);
            }
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
