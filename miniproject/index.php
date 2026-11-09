<?php
require __DIR__ . '/proses.php';           // 1) LOGIKA

$hasil = null;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $hasil = prosesFormMahasiswa($_POST);
}

$judul = 'Formulir Data Mahasiswa';   // 2) TAMPILAN
require __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/tampilan_mahasiswa.php';
require __DIR__ . '/../includes/footer.php';
