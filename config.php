<?php
// ============================================================
//  SAVORIA PREMIUM - Konfigurasi Utama Aplikasi
//  File: config.php
//  Letakkan file ini di root folder project.
// ============================================================

// ── Environment ──────────────────────────────────────────────
// Ubah ke 'production' saat deploy ke VPS
define('APP_ENV', 'development');

// ── URL & Path ───────────────────────────────────────────────
// Ganti dengan domain/IP VPS Anda saat production
define('APP_URL',  'http://localhost:8000');
define('APP_ROOT', __DIR__);

// ── Aplikasi ─────────────────────────────────────────────────
define('APP_NAME',    'Savoria Premium');
define('APP_TAGLINE', 'Semua Rasa Favoritmu Ada Di Sini');
define('APP_EMAIL',   'savoriapremium@gmail.com');
define('APP_PHONE',   '+62 858-9236-2876');
define('APP_ADDRESS', 'Jl. Ciantra RT009/RW005, Sukadami, Cikarang Selatan, Kab. Bekasi, Jawa Barat');

// ── Database ─────────────────────────────────────────────────
define('DB_HOST',    'localhost');
define('DB_PORT',    '3306');
define('DB_USER',    'root');        // ← Ganti sesuai user MySQL VPS Anda
define('DB_PASS',    '');            // ← Ganti sesuai password MySQL VPS Anda
define('DB_NAME',    'savoria_db');
define('DB_CHARSET', 'utf8mb4');

// ── Session ───────────────────────────────────────────────────
define('SESSION_LIFETIME', 7200);   // 2 jam (detik)
define('SESSION_NAME',     'savoria_sess');

// ── Keamanan ─────────────────────────────────────────────────
// Ganti dengan string acak panjang untuk produksi
define('APP_SECRET', 'savoria_secret_key_ganti_ini_2025!');

// ── CORS ─────────────────────────────────────────────────────
// Untuk production: ganti '*' dengan domain Anda, misal 'https://savoriapremium.com'
define('CORS_ORIGIN', '*');

// ── Error Reporting ───────────────────────────────────────────
if (APP_ENV === 'development') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
    ini_set('log_errors', 1);
    ini_set('error_log', APP_ROOT . '/logs/error.log');
}

// ── Timezone ─────────────────────────────────────────────────
date_default_timezone_set('Asia/Jakarta');

// ── Session Init ─────────────────────────────────────────────
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_set_cookie_params([
        'lifetime' => SESSION_LIFETIME,
        'path'     => '/',
        'secure'   => (APP_ENV === 'production'),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}
