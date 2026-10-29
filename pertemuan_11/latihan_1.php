<?php
// Hostname or IP of the database server
$servername = 'localhost';

// Database username and password
$dbusername = 'root';
$dbpassword = '';

$link = mysqli_connect($servername, $dbusername, $dbpassword);

if (!$link) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

echo 'OK... koneksi berhasil';
?>