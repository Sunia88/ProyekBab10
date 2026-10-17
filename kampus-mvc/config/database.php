<?php
// config/database.php - kredensial basis data (pengganti Kode 8.7 Bab 8)
// Versi Docker: nilai dibaca dari environment variable yang diset di
// docker-compose.yml. Host-nya 'db' (nama service MySQL), BUKAN 127.0.0.1,
// karena PHP dan MySQL berjalan di container yang berbeda.
return [
    'host'    => getenv('DB_HOST') ?: 'db',
    'port'    => getenv('DB_PORT') ?: '3306',
    'dbname'  => getenv('DB_DATABASE') ?: 'db_kampus',
    'charset' => 'utf8mb4',
    'user'    => getenv('DB_USERNAME') ?: 'app_kampus',
    'pass'    => getenv('DB_PASSWORD') ?: 'rahasia123',
];
