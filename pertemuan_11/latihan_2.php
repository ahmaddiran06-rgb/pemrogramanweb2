<?php
$servername = 'localhost';
$dbusername = 'root';
$dbpassword = '';
$dbname = 'lat_dbase';

$link = mysqli_connect($servername, $dbusername, $dbpassword);

if (!$link) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

$query = 'CREATE DATABASE IF NOT EXISTS `' . $dbname . '`';

if (!mysqli_query($link, $query)) {
    die('Database gagal dibuat: ' . mysqli_error($link));
}

if (!mysqli_select_db($link, $dbname)) {
    die('Database gagal dipilih: ' . mysqli_error($link));
}

if (!mysqli_set_charset($link, 'utf8mb4')) {
    die('Pengaturan charset gagal: ' . mysqli_error($link));
}

echo "Database $dbname berhasil dibuat atau sudah tersedia dan terkoneksi.";
?>