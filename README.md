# 🍽️ Savoria Premium

Platform informasi UMKM makanan & minuman lokal terbaik di **Cikarang, Bekasi**.

---

## 📁 Struktur Folder

```
savoria/
├── index.php                    ← Halaman utama (PHP)
├── config.php                   ← ⭐ Konfigurasi utama (DB, URL, App)
├── .htaccess                    ← Konfigurasi Apache (proteksi & rewrite)
├── nginx.conf.example           ← Contoh konfigurasi Nginx untuk VPS
├── README.md                    ← Dokumentasi ini
│
├── public/                      ← Aset frontend (bisa diakses publik)
│   ├── css/
│   │   └── style.css            ← Stylesheet utama
│   ├── js/
│   │   └── app.js               ← JavaScript utama
│   └── images/                  ← Gambar lokal (opsional)
│
├── backend/                     ← Server-side PHP
│   ├── bootstrap.php            ← Entry point tunggal backend
│   ├── config/
│   │   └── database.php         ← Koneksi PDO (menggunakan config.php)
│   ├── includes/
│   │   └── helpers.php          ← Fungsi bantu (response, sanitasi, dll)
│   └── api/
│       ├── products.php         ← API CRUD produk
│       ├── auth.php             ← API login / register / logout
│       └── contact.php          ← API formulir kontak
│
├── admin/                       ← Panel admin (dikembangkan lebih lanjut)
├── logs/                        ← Log error PHP (dibuat otomatis)
└── database/
    └── savoria_db.sql           ← Schema & seed data MySQL
```

---

## ⚙️ Setup Lokal (Development)

### Persyaratan
- PHP 8.0+
- MySQL 5.7+ / MariaDB 10.4+
- Web server: Apache / Nginx (atau PHP built-in server)

### Langkah

**1. Import Database**
```bash
mysql -u root -p < database/savoria_db.sql
```

**2. Edit Konfigurasi**

Buka `config.php` dan sesuaikan:
```php
define('APP_ENV',  'development');
define('APP_URL',  'http://localhost:8000');
define('DB_USER',  'root');
define('DB_PASS',  '');      // password MySQL Anda
define('DB_NAME',  'savoria_db');
```

**3. Jalankan Server**
```bash
cd /path/to/savoria
php -S localhost:8000
# Buka http://localhost:8000
```

---

## 🚀 Deploy ke VPS (Production)

### Persyaratan VPS
- Ubuntu 20.04+ / Debian 11+
- PHP 8.0+ dengan ekstensi: `php-mysql`, `php-mbstring`, `php-json`
- MySQL 8.0+ atau MariaDB 10.6+
- Nginx atau Apache

### Langkah Deploy

**1. Upload file ke VPS**
```bash
# Menggunakan rsync
rsync -avz --exclude='logs/' ./savoria/ user@IP_VPS:/var/www/savoria/

# Atau menggunakan scp
scp -r ./savoria/ user@IP_VPS:/var/www/savoria/
```

**2. Buat database di VPS**
```bash
ssh user@IP_VPS
mysql -u root -p
```
```sql
CREATE DATABASE savoria_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'savoria_user'@'localhost' IDENTIFIED BY 'password_kuat_anda';
GRANT ALL PRIVILEGES ON savoria_db.* TO 'savoria_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```
```bash
mysql -u savoria_user -p savoria_db < /var/www/savoria/database/savoria_db.sql
```

**3. Edit config.php di VPS**
```php
define('APP_ENV',  'production');
define('APP_URL',  'https://savoriapremium.com');   // domain Anda
define('DB_USER',  'savoria_user');
define('DB_PASS',  'password_kuat_anda');
define('DB_NAME',  'savoria_db');
define('APP_SECRET', 'string_acak_panjang_unik');
```

**4. Set permission folder**
```bash
sudo chown -R www-data:www-data /var/www/savoria
sudo chmod -R 755 /var/www/savoria
sudo mkdir -p /var/www/savoria/logs
sudo chmod 775 /var/www/savoria/logs
```

**5. Konfigurasi Nginx**
```bash
sudo cp /var/www/savoria/nginx.conf.example /etc/nginx/sites-available/savoria
sudo nano /etc/nginx/sites-available/savoria
# Sesuaikan server_name dan path root

sudo ln -s /etc/nginx/sites-available/savoria /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

**6. Pasang SSL dengan Certbot (HTTPS)**
```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d savoriapremium.com -d www.savoriapremium.com
```
Lalu uncomment baris SSL di `nginx.conf.example` dan aktifkan redirect HTTP→HTTPS di `.htaccess`.

---

## 🌐 API Endpoints

### Products
| Method | URL | Deskripsi |
|--------|-----|-----------|
| GET | `backend/api/products.php` | Semua produk |
| GET | `backend/api/products.php?cat=minuman` | Filter kategori |
| GET | `backend/api/products.php?q=kopi` | Pencarian |
| GET | `backend/api/products.php?id=1` | Detail produk |
| POST | `backend/api/products.php` | Tambah produk (admin) |
| PUT | `backend/api/products.php` | Edit produk (admin) |
| DELETE | `backend/api/products.php?id=1` | Hapus produk (admin) |

### Auth
| Method | URL | Deskripsi |
|--------|-----|-----------|
| POST | `backend/api/auth.php?action=login` | Login |
| POST | `backend/api/auth.php?action=register` | Daftar akun |
| POST | `backend/api/auth.php?action=logout` | Logout |
| GET | `backend/api/auth.php?action=me` | Cek status login |

### Contact
| Method | URL | Deskripsi |
|--------|-----|-----------|
| POST | `backend/api/contact.php` | Kirim pesan kontak |

---

## 👤 Akun Demo

| Email | Password | Role |
|-------|----------|------|
| demo@savoria.com | Demo1234 | user (frontend demo) |
| admin@savoriapremium.com | Admin@1234 | admin (backend) |

> ⚠️ Ganti password admin default setelah deploy ke VPS!

---

## 📞 Kontak

- 📧 savoriapremium@gmail.com
- 📞 +62 858-9236-2876
- 📍 Jl. Ciantra RT009/RW005, Sukadanau, Cikarang Selatan, Kab. Bekasi
