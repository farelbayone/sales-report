CREATE DATABASE IF NOT EXISTS umkm_sales CHARACTER SET utf8mb4;
USE umkm_sales;
CREATE TABLE produk(id INT AUTO_INCREMENT PRIMARY KEY,nama VARCHAR(100) NOT NULL,kategori VARCHAR(50),harga INT NOT NULL,stok INT NOT NULL DEFAULT 0);
CREATE TABLE pelanggan(id INT AUTO_INCREMENT PRIMARY KEY,nama VARCHAR(100) NOT NULL,telepon VARCHAR(20),alamat TEXT);
CREATE TABLE transaksi(id INT AUTO_INCREMENT PRIMARY KEY,tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,pelanggan_id INT NULL,total INT NOT NULL,FOREIGN KEY(pelanggan_id) REFERENCES pelanggan(id) ON DELETE SET NULL);
CREATE TABLE detail_transaksi(id INT AUTO_INCREMENT PRIMARY KEY,transaksi_id INT NOT NULL,produk_id INT NOT NULL,qty INT NOT NULL,harga INT NOT NULL,FOREIGN KEY(transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE,FOREIGN KEY(produk_id) REFERENCES produk(id));
INSERT INTO produk(nama,kategori,harga,stok) VALUES('Keripik Singkong','Makanan',15000,40),('Kopi Arabika 250g','Minuman',55000,25),('Sambal Roa','Makanan',32000,8),('Tote Bag Batik','Fashion',45000,15);
INSERT INTO pelanggan(nama,telepon,alamat) VALUES('Siti Aminah','081234567890','Jakarta Selatan'),('Budi Santoso','081298765432','Bekasi');
