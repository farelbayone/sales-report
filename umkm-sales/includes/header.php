<?php require_once __DIR__.'/../config.php'; $cur = basename($_SERVER['PHP_SELF']); ?>
<!doctype html><html lang="id"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($title ?? 'UMKM') ?> | Sistem Penjualan UMKM</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>body{background:#f3f7f5}.side{width:230px;min-height:100vh;background:#0f4c3a}
.side a{color:#cfe8dd;text-decoration:none;display:block;padding:10px 16px;border-radius:8px;margin:2px 10px}
.side a.on,.side a:hover{background:#1c6b53;color:#fff}</style></head><body>
<div class="d-flex"><nav class="side py-3"><h5 class="text-white px-4 mb-3">UMKM Sales</h5>
<?php foreach(['index.php'=>'Dashboard','produk.php'=>'Produk & Stok','pelanggan.php'=>'Pelanggan','transaksi.php'=>'Transaksi Baru','laporan.php'=>'Laporan'] as $f=>$l): ?>
<a class="<?= $cur==$f?'on':'' ?>" href="<?= $f ?>"><?= $l ?></a><?php endforeach; ?></nav>
<main class="flex-grow-1 p-4"><h3 class="mb-4"><?= e($title) ?></h3>
