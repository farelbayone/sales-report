<?php $title='Laporan Penjualan'; require_once 'config.php';
$dari=$_GET['dari']??date('Y-m-01'); $sampai=$_GET['sampai']??date('Y-m-d');
$s=$pdo->prepare('SELECT t.*,p.nama pelanggan FROM transaksi t LEFT JOIN pelanggan p ON p.id=t.pelanggan_id WHERE DATE(t.tanggal) BETWEEN ? AND ? ORDER BY t.tanggal DESC'); $s->execute([$dari,$sampai]); $rows=$s->fetchAll();
$s=$pdo->prepare('SELECT p.nama,SUM(d.qty) q,SUM(d.qty*d.harga) omzet FROM detail_transaksi d JOIN transaksi t ON t.id=d.transaksi_id JOIN produk p ON p.id=d.produk_id WHERE DATE(t.tanggal) BETWEEN ? AND ? GROUP BY p.id ORDER BY omzet DESC'); $s->execute([$dari,$sampai]); $per=$s->fetchAll();
require 'includes/header.php'; ?>
<form class="row g-2 mb-4"><div class="col-auto"><input type="date" name="dari" value="<?= e($dari) ?>" class="form-control"></div>
<div class="col-auto"><input type="date" name="sampai" value="<?= e($sampai) ?>" class="form-control"></div>
<div class="col-auto"><button class="btn btn-success">Tampilkan</button> <button type="button" onclick="print()" class="btn btn-outline-secondary">Cetak</button></div></form>
<div class="row g-3"><div class="col-lg-7"><div class="card border-0 shadow-sm"><table class="table mb-0"><thead><tr><th>No</th><th>Tanggal</th><th>Pelanggan</th><th class="text-end">Total</th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td>#<?= $r['id'] ?></td><td><?= e($r['tanggal']) ?></td><td><?= e($r['pelanggan']?:'Umum') ?></td><td class="text-end"><?= rp($r['total']) ?></td></tr><?php endforeach; ?>
<tr class="table-light fw-bold"><td colspan="3">Total omzet</td><td class="text-end"><?= rp(array_sum(array_column($rows,'total'))) ?></td></tr></tbody></table></div></div>
<div class="col-lg-5"><div class="card border-0 shadow-sm"><table class="table mb-0"><thead><tr><th>Produk</th><th>Terjual</th><th class="text-end">Omzet</th></tr></thead><tbody>
<?php foreach($per as $r): ?><tr><td><?= e($r['nama']) ?></td><td><?= $r['q'] ?></td><td class="text-end"><?= rp($r['omzet']) ?></td></tr><?php endforeach; ?></tbody></table></div></div></div>
<?php require 'includes/footer.php'; ?>
