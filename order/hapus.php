<?php
session_start();
if (!isset($_SESSION["login"])){
  header ("Location: ../../login.php");
  exit;
}
require '../../functions.php';

$id = $_GET["idprod"];

if ( hapusproduk($id)){
    echo "
      <script>
        alert('Data Berhasil Dihapus!');
        document.location.href = 'produk.php';
      </script>
    ";
  }else {
    echo "
      <script>
        alert('Data Gagal Dihapus!');
        document.location.href = 'produk.php';
      </script>
    ";
  }
?>