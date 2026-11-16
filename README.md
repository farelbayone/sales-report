# Sistem Informasi Penjualan UMKM

Aplikasi web untuk mengelola produk, stok, pelanggan, transaksi, dan laporan penjualan UMKM.

![Preview](preview.png)

## Fitur
- Dashboard: omzet harian/bulanan, grafik 7 hari (Chart.js), produk terlaris, peringatan stok menipis
- CRUD produk & pelanggan
- Transaksi multi-item, stok berkurang otomatis, validasi stok (database transaction)
- Laporan per periode + rekap per produk, bisa dicetak

## Teknologi
PHP 8 (PDO) · MySQL · Bootstrap 5 · Chart.js

## Instalasi
1. Salin folder ke `htdocs` (XAMPP) atau `www` (Laragon).
2. Import `database.sql` lewat phpMyAdmin.
3. Sesuaikan kredensial DB di `config.php`.
4. Buka `http://localhost/umkm-sales/`.

## Pengembangan lanjutan
Login & hak akses (admin/kasir), cetak struk, ekspor Excel/PDF, upload foto produk.
