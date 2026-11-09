<?php
require __DIR__ . '/../miniproject/proses.php';

$hasil = null;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $hasil = prosesFormMahasiswa($_POST, true);   // true = aktifkan validasi NIM
}

$judul   = 'Validasi NIM';
$infoNim = 'wajib ' . NIM_PANJANG . ' digit angka';
require __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/tampilan_mahasiswa.php';
require __DIR__ . '/../includes/footer.php';
