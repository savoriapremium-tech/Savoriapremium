<?php
// ============================================================
//  SAVORIA PREMIUM - Koneksi Database (PDO)
//  File: backend/config/database.php
// ============================================================

// Load konfigurasi utama jika belum dimuat
if (!defined('DB_HOST')) {
    require_once APP_ROOT . '/config.php';
}

/**
 * Membuat atau mengembalikan koneksi PDO ke MySQL (singleton).
 * Melempar Exception jika koneksi gagal.
 */
function getDB(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            DB_HOST, DB_PORT, DB_NAME, DB_CHARSET
        );
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            http_response_code(500);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'success' => false,
                'message' => 'Koneksi database gagal. Periksa konfigurasi di config.php.',
            ]);
            exit;
        }
    }

    return $pdo;
}
