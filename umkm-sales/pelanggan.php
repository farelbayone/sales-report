<?php $title='Pelanggan'; require_once 'config.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  if(isset($_POST['hapus'])) $pdo->prepare('DELETE FROM pelanggan WHERE id=?')->execute([(int)$_POST['hapus']]);
  else{ $d=[trim($_POST['nama']),trim($_POST['telepon']),trim($_POST['alamat'])];
    if(!empty($_POST['id'])) $pdo->prepare('UPDATE pelanggan SET nama=?,telepon=?,alamat=? WHERE id=?')->execute([...$d,(int)$_POST['id']]);
    else $pdo->prepare('INSERT INTO pelanggan(nama,telepon,alamat) VALUES(?,?,?)')->execute($d); }
  header('Location: pelanggan.php'); exit; }
$edit=null; if(isset($_GET['edit'])){ $s=$pdo->prepare('SELECT * FROM pelanggan WHERE id=?'); $s->execute([(int)$_GET['edit']]); $edit=$s->fetch(); }
$rows=$pdo->query('SELECT * FROM pelanggan ORDER BY nama')->fetchAll();
require 'includes/header.php'; ?>
<form method="post" class="card card-body border-0 shadow-sm mb-4"><input type="hidden" name="id" value="<?= e($edit['id']??'') ?>">
<div class="row g-2"><div class="col-md-3"><input name="nama" class="form-control" placeholder="Nama" required value="<?= e($edit['nama']??'') ?>"></div>
<div class="col-md-3"><input name="telepon" class="form-control" placeholder="Telepon" value="<?= e($edit['telepon']??'') ?>"></div>
<div class="col-md-4"><input name="alamat" class="form-control" placeholder="Alamat" value="<?= e($edit['alamat']??'') ?>"></div>
<div class="col-md-2"><button class="btn btn-success w-100"><?= $edit?'Simpan':'Tambah' ?></button></div></div></form>
<div class="card border-0 shadow-sm"><table class="table mb-0"><thead><tr><th>Nama</th><th>Telepon</th><th>Alamat</th><th></th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><?= e($r['nama']) ?></td><td><?= e($r['telepon']) ?></td><td><?= e($r['alamat']) ?></td>
<td class="text-end"><a class="btn btn-sm btn-outline-secondary" href="?edit=<?= $r['id'] ?>">Ubah</a>
<form method="post" class="d-inline" onsubmit="return confirm('Hapus pelanggan ini?')"><button name="hapus" value="<?= $r['id'] ?>" class="btn btn-sm btn-outline-danger">Hapus</button></form></td></tr><?php endforeach; ?></tbody></table></div>
<?php require 'includes/footer.php'; ?>
