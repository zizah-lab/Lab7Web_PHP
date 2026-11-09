<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Latihan 4</title>
</head>
<body>
   
    <?php
    function hitungDiskon($harga, $persen) {
        $potongan = $harga * ($persen / 100);
        return $harga - $potongan;
    }

    // Function tambahan 1
    function hitungLuasPersegiPanjang($panjang, $lebar) {
        return $panjang * $lebar;
    }

    // Function tambahan 2
    function tentukanKelulusan($nilai) {
        if ($nilai >= 60) {
            return "LULUS";
        }
        return "TIDAK LULUS";
    }

    $hargaAkhir = hitungDiskon(150000, 10);
    echo "Harga setelah diskon: Rp" . number_format($hargaAkhir, 0, ",", ".") . "<br>";
    echo "Luas persegi panjang 8 x 4 = " . hitungLuasPersegiPanjang(8, 4) . "<br>";
    echo "Nilai 85: " . tentukanKelulusan(85) . "<br>";
    echo "Nilai 50: " . tentukanKelulusan(50) . "<br>";
    ?>
</body>
</html>
