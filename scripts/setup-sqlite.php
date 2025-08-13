<?php
require_once __DIR__ . '/../config/config.php';

$dbPath = __DIR__ . '/../' . SQLITE_FILE_PATH ;

if (!file_exists($dbPath)) {
    if (!is_dir(dirname($dbPath))) {
        mkdir(dirname($dbPath), 0755, true);
    }

    touch($dbPath);
    echo "\n SQLite database created at: $dbPath\n";
} else {
    echo "\n SQLite database already exists.\n";
}

$pdo = new PDO('sqlite:' . $dbPath);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec("CREATE TABLE IF NOT EXISTS companies (
    id TEXT PRIMARY KEY,
    name TEXT NOT NULL,
    country TEXT NOT NULL,
    strategy_id TEXT NOT NULL
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS company_main_url (
    company_id TEXT PRIMARY KEY,
    website_id TEXT NOT NULL
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS websites (
    id TEXT PRIMARY KEY,
    company_id TEXT NOT NULL,
    address TEXT NOT NULL,
    source TEXT NOT NULL,
    roi INT NULL,
    subscribers INT NULL,
    updated_at INT NOT NULL
)");

unset($pdo);