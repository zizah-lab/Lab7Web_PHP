<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Latihan 2</title>
</head>
<body>
   
    <?php
    $nama  = "Siti";
    $tugas = 85;
    $uts   = 78;
    $uas   = 90;

    $nilaiAkhir = ($tugas * 0.30) + ($uts * 0.30) + ($uas * 0.40);

    if ($nilaiAkhir >= 85) {
        $predikat = "A";
    } elseif ($nilaiAkhir >= 75) {
        $predikat = "B";
    } elseif ($nilaiAkhir >= 60) {
        $predikat = "C";
    } else {
        $predikat = "D";
    }

    echo "Nama: " . htmlspecialchars($nama) . "<br>";
    echo "Nilai akhir: " . number_format($nilaiAkhir, 2) . "<br>";
    echo "Predikat: <strong>" . $predikat . "</strong>";
    ?>

    <h3>Uji beberapa kombinasi nilai</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr><th>Tugas</th><th>UTS</th><th>UAS</th><th>Nilai Akhir</th><th>Predikat</th></tr>
        <?php
        $kombinasi = [[85, 78, 90], [95, 90, 98], [70, 72, 76], [50, 45, 55], [75, 75, 75]];
        foreach ($kombinasi as $k) {
            $na = ($k[0] * 0.30) + ($k[1] * 0.30) + ($k[2] * 0.40);
            if ($na >= 85) { $p = "A"; }
            elseif ($na >= 75) { $p = "B"; }
            elseif ($na >= 60) { $p = "C"; }
            else { $p = "D"; }
            echo "<tr><td>$k[0]</td><td>$k[1]</td><td>$k[2]</td><td>" . number_format($na, 2) . "</td><td>$p</td></tr>";
        }
        ?>
    </table>
</body>
</html>
