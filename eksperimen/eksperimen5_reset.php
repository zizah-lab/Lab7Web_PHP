<?php
require __DIR__ . '/../includes/helpers.php';

$nama = '';
$dikirim = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = ambil($_POST, 'nama');
    $dikirim = true;
}

$judul = 'Tombol Reset vs Proses Ulang Server';
require __DIR__ . '/../includes/header.php';
?>
    <form method="POST" action="">
        <label for="nama">Nama</label>
        <input id="nama" name="nama" type="text" value="<?= e($nama) ?>">
        <button type="submit">Kirim</button>
        <button type="reset">Reset (browser)</button>
        <a class="btn sekunder" href="eksperimen5_reset.php">Bersihkan (server)</a>
    </form>

    <?php if ($dikirim): ?>
        <div class="pesan-ok">Server menerima: <strong><?= e($nama) ?></strong>
            (diproses pada <?= date('H:i:s') ?>)</div>
    <?php endif; ?>

    <h3>Cara menguji</h3>
    <ol>
        <li>Ketik nama, ubah-ubah isinya tanpa menekan Kirim, lalu tekan <em>Reset (browser)</em>
            &rarr; isi kembali ke nilai awal halaman. <strong>Tidak ada request ke server.</strong></li>
        <li>Tekan <em>Kirim</em> sehingga nama tampil di kotak hijau. Ubah isi kolom, tekan
            <em>Reset (browser)</em> &rarr; kolom kembali ke nama yang <u>sudah dikirim</u> (bukan kosong), karena
            atribut <code>value</code> yang dirender server sudah berisi nama itu. Kotak hijau tetap ada.</li>
        <li>Tekan <em>Bersihkan (server)</em> &rarr; browser meminta halaman baru ke server (GET),
            PHP berjalan ulang, variabel kosong, dan hasil hilang.</li>
    </ol>
<?php require __DIR__ . '/../includes/footer.php'; ?>
