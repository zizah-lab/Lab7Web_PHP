<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Latihan 3</title>
</head>
<body>
  
    <?php
    // 4 nama dari modul + 3 nama tambahan
    $mahasiswa = ["Alya", "Bima", "Citra", "Doni", "Eka", "Fajar", "Gita"];

    echo "<h3>Daftar Mahasiswa</h3><ol>";
    foreach ($mahasiswa as $nama) {
        echo "<li>" . htmlspecialchars($nama) . "</li>";
    }
    echo "</ol>";
    echo "Jumlah mahasiswa: " . count($mahasiswa) . " orang.";
    ?>
</body>
</html>
