<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Submit']) && $_POST['Submit'] === 'Submit') {
    $id_mahasiswa = trim($_POST['id_mahasiswa'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $jurusan = trim($_POST['jurusan'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $telepon = trim($_POST['telepon'] ?? '');

    if ($id_mahasiswa === '' || $nama === '' || $jurusan === '' || $alamat === '' || $telepon === '') {
        echo "<script>alert('Data Harap Dilengkapi!'); window.location.href='form-input-data.php';</script>";
        exit;
    }

    include "koneksi.php";

    $checkQuery = "SELECT id_mahasiswa FROM mahasiswa WHERE id_mahasiswa = ?";
    $checkStmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($checkStmt, 's', $id_mahasiswa);
    mysqli_stmt_execute($checkStmt);
    mysqli_stmt_store_result($checkStmt);

    if (mysqli_stmt_num_rows($checkStmt) > 0) {
        mysqli_stmt_close($checkStmt);
        mysqli_close($conn);
        echo "<script>alert('NIM sudah dipakai!, silahkan ganti NIM yang lain'); window.location.href='form-input-data.php';</script>";
        exit;
    }

    mysqli_stmt_close($checkStmt);

    $insertQuery = "INSERT INTO mahasiswa (id_mahasiswa, nama, jurusan, alamat, telepon) VALUES (?, ?, ?, ?, ?)";
    $insertStmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($insertStmt, 'sssss', $id_mahasiswa, $nama, $jurusan, $alamat, $telepon);

    if (mysqli_stmt_execute($insertStmt)) {
        mysqli_stmt_close($insertStmt);
        mysqli_close($conn);
        echo "<script>alert('Input Data Mahasiswa Berhasil'); window.location.href='form-input-data.php';</script>";
        exit;
    }

    mysqli_stmt_close($insertStmt);
    mysqli_close($conn);
    echo "<script>alert('Input Data Mahasiswa Gagal!, Silahkan diulangi!'); window.location.href='form-input-data.php';</script>";
    exit;
}

header('Location: form-input-data.php');
exit;
