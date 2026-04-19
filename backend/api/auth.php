<?php
// ============================================================
//  SAVORIA PREMIUM - API: Autentikasi
//  File: backend/api/auth.php
//
//  Endpoint:
//    POST backend/api/auth.php?action=login    → Login
//    POST backend/api/auth.php?action=register → Daftar akun baru
//    POST backend/api/auth.php?action=logout   → Logout
//    GET  backend/api/auth.php?action=me       → Cek status login
// ============================================================

require_once __DIR__ . '/../bootstrap.php';

$db     = getDB();
$action = $_GET['action'] ?? '';
$body   = json_decode(file_get_contents('php://input'), true) ?? [];

switch ($action) {

    // ── LOGIN ────────────────────────────────────────────────
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            jsonResponse(false, 'Method tidak valid.', [], 405);
        }

        $email    = clean($body['email']    ?? '');
        $password =       $body['password'] ?? '';

        if (!$email || !$password) {
            jsonResponse(false, 'Email dan password wajib diisi.', [], 422);
        }

        $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND status = 'aktif' LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            jsonResponse(false, 'Email atau password salah.', [], 401);
        }

        // Regenerate session ID untuk keamanan
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama']    = $user['nama'];
        $_SESSION['email']   = $user['email'];
        $_SESSION['role']    = $user['role'];

        jsonResponse(true, 'Login berhasil.', [
            'user' => [
                'id'    => $user['id'],
                'nama'  => $user['nama'],
                'email' => $user['email'],
                'role'  => $user['role'],
            ]
        ]);
        break;

    // ── REGISTER ─────────────────────────────────────────────
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            jsonResponse(false, 'Method tidak valid.', [], 405);
        }

        $nama     = clean($body['nama']     ?? '');
        $email    = clean($body['email']    ?? '');
        $password =       $body['password'] ?? '';

        if (!$nama || !$email || !$password) {
            jsonResponse(false, 'Nama, email, dan password wajib diisi.', [], 422);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            jsonResponse(false, 'Format email tidak valid.', [], 422);
        }
        if (!isPasswordValid($password)) {
            jsonResponse(false, 'Password minimal 8 karakter, harus mengandung huruf dan angka.', [], 422);
        }

        // Cek email sudah terdaftar
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            jsonResponse(false, 'Email sudah terdaftar.', [], 409);
        }

        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $stmt = $db->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, 'user')");
        $stmt->execute([$nama, $email, $hash]);

        jsonResponse(true, 'Akun berhasil dibuat. Silakan login.', [], 201);
        break;

    // ── LOGOUT ───────────────────────────────────────────────
    case 'logout':
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
        session_destroy();
        jsonResponse(true, 'Logout berhasil.');
        break;

    // ── CEK STATUS LOGIN ──────────────────────────────────────
    case 'me':
        if (!isLoggedIn()) {
            jsonResponse(false, 'Belum login.', [], 401);
        }
        jsonResponse(true, 'OK', [
            'user' => [
                'id'    => $_SESSION['user_id'],
                'nama'  => $_SESSION['nama'],
                'email' => $_SESSION['email'],
                'role'  => $_SESSION['role'],
            ]
        ]);
        break;

    default:
        jsonResponse(false, 'Action tidak dikenali.', [], 400);
}
