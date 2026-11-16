<?php $title='Produk & Stok'; require_once 'config.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  if(isset($_POST['hapus'])){ try{ $pdo->prepare('DELETE FROM produk WHERE id=?')->execute([(int)$_POST['hapus']]); }catch(PDOException $x){ $_SESSION['err']='Produk sudah dipakai di transaksi, tidak bisa dihapus.'; } }
  else{ $d=[trim($_POST['nama']),trim($_POST['kategori']),(int)$_POST['harga'],(int)$_POST['stok']];
    if(!empty($_POST['id'])) $pdo->prepare('UPDATE produk SET nama=?,kategori=?,harga=?,stok=? WHERE id=?')->execute([...$d,(int)$_POST['id']]);
    else $pdo->prepare('INSERT INTO produk(nama,kategori,harga,stok) VALUES(?,?,?,?)')->execute($d); }
  header('Location: produk.php'); exit; }
$edit=null; if(isset($_GET['edit'])){ $s=$pdo->prepare('SELECT * FROM produk WHERE id=?'); $s->execute([(int)$_GET['edit']]); $edit=$s->fetch(); }
$rows=$pdo->query('SELECT * FROM produk ORDER BY nama')->fetchAll();
require 'includes/header.php';
if(!empty($_SESSION['err'])){ echo '<div class="alert alert-warning">'.e($_SESSION['err']).'</div>'; unset($_SESSION['err']); } ?>
<form method="post" class="card card-body border-0 shadow-sm mb-4"><input type="hidden" name="id" value="<?= e($edit['id']??'') ?>">
<div class="row g-2"><div class="col-md-4"><input name="nama" class="form-control" placeholder="Nama produk" required value="<?= e($edit['nama']??'') ?>"></div>
<div class="col-md-2"><input name="kategori" class="form-control" placeholder="Kategori" value="<?= e($edit['kategori']??'') ?>"></div>
<div class="col-md-2"><input name="harga" type="number" min="0" class="form-control" placeholder="Harga" required value="<?= e($edit['harga']??'') ?>"></div>
<div class="col-md-2"><input name="stok" type="number" min="0" class="form-control" placeholder="Stok" required value="<?= e($edit['stok']??'') ?>"></div>
<div class="col-md-2"><button class="btn btn-success w-100"><?= $edit?'Simpan perubahan':'Tambah produk' ?></button></div></div></form>
<div class="card border-0 shadow-sm"><table class="table mb-0"><thead><tr><th>Produk</th><th>Kategori</th><th>Harga</th><th>Stok</th><th></th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><?= e($r['nama']) ?></td><td><?= e($r['kategori']) ?></td><td><?= rp($r['harga']) ?></td>
<td><span class="badge text-bg-<?= $r['stok']<=10?'danger':'success' ?>"><?= $r['stok'] ?></span></td>
<td class="text-end"><a class="btn btn-sm btn-outline-secondary" href="?edit=<?= $r['id'] ?>">Ubah</a>
<form method="post" class="d-inline" onsubmit="return confirm('Hapus produk ini?')"><button name="hapus" value="<?= $r['id'] ?>" class="btn btn-sm btn-outline-danger">Hapus</button></form></td></tr><?php endforeach; ?></tbody></table></div>
<?php require 'includes/footer.php'; ?>
