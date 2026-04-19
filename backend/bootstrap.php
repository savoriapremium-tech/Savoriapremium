<?php
// ============================================================
//  SAVORIA PREMIUM - Bootstrap Backend
//  File: backend/bootstrap.php
//  Di-include oleh semua file API sebagai titik masuk tunggal.
// ============================================================

// Temukan root project (2 level di atas folder backend/)
define('APP_ROOT', dirname(__DIR__));

// Muat konfigurasi utama (session juga di-start di sini)
require_once APP_ROOT . '/config.php';

// Muat database & helpers
require_once APP_ROOT . '/backend/config/database.php';
require_once APP_ROOT . '/backend/includes/helpers.php';

// Set CORS headers
setCorsHeaders();
