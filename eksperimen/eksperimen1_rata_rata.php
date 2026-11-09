<?php
require __DIR__ . '/../includes/helpers.php';

/** Rata-rata aritmetika dari sekumpulan nilai. */
function hitungRataRata(array $nilai): float
{
    return array_sum($nilai) / count($nilai);
}

$error = [];
$hasil = null;
$old = ['tugas' => '', 'uts' => '', 'uas' => ''];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $label = ['tugas' => 'Nilai tugas', 'uts' => 'Nilai UTS', 'uas' => 'Nilai UAS'];
    $nilai = [];
    foreach ($label as $kunci => $nama) {
        $input = ambil($_POST, $kunci);
        $old[$kunci] = $input;
        if (!is_numeric($input) || (float)$input < 0 || (float)$input > 100) {
            $error[] = "$nama harus berupa angka 0–100.";
        } else {
            $nilai[$kunci] = (float)$input;
        }
    }
    if (!$error) {
        $hasil = ['nilai' => $nilai, 'rata' => hitungRataRata($nilai)];
    }
}

$judul = 'Nilai Rata-rata';
require __DIR__ . '/../includes/header.php';
?>
    <?php if ($error): ?>
        <div class="pesan-error"><ul><?php foreach ($error as $p): ?><li><?= e($p) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>

    <form method="POST">
        <label for="tugas">Nilai Tugas</label><input id="tugas" name="tugas" value="<?= e($old['tugas']) ?>">
        <label for="uts">Nilai UTS</label><input id="uts" name="uts" value="<?= e($old['uts']) ?>">
        <label for="uas">Nilai UAS</label><input id="uas" name="uas" value="<?= e($old['uas']) ?>">
        <button type="submit">Hitung Rata-rata</button>
    </form>

    <?php if ($hasil): ?>
        <h3>Hasil</h3>
        <table>
            <tr><th>Tugas</th><th>UTS</th><th>UAS</th><th>Rata-rata</th></tr>
            <tr>
                <td><?= $hasil['nilai']['tugas'] ?></td>
                <td><?= $hasil['nilai']['uts'] ?></td>
                <td><?= $hasil['nilai']['uas'] ?></td>
                <td><strong><?= number_format($hasil['rata'], 2) ?></strong></td>
            </tr>
        </table>
    <?php endif; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
