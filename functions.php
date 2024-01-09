<?php
//koneksi ke database ============================================================================
$conn = mysqli_connect("localhost","root","","tokoduabersaudara");
//umum ===========================================================================================
function query ($query){
    global $conn;
    $result = mysqli_query($conn,$query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)){
        $rows [] = $row;
    }
    return $rows;
}
// function to encrypt the text given
function encrypt($text){
	// change key to lowercase for simplicity
	$pswd = strtolower('TODUBER');
	// intialize variables
	$code = "";
	$ki = 0;
	$kl = strlen($pswd);
	$length = strlen($text);
	// iterate over each line in text
	for ($i = 0; $i < $length; $i++){
        // if the letter is alpha, encrypt it
		if (ctype_alpha($text[$i])){
            // uppercase
			if (ctype_upper($text[$i])){
				$text[$i] = chr(((ord($pswd[$ki]) - ord("a") + ord($text[$i]) - ord("A")) % 26) + ord("A"));
			}
			// lowercase
			else{
				$text[$i] = chr(((ord($pswd[$ki]) - ord("a") + ord($text[$i]) - ord("a")) % 26) + ord("a"));
			}
			// update the index of key
			$ki++;
			if ($ki >= $kl){
				$ki = 0;
			}
		}
	}
	// return the encrypted code
	return $text;
}

// function to decrypt the text given
function decrypt($text){
	// change key to lowercase for simplicity
	$pswd = strtolower('TODUBER');
	// intialize variables
	$code = "";
	$ki = 0;
	$kl = strlen($pswd);
	$length = strlen($text);
	// iterate over each line in text
	for ($i = 0; $i < $length; $i++){
		// if the letter is alpha, decrypt it
		if (ctype_alpha($text[$i])){
			// uppercase
			if (ctype_upper($text[$i])){
				$x = (ord($text[$i]) - ord("A")) - (ord($pswd[$ki]) - ord("a"));
				if ($x < 0){
					$x += 26;
				}
				$x = $x + ord("A");
				$text[$i] = chr($x);
			}
			// lowercase
			else{
				$x = (ord($text[$i]) - ord("a")) - (ord($pswd[$ki]) - ord("a"));
				if ($x < 0){
					$x += 26;
				}
				$x = $x + ord("a");	
				$text[$i] = chr($x);
			}
			// update the index of key
			$ki++;
			if ($ki >= $kl){
				$ki = 0;
			}
		}
	}
	// return the decrypted text
	return $text;
}
function numbtotext($number){
    $number = intval($number);
    if ($number <= 0) {
       return '';
    }
    $alphabet = '';
    while($number != 0) {
       $p = ($number - 1) % 26;
       $number = intval(($number - $p) / 26);
       $alphabet = chr(65 + $p) . $alphabet;
   }
   return $alphabet;
}
function texttonumb($string){
    $string = strtoupper($string);
     $length = strlen($string);
     $number = 0;
     $level = 1;
     while ($length >= $level ) {
         $char = $string[$length - $level];
         $c = ord($char) - 64;        
         $number += $c * (26 ** ($level-1));
        $level++;
     }
    return $number;
}
//Produk =========================================================================================
function tambahproduk ($data) {
    global $conn;
    $kategori = htmlspecialchars($data["kategori"]);
    $nama = htmlspecialchars(encrypt($data["nama"]));
    $jumlah = htmlspecialchars($data["jumlah"]);
    $harga = htmlspecialchars($data["harga"]);
    $deskripsi = htmlspecialchars(encrypt($data["deskripsi"]));
    
    $query = "INSERT INTO produk VALUES ('','$kategori','$nama',$jumlah,$harga,'$deskripsi')";
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
}
function hapusproduk ($id){
    global $conn;
    $query = "DELETE FROM produk WHERE id = $id";
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
}
function ubahproduk($data){
    global $conn;
    $id = htmlspecialchars($data["id"]);
    $kategori = htmlspecialchars($data["kategori"]);
    $nama = htmlspecialchars(encrypt($data["nama"]));
    $jumlah = htmlspecialchars($data["jumlah"]);
    $harga = htmlspecialchars($data["harga"]);
    $deskripsi = htmlspecialchars(encrypt($data["deskripsi"]));

    $query = "UPDATE produk SET
                kategori_ID = '$kategori',
                nama = '$nama',
                jumlah = $jumlah,
                harga = $harga,
                deskripsi ='$deskripsi' WHERE id = $id";
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
}
function cariproduk($keyword) {
    $query = "SELECT p.id id, k.nama kategori, p.nama nama, jumlah, harga, deskripsi FROM produk p
                    JOIN kategori k ON (p.kategori_ID=k.id) 
                    WHERE p.id LIKE '%$keyword%' OR p.nama LIKE '%".encrypt($keyword)."%'";
    return query($query);
}
function tambahjumlah($data){
    global $conn;
    $id = htmlspecialchars($data["id"]);
    $jumlah = htmlspecialchars($data["jumlah"]);

    $query = "UPDATE produk SET
                jumlah = jumlah + $jumlah WHERE id = $id";
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
}

//kategori =========================================================================================
function tambahkategori ($data) {
    global $conn;
    $nama = htmlspecialchars(encrypt($data["nama"]));
    
    $query = "INSERT INTO kategori VALUES ('','$nama')";
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
}
function hapuskategori ($id){
    global $conn;
    $query = "DELETE FROM kategori WHERE id = $id";
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
}
function ubahkategori($data){
    global $conn;
    $id = htmlspecialchars($data["id"]);
    $nama = htmlspecialchars(encrypt($data["nama"]));

    $query = "UPDATE kategori SET
                nama = '$nama' WHERE id = $id";
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
}
function carikategori($keyword) {
    $query = "SELECT * FROM kategori WHERE id LIKE '%$keyword%' OR nama LIKE '%".encrypt($keyword)."%'";
    return query($query);
}

//customer =========================================================================================
function tambahcustomer ($data) {
    global $conn;
    $nama = htmlspecialchars(encrypt($data["nama"]));
    $notelp = htmlspecialchars(encrypt(numbtotext($data["notelp"])));
    $alamat = htmlspecialchars(encrypt($data["alamat"]));
    
    $query = "INSERT INTO customer VALUES ('','$nama','$notelp','$alamat')";
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
}
function hapuscustomer ($id){
    global $conn;
    $query = "DELETE FROM customer WHERE id = $id";
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
}
function ubahcustomer($data){
    global $conn;
    $id = htmlspecialchars($data["id"]);
    $nama = htmlspecialchars(encrypt($data["nama"]));
    $notelp = htmlspecialchars(encrypt(numbtotext($data["notelp"])));
    $alamat = htmlspecialchars(encrypt($data["alamat"]));

    $query = "UPDATE customer SET
                nama = '$nama',
                notelp = '$notelp',
                alamat = '$alamat' WHERE id = $id";
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
}
function caricustomer($keyword) {
    $query = "SELECT * FROM customer WHERE id LIKE '%$keyword%' OR nama LIKE '%".encrypt($keyword)."%'";
    return query($query);
}
?>