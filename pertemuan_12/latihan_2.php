<?php
// Hapus data Prabowo dari lat_dbase
$con = mysqli_connect("localhost", "root", "", "lat_dbase");

if (!$con) {
    die("Koneksi ke lat_dbase gagal: " . mysqli_connect_error());
}

$query = "DELETE FROM tbl_mhs WHERE LastName = 'Prabowo'";

if (!mysqli_query($con, $query)) {
    die("Query DELETE gagal: " . mysqli_error($con));
}

echo "Query DELETE berhasil. Baris yang dihapus: " . mysqli_affected_rows($con);

mysqli_close($con);

// Contoh koneksi dan pemilihan database artikel_db
$connection = mysqli_connect("localhost", "root", "");

if (!$connection) {
    die("Tidak dapat terhubung dengan MySQL: " . mysqli_connect_error());
}

if (!mysqli_select_db($connection, "artikel_db")) {
    die("Tidak dapat memilih database artikel_db: " . mysqli_error($connection));
}

echo "<br>Koneksi ke artikel_db berhasil.";

mysqli_close($connection);
?>