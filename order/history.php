<?php
session_start();
if (!isset($_SESSION["login"])){
  header ("Location: ../../login.php");
  exit;
}
require '../../functions.php';
$produk  = query("SELECT * FROM produk ORDER BY idprod");
$toko = query("SELECT * FROM toko");
//tombol cari
if ( isset($_POST["cari"])){
  $produk = cariproduk($_POST["keyword"]);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $toko[0]["nama_toko"]?> - Kelola Produk</title>
    <link rel="icon" type="icon" href="../../img\umum\<?= $toko[0]["logo_toko"]?>" />
    <!--CSS-->
    <link rel="stylesheet" href="../../style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  </head>

  <body>
    <!-- NavBar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow" style="background-color: #0B2Fa6">
      <div class="container">
        <a class="navbar-brand" href="../../dashboard.php" style="color: white"> <img src="../../img\umum\<?= $toko[0]["logo_toko"]?>" width="50vh" class="d-inline-block align-text-mid me-2" /> <?= $toko[0]["nama_toko"]?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </nav>
    <!-- Akhir NavBar -->

    <!-- Keterangan -->
    <div class="container pt-2 pb-2">
      <div class="d-flex justify-content-start">
        <a href="../../dashboard.php"><button type="button" class="btn btn-light"><i class="bi bi-back"></i> Kembali</button></a>
      </div>
      <div class="d-flex justify-content-center pt-3 pb-1">
        <h1 class="fw-bolder">Kelola Produk</h1>
      </div>
      <div class="d-flex justify-content-center pt-1 pb-3">
        <p class="text-start">Halaman ini adalah Halaman yang mengelola bagian <a href="../../index.php#products">Our Product</a> pada Halaman utama.</p>
      </div>
    <!-- Akhir Keterangan --> 
    
    <!-- Pencarian -->
      <div class="col-md-auto d-flex justify-content-start pt-2 pb-2">
        <form action="" method ="post" class="row g-3">
          <div class="col-md-auto">
            <input class="form-control" type="text" name ="keyword" autofocus placeholder ="Input ID / Nama Produk" autocomplete ="off" required>
          </div>
          <div class="col-md-auto">
            <button class="btn btn-secondary" type ="submit" name="cari">Cari</button>
          </div>
        </form>
    <!-- Akhir Pencarian -->

    <!-- Tabel dan Kontrol -->
        <div class="col-md-auto ps-3 me-0">
          <a href="tambah.php"><button type="button" class="btn btn-primary"><i class="bi bi-plus-lg"></i></button></a>
        </div>
      </div>
      <div class="pt-2 pb-2 table-responsive">
        <table class="table table-striped table-bordered align-middle">
          <tr class="text-center">
            <th>No.</th>
            <th>ID Produk</th>
            <th>Nama Produk</th>
            <th>Deskripsi Produk</th>
            <th>Gambar Produk</th>
            <th>Kategori</th>
            <th>Aksi</th>
          </tr>
          <?php $i = 1 ?>
          <?php foreach ($produk as $row) : ?>
          <tr>
            <td><?= $i ?></td>
            <td><?= $row["idprod"]?></td>
            <td><?= $row["nama_produk"]?></td>
            <td><?= $row["deskripsi_produk"]?></td>
            <td class="text-center"><img src="..\..\img\produk\<?= $row["gambar_produk"]?>" alt="<?= $row["gambar_produk"]?>" width="100vh"></td>
            <td ><?= $row["kategori"]?></td>
            <td class="text-center">
            <a href="hapus.php?idprod=<?= $row["idprod"];?>" onclick="return confirm('Yakin?');"><button type="button" class="btn btn-secondary btn-sm"><i class="bi bi-trash"></i></button></a>
            <a href="ubah.php?idprod=<?= $row["idprod"];?>"><button type="button" class="btn btn-secondary btn-sm"><i class="bi bi-pencil-square"></i></button></a>
            </td>
          </tr>
          <?php $i++ ?>
          <?php endforeach ?>
        </table>
      </div>
    <!-- Akhir Tabel dan Kontrol -->
    </div>
  </body>
</html>