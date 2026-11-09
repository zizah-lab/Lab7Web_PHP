<?php
$barang = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $barang      = trim($_POST["barang"] ?? "");
    $hargaInput  = $_POST["harga"] ?? "";
    $jumlahInput = $_POST["jumlah"] ?? "";

    if ($barang === "" || !is_numeric($hargaInput) ||
        !ctype_digit((string)$jumlahInput) ||
        (float)$hargaInput < 0 || (int)$jumlahInput < 1) {
        $error = "Periksa kembali nama barang, harga, dan jumlah.";
    } else {
        $harga    = (float)$hargaInput;
        $jumlah   = (int)$jumlahInput;
        $subtotal = $harga * $jumlah;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Latihan 7</title>
</head>
<body>
    <h1>Pengolahan Data Sederhana</h1>
    <form method="POST">
        <label>Nama barang <input name="barang" required></label><br>
        <label>Harga <input name="harga" type="number" min="0" step="0.01" required></label><br>
        <label>Jumlah <input name="jumlah" type="number" min="1" step="1" required></label><br>
        <button type="submit">Hitung</button>
    </form>

    <?php
    if (isset($error)) {
        echo "<p>" . htmlspecialchars($error) . "</p>";
    } elseif (isset($subtotal)) {
        echo "<h3>Ringkasan Transaksi</h3>";
        echo "<p>Barang: " . htmlspecialchars($barang) . "</p>";
        echo "<p>Harga: Rp" . number_format($harga, 2, ",", ".") . "</p>";
        echo "<p>Jumlah: " . $jumlah . "</p>";
        echo "<p>Subtotal: Rp" . number_format($subtotal, 2, ",", ".") . "</p>";
    }
    ?>
</body>
</html>
