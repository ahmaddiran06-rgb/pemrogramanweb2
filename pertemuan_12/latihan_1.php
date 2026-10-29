<?php
$con = mysqli_connect("localhost", "root", "", "lat_dbase");

if (!$con) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$query = "UPDATE tbl_mhs
          SET Age = ?
          WHERE FirstName = ? AND LastName = ?";

$stmt = mysqli_prepare($con, $query);

if (!$stmt) {
    die("Query gagal disiapkan: " . mysqli_error($con));
}

$age = 36;
$firstName = "Karina";
$lastName = "Suwandi";


mysqli_stmt_bind_param($stmt, "iss", $age, $firstName, $lastName);

if (!mysqli_stmt_execute($stmt)) {
    die("Query gagal dijalankan: " . mysqli_stmt_error($stmt));
}

echo "Berhasil. Baris yang berubah: " . mysqli_stmt_affected_rows($stmt);

mysqli_stmt_close($stmt);
mysqli_close($con);
?>