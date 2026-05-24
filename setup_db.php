<?php

// Script untuk membuat database LMS Bahasa
$host = '127.0.0.1';
$port = '3306';
$username = 'root';
$password = '';

try {
    // Koneksi tanpa database
    $pdo = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Buat database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS lms_bahasa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    echo "✓ Database 'lms_bahasa' berhasil dibuat!\n";
    
    // Koneksi ke database yang baru dibuat
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=lms_bahasa;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Terhubung ke database lms_bahasa\n";
    echo "✓ Sekarang jalankan: php artisan migrate --seed\n";
    
} catch (PDOException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "\nPastikan MySQL sudah berjalan dan credentials benar di file .env\n";
}
