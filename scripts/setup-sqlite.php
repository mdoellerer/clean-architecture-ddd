<?php
require_once __DIR__ . '/../config/config.php';

$dbPath = __DIR__ . '/../' . SQLITE_FILE_PATH ;

if (!file_exists($dbPath)) {
    if (!is_dir(dirname($dbPath))) {
        mkdir(dirname($dbPath), 0755, true);
    }

    touch($dbPath);
    echo "SQLite database created at: $dbPath\n";
} else {
    echo "SQLite database already exists.\n";
}