<?php
/**
 * proses.php — LOGIKA pemrosesan form mahasiswa (dipisah dari tampilan).
 * Tidak mencetak HTML sama sekali; hanya mengembalikan array hasil.
 */
require_once __DIR__ . '/../includes/helpers.php';

const SEMESTER_MIN = 1;
const SEMESTER_MAKS = 14;
const NIM_PANJANG = 10; // dipakai hanya jika $validasiNim = true (Eksperimen 4)

/**
 * @param array $post        biasanya $_POST
 * @param bool  $validasiNim true = NIM wajib angka dengan panjang NIM_PANJANG
 * @return array{data: ?array, error: string[], old: array}
 */
function prosesFormMahasiswa(array $post, bool $validasiNim = false): array
{
    $nama          = ambil($post, "nama");
    $nim           = ambil($post, "nim");
    $prodi         = ambil($post, "prodi");
    $semesterInput = ambil($post, "semester");
    $email         = ambil($post, "email");

    $error = [];

    if ($nama === "")  $error[] = "Nama wajib diisi.";
    if ($nim === "")   $error[] = "NIM wajib diisi.";
    elseif ($validasiNim && !preg_match('/^\d{' . NIM_PANJANG . '}$/', $nim)) {
        $error[] = "NIM harus berupa " . NIM_PANJANG . " digit angka.";
    }
    if ($prodi === "") $error[] = "Program studi wajib diisi.";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Format email tidak valid.";
    }

    if (!ctype_digit($semesterInput) ||
        (int)$semesterInput < SEMESTER_MIN || (int)$semesterInput > SEMESTER_MAKS) {
        $error[] = "Semester harus berupa angka " . SEMESTER_MIN . "–" . SEMESTER_MAKS . ".";
    }

    $data = null;
    if (!$error) {
        $data = compact("nama", "nim", "prodi", "email");
        $data["semester"] = (int)$semesterInput;
    }

    return [
        'data'  => $data,
        'error' => $error,
        'old'   => ['nama' => $nama, 'nim' => $nim, 'prodi' => $prodi,
                    'semester' => $semesterInput, 'email' => $email],
    ];
}
