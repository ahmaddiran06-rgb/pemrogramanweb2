<?php
include "koneksi.php";

$result = mysqli_query($conn, "SELECT id_mahasiswa, nama, jurusan, alamat, telepon FROM mahasiswa ORDER BY id_mahasiswa ASC");
$rows = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    mysqli_free_result($result);
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Form Input Data Mahasiswa</title>
    <style type="text/css" media="screen">
        table { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
        input, select { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; height: 24px; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: left; }
        .data-table { margin-top: 25px; width: 760px; border-collapse: collapse; }
    </style>
</head>
<body>
    <div style="border:0; padding:10px; width:760px; height:auto;">
        <form action="action-input-data.php" method="POST" name="form-input-data">
            <table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr height="46">
                    <td width="10%">&nbsp;</td>
                    <td width="25%">&nbsp;</td>
                    <td width="65%"><font color="orange" size="2">Form Input Data Mahasiswa</font></td>
                </tr>
                <tr height="46">
                    <td>&nbsp;</td>
                    <td>ID Mahasiswa / NIM</td>
                    <td><input type="text" name="id_mahasiswa" size="35" maxlength="6" /></td>
                </tr>
                <tr height="46">
                    <td>&nbsp;</td>
                    <td>Nama</td>
                    <td><input type="text" name="nama" size="50" maxlength="30" /></td>
                </tr>
                <tr height="46">
                    <td>&nbsp;</td>
                    <td>Jurusan</td>
                    <td>
                        <select name="jurusan">
                            <option value="">- Pilih Jurusan -</option>
                            <option value="Teknik Komputer">Teknik Komputer</option>
                            <option value="Teknik Informatika">Teknik Informatika</option>
                            <option value="Teknik Mesin">Teknik Mesin</option>
                            <option value="Teknik Elektro">Teknik Elektro</option>
                            <option value="Komputer Akuntansi">Komputer Akuntansi</option>
                        </select>
                    </td>
                </tr>
                <tr height="46">
                    <td>&nbsp;</td>
                    <td>Alamat</td>
                    <td><input type="text" name="alamat" size="50" maxlength="30" /></td>
                </tr>
                <tr height="46">
                    <td>&nbsp;</td>
                    <td>No. Telp</td>
                    <td><input type="text" name="telepon" size="20" maxlength="12" /></td>
                </tr>
                <tr height="46">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>
                        <input type="submit" name="Submit" value="Submit">&nbsp;&nbsp;
                        <input type="reset" name="reset" value="Cancel">
                    </td>
                </tr>
            </table>
        </form>

        <table class="data-table" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <th>ID Mahasiswa</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th>Alamat</th>
                <th>No. Telp</th>
            </tr>
            <?php if (empty($rows)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">Belum ada data mahasiswa</td>
                </tr>
            <?php else: ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_mahasiswa'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['jurusan'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['alamat'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['telepon'], ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
