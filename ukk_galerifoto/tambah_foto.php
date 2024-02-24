<?php
include "koneksi.php";
session_start();

$allowed_extensions = array('jpg', 'jpeg', 'png', 'gif'); // Ekstensi file yang diizinkan

$judulfoto = $_POST['judulfoto'];
$deskripsifoto = $_POST['deskripsifoto'];
$albumid = $_POST['albumid'];
$tanggalunggah = date("Y-m-d");
$userid = $_SESSION['userid'];
$foto = $_FILES['lokasifile']['name'];
$tmp = $_FILES['lokasifile']['tmp_name'];
$lokasi = 'gambar/';
$namafoto = rand() . '-' . $foto;

// Mendapatkan ekstensi file yang diunggah
$file_extension = strtolower(pathinfo($foto, PATHINFO_EXTENSION));

// Memeriksa apakah ekstensi file diizinkan
if (!in_array($file_extension, $allowed_extensions)) {
    echo "<script> 
    alert('Hanya gambar dengan format JPG, JPEG, PNG, atau GIF yang diizinkan');
    location.href='foto.php';
    </script>";
    exit; // Menghentikan eksekusi script jika ekstensi tidak diizinkan
}

// Pindahkan file ke lokasi yang ditentukan
if (move_uploaded_file($tmp, $lokasi . $namafoto)) {
    $sql = mysqli_query($conn, "INSERT INTO foto 
                                VALUES ('', '$judulfoto', '$deskripsifoto', '$tanggalunggah', '$namafoto', '$albumid', '$userid')");
    
    if ($sql) {
        echo "<script> 
        alert('Tambah data berhasil');
        location.href='foto.php';
        </script>";
    } else {
        echo "<script> 
        alert('Gagal menyimpan data ke database');
        location.href='foto.php';
        </script>";
    }
} else {
    echo "<script> 
    alert('Gagal mengunggah file');
    location.href='foto.php';
    </script>";
}
?>
