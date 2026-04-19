-- ============================================================
--  SAVORIA PREMIUM - DATABASE SCHEMA
--  Database: savoria_db
--  Versi: 1.0
-- ============================================================

CREATE DATABASE IF NOT EXISTS savoria_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE savoria_db;

-- ============================================================
-- TABEL: users (Admin & Mitra login)
-- ============================================================
CREATE TABLE IF NOT EXISTS users (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  nama        VARCHAR(100)        NOT NULL,
  email       VARCHAR(150)        NOT NULL UNIQUE,
  password    VARCHAR(255)        NOT NULL,
  role        ENUM('admin','mitra','user') DEFAULT 'user',
  status      ENUM('aktif','nonaktif') DEFAULT 'aktif',
  created_at  TIMESTAMP           DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP           DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- TABEL: categories (Kategori produk)
-- ============================================================
CREATE TABLE IF NOT EXISTS categories (
  id    INT AUTO_INCREMENT PRIMARY KEY,
  slug  VARCHAR(60)  NOT NULL UNIQUE,
  nama  VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

INSERT INTO categories (slug, nama) VALUES
  ('semua',          'Semua'),
  ('makanan-berat',  'Makanan Berat'),
  ('minuman',        'Minuman'),
  ('dessert',        'Dessert'),
  ('makanan-ringan', 'Makanan Ringan'),
  ('makanan-pedas',  'Makanan Pedas');

-- ============================================================
-- TABEL: vendors (UMKM / Mitra)
-- ============================================================
CREATE TABLE IF NOT EXISTS vendors (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  user_id      INT           NULL,
  nama_vendor  VARCHAR(150)  NOT NULL,
  deskripsi    TEXT,
  alamat       TEXT,
  wilayah      VARCHAR(100),
  maps_url     VARCHAR(500),
  telepon      VARCHAR(20),
  status       ENUM('aktif','nonaktif') DEFAULT 'aktif',
  created_at   TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================================
-- TABEL: products (Produk makanan/minuman)
-- ============================================================
CREATE TABLE IF NOT EXISTS products (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  vendor_id    INT           NOT NULL,
  category_id  INT           NOT NULL,
  nama         VARCHAR(150)  NOT NULL,
  deskripsi    TEXT,
  harga        DECIMAL(12,2) NOT NULL DEFAULT 0,
  gambar_url   VARCHAR(500),
  rating       DECIMAL(2,1)  DEFAULT 0.0,
  total_terjual INT           DEFAULT 0,
  status       ENUM('aktif','nonaktif') DEFAULT 'aktif',
  created_at   TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
  updated_at   TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (vendor_id)   REFERENCES vendors(id)    ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ============================================================
-- TABEL: reviews (Ulasan produk)
-- ============================================================
CREATE TABLE IF NOT EXISTS reviews (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT           NOT NULL,
  user_id    INT           NULL,
  nama       VARCHAR(100),
  rating     TINYINT       NOT NULL CHECK (rating BETWEEN 1 AND 5),
  komentar   TEXT,
  created_at TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id)    REFERENCES users(id)    ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================================
-- TABEL: contacts (Pesan kontak / formulir)
-- ============================================================
CREATE TABLE IF NOT EXISTS contacts (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  nama       VARCHAR(100) NOT NULL,
  email      VARCHAR(150) NOT NULL,
  pesan      TEXT         NOT NULL,
  status     ENUM('baru','dibaca','dibalas') DEFAULT 'baru',
  created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- SEED DATA: Admin user (password: Admin@1234)
-- ============================================================
INSERT INTO users (nama, email, password, role) VALUES
  ('Admin Savoria', 'admin@savoriapremium.com',
   '$2y$10$abcdefghijklmnopqrstuuVGZtY9kL6KQlMnWzXyZABCDEFGHIJKL',
   'admin');

-- ============================================================
-- SEED DATA: Vendors
-- ============================================================
INSERT INTO vendors (nama_vendor, alamat, wilayah, maps_url, telepon) VALUES
  ('Cikarang Festival (Cifest)',      'Cikarang Festival, Cikarang Selatan',       'Cikarang Selatan', 'https://maps.app.goo.gl/uDafvmhJ1Yyshqgw5', NULL),
  ('Bumi Cikarang Makmur (BCM)',      'BCM, Cikarang Selatan',                      'Cikarang Selatan', 'https://maps.app.goo.gl/R3NP87mG3RtouSR66', NULL),
  ('Caramel SBC',                    'Cifest, Cikarang Selatan',                   'Cikarang Selatan', 'https://maps.app.goo.gl/RPSPJM9Hb4UhF4nGA', NULL),
  ('Dawet Durian Ratu Cikarang',     'Jatireja, Cikarang Timur',                   'Cikarang Timur',   'https://maps.app.goo.gl/TwQ9XNsc4iM2cBVK8', NULL),
  ('Lucky Drink & Rokupang',         'Mekarmukti, Cikarang Utara',                 'Cikarang Utara',   'https://share.google/DfkuD5cb2kUJyJunu',    NULL),
  ('Nasi Padang Fahmi',              'Pegadungan, Cikarang Selatan',               'Cikarang Selatan', 'https://maps.app.goo.gl/KtXBcrNAHr2A5hh38', NULL),
  ('Oniisan Japanese Cuisine CINITY','Karangraharja, Cikarang Utara',              'Cikarang Utara',   'https://maps.app.goo.gl/7phUNBT3kxwjYjar9', NULL),
  ('Es Doger Babang Bayu',           'Mekarmukti, Cikarang Utara',                 'Cikarang Utara',   'https://maps.app.goo.gl/fumrx6rAMSz9SC2u9', NULL),
  ('Royal Smoothies',                'Serang, Cikarang Selatan',                   'Cikarang Selatan', 'https://maps.app.goo.gl/xi8iwbDUJFzHMC6n8', NULL),
  ('Kedai Kang Ade',                 'Ciantra, Cikarang Selatan',                  'Cikarang Selatan', 'https://maps.app.goo.gl/rG7P8nJRzpRQVdKw8', NULL),
  ('Fuji Matcha Cikarang',           'Sukamahi, Cikarang Pusat',                   'Cikarang Pusat',   'https://maps.app.goo.gl/h4MWbyWuW4pbUQ5d9', NULL),
  ('Donatsu Jababeka Cikarang',      'Mekarmukti, Cikarang Utara',                 'Cikarang Utara',   'https://maps.app.goo.gl/Ae14iY5XK56S16tHA', NULL),
  ('Sate Taichan Bang Ocit',         'Cikarang Utara',                             'Cikarang Utara',   'https://maps.app.goo.gl/kLvHburG86om6PCe6', NULL),
  ('Queen Es Krim',                  'Tegal Danas, Cikarang Timur',                'Cikarang Timur',   'https://maps.app.goo.gl/yeoctNJARvLpQY2b7', NULL),
  ('Es Sakaw, Es Mujito, Es Boba',   'Jati Wangi, Cikarang Barat',                 'Cikarang Barat',   'https://share.google/jGVvdzw85FstlLZqC',    NULL),
  ('Sate Maranggi OTW Sukses',       'Danau Indah, Cikarang Barat',                'Cikarang Barat',   'https://maps.app.goo.gl/rJyNzzeMJdoU8Vg86', NULL),
  ('Mille Crepes',                   'Jatireja, Cikarang Timur',                   'Cikarang Timur',   'https://maps.app.goo.gl/BmA9bL6ayAHg3eRv6', NULL),
  ('Bakso & Mie Ayam Mas Dawer',     'Jatireja, Cikarang Timur',                   'Cikarang Timur',   'https://maps.app.goo.gl/kKxGKTsHUtgE3rt29', NULL),
  ('Misnow Korean Milky Snow',       'Jaya Mukti, Cikarang Pusat',                 'Cikarang Pusat',   'https://www.google.com/maps/search/Misnow+Korean+Milky+Snow+Ice+Jayamukti+Cikarang+Pusat', NULL);

-- ============================================================
-- SEED DATA: Products
-- ============================================================
INSERT INTO products (vendor_id, category_id, nama, harga, gambar_url, rating, total_terjual) VALUES
  (1,  3, 'Kopi Kenangan Mantan',       20000, 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=400&q=80', 4.7, 150),
  (2,  6, 'Seblak Mewek',              10000, 'https://nibble-images.b-cdn.net/nibble/original_images/389848189.jpg?class=large', 4.8, 320),
  (3,  4, 'Salad Buah Caramel SBC',    20000, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQWwANnimH7fTHHwvkSi88hgoGqxSn7lzLrpw&s', 4.7, 400),
  (4,  3, 'Dawet Durian Ratu',         15000, 'https://i.gojekapi.com/darkroom/gofood-indonesia/v2/images/uploads/7a23ed74-50ed-4ae2-8a02-257e0ece8a82_Go-Biz_20210830_102906.jpeg', 4.6, 120),
  (5,  3, 'Lucky Drink & Rokupang',    10000, 'https://cdn.rri.co.id/berita/44/images/1701382129043-E/udhdc9544bh0arw.jpeg', 4.9, 85),
  (6,  2, 'Nasi Padang Fahmi',         15000, 'https://katasumbar.com/wp-content/uploads/2023/07/Seporsi-Nasi-Padang.jpg', 4.8, 340),
  (7,  2, 'Oniisan Japanese Cuisine',  15000, 'https://images.unsplash.com/photo-1569050467447-ce54b3bbc37d?w=400&q=80', 4.8, 210),
  (8,  3, 'Es Doger Babang Bayu',       5000, 'https://superapp.id/blog/wp-content/uploads/2022/04/jajansolo_69295374_2443349222573675_3245694075287370282_n-570x468.jpg', 4.8, 150),
  (9,  3, 'Royal Smoothies',           15000, 'https://images.unsplash.com/photo-1589733955941-5eeaf752f6dd?w=400&q=80', 4.8, 95),
  (10, 5, 'Surabi Kedai Kang Ade',      5000, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRaZoNOoQQIKwNjbDzVCm5fbEdiOV4tAtJDQA&s', 4.8, 180),
  (11, 3, 'Fuji Matcha',               12000, 'https://down-id.img.susercontent.com/file/id-11134207-7ra0m-mckcoi91u6mv36', 4.8, 120),
  (12, 4, 'Donatsu',                    8000, 'https://i.gojekapi.com/darkroom/gofood-indonesia/v2/images/uploads/e795e40f-8c42-4b32-954a-ba56dde6fc71_Go-Biz_20240608_114524.jpeg', 4.8, 300),
  (13, 6, 'Sate Taichan Senayan',      25000, 'https://upload.wikimedia.org/wikipedia/commons/1/16/Sate_taichan_jakarta.jpg', 4.7, 220),
  (14, 3, 'Queen Es Krim',             10000, 'https://tse3.mm.bing.net/th/id/OIP.ZzV83aks5VoTzhzqs3lswwAAAA?pid=Api&h=220&P=0', 4.6, 150),
  (15, 3, 'Es Sakaw',                  15000, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSLWw7pqD7TiMBk5hinA7Vmrw-ofukFgux9GQ&s', 4.6, 0),
  (16, 2, 'Sate Maranggi',             30000, 'https://images.aws.nestle.recipes/original/c3154a6bd035b2cea65301c7bd7eac83_recipe_website_images_14_juli_1500x700_sate-maranggi.jpg', 4.6, 0),
  (17, 4, 'Mille Crepes',              15000, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRvuP2b2FU9MpcolDUoTeKAiWoN44eYmvnRGQ&s', 4.6, 0),
  (18, 2, 'Bakso & Mie Ayam Mas Dawer',25000, 'https://garasijogja.com/wp-content/uploads/2018/12/kulineryogya.jpg', 4.6, 0),
  (19, 4, 'Korean Milky Snow Ice',     25000, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRYFDLe7K1Uyc1zJ3eL6XFjjsR03UPLC8pa1A&s', 4.6, 0);
