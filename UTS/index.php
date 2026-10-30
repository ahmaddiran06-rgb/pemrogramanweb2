<?php
$db = mysqli_connect("localhost", "root", "", "lat_dbase");

if (!$db) {
    die("Koneksi ke database gagal: " . htmlspecialchars(mysqli_connect_error(), ENT_QUOTES, 'UTF-8'));
}

if (!mysqli_set_charset($db, "utf8mb4")) {
    die("Pengaturan charset gagal: " . htmlspecialchars(mysqli_error($db), ENT_QUOTES, 'UTF-8'));
}

$createTableQuery = "CREATE TABLE IF NOT EXISTS pendaftaran_mhs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tgl_input DATE NOT NULL,
    kode VARCHAR(20) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    jk VARCHAR(20) NOT NULL,
    asal_sekolah VARCHAR(150) NOT NULL,
    pekerjaan_ortu VARCHAR(100) NOT NULL,
    tempat_lahir VARCHAR(100) NOT NULL,
    tgl_lahir DATE NOT NULL,
    mat TINYINT UNSIGNED NOT NULL,
    bing TINYINT UNSIGNED NOT NULL,
    umum TINYINT UNSIGNED NOT NULL,
    rata DECIMAL(5,2) NOT NULL,
    tempat_tes VARCHAR(50) NOT NULL,
    keterangan VARCHAR(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!mysqli_query($db, $createTableQuery)) {
    die("Tabel pendaftaran gagal disiapkan: " . htmlspecialchars(mysqli_error($db), ENT_QUOTES, 'UTF-8'));
}

$formError = "";

if (($_SERVER["REQUEST_METHOD"] ?? "") === "POST" && isset($_POST["simpan"])) {
    $tgl_input = $_POST["tgl_input"] ?? "";
    $kode = strtoupper(trim($_POST["kode"] ?? ""));
    $nama = trim($_POST["nama"] ?? "");
    $jk = $_POST["jk"] ?? "";
    $asal_sekolah = trim($_POST["asal_sekolah"] ?? "");
    $pekerjaan_ortu = trim($_POST["pekerjaan_ortu"] ?? "");
    $tempat_lahir = trim($_POST["tempat_lahir"] ?? "");
    $tgl_lahir = $_POST["tgl_lahir"] ?? "";
    $matInput = $_POST["mat"] ?? "";
    $bingInput = $_POST["bing"] ?? "";
    $umumInput = $_POST["umum"] ?? "";

    $validGenders = ["Laki-Laki", "Perempuan"];
    $validDate = static function ($value) {
        $date = DateTime::createFromFormat("!Y-m-d", $value);
        return $date && $date->format("Y-m-d") === $value;
    };

    if (
        !$validDate($tgl_input) ||
        !$validDate($tgl_lahir) ||
        $kode === "" ||
        $nama === "" ||
        !in_array($jk, $validGenders, true) ||
        $asal_sekolah === "" ||
        $pekerjaan_ortu === "" ||
        $tempat_lahir === "" ||
        !is_numeric($matInput) || $matInput < 0 || $matInput > 100 ||
        !is_numeric($bingInput) || $bingInput < 0 || $bingInput > 100 ||
        !is_numeric($umumInput) || $umumInput < 0 || $umumInput > 100
    ) {
        $formError = "Data tidak valid. Pastikan semua kolom terisi dan nilai berada di antara 0 sampai 100.";
    } else {
        $mat = (int) $matInput;
        $bing = (int) $bingInput;
        $umum = (int) $umumInput;
        $rata = ($mat + $bing + $umum) / 3;
        $keterangan = $rata >= 70 ? "Lulus" : ($rata >= 60 ? "Cadangan" : "Tidak Lulus");

        $kodeAwal = substr($kode, 0, 1);
        if ($kodeAwal === "A") {
            $tempat_tes = "Gedung A";
        } elseif ($kodeAwal === "B") {
            $tempat_tes = "Gedung B";
        } elseif ($kodeAwal === "V") {
            $tempat_tes = "Viktor";
        } else {
            $tempat_tes = "Tidak Diketahui";
        }

        $insertQuery = "INSERT INTO pendaftaran_mhs
            (tgl_input, kode, nama, jk, asal_sekolah, pekerjaan_ortu, tempat_lahir, tgl_lahir,
             mat, bing, umum, rata, tempat_tes, keterangan)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($db, $insertQuery);

        if (!$stmt) {
            $formError = "Query penyimpanan gagal disiapkan: " . mysqli_error($db);
        } else {
            mysqli_stmt_bind_param(
                $stmt,
                "ssssssssiiidss",
                $tgl_input,
                $kode,
                $nama,
                $jk,
                $asal_sekolah,
                $pekerjaan_ortu,
                $tempat_lahir,
                $tgl_lahir,
                $mat,
                $bing,
                $umum,
                $rata,
                $tempat_tes,
                $keterangan
            );

            if (!mysqli_stmt_execute($stmt)) {
                $formError = "Data gagal disimpan: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);
        }

        if ($formError === "") {
            header("Location: " . strtok($_SERVER["REQUEST_URI"], "?") . "?tersimpan=1");
            exit;
        }
    }
}

$registrations = [];
$result = mysqli_query($db, "SELECT * FROM pendaftaran_mhs ORDER BY id ASC");
if (!$result) {
    die("Data pendaftaran gagal dibaca: " . htmlspecialchars(mysqli_error($db), ENT_QUOTES, 'UTF-8'));
}
while ($row = mysqli_fetch_assoc($result)) {
    $registrations[] = $row;
}
mysqli_free_result($result);

$jumlah_pendaftar = count($registrations);
$jumlah_lulus = 0;
$jumlah_tidak_lulus = 0;
foreach ($registrations as $registration) {
    if ($registration["keterangan"] === "Lulus") {
        $jumlah_lulus++;
    } elseif ($registration["keterangan"] === "Tidak Lulus") {
        $jumlah_tidak_lulus++;
    }
}

$escape = static function ($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
};
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTS PHP - Pendaftaran Mahasiswa</title>

    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            margin: 30px;
            background: #f4f4f4;
        }

        .container{
            width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        h2{
            text-align: center;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td{
            border: 1px solid black;
        }

        th, td{
            padding: 10px;
            text-align: center;
        }

        input[type=text],
        input[type=number],
        input[type=date]{
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .btn{
            background: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .btn:hover{
            background: darkblue;
        }

        .info{
            margin-top: 20px;
            padding: 10px;
            background: #eef;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>FORM PENDAFTARAN MAHASISWA BARU</h2>

    <form method="POST">

        <label>Tanggal Input</label>
        <input type="date" name="tgl_input" required>

        <label>Kode Pendaftaran</label>
        <input type="text" name="kode" placeholder="Contoh : A2" required>

        <label>Nama Pendaftar</label>
        <input type="text" name="nama" required>

        <label>Jenis Kelamin</label><br>
        <input type="radio" name="jk" value="Laki-Laki" required> Laki-Laki
        <input type="radio" name="jk" value="Perempuan"> Perempuan
        <br><br>

        <label>Asal Sekolah</label>
        <input type="text" name="asal_sekolah" required>

        <label>Pekerjaan Orang Tua</label>
        <input type="text" name="pekerjaan_ortu" required>

        <label>Tempat Lahir</label>
        <input type="text" name="tempat_lahir" required>

        <label>Tanggal Lahir</label>
        <input type="date" name="tgl_lahir" required>

        <label>Matematika</label>
        <input type="number" name="mat" required>

        <label>Bahasa Inggris</label>
        <input type="number" name="bing" required>

        <label>Umum</label>
        <input type="number" name="umum" required>

        <button type="submit" name="simpan" class="btn">SIMPAN</button>

    </form>

    <?php if ($formError !== ""): ?>
        <div class="info"><?= $escape($formError) ?></div>
    <?php elseif (isset($_GET["tersimpan"])): ?>
        <div class="info">Data pendaftaran berhasil disimpan ke MySQL.</div>
    <?php endif; ?>

    <?php if ($jumlah_pendaftar > 0): ?>
        <table>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>JK</th>
                <th>Tgl Lahir</th>
                <th>Asal Sekolah</th>
                <th>Pekerjaan Ortu</th>
                <th>Tempat Tes</th>
                <th>MAT</th>
                <th>B. Inggris</th>
                <th>Umum</th>
                <th>Rata-rata</th>
                <th>Keterangan</th>
            </tr>
            <?php foreach ($registrations as $registration): ?>
                <tr>
                    <td><?= $escape($registration["kode"]) ?></td>
                    <td><?= $escape($registration["nama"]) ?></td>
                    <td><?= $escape($registration["jk"]) ?></td>
                    <td><?= $escape($registration["tempat_lahir"]) ?>, <?= $escape($registration["tgl_lahir"]) ?></td>
                    <td><?= $escape($registration["asal_sekolah"]) ?></td>
                    <td><?= $escape($registration["pekerjaan_ortu"]) ?></td>
                    <td><?= $escape($registration["tempat_tes"]) ?></td>
                    <td><?= $escape($registration["mat"]) ?></td>
                    <td><?= $escape($registration["bing"]) ?></td>
                    <td><?= $escape($registration["umum"]) ?></td>
                    <td><?= number_format((float) $registration["rata"], 2) ?></td>
                    <td><?= $escape($registration["keterangan"]) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <div class="info">
        <h3>Rekap Data:</h3>
        <p>Jumlah Pendaftar : <b><?= $jumlah_pendaftar ?></b></p>
        <p>Jumlah Peserta Lulus : <b><?= $jumlah_lulus ?></b></p>
        <p>Jumlah Tidak Lulus : <b><?= $jumlah_tidak_lulus ?></b></p>
    </div>

    <div class="info">
        <h3>Keterangan:</h3>
        <p><b>Kode Tempat Tes:</b></p>
        <ul>
            <li>A = Gedung A</li>
            <li>B = Gedung B</li>
            <li>V = Viktor</li>
        </ul>

        <p><b>Hasil Seleksi:</b></p>
        <ul>
            <li>Rata-rata ≥ 70 = Lulus</li>
            <li>Rata-rata 60 - 69 = Cadangan</li>
            <li>Rata-rata &lt; 60 = Tidak Lulus</li>
        </ul>
    </div>

</div>

</body>
</html>