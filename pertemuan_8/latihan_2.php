<html>
<head><title>Contoh Penggunaan UDF</title></head>
<body>
    <h3>Menentukan Form Input</h3>
    <form method="POST">
        Masukkan Bilangan Pertama : <br>
        <input type="text" name="A" size="10"> <br>
        Masukkan Bilangan Kedua : <br>
        <input type="text" name="B" size="10"> <br>
        <input type="submit" value="hitung">
    </form>

    <?php
    if (isset($_POST['A']) && isset($_POST['B'])) {
        $A = $_POST['A'];
        $B = $_POST['B'];

        function jumlah($A, $B) {
            return $A + $B;
        }

        function kurang($A, $B) {
            return $A - $B;
        }

        function kali($A, $B) {
            return $A * $B;
        }

        function bagi($A, $B) {
            return $A / $B;
        }

        echo "<br>";
        echo "Bilangan Pertama : ".$A."<br>";
        echo "Bilangan Kedua : ".$B."<br><br>";

        echo "Hasil Penjumlahan 2 buah bilangan <br>";
        $jumlahbil = jumlah($A, $B);
        printf("Penjumlahan antara : %d + %d = %d", $A, $B, $jumlahbil);
        echo "<br><br>";

        echo "Hasil Pengurangan 2 buah bilangan <br>";
        $kurangbil = kurang($A, $B);
        printf("Pengurangan antara : %d - %d = %d", $A, $B, $kurangbil);
        echo "<br><br>";

        echo "Hasil Perkalian 2 buah bilangan <br>";
        $kalibil = kali($A, $B);
        printf("Perkalian antara : %d * %d = %d", $A, $B, $kalibil);
        echo "<br><br>";

        echo "Hasil Pembagian 2 buah bilangan <br>";
        $bagibil = bagi($A, $B);
        printf("Pembagian antara : %d / %d = %d", $A, $B, $bagibil);
        echo "<br><br>";
    }
    ?>
</body>
</html>

