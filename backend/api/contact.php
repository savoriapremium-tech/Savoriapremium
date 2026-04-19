<?php
// ============================================================
//  SAVORIA PREMIUM - API: Formulir Kontak
//  File: backend/api/contact.php
//
//  Endpoint:
//    POST backend/api/contact.php → Kirim pesan kontak
// ============================================================

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Method tidak didukung.', [], 405);
}

$db   = getDB();
$body = json_decode(file_get_contents('php://input'), true) ?? [];

$nama  = clean($body['nama']  ?? '');
$email = clean($body['email'] ?? '');
$pesan = clean($body['pesan'] ?? '');

if (!$nama || !$email || !$pesan) {
    jsonResponse(false, 'Nama, email, dan pesan wajib diisi.', [], 422);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(false, 'Format email tidak valid.', [], 422);
}

$stmt = $db->prepare("INSERT INTO contacts (nama, email, pesan) VALUES (?, ?, ?)");
$stmt->execute([$nama, $email, $pesan]);

jsonResponse(true, 'Pesan berhasil dikirim! Kami akan membalas segera.', [], 201);
