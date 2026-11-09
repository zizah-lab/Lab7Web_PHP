<?php
require __DIR__ . '/../includes/helpers.php';

// "Database" sederhana berupa array
$dataMahasiswa = [
    ['nama' => 'Alya Putri',    'prodi' => 'Teknik Informatika'],
    ['nama' => 'Bima Saputra',  'prodi' => 'Sistem Informasi'],
    ['nama' => 'Citra Lestari', 'prodi' => 'Teknik Informatika'],
    ['nama' => 'Doni Pratama',  'prodi' => 'Teknik Elektro'],
    ['nama' => 'Eka Putri',     'prodi' => 'Sistem Informasi'],
    ['nama' => 'Fajar Alamsyah','prodi' => 'Teknik Informatika'],
];

/** Mengembalikan elemen yang namanya mengandung $kata (tidak peka huruf besar/kecil). */
function cariMahasiswa(array $data, string $kata): array
{
    return array_filter($data, fn($m) => stripos($m['nama'], $kata) !== false);
}

$kata = isset($_GET['q']) ? ambil($_GET, 'q') : null;
$hasil = ($kata !== null && $kata !== '') ? cariMahasiswa($dataMahasiswa, $kata) : [];

$judul = 'Cari Nama (GET + Array)';
require __DIR__ . '/../includes/header.php';
?>
    <form method="GET" action="">
        <label for="q">Cari nama mahasiswa</label>
        <input id="q" name="q" type="text" value="<?= e($kata ?? '') ?>" placeholder="contoh: putri">
        <button type="submit">Cari</button>
    </form>

    <?php if ($kata === null): ?>
        <p class="catatan">Masukkan kata kunci lalu tekan Cari. Data tersedia: <?= count($dataMahasiswa) ?> mahasiswa.</p>
    <?php elseif ($kata === ''): ?>
        <div class="pesan-error">Kata kunci tidak boleh kosong.</div>
    <?php elseif (!$hasil): ?>
        <div class="pesan-error">Tidak ada mahasiswa dengan nama mengandung "<?= e($kata) ?>".</div>
    <?php else: ?>
        <div class="pesan-ok">Ditemukan <?= count($hasil) ?> hasil untuk "<?= e($kata) ?>".</div>
        <table>
            <tr><th>No</th><th>Nama</th><th>Program Studi</th></tr>
            <?php $no = 1; foreach ($hasil as $m): ?>
                <tr><td><?= $no++ ?></td><td><?= e($m['nama']) ?></td><td><?= e($m['prodi']) ?></td></tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
