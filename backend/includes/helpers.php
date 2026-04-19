<?php
// ============================================================
//  SAVORIA PREMIUM - Helper Functions
//  File: backend/includes/helpers.php
// ============================================================

/**
 * Kirim response JSON dan hentikan eksekusi.
 */
function jsonResponse(bool $success, string $message, array $data = [], int $code = 200): void
{
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $data));
    exit;
}

/**
 * Bersihkan input dari XSS.
 */
function clean(string $input): string
{
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

/**
 * Cek apakah user sudah login (session).
 */
function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

/**
 * Cek apakah user adalah admin.
 */
function isAdmin(): bool
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Format harga ke format Rupiah.
 */
function formatRupiah(float $harga): string
{
    return 'Rp ' . number_format($harga, 0, ',', '.');
}

/**
 * Set CORS headers untuk API.
 * Menggunakan konstanta CORS_ORIGIN dari config.php.
 */
function setCorsHeaders(): void
{
    $origin = defined('CORS_ORIGIN') ? CORS_ORIGIN : '*';
    header('Access-Control-Allow-Origin: ' . $origin);
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(204);
        exit;
    }
}

/**
 * Validasi kekuatan password (min. 8 karakter, mengandung huruf & angka).
 */
function isPasswordValid(string $password): bool
{
    return strlen($password) >= 8
        && preg_match('/[A-Za-z]/', $password)
        && preg_match('/\d/', $password);
}
