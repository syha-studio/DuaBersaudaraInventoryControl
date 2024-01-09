<?php
session_start();
if (!isset($_SESSION["login"])){
  header ("Location: ../../login.php");
  exit;
}
require '../../functions.php';
$toko = query("SELECT * FROM toko");
$kategori = query("SELECT * FROM kategori");

$id = $_GET["idprod"];
$ganti  = query("SELECT * FROM produk WHERE idprod = $id")[0];


if ( isset($_POST["submit"])){
  if (ubahproduk($_POST) > 0){
    echo "
      <script>
        alert('Data Berhasil Diubah!');
        document.location.href = 'produk.php';
      </script>
    ";
  }else {
    echo "
      <script>
        alert('Data Gagal Diubah!');
        document.location.href = 'produk.php';
      </script>
    ";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $toko[0]["nama_toko"]?> - Ubah Data Produk</title>
    <link rel="icon" type="icon" href="..\..\img\umum\<?= $toko[0]["logo_toko"]?>" />
    <!--CSS-->
    <link rel="stylesheet" href="..\..\style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  </head>

  <body>
    <!-- NavBar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow" style="background-color: #0B2Fa6">
      <div class="container">
        <a class="navbar-brand" href="../../dashboard.php" style="color: white"> <img src="..\..\img\umum\<?= $toko[0]["logo_toko"]?>" width="50vh" class="d-inline-block align-text-mid me-2" /> <?= $toko[0]["nama_toko"]?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </nav>
    <!-- Akhir NavBar -->

    <!-- Keterangan -->
    <div class="container pt-2 pb-2">
      <div class="d-flex justify-content-start">
        <a href="produk.php"><button type="button" class="btn btn-light"><i class="bi bi-x-square-fill"></i> Batal</button></a>
      </div>
      <div class="d-flex justify-content-center pt-3 pb-3">
        <h1 class="fw-bolder">Ubah Data Produk</h1>
      </div>
    <!-- Akhir Keterangan --> 
    
    <!-- Formulir -->
      <form action="" method ="post" enctype="multipart/form-data" class="row g-3">
        <input type="hidden" name="idprod" value="<?= $ganti["idprod"]?>">
        <input type="hidden" name="gambarLama" value="<?= $ganti["gambar_produk"]?>">
        <div class="mb-2">
          <label for="kategori" class="form-label">Kategori</label>
          <select class="form-select" name="kategori" id="kategori" required>
            <option selected><?= $ganti["kategori"]?></option>
          <?php foreach ($kategori as $katpro) : ?>
            <option value="<?=$katpro['kategori']?>"><?=$katpro['kategori']?></option>
          <?php endforeach?>
          </select>
        </div>
        <div class="mb-2">
          <label for="nama_produk" class="form-label">Nama Produk</label>
          <input class="form-control" type="text" name="nama_produk" id="nama_produk" required value = "<?= $ganti["nama_produk"]?>">  
        </div>
        <div class="mb-2">
          <label for="deskripsi_produk" class="form-label">Deskripsi Produk</label>
          <textarea rows="3" class="form-control" type="text" name="deskripsi_produk" id="deskripsi_produk" required><?= $ganti["deskripsi_produk"]?></textarea>
        </div>
        <div class="mb-2">
          <label for="gambar_produk" class="form-label">Gambar Produk</label>
          <div class="p-2 m-2 border">
            <img src="..\..\img\produk\<?= $ganti["gambar_produk"]?>" alt="<?= $ganti["gambar_produk"]?>" width="150vh">
          </div>
          <input class="form-control" type="file" id="gambar_produk" name="gambar_produk">
        </div>
        <div class="d-flex justify-content-center mb-3">
          <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    <!-- Akhir Formulir -->
    </div>
  </body>
</html>
