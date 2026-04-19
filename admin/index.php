<?php
// ============================================================
//  SAVORIA PREMIUM - Admin Panel
//  File: admin/index.php
// ============================================================

define('APP_ROOT', dirname(__DIR__));
require_once APP_ROOT . '/config.php';

if (!isAdmin()) {
    header('Location: ' . APP_URL);
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Panel | <?= htmlspecialchars(APP_NAME) ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Poppins', sans-serif; background: #f8f8f8; color: #222; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
    .card { background: #fff; border-radius: 16px; padding: 48px 40px; text-align: center; box-shadow: 0 4px 24px rgba(0,0,0,0.08); max-width: 420px; width: 100%; }
    h1 { font-size: 22px; margin-bottom: 12px; }
    p  { font-size: 14px; color: #888; margin-bottom: 24px; }
    .badge { display: inline-block; background: #fff0f5; color: #e75480; font-size: 12px; font-weight: 600; padding: 4px 14px; border-radius: 50px; margin-bottom: 20px; }
    a { color: #e75480; text-decoration: none; font-weight: 500; }
  </style>
</head>
<body>
  <div class="card">
    <div class="badge">Admin Panel</div>
    <h1>Halo, <?= htmlspecialchars($_SESSION['nama'] ?? 'Admin') ?>!</h1>
    <p>Panel admin sedang dalam pengembangan.<br>API backend sudah siap digunakan.</p>
    <a href="<?= APP_URL ?>">← Kembali ke Website</a>
  </div>
</body>
</html>
