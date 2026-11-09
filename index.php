<?php
require __DIR__ . '/includes/helpers.php';
$judul = 'Praktikum 7 — Pemrograman Server-Side dengan PHP';
$css = 'assets/style.css';
require __DIR__ . '/includes/header.php';

$menu = [
    'Latihan' => [
        'latihan/latihan1_hello.php'     => 'Latihan 1 — Menjalankan PHP',
        'latihan/latihan2_nilai.php'     => 'Latihan 2 — Variabel, operator, percabangan',
        'latihan/latihan3_array.php'     => 'Latihan 3 — Perulangan dan array',
        'latihan/latihan4_function.php'  => 'Latihan 4 — Membuat function',
        'latihan/latihan5_get.php'       => 'Latihan 5 — Form dengan GET',
        'latihan/latihan6_post.php'      => 'Latihan 6 — Form dengan POST',
        'latihan/latihan7_transaksi.php' => 'Latihan 7 — Pengolahan data sederhana',
    ],
    'Mini Project' => [
        'miniproject/index.php' => 'Aplikasi Formulir Data Mahasiswa',
    ],
    'Eksperimen Mandiri' => [
        'eksperimen/eksperimen1_rata_rata.php' => 'Eksperimen 1 — Nilai rata-rata',
        'eksperimen/eksperimen2_cari_get.php'  => 'Eksperimen 2 — Cari nama (GET + array)',
        'eksperimen/eksperimen3_rupiah.php'    => 'Eksperimen 3 — Function format Rupiah',
        'eksperimen/eksperimen4_nim.php'       => 'Eksperimen 4 — Validasi NIM',
        'eksperimen/eksperimen5_reset.php'     => 'Eksperimen 5 — Tombol reset vs proses ulang server',
    ],
];
foreach ($menu as $kelompok => $item): ?>
    <h3><?= e($kelompok) ?></h3>
    <ul class="menu">
        <?php foreach ($item as $url => $nama): ?>
            <li><a href="<?= e($url) ?>"><?= e($nama) ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php endforeach; ?>
</main>
</body>
</html>
