<?php
require __DIR__ . '/../includes/helpers.php';   // formatRupiah() didefinisikan di sini

$contoh = [0, 500, 15000, 150000, 1250000, 1999999.5, 25000000];

$input = isset($_GET['angka']) ? ambil($_GET, 'angka') : null;
$pesan = null;
if ($input !== null) {
    $pesan = is_numeric($input) ? formatRupiah((float)$input, 2) : null;
}

$judul = 'Function Format Rupiah';
require __DIR__ . '/../includes/header.php';
?>
    <p>Function: <code>formatRupiah($angka, $desimal = 0)</code> memakai
        <code>number_format($angka, $desimal, ',', '.')</code> sehingga ribuan dipisah titik dan desimal dipisah koma.</p>

    <table>
        <tr><th>Angka asli</th><th>Hasil formatRupiah()</th></tr>
        <?php foreach ($contoh as $a): ?>
            <tr><td><?= $a ?></td><td><?= formatRupiah($a) ?></td></tr>
        <?php endforeach; ?>
    </table>

    <h3>Coba sendiri</h3>
    <form method="GET" action="">
        <label for="angka">Masukkan angka</label>
        <input id="angka" name="angka" value="<?= e($input ?? '') ?>">
        <button type="submit">Format</button>
    </form>
    <?php if ($input !== null): ?>
        <?php if ($pesan !== null): ?>
            <div class="pesan-ok">Hasil: <strong><?= e($pesan) ?></strong></div>
        <?php else: ?>
            <div class="pesan-error">Input harus berupa angka.</div>
        <?php endif; ?>
    <?php endif; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
