<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "lat_dbase";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

$tableQuery = "CREATE TABLE IF NOT EXISTS mahasiswa (
    id_mahasiswa VARCHAR(6) PRIMARY KEY,
    nama VARCHAR(30) NOT NULL,
    jurusan VARCHAR(50) NOT NULL,
    alamat VARCHAR(100) NOT NULL,
    telepon VARCHAR(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!mysqli_query($conn, $tableQuery)) {
    die("Gagal membuat tabel mahasiswa: " . mysqli_error($conn));
}
?>
