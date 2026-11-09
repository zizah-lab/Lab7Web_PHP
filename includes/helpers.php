<?php
/**
 * helpers.php — fungsi bantu yang dipakai bersama oleh banyak halaman.
 */

/** Mengamankan teks sebelum ditampilkan ke HTML (mencegah XSS). */
function e(?string $teks): string
{
    return htmlspecialchars($teks ?? '', ENT_QUOTES, 'UTF-8');
}

/** Mengubah angka menjadi format Rupiah, mis. 150000 -> Rp150.000 */
function formatRupiah(float|int $angka, int $desimal = 0): string
{
    return 'Rp' . number_format($angka, $desimal, ',', '.');
}

/** Mengambil nilai string dari array input dengan aman (tanpa warning/TypeError). */
function ambil(array $sumber, string $kunci): string
{
    $nilai = $sumber[$kunci] ?? '';
    return is_string($nilai) ? trim($nilai) : '';
}
