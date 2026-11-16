<?php $title='Dashboard'; require 'includes/header.php';
$q = fn($sql)=>$pdo->query($sql)->fetchColumn();
$hari  = $q("SELECT COALESCE(SUM(total),0) FROM transaksi WHERE DATE(tanggal)=CURDATE()");
$bulan = $q("SELECT COALESCE(SUM(total),0) FROM transaksi WHERE YEAR(tanggal)=YEAR(CURDATE()) AND MONTH(tanggal)=MONTH(CURDATE())");
$nProd = $q("SELECT COUNT(*) FROM produk");
$low   = $pdo->query("SELECT nama,stok FROM produk WHERE stok<=10 ORDER BY stok")->fetchAll();
$grafik= $pdo->query("SELECT DATE(tanggal) d,SUM(total) t FROM transaksi WHERE tanggal>=CURDATE()-INTERVAL 6 DAY GROUP BY d ORDER BY d")->fetchAll();
$top   = $pdo->query("SELECT p.nama,SUM(d.qty) q FROM detail_transaksi d JOIN produk p ON p.id=d.produk_id GROUP BY p.id ORDER BY q DESC LIMIT 5")->fetchAll(); ?>
<div class="row g-3 mb-4">
<?php foreach([['Penjualan hari ini',rp($hari)],['Penjualan bulan ini',rp($bulan)],['Jumlah produk',$nProd],['Stok menipis',count($low)]] as [$l,$v]): ?>
<div class="col-md-3"><div class="card border-0 shadow-sm"><div class="card-body"><div class="text-muted small"><?= $l ?></div><div class="fs-4 fw-bold"><?= e($v) ?></div></div></div></div><?php endforeach; ?></div>
<div class="row g-3"><div class="col-lg-8"><div class="card border-0 shadow-sm"><div class="card-body"><h6>Penjualan 7 hari terakhir</h6><canvas id="c" height="110"></canvas></div></div></div>
<div class="col-lg-4"><div class="card border-0 shadow-sm mb-3"><div class="card-body"><h6>Produk terlaris</h6><?php foreach($top as $t): ?><div class="d-flex justify-content-between"><span><?= e($t['nama']) ?></span><b><?= $t['q'] ?></b></div><?php endforeach; if(!$top) echo '<small class="text-muted">Belum ada transaksi.</small>'; ?></div></div>
<div class="card border-0 shadow-sm"><div class="card-body"><h6>Perlu restock</h6><?php foreach($low as $l): ?><div class="d-flex justify-content-between"><span><?= e($l['nama']) ?></span><span class="badge text-bg-danger"><?= $l['stok'] ?></span></div><?php endforeach; if(!$low) echo '<small class="text-muted">Semua stok aman.</small>'; ?></div></div></div></div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>new Chart(document.getElementById('c'),{type:'line',data:{labels:<?= json_encode(array_column($grafik,'d')) ?>,datasets:[{label:'Penjualan (Rp)',data:<?= json_encode(array_map('intval',array_column($grafik,'t'))) ?>,borderColor:'#1c6b53',backgroundColor:'rgba(28,107,83,.12)',fill:true,tension:.3}]}});</script>
<?php require 'includes/footer.php'; ?>
