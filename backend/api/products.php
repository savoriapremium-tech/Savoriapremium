<?php
// ============================================================
//  SAVORIA PREMIUM - API: Products
//  File: backend/api/products.php
//
//  Endpoint:
//    GET    backend/api/products.php            → Semua produk aktif
//    GET    backend/api/products.php?cat=slug   → Filter kategori
//    GET    backend/api/products.php?q=keyword  → Pencarian
//    GET    backend/api/products.php?id=5       → Detail produk
//    POST   backend/api/products.php            → Tambah produk (admin)
//    PUT    backend/api/products.php            → Edit produk (admin)
//    DELETE backend/api/products.php?id=5       → Hapus produk (admin)
// ============================================================

require_once __DIR__ . '/../bootstrap.php';

$db     = getDB();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // ── GET: Ambil produk ────────────────────────────────────
    case 'GET':
        // Detail satu produk
        if (isset($_GET['id'])) {
            $stmt = $db->prepare("
                SELECT p.*, c.nama AS kategori, v.nama_vendor, v.wilayah, v.maps_url
                FROM   products   p
                JOIN   categories c ON c.id = p.category_id
                JOIN   vendors    v ON v.id = p.vendor_id
                WHERE  p.id = ? AND p.status = 'aktif'
            ");
            $stmt->execute([(int) $_GET['id']]);
            $product = $stmt->fetch();
            if (!$product) {
                jsonResponse(false, 'Produk tidak ditemukan.', [], 404);
            }
            jsonResponse(true, 'OK', ['data' => $product]);
        }

        // Daftar produk (dengan filter opsional)
        $where  = "p.status = 'aktif'";
        $params = [];

        if (!empty($_GET['cat']) && $_GET['cat'] !== 'semua') {
            $where   .= ' AND c.slug = ?';
            $params[] = clean($_GET['cat']);
        }

        if (!empty($_GET['q'])) {
            $where   .= ' AND (p.nama LIKE ? OR v.nama_vendor LIKE ? OR v.wilayah LIKE ?)';
            $like     = '%' . clean($_GET['q']) . '%';
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
        }

        $stmt = $db->prepare("
            SELECT p.id, p.nama, p.harga, p.gambar_url, p.rating, p.total_terjual,
                   c.slug        AS category_slug,
                   c.nama        AS kategori,
                   v.nama_vendor,
                   v.wilayah,
                   v.maps_url
            FROM   products   p
            JOIN   categories c ON c.id = p.category_id
            JOIN   vendors    v ON v.id = p.vendor_id
            WHERE  $where
            ORDER  BY p.rating DESC, p.total_terjual DESC
        ");
        $stmt->execute($params);
        $products = $stmt->fetchAll();
        jsonResponse(true, 'OK', ['data' => $products, 'total' => count($products)]);
        break;

    // ── POST: Tambah produk (admin) ──────────────────────────
    case 'POST':
        if (!isAdmin()) {
            jsonResponse(false, 'Akses ditolak.', [], 403);
        }
        $body     = json_decode(file_get_contents('php://input'), true) ?? [];
        $required = ['vendor_id', 'category_id', 'nama', 'harga'];
        foreach ($required as $field) {
            if (empty($body[$field])) {
                jsonResponse(false, "Field '$field' wajib diisi.", [], 422);
            }
        }
        $stmt = $db->prepare("
            INSERT INTO products (vendor_id, category_id, nama, deskripsi, harga, gambar_url)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            (int)   $body['vendor_id'],
            (int)   $body['category_id'],
                    clean($body['nama']),
                    clean($body['deskripsi'] ?? ''),
            (float) $body['harga'],
                    clean($body['gambar_url'] ?? ''),
        ]);
        jsonResponse(true, 'Produk berhasil ditambahkan.', ['id' => $db->lastInsertId()], 201);
        break;

    // ── PUT: Edit produk (admin) ─────────────────────────────
    case 'PUT':
        if (!isAdmin()) {
            jsonResponse(false, 'Akses ditolak.', [], 403);
        }
        $body = json_decode(file_get_contents('php://input'), true) ?? [];
        if (empty($body['id'])) {
            jsonResponse(false, 'ID produk wajib diisi.', [], 422);
        }
        $stmt = $db->prepare("
            UPDATE products
               SET nama        = ?,
                   deskripsi   = ?,
                   harga       = ?,
                   gambar_url  = ?,
                   category_id = ?,
                   vendor_id   = ?,
                   updated_at  = NOW()
             WHERE id = ?
        ");
        $stmt->execute([
                clean($body['nama']),
                clean($body['deskripsi'] ?? ''),
            (float) $body['harga'],
                clean($body['gambar_url'] ?? ''),
            (int)   $body['category_id'],
            (int)   $body['vendor_id'],
            (int)   $body['id'],
        ]);
        jsonResponse(true, 'Produk berhasil diperbarui.');
        break;

    // ── DELETE: Soft-delete produk (admin) ───────────────────
    case 'DELETE':
        if (!isAdmin()) {
            jsonResponse(false, 'Akses ditolak.', [], 403);
        }
        if (empty($_GET['id'])) {
            jsonResponse(false, 'ID produk wajib diisi.', [], 422);
        }
        $stmt = $db->prepare("UPDATE products SET status = 'nonaktif' WHERE id = ?");
        $stmt->execute([(int) $_GET['id']]);
        jsonResponse(true, 'Produk berhasil dihapus.');
        break;

    default:
        jsonResponse(false, 'Method tidak didukung.', [], 405);
}
