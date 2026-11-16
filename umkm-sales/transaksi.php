<?php $title='Transaksi Baru'; require_once 'config.php'; $err=''; $ok=$_GET['ok']??'';
if($_SERVER['REQUEST_METHOD']==='POST'){
  try{ $pdo->beginTransaction(); $total=0; $lines=[];
    foreach(($_POST['produk']??[]) as $i=>$pid){ $qty=(int)($_POST['qty'][$i]??0); if(!$pid||$qty<=0) continue;
      $s=$pdo->prepare('SELECT nama,harga,stok FROM produk WHERE id=? FOR UPDATE'); $s->execute([(int)$pid]); $p=$s->fetch();
      if(!$p) throw new Exception('Produk tidak ditemukan.');
      if($p['stok']<$qty) throw new Exception("Stok {$p['nama']} tidak cukup (sisa {$p['stok']}).");
      $total+=$p['harga']*$qty; $lines[]=[(int)$pid,$qty,$p['harga']]; }
    if(!$lines) throw new Exception('Pilih minimal satu produk.');
    $pdo->prepare('INSERT INTO transaksi(pelanggan_id,total) VALUES(?,?)')->execute([$_POST['pelanggan']?:null,$total]); $tid=$pdo->lastInsertId();
    foreach($lines as [$pid,$qty,$h]){ $pdo->prepare('INSERT INTO detail_transaksi(transaksi_id,produk_id,qty,harga) VALUES(?,?,?,?)')->execute([$tid,$pid,$qty,$h]);
      $pdo->prepare('UPDATE produk SET stok=stok-? WHERE id=?')->execute([$qty,$pid]); }
    $pdo->commit(); header("Location: transaksi.php?ok=$tid"); exit;
  }catch(Exception $x){ if($pdo->inTransaction()) $pdo->rollBack(); $err=$x->getMessage(); } }
$prod=$pdo->query('SELECT * FROM produk WHERE stok>0 ORDER BY nama')->fetchAll(); $cust=$pdo->query('SELECT * FROM pelanggan ORDER BY nama')->fetchAll();
require 'includes/header.php';
if($ok) echo '<div class="alert alert-success">Transaksi #'.e($ok).' berhasil disimpan.</div>';
if($err) echo '<div class="alert alert-danger">'.e($err).'</div>'; ?>
<form method="post" class="card card-body border-0 shadow-sm" style="max-width:720px">
<label class="form-label">Pelanggan (opsional)</label><select name="pelanggan" class="form-select mb-3"><option value="">Umum</option>
<?php foreach($cust as $c) echo '<option value="'.$c['id'].'">'.e($c['nama']).'</option>'; ?></select>
<div id="rows"></div><button type="button" id="add" class="btn btn-outline-success btn-sm mb-3 align-self-start">+ Tambah baris</button>
<button class="btn btn-success">Simpan transaksi</button></form>
<script>const P=<?= json_encode($prod) ?>;
function row(){const d=document.createElement('div');d.className='row g-2 mb-2';
d.innerHTML='<div class="col-8"><select name="produk[]" class="form-select"><option value="">Pilih produk</option>'+P.map(p=>`<option value="${p.id}">${p.nama} (stok ${p.stok}) - Rp ${(+p.harga).toLocaleString('id-ID')}</option>`).join('')+'</select></div><div class="col-4"><input type="number" name="qty[]" min="1" value="1" class="form-control"></div>';
document.getElementById('rows').appendChild(d);}
document.getElementById('add').onclick=row;row();</script>
<?php require 'includes/footer.php'; ?>
