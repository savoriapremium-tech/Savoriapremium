<?php
// ============================================================
//  SAVORIA PREMIUM - Halaman Utama
//  File: index.php
// ============================================================

define('APP_ROOT', __DIR__);
require_once __DIR__ . '/config.php';

$appName    = APP_NAME;
$appTagline = APP_TAGLINE;
$appUrl     = APP_URL;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="<?= htmlspecialchars($appName) ?> – Platform promosi UMKM makanan &amp; minuman lokal terbaik di Cikarang." />
  <title><?= htmlspecialchars($appName) ?> | <?= htmlspecialchars($appTagline) ?></title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

  <!-- Stylesheet -->
  <link rel="stylesheet" href="public/css/style.css" />
</head>
<body>

<!-- ══════════════════════════════════════════
     NAVBAR
══════════════════════════════════════════ -->
<nav class="navbar" role="navigation" aria-label="Navigasi utama">
  <a href="#" class="nav-logo"><span>Savoria</span>Premium</a>

  <div class="nav-links" id="navLinks">
    <a href="#beranda">Beranda</a>
    <a href="#menu">Menu</a>
    <a href="#about">Tentang Kami</a>
    <a href="#kontak">Kontak</a>
  </div>

  <div class="nav-actions">
    <a href="#" class="nav-login-btn" data-open-modal>Login</a>
  </div>

  <button class="hamburger" id="hamburgerBtn" aria-label="Buka menu" aria-expanded="false">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ -->
<section class="hero" id="beranda">
  <div class="hero-bg"></div>
  <div class="hero-pattern"></div>
  <div class="hero-blob"></div>

  <div class="hero-content">
    <div class="hero-tag">#BanggaBuatanIndonesia</div>
    <h1 class="hero-title">
      Semua Rasa<br>
      Favoritmu Ada Di<br>
      <span class="line-pink">Savoria Premium</span>
    </h1>
    <p class="hero-desc">
      Platform informasi UMKM kuliner lokal terbaik di Cikarang.
      Temukan, dukung, dan nikmati produk asli Indonesia.
    </p>
    <div class="hero-cta">
      <a href="#menu" class="btn btn-primary">Jelajahi Menu &nbsp;→</a>
      <a href="#about" class="btn btn-secondary">Tentang Kami</a>
    </div>

    <div class="hero-stats">
      <div>
        <div class="hero-stat-num">30+</div>
        <div class="hero-stat-label">Mitra UMKM</div>
      </div>
      <div>
        <div class="hero-stat-num">19+</div>
        <div class="hero-stat-label">Produk Pilihan</div>
      </div>
      <div>
        <div class="hero-stat-num">100%</div>
        <div class="hero-stat-label">Lokal Indonesia</div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     MENU SECTION
══════════════════════════════════════════ -->
<section class="menu-section" id="menu">
  <div class="menu-header">
    <h2 class="section-title">Jelajahi Rasa <span class="pink-text">Premium</span></h2>
    <p class="section-sub">Temukan kuliner terbaik berdasarkan kategori favoritmu atau cari berdasarkan wilayah asal UMKM.</p>
  </div>

  <!-- Search Bar -->
  <div class="search-wrap">
    <div class="search-box">
      <span>🔍</span>
      <input type="text" id="searchInput" placeholder="Cari produk, vendor, atau wilayah…" aria-label="Cari produk" />
    </div>
  </div>

  <!-- Category Pills -->
  <div class="category-pills" role="group" aria-label="Filter kategori">
    <button class="pill active" onclick="filterCategory('semua', this)">Semua</button>
    <button class="pill" onclick="filterCategory('makanan-berat', this)">🍚 Makanan Berat</button>
    <button class="pill" onclick="filterCategory('minuman', this)">🥤 Minuman</button>
    <button class="pill" onclick="filterCategory('dessert', this)">🍰 Dessert</button>
    <button class="pill" onclick="filterCategory('makanan-ringan', this)">🥨 Makanan Ringan</button>
    <button class="pill" onclick="filterCategory('makanan-pedas', this)">🌶️ Makanan Pedas</button>
  </div>

  <!-- Products Grid (populated by JS) -->
  <div class="products-grid" id="productsGrid" role="list" aria-label="Daftar produk"></div>

  <div class="see-all-wrap">
    <button class="btn btn-outline" onclick="filterCategory('semua', document.querySelector('.pill'))">Lihat Semua Produk</button>
  </div>
</section>

<!-- ══════════════════════════════════════════
     ABOUT SECTION
══════════════════════════════════════════ -->
<section class="about-section" id="about">
  <div class="about-img-wrap">
    <img
      src="https://image2url.com/r2/default/images/1772256798663-fbab917c-b877-4a77-a171-5ec50ab7cdd0.jpeg"
      alt="Logo <?= htmlspecialchars($appName) ?>"
      onerror="this.src='https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=600&q=80'"
    />
  </div>

  <div class="about-content">
    <div class="about-label">Tentang Kami</div>
    <h2 class="section-title">
      <span class="pink-text">Savoria Premium</span><br>
      Semua Rasa Favoritmu Ada Di Sini!
    </h2>
    <p>
      Website ini menjadi platform informasi UMKM lokal yang memudahkan masyarakat menemukan
      lokasi penjualan usaha kecil di lingkungan sekitar, serta membantu UMKM lebih dikenal
      dan berkembang.
    </p>
    <p>
      Mendorong masyarakat untuk mendukung produk lokal dengan mempermudah akses
      informasi UMKM terdekat di wilayah Cikarang, Bekasi.
    </p>

    <div class="about-stats">
      <div class="stat-card">
        <span class="stat-icon">👥</span>
        <div>
          <div class="stat-num">30+</div>
          <div class="stat-label">Mitra UMKM Tergabung</div>
        </div>
      </div>
      <div class="stat-card">
        <span class="stat-icon">❤️</span>
        <div>
          <div class="stat-num">100%</div>
          <div class="stat-label">Bahan Pokok Lokal</div>
        </div>
      </div>
      <div class="stat-card">
        <span class="stat-icon">🏆</span>
        <div>
          <div class="stat-num">Tercurasi</div>
          <div class="stat-label">Kualitas Dijamin</div>
        </div>
      </div>
      <div class="stat-card">
        <span class="stat-icon">🛍️</span>
        <div>
          <div class="stat-num">Mudah</div>
          <div class="stat-label">Akses Informasi</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     CONTACT SECTION
══════════════════════════════════════════ -->
<section class="contact-section" id="kontak">
  <div class="contact-info">
    <div class="about-label">Hubungi Kami</div>
    <h2>Mari Berkolaborasi <span class="pink-text">Bersama</span></h2>
    <p>Ingin mendaftarkan UMKM Anda atau ada pertanyaan? Hubungi kami sekarang!</p>

    <div class="contact-item">
      <div class="contact-icon-wrap">📍</div>
      <div>
        <strong style="font-size:13px;color:var(--dark)">Alamat</strong><br>
        <a href="https://www.google.com/maps/search/Jl+Ciantra+RT009+RW005+Sukadanau+Cikarang+Selatan+Bekasi+Jawa+Barat" target="_blank" rel="noopener" class="text">
          <?= htmlspecialchars(APP_ADDRESS) ?>
        </a>
      </div>
    </div>
    <div class="contact-item">
      <div class="contact-icon-wrap">📞</div>
      <div>
        <strong style="font-size:13px;color:var(--dark)">Telepon</strong><br>
        <span class="text"><?= htmlspecialchars(APP_PHONE) ?></span>
      </div>
    </div>
    <div class="contact-item">
      <div class="contact-icon-wrap">✉️</div>
      <div>
        <strong style="font-size:13px;color:var(--dark)">Email</strong><br>
        <span class="text"><?= htmlspecialchars(APP_EMAIL) ?></span>
      </div>
    </div>
  </div>

  <!-- Contact Form -->
  <div class="contact-form">
    <h3 style="font-family:'Playfair Display',serif;font-size:24px;margin-bottom:24px">Kirim Pesan</h3>
    <div id="contactFormWrap">
      <div class="form-group">
        <label for="contactNama">Nama Lengkap</label>
        <input type="text" id="contactNama" class="form-control" placeholder="Masukkan nama Anda" />
      </div>
      <div class="form-group">
        <label for="contactEmail">Email</label>
        <input type="email" id="contactEmail" class="form-control" placeholder="email@contoh.com" />
      </div>
      <div class="form-group">
        <label for="contactPesan">Pesan</label>
        <textarea id="contactPesan" class="form-control" placeholder="Tuliskan pesan Anda di sini…"></textarea>
      </div>
      <button type="button" id="contactSubmitBtn" class="btn btn-primary" style="width:100%;justify-content:center">Kirim Pesan →</button>
      <div id="contactMsg" class="form-msg"></div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     FOOTER
══════════════════════════════════════════ -->
<footer>
  <div class="footer-grid">

    <div>
      <div class="footer-brand"><span>Savoria</span>Premium</div>
      <p class="footer-desc">
        Platform promosi produk makanan dan minuman UMKM di daerah Cikarang.
        Mari dukung produk lokal!
      </p>
      <div class="social-row">
        <a class="social-btn" href="#" title="Instagram" aria-label="Instagram">📷</a>
        <a class="social-btn" href="#" title="Facebook" aria-label="Facebook">f</a>
        <a class="social-btn" href="#" title="WhatsApp" aria-label="WhatsApp">💬</a>
      </div>
    </div>

    <div>
      <h4>Tautan Cepat</h4>
      <ul>
        <li><a href="#beranda">Beranda</a></li>
        <li><a href="#menu">Produk Unggulan</a></li>
        <li><a href="#about">Tentang Kami</a></li>
        <li><a href="#kontak">Hubungi Kami</a></li>
        <li><a href="#kontak">Daftar Jadi Mitra</a></li>
      </ul>
    </div>

    <div>
      <h4>Kategori</h4>
      <ul>
        <li><a href="#menu">Makanan Berat</a></li>
        <li><a href="#menu">Minuman</a></li>
        <li><a href="#menu">Dessert</a></li>
        <li><a href="#menu">Makanan Ringan</a></li>
        <li><a href="#menu">Makanan Pedas</a></li>
      </ul>
    </div>

    <div>
      <h4>Hubungi Kami</h4>
      <div class="footer-contact-item">
        <div class="footer-contact-icon">📍</div>
        <a href="https://www.google.com/maps/search/Jl+Ciantra+Sukadanau+Cikarang+Selatan" target="_blank" rel="noopener">
          Jl. Ciantra RT009/RW005, Sukadanau, Cikarang Selatan, Kab. Bekasi
        </a>
      </div>
      <div class="footer-contact-item">
        <div class="footer-contact-icon">📞</div>
        <span><?= htmlspecialchars(APP_PHONE) ?></span>
      </div>
      <div class="footer-contact-item">
        <div class="footer-contact-icon">✉️</div>
        <span><?= htmlspecialchars(APP_EMAIL) ?></span>
      </div>
    </div>

  </div>
  <div class="footer-bottom">
    © <?= date('Y') ?> <?= htmlspecialchars($appName) ?>. All rights reserved. Made with ❤️ for Indonesian Food.
  </div>
</footer>

<!-- ══════════════════════════════════════════
     LOGIN MODAL
══════════════════════════════════════════ -->
<div class="modal-overlay" id="loginModal" role="dialog" aria-modal="true" aria-label="Login atau Daftar">
  <div class="modal-box">
    <button class="modal-close" aria-label="Tutup modal">✕</button>

    <div class="modal-logo"><span>Savoria</span>Premium</div>
    <p class="modal-subtitle">Masuk atau buat akun baru untuk melanjutkan</p>

    <div class="modal-tabs" role="tablist">
      <button class="modal-tab active" role="tab" aria-selected="true">Masuk</button>
      <button class="modal-tab" role="tab" aria-selected="false">Daftar</button>
    </div>

    <!-- LOGIN PANEL -->
    <div class="modal-panel active" id="loginPanel" role="tabpanel">
      <div class="form-group">
        <label for="loginEmail">Email</label>
        <input type="email" id="loginEmail" class="form-control" placeholder="email@contoh.com" />
      </div>
      <div class="form-group">
        <label for="loginPassword">Password</label>
        <input type="password" id="loginPassword" class="form-control" placeholder="Minimal 8 karakter" />
      </div>
      <button type="button" id="loginSubmitBtn" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:8px">Masuk →</button>
      <p style="text-align:center;font-size:12px;color:var(--gray);margin-top:14px">
        Demo: demo@savoria.com / Demo1234
      </p>
      <div id="loginMsg" class="form-msg"></div>
    </div>

    <!-- REGISTER PANEL -->
    <div class="modal-panel" id="registerPanel" role="tabpanel">
      <div class="form-group">
        <label for="regNama">Nama Lengkap</label>
        <input type="text" id="regNama" class="form-control" placeholder="Nama lengkap Anda" />
      </div>
      <div class="form-group">
        <label for="regEmail">Email</label>
        <input type="email" id="regEmail" class="form-control" placeholder="email@contoh.com" />
      </div>
      <div class="form-group">
        <label for="regPassword">Password</label>
        <input type="password" id="regPassword" class="form-control" placeholder="Min. 8 karakter, ada huruf & angka" />
      </div>
      <button type="button" id="registerSubmitBtn" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:8px">Daftar Sekarang →</button>
      <div id="registerMsg" class="form-msg"></div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script>
  // Inject APP_URL ke JavaScript agar API endpoint dinamis
  window.SAVORIA_API_BASE = '<?= rtrim(APP_URL, '/') ?>/backend/api';
</script>
<script src="public/js/app.js"></script>
</body>
</html>
