# Praktikum 7: Pemrograman Server-Side dengan PHP

| Komponen | Keterangan |
|---|---|
| Nama | Azizah Rachmatania |
| NIM | 312510159 |
| Kelas | I251B |
| Mata Kuliah | Pemrograman Web |
| Dosen Pengampu | Agung Nugroho, S.Kom., M.Kom., S.Kom., M. Kom |


---

## 1. Latar Belakang

Halaman web yang hanya memakai HTML, CSS, dan JavaScript bersifat **client-side**: seluruh kodenya dikirim ke browser dan dijalankan di komputer pengguna. Pendekatan ini cukup untuk tampilan, tetapi tidak cukup untuk kebutuhan aplikasi nyata seperti menyimpan data pendaftaran, memeriksa login, atau menghitung transaksi. Proses-proses tersebut harus dikendalikan oleh **server**, karena kode di sisi pengguna dapat dilihat dan diubah oleh siapa saja.

**PHP (PHP: Hypertext Preprocessor)** adalah bahasa pemrograman *server-side* yang disisipkan di dalam dokumen HTML. Saat browser meminta file `.php`, server menjalankan kode PHP tersebut dan hanya mengirimkan **hasil keluarannya** (biasanya HTML) ke browser. Browser tidak pernah menerima kode PHP mentah. PHP banyak dipakai pada situs besar seperti WordPress dan Wikipedia.

Salah satu kemampuan paling mendasar dari bahasa server-side adalah **menerima data dari form HTML**, memvalidasinya, lalu menampilkan atau memprosesnya. Praktikum ini membahas dasar-dasar tersebut: sintaks PHP, variabel, percabangan, perulangan, function, pemrosesan form dengan GET dan POST, serta validasi dan sanitasi input agar aplikasi aman dan benar.

## 2. Tujuan dan Fungsi Praktikum

**Tujuan** (sesuai modul):

1. Memahami perbedaan pemrosesan client-side dan server-side.
2. Mengenali sintaks PHP dan menjalankan file PHP melalui server lokal.
3. Menggunakan variabel, tipe data, operator, percabangan, perulangan, dan function.
4. Menerima dan memproses data form HTML dengan metode GET dan POST.
5. Melakukan validasi dan sanitasi input dasar sebelum data ditampilkan atau diproses.
6. Membangun aplikasi sederhana yang menerima, memproses, dan menampilkan data pengguna.

**Fungsi proyek ini:** kumpulan program latihan yang masing-masing mendemonstrasikan satu konsep PHP, ditutup dengan *mini project* (formulir data mahasiswa) yang menggabungkan semuanya.

## 3. Perangkat yang Digunakan

| Perangkat | Fungsi |
|---|---|
| Laptop/PC | Menjalankan seluruh perangkat lunak |
| XAMPP atau Laragon | Menyediakan PHP + web server Apache/Nginx lokal |
| Visual Studio Code | Editor kode |
| Web browser (Chrome/Edge/Firefox) | Membuka halaman dan memeriksa hasil |
| Git + akun GitHub/GitLab | Menyimpan dan mengumpulkan pekerjaan |

> Kode diuji dengan **PHP 8.3**. Kode memakai fitur PHP 8 (misalnya tipe gabungan `float|int` dan arrow function `fn`), sehingga gunakan **PHP 8.0 atau lebih baru**.

## 4. Cara Menjalankan Server Lokal

### Opsi A — XAMPP
1. Instal XAMPP, buka **XAMPP Control Panel**, lalu klik **Start** pada modul **Apache**.
2. Salin folder `Lab7Web_PHP` ke `C:\xampp\htdocs\`.
3. Buka browser: **http://localhost/Lab7Web_PHP/**

### Opsi B — Laragon
1. Jalankan Laragon, klik **Start All**.
2. Salin folder `Lab7Web_PHP` ke `C:\laragon\www\`.
3. Buka **http://localhost/Lab7Web_PHP/** (atau `http://lab7web_php.test`).

### Opsi C — Server bawaan PHP (tanpa XAMPP)
```bash
cd Lab7Web_PHP
php -S localhost:8000
# lalu buka http://localhost:8000/
```

> ⚠️ **Jangan membuka file PHP dengan klik ganda** (`file:///...`). Browser tidak dapat menjalankan PHP, sehingga yang tampil adalah kode mentah atau halaman kosong. File PHP harus diakses lewat `http://localhost/...` agar diproses server.

## 5. Struktur File

```
Lab7Web_PHP/
├── index.php                      ← menu utama menuju semua latihan
├── README.md                      ← dokumen ini
├── assets/
│   └── style.css                  ← tampilan bersama
├── includes/
│   ├── helpers.php                ← e(), formatRupiah(), ambil()
│   ├── header.php                 ← bagian atas halaman (layout)
│   ├── footer.php                 ← bagian bawah halaman (layout)
│   └── tampilan_mahasiswa.php     ← view form + hasil (dipakai mini project & Eksperimen 4)
├── latihan/
│   ├── latihan1_hello.php         ← Menjalankan PHP (semua file latihan berdiri sendiri,
│   │                                 HTML polos tanpa CSS/include, seperti di modul)
│   ├── latihan2_nilai.php         ← Variabel, operator, percabangan
│   ├── latihan3_array.php         ← Perulangan dan array
│   ├── latihan4_function.php      ← Function
│   ├── latihan5_get.php           ← Form GET
│   ├── latihan6_post.php          ← Form POST
│   └── latihan7_transaksi.php     ← Pengolahan data sederhana
├── miniproject/
│   ├── proses.php                 ← LOGIKA validasi (tanpa HTML)
│   └── index.php                  ← halaman: memanggil logika + view
├── eksperimen/
│   ├── eksperimen1_rata_rata.php
│   ├── eksperimen2_cari_get.php
│   ├── eksperimen3_rupiah.php
│   ├── eksperimen4_nim.php
│   └── eksperimen5_reset.php
└── dokumentasi/                   ← 14 screenshot hasil praktikum
    ├── 1. latihan1 .png … 7. latihan7 .png
    ├── 8. miniproject .png        ← mini project, data valid
    ├── 9. miniproject eror.png    ← mini project, input tidak valid (satu-satunya versi error)
    └── 10. eksperimen1 .png … 14. eksperimen5 .png
```

## 6. Fungsi Pendukung (helpers) dan Layout

> Catatan: **Latihan 1–7 sengaja dibuat sederhana dan berdiri sendiri** (tanpa CSS dan tanpa file include). Fungsi bantu dan layout di bawah ini dipakai oleh **Mini Project dan Eksperimen**.

File `includes/helpers.php` berisi tiga fungsi kecil yang dipakai berulang agar kode tidak berulang-ulang (prinsip **DRY**):

```php
function e(?string $teks): string
{
    return htmlspecialchars($teks ?? '', ENT_QUOTES, 'UTF-8');
}
```
**`e()`** adalah singkatan dari *escape*. Fungsi ini membungkus `htmlspecialchars()` sehingga karakter berbahaya (`< > & " '`) diubah menjadi entitas HTML (`&lt; &gt; &amp; &quot; &#039;`). Dengan begitu, jika pengguna mengetik `<script>`, browser hanya **menampilkannya sebagai teks**, bukan menjalankannya. `ENT_QUOTES` memastikan tanda kutip tunggal dan ganda ikut diamankan, dan `'UTF-8'` menentukan encoding. Tipe `?string` dan `?? ''` membuat fungsi aman bila nilainya `null`.

```php
function formatRupiah(float|int $angka, int $desimal = 0): string
{
    return 'Rp' . number_format($angka, $desimal, ',', '.');
}
```
**`formatRupiah()`** memformat angka menjadi Rupiah. `number_format($angka, $desimal, ',', '.')` berarti: pemisah desimal = koma, pemisah ribuan = titik, sesuai kebiasaan penulisan Indonesia. Contoh: `150000` → `Rp150.000`. Ini juga menjadi jawaban **Eksperimen 3**.

```php
function ambil(array $sumber, string $kunci): string
{
    $nilai = $sumber[$kunci] ?? '';
    return is_string($nilai) ? trim($nilai) : '';
}
```
**`ambil()`** mengambil satu nilai dari `$_POST`/`$_GET` secara aman: (1) `?? ''` mencegah *undefined index* bila kunci tidak ada, (2) `is_string()` mencegah *TypeError* bila ada yang mengirim array (misalnya `nama[]=x`) karena `trim()` di PHP 8 tidak menerima array, (3) `trim()` membuang spasi di awal dan akhir.

**Layout** (`header.php` dan `footer.php`) menaruh bagian `<head>`, judul `<h1>`, dan penutup HTML di satu tempat. Setiap halaman cukup mengisi `$judul` lalu `require` kedua file tersebut.

---

## 7. Latihan 1–7: Penjelasan Kode, Langkah, dan Hasil

### Latihan 1 — Menjalankan PHP
**File:** `latihan/latihan1_hello.php`  
**Alamat:** `http://localhost/Lab7Web_PHP/latihan/latihan1_hello.php`
**Tujuan:** membuktikan bahwa PHP dijalankan di server dan browser hanya menerima hasilnya.

**Kode inti:**
```php
<?php
echo "<p>PHP berhasil dijalankan.</p>";
echo "<p>Waktu server: " . date("d-m-Y H:i:s") . "</p>";
?>
```
**Penjelasan:**
- `<?php ... ?>` adalah tag pembuka dan penutup PHP. Hanya teks di dalamnya yang diproses sebagai PHP; sisanya dikirim apa adanya sebagai HTML.
- `echo` mencetak teks ke keluaran halaman.
- Tanda titik `.` adalah operator **penggabung string** (*concatenation*).
- `date("d-m-Y H:i:s")` mengambil waktu **server** dengan format hari-bulan-tahun jam:menit:detik.

**Langkah:**
1. Jalankan Apache (XAMPP/Laragon).
2. Letakkan folder di `htdocs`/`www`.
3. Buka `http://localhost/Lab7Web_PHP/latihan/latihan1_hello.php`.
4. Tekan **Ctrl+U** (*view source*) dan amati: yang terlihat hanya HTML hasil, tanpa tag `<?php`.
5. Refresh halaman beberapa kali; waktu berubah karena PHP dijalankan ulang di tiap permintaan.

**Hasil:**

![Latihan 1](dokumentasi/1.%20latihan1%20.png)

---

### Latihan 2 — Variabel, Operator, dan Percabangan
**File:** `latihan/latihan2_nilai.php`  
**Alamat:** `http://localhost/Lab7Web_PHP/latihan/latihan2_nilai.php`
**Tujuan:** memakai variabel (`$`), tipe data, operator aritmetika, dan `if / elseif / else`.

**Kode inti:**
```php
$nilaiAkhir = ($tugas * 0.30) + ($uts * 0.30) + ($uas * 0.40);

if ($nilaiAkhir >= 85) {
    $predikat = "A";
} elseif ($nilaiAkhir >= 75) {
    $predikat = "B";
} elseif ($nilaiAkhir >= 60) {
    $predikat = "C";
} else {
    $predikat = "D";
}
```
**Penjelasan:**
- Variabel diawali `$` (`$nama`, `$tugas`). PHP menentukan tipenya otomatis: `"Siti"` = string, `85` = integer.
- Nilai akhir = **30% tugas + 30% UTS + 40% UAS**. Untuk Siti: `85×0,30 + 78×0,30 + 90×0,40 = 25,5 + 23,4 + 36 = 84,9`.
- Percabangan dibaca dari atas ke bawah dan berhenti pada kondisi pertama yang benar. Karena `84,9` tidak `>= 85`, tetapi `>= 75`, predikatnya **B** (bukan A; selisihnya hanya 0,1).
- `number_format($nilaiAkhir, 2)` menampilkan 2 angka di belakang koma.
- Di bawahnya ada tabel sederhana (`<table border="1">`) yang menguji lima kombinasi nilai memakai `foreach`.

**Pengujian kombinasi nilai (sesuai perintah "ubah nilai dan uji"):**

| Kasus | Tugas | UTS | UAS | Nilai Akhir | Predikat |
|---|---|---|---|---|---|
| Data modul (Siti) | 85 | 78 | 90 | 84,90 | B |
| Nilai tinggi | 95 | 90 | 98 | 94,70 | A |
| Nilai sedang | 70 | 72 | 76 | 73,00 | C |
| Nilai rendah | 50 | 45 | 55 | 50,50 | D |
| Tepat batas B | 75 | 75 | 75 | 75,00 | B |

**Hasil:**

![Latihan 2](dokumentasi/2.%20latihan2%20.png)

---

### Latihan 3 — Perulangan dan Array
**File:** `latihan/latihan3_array.php`  
**Alamat:** `http://localhost/Lab7Web_PHP/latihan/latihan3_array.php`

**Kode inti:**
```php
$mahasiswa = ["Alya", "Bima", "Citra", "Doni", "Eka", "Fajar", "Gita"];

foreach ($mahasiswa as $nama) {
    echo "<li>" . htmlspecialchars($nama) . "</li>";
}
```
**Penjelasan:**
- **Array** adalah satu variabel yang menyimpan banyak nilai. `["Alya", ...]` membuat array berindeks mulai dari 0.
- `foreach ($mahasiswa as $nama)` mengulang untuk setiap elemen; di tiap putaran, elemen berikutnya masuk ke `$nama`.
- Modul meminta menambah **minimal tiga nama**; saya menambahkan Eka, Fajar, dan Gita (total 7).
- `htmlspecialchars($nama)` mengamankan keluaran dari karakter berbahaya.
- `count($mahasiswa)` menghitung jumlah elemen.

**Hasil:**

![Latihan 3](dokumentasi/3.%20latihan3%20.png)

---

### Latihan 4 — Membuat Function
**File:** `latihan/latihan4_function.php`  
**Alamat:** `http://localhost/Lab7Web_PHP/latihan/latihan4_function.php`

**Kode inti:**
```php
function hitungDiskon($harga, $persen) {
    $potongan = $harga * ($persen / 100);
    return $harga - $potongan;
}

function hitungLuasPersegiPanjang($panjang, $lebar) {
    return $panjang * $lebar;
}

function tentukanKelulusan($nilai) {
    if ($nilai >= 60) {
        return "LULUS";
    }
    return "TIDAK LULUS";
}

$hargaAkhir = hitungDiskon(150000, 10);
echo "Harga setelah diskon: Rp" . number_format($hargaAkhir, 0, ",", ".");
```
**Penjelasan:**
- `function nama(parameter) { ... return ...; }` mendefinisikan blok kode yang bisa dipanggil berkali-kali.
- `hitungDiskon(150000, 10)`: potongan = 150000 × 0,10 = 15.000, harga akhir = **Rp135.000**.
- Dua function tambahan sesuai perintah modul: `hitungLuasPersegiPanjang` (8 × 4 = 32) dan `tentukanKelulusan`.
- `tentukanKelulusan()` memakai `if`: nilai 60 ke atas = LULUS, di bawahnya TIDAK LULUS.
- `number_format($hargaAkhir, 0, ",", ".")` memformat angka ke gaya Indonesia (titik ribuan, koma desimal).

**Hasil:**

![Latihan 4](dokumentasi/4.%20latihan4%20.png)

---

### Latihan 5 — Memproses Form dengan GET
**File:** `latihan/latihan5_get.php`  
**Alamat:** `http://localhost/Lab7Web_PHP/latihan/latihan5_get.php` (setelah menekan Cari, URL menjadi `...latihan5_get.php?kata=...`)

**Kode inti:**
```php
<form method="GET" action="">
    <input id="kata" name="kata" type="text">
    <button type="submit">Cari</button>
</form>
<?php
if (isset($_GET["kata"])) {
    $kata = trim($_GET["kata"]);
    echo "Kata kunci: " . htmlspecialchars($kata, ENT_QUOTES, "UTF-8");
}
?>
```
**Penjelasan:**
- `method="GET"` membuat browser menaruh data pada URL: `...latihan5_get.php?kata=pemrograman+web`.
- `action=""` berarti form dikirim ke halaman yang sama.
- `$_GET` adalah *superglobal array* berisi parameter URL; kuncinya sama dengan atribut `name` input.
- `isset()` memeriksa apakah kunci ada, supaya tidak muncul *warning* saat halaman pertama kali dibuka.
- `htmlspecialchars()` wajib sebelum menampilkan kembali input pengguna.
- GET cocok untuk pencarian/filter (aman diulang, bisa di-*bookmark*), **tidak untuk kata sandi** karena data terlihat di URL, riwayat browser, dan log server.

**Langkah:** ketik kata kunci (pada screenshot: `ziza`) lalu klik **Cari**, amati URL berubah menjadi `?kata=ziza`.

**Hasil:** di bawah form tampil tulisan `Kata kunci: ziza`, yaitu nilai yang dikirim lewat GET dan dibaca dengan `$_GET["kata"]`.

![Latihan 5](dokumentasi/5.%20latihan5%20.png)



---

### Latihan 6 — Memproses Form dengan POST
**File:** `latihan/latihan6_post.php`  
**Alamat:** `http://localhost/Lab7Web_PHP/latihan/latihan6_post.php`

**Kode inti:**
```php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama  = trim($_POST["nama"] ?? "");
    $prodi = trim($_POST["prodi"] ?? "");

    if ($nama === "" || $prodi === "") {
        echo "Semua kolom wajib diisi.";
    } else {
        echo "Nama: " . htmlspecialchars($nama, ENT_QUOTES, "UTF-8");
        echo "Program Studi: " . htmlspecialchars($prodi, ENT_QUOTES, "UTF-8");
    }
}
```
**Penjelasan:**
- `$_SERVER["REQUEST_METHOD"] === "POST"` memastikan blok ini hanya jalan saat form dikirim, bukan saat halaman pertama kali dibuka (GET).
- `$_POST["nama"] ?? ""` memakai **null coalescing**: bila kunci tidak ada, hasilnya `""`.
- `trim()` membuang spasi awal/akhir, jadi input yang hanya berisi spasi dianggap kosong.
- `===` membandingkan nilai **dan** tipe secara ketat.
- Atribut `required` di HTML hanya membantu pengguna; pemeriksaan `=== ""` di PHP tetap dibutuhkan karena `required` bisa dilewati (mis. lewat alat pengembang browser atau `curl`).
- Data POST ada di *body* permintaan, tidak tampil di URL. Namun POST **bukan enkripsi**; keamanan transport tetap membutuhkan HTTPS.

**Hasil:** form diisi nama `Azizah Rachmatania` dan program studi `Teknik Informatika`, lalu setelah **Kirim Data** muncul judul *Data diterima* beserta kedua data tersebut. Bila salah satu kolom kosong (atau hanya spasi), yang tampil adalah pesan "Semua kolom wajib diisi."; bila berisi tag HTML, tag itu tampil sebagai teks karena `htmlspecialchars()`.

![Latihan 6](dokumentasi/6.%20latihan6%20.png)

---

### Latihan 7 — Pengolahan Data Sederhana
**File:** `latihan/latihan7_transaksi.php`  
**Alamat:** `http://localhost/Lab7Web_PHP/latihan/latihan7_transaksi.php`

**Kode inti:**
```php
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
```
**Penjelasan:**
- Semua input dari form adalah **string**, sehingga perlu dicek dan dikonversi sebelum dihitung.
- `is_numeric()` menerima angka dan desimal (`"2500.50"`), menolak teks (`"abc"`).
- `ctype_digit()` hanya `true` bila string berisi digit 0–9 saja; ini menolak `"-2"`, `"2.5"`, dan `"abc"` untuk jumlah.
- `(float)` / `(int)` adalah *type casting*.
- Urutan kondisi memakai `||` (atau): jika **salah satu** pemeriksaan gagal, tampilkan error.
- Subtotal = harga × jumlah, ditampilkan dengan `number_format($subtotal, 2, ",", ".")`.
- Hasil ditampilkan dengan `isset($error)` / `isset($subtotal)` supaya tidak muncul *undefined variable* saat halaman pertama kali dibuka.

**Hasil pada screenshot:** barang `pensil`, harga `2000`, jumlah `1` menghasilkan ringkasan transaksi dengan subtotal **Rp2.000,00**.

**Pengujian tambahan sesuai perintah modul** (hasil dari pengujian kode, tanpa screenshot):

| Skenario | Input (barang / harga / jumlah) | Hasil |
|---|---|---|
| Harga desimal (valid) | Pulpen / 2500.50 / 3 | Subtotal **Rp7.501,50** |
| Bilangan bulat (valid) | Kopi / 12500 / 4 | Subtotal **Rp50.000,00** |
| Jumlah nol | Buku / 10000 / 0 | Ditolak |
| Jumlah negatif | Buku / 10000 / -2 | Ditolak |
| Harga bukan angka | Buku / abc / 2 | Ditolak |
| Harga negatif | Buku / -500 / 2 | Ditolak |

![Latihan 7](dokumentasi/7.%20latihan7%20.png)



> Catatan: pengiriman data tidak sesuai (seperti `abc` di kolom angka) tidak bisa dilakukan lewat form biasa karena `type="number"` menolaknya di browser. Karena itu validasi PHP diuji dengan mengirim POST langsung (mis. lewat `curl` atau menonaktifkan validasi HTML di DevTools). Inilah alasan validasi server wajib ada.

---

## 8. Mini Project: Aplikasi Formulir Data Mahasiswa

**File:** `miniproject/proses.php` (logika), `miniproject/index.php` (halaman), `includes/tampilan_mahasiswa.php` (tampilan)  
**Alamat:** `http://localhost/Lab7Web_PHP/miniproject/index.php`

**Fungsi:** menerima data mahasiswa (nama, NIM, program studi, semester, email) lewat POST, memvalidasinya di server, lalu menampilkan ringkasan bila valid atau seluruh pesan kesalahan bila tidak.

### Pemisahan logika dan tampilan
Sesuai saran modul, pemrosesan dipisah dari tampilan:

| Berkas | Peran |
|---|---|
| `proses.php` | Hanya logika: membaca input, validasi, mengembalikan array hasil. **Tidak ada `echo`/HTML.** |
| `tampilan_mahasiswa.php` | Hanya tampilan: form, daftar error, tabel ringkasan. |
| `index.php` | Perekat: memanggil logika, lalu memuat layout dan tampilan. |

### Alur program
```
Browser ──POST──▶ index.php ──▶ prosesFormMahasiswa($_POST)
                                   │  ambil() + trim() tiap kolom
                                   │  cek wajib isi, email, semester
                                   ▼
                      ['data'=>..., 'error'=>[...], 'old'=>[...]]
                                   ▼
                    tampilan_mahasiswa.php ──▶ HTML ──▶ Browser
```

### Penjelasan kode `proses.php`
```php
const SEMESTER_MIN = 1;
const SEMESTER_MAKS = 14;
```
Batas semester dijadikan **konstanta** agar mudah diubah di satu tempat.

```php
$nama = ambil($post, "nama");  // dst. untuk nim, prodi, semester, email
$error = [];
if ($nama === "")  $error[] = "Nama wajib diisi.";
```
Tiap kolom diambil dengan aman, lalu dicek. Setiap kesalahan **ditambahkan** ke array `$error` (`$error[] = ...`), bukan langsung berhenti, sehingga **semua** pesan bisa ditampilkan sekaligus.

```php
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error[] = "Format email tidak valid.";
}
```
`filter_var()` dengan `FILTER_VALIDATE_EMAIL` memeriksa format email (`nama@domain.tld`) memakai aturan standar PHP, lebih andal daripada membuat pola sendiri.

```php
if (!ctype_digit($semesterInput) ||
    (int)$semesterInput < SEMESTER_MIN || (int)$semesterInput > SEMESTER_MAKS) {
    $error[] = "Semester harus berupa angka 1–14.";
}
```
Semester harus **bilangan bulat** (`ctype_digit` menolak `2.5`, `-1`, `abc`, kosong) **dan** berada di rentang 1–14.

```php
if (!$error) {
    $data = compact("nama", "nim", "prodi", "email");
    $data["semester"] = (int)$semesterInput;
}
```
Bila array `$error` kosong (`!$error` bernilai `true`), data dianggap valid. `compact()` membuat array asosiatif dari nama variabel. Semester disimpan sebagai integer.

```php
return ['data' => $data, 'error' => $error, 'old' => [...]];
```
Fungsi mengembalikan tiga hal: `data` (hasil valid atau `null`), `error` (daftar pesan), dan `old` (nilai yang diketik pengguna agar form tidak kosong kembali saat ada kesalahan).

### Penjelasan tampilan
- Pesan error ditampilkan dengan `foreach` di dalam kotak merah, lengkap dengan jumlah kesalahan.
- Setiap nilai yang dicetak memakai `e()` (= `htmlspecialchars`).
- Kolom form **sengaja tidak memakai** `required` atau `type="email"` agar validasi server mudah diuji. Pada aplikasi nyata, atribut tersebut boleh ditambahkan **sebagai pelengkap**, bukan pengganti.

### Hasil

**Data valid.** Nama `ziza`, NIM `312510159`, program studi `Teknik Informatika`, semester `3`, email `zizaaa469@gmail.com`. Muncul kotak hijau "Data valid dan berhasil diterima." dan tabel *Ringkasan Data Mahasiswa*.

![Mini project valid](dokumentasi/8.%20miniproject%20.png)

**Data tidak valid.** Semua kolom terisi kecuali **NIM yang dikosongkan**. Server menolak data dan menampilkan kotak merah "Terdapat 1 kesalahan: NIM wajib diisi." Kolom lain tetap terisi (nama, program studi, semester, email) karena nilainya dikembalikan dari array `old`, sehingga pengguna tidak perlu mengetik ulang dari awal. Tabel ringkasan tidak ditampilkan.

![Mini project error](dokumentasi/9.%20miniproject%20eror.png)


---

## 9. Eksperimen Mandiri

### Eksperimen 1 — Nilai rata-rata dari tiga komponen
**File:** `eksperimen/eksperimen1_rata_rata.php`  
**Alamat:** `http://localhost/Lab7Web_PHP/eksperimen/eksperimen1_rata_rata.php`
```php
function hitungRataRata(array $nilai): float
{
    return array_sum($nilai) / count($nilai);
}
```
- `array_sum()` menjumlahkan semua elemen array; dibagi `count()` (jumlah elemen) = rata-rata aritmetika.
- Tiap komponen divalidasi dengan `is_numeric()` dan rentang 0–100. Contoh pada screenshot: tugas 90, UTS 85, UAS 95 → (90+85+95)/3 = **90,00**. (Contoh lain: 85, 78, 90 → 84,33.)
- Perbedaan dengan Latihan 2: Latihan 2 memakai **rata-rata berbobot** (30/30/40), eksperimen ini memakai **rata-rata biasa** (bobot sama).

![Eksperimen 1](dokumentasi/10.%20eksperimen1%20.png)

### Eksperimen 2 — Contoh GET: mencari nama dari array
**File:** `eksperimen/eksperimen2_cari_get.php`  
**Alamat:** `http://localhost/Lab7Web_PHP/eksperimen/eksperimen2_cari_get.php` (contoh hasil pencarian: `...?q=citra`)
```php
function cariMahasiswa(array $data, string $kata): array
{
    return array_filter($data, fn($m) => stripos($m['nama'], $kata) !== false);
}
```
- Data berupa array berisi array (nama + prodi), semacam tabel kecil.
- `array_filter()` menyaring elemen; `fn($m) => ...` adalah *arrow function* yang mengembalikan `true` untuk elemen yang dipertahankan.
- `stripos()` mencari teks **tanpa membedakan huruf besar/kecil** dan mengembalikan posisi atau `false`; maka dibandingkan dengan `!== false`.
- Alur: kata kunci kosong → pesan error; tidak ada yang cocok → pesan tidak ditemukan; ada → tabel hasil.

**Hasil:** kata kunci `citra` menemukan 1 hasil, yaitu *Citra Lestari* (Teknik Informatika). Pencarian tidak membedakan huruf besar/kecil karena memakai `stripos()`.

![Eksperimen 2](dokumentasi/11.%20eksperimen2%20.png)

### Eksperimen 3 — Function format Rupiah
**File:** `eksperimen/eksperimen3_rupiah.php` (function di `includes/helpers.php`)  
**Alamat:** `http://localhost/Lab7Web_PHP/eksperimen/eksperimen3_rupiah.php` (contoh: `...?angka=2000`)
```php
function formatRupiah(float|int $angka, int $desimal = 0): string
{
    return 'Rp' . number_format($angka, $desimal, ',', '.');
}
```
Contoh hasil pada screenshot: `0` → `Rp0`, `15000` → `Rp15.000`, `1250000` → `Rp1.250.000`, dan input `2000` pada kolom "Coba sendiri" → `Rp2.000,00` (2 desimal). Perhatikan baris `1999999.5` → `Rp2.000.000`: karena tabel memakai 0 desimal, `number_format()` **membulatkan** angka. Function ini ditaruh di `includes/helpers.php` sehingga bisa dipakai ulang oleh halaman lain tanpa menyalin kode (manfaat *reusability*).

![Eksperimen 3](dokumentasi/12.%20eksperimen3%20.png)

### Eksperimen 4 — Validasi NIM hanya angka dan panjang tertentu
**File:** `eksperimen/eksperimen4_nim.php`  
**Alamat:** `http://localhost/Lab7Web_PHP/eksperimen/eksperimen4_nim.php`
**Ketentuan yang saya tetapkan:** NIM harus **tepat 10 digit angka** (konstanta `NIM_PANJANG = 10`; ubah sesuai aturan kampus Anda).
```php
elseif ($validasiNim && !preg_match('/^\d{' . NIM_PANJANG . '}$/', $nim)) {
    $error[] = "NIM harus berupa " . NIM_PANJANG . " digit angka.";
}
```
- `preg_match()` memeriksa teks terhadap *regular expression*.
- `^` = awal teks, `$` = akhir teks, `\d` = satu digit, `{10}` = tepat 10 kali. Jadi `2024110001` lolos, sedangkan `20241A0001` (ada huruf) dan `12345` (terlalu pendek) ditolak.
- Parameter `$validasiNim` (default `false`) membuat **mini project tetap sesuai modul**, sementara eksperimen ini mengaktifkannya dengan `prosesFormMahasiswa($_POST, true)`. Logika tidak perlu disalin.

**Hasil:** NIM `3125101591` (10 digit angka) lolos sehingga muncul "Data valid dan berhasil diterima." Perhatikan perbedaannya dengan Mini Project: di sana NIM `312510159` (9 digit) tetap diterima karena hanya diwajibkan terisi. Pada Eksperimen 4, NIM 9 digit akan ditolak dengan pesan "NIM harus berupa 10 digit angka."

![Eksperimen 4](dokumentasi/13.%20eksperimen4%20.png)

### Eksperimen 5 — Tombol reset vs pemrosesan ulang di server
**File:** `eksperimen/eksperimen5_reset.php`  
**Alamat:** `http://localhost/Lab7Web_PHP/eksperimen/eksperimen5_reset.php`
```html
<button type="reset">Reset (browser)</button>
<a class="btn sekunder" href="eksperimen5_reset.php">Bersihkan (server)</a>
```
**Perbedaannya:**

| | `<button type="reset">` | Proses ulang di server (link/kirim form) |
|---|---|---|
| Dijalankan oleh | Browser | Server (PHP) |
| Ada permintaan ke server? | **Tidak** | **Ya** (GET/POST baru) |
| Yang terjadi | Kolom form dikembalikan ke nilai awal atribut `value` | PHP dijalankan lagi dari awal; variabel dan hasil dibuat ulang |
| Hasil di halaman (mis. kotak hijau, tabel) | **Tidak berubah** | Mengikuti hasil pemrosesan baru |
| Perilaku bila form berisi nilai hasil kirim | Kembali ke nilai yang **dirender server** (bukan otomatis kosong) | Kosong bila dibuka tanpa data |

Poin penting: setelah form dikirim, PHP merender ulang input dengan `value="<?= e($nama) ?>"`. Jadi tombol *reset* akan mengembalikan kolom ke nama **yang sudah dikirim**, bukan kosong. Untuk benar-benar mengosongkan semuanya, halaman harus diminta ulang ke server (tombol *Bersihkan*).

**Hasil:** setelah nama `Azizah Rachmatania` dikirim, muncul kotak hijau "Server menerima: ... (diproses pada 08:38:39)". Jam tersebut menunjukkan bahwa PHP benar-benar dijalankan di server pada saat form dikirim.

![Eksperimen 5](dokumentasi/14.%20eksperimen5%20.png)

---

## 10. Kasus Uji: Input Valid dan Tidak Valid

Kasus yang memiliki screenshot berasal dari hasil praktikum pada folder `dokumentasi/`. Kasus lain (tanpa screenshot) berasal dari pengujian kode pada server PHP 8.3 dan hasilnya sesuai harapan.

### Dua kasus input VALID

| | Valid 1 — Mini Project | Valid 2 — Eksperimen 4 |
|---|---|---|
| Nama | ziza | ziza |
| NIM | 312510159 | 3125101591 |
| Program Studi | Teknik Informatika | Teknik Informatika |
| Semester | 3 | 3 |
| Email | zizaaa469@gmail.com | zizaaa469@gmail.com |
| **Hasil** | Diterima, ringkasan tampil | Diterima, ringkasan tampil |
| **Alasan valid** | Semua kolom terisi, semester 3 berada di rentang 1–14, format email benar | Sama seperti Valid 1, ditambah NIM terdiri dari tepat 10 digit angka |

![Valid 1 - Mini Project](dokumentasi/8.%20miniproject%20.png)

![Valid 2 - Eksperimen 4](dokumentasi/13.%20eksperimen4%20.png)

### Dua kasus input TIDAK VALID

| | Tidak Valid 1 (ada screenshot) | Tidak Valid 2 (tanpa screenshot) |
|---|---|---|
| Halaman | Mini Project | Mini Project |
| Input | Nama, prodi, semester `3`, dan email terisi; **NIM dikosongkan** | Data lain benar; semester diisi **`15`** |
| **Pesan error** | Terdapat 1 kesalahan: NIM wajib diisi. | Semester harus berupa angka 1–14. |
| **Alasan ditolak** | NIM adalah kolom wajib; pemeriksaan `$nim === ""` bernilai benar | 15 melebihi batas `SEMESTER_MAKS = 14` |

![Tidak valid 1 - NIM kosong](dokumentasi/9.%20miniproject%20eror.png)

**Kasus tidak valid tambahan** (pengujian kode, tanpa screenshot):

| Halaman | Input | Hasil |
|---|---|---|
| Mini Project | Email `siti@kampus` (tanpa domain tingkat atas) | "Format email tidak valid." |
| Mini Project | Semester `2.5` atau `0` | "Semester harus berupa angka 1–14." |
| Mini Project | Semua kolom kosong | 5 pesan kesalahan sekaligus |
| Eksperimen 4 | NIM `20241A0001` (ada huruf) atau `12345` (terlalu pendek) | "NIM harus berupa 10 digit angka." |
| Eksperimen 4 | NIM `312510159` (9 digit) | Ditolak oleh aturan yang sama (`^\d{10}$`), padahal diterima di Mini Project |
| Latihan 7 | Jumlah `0` atau `-2`; harga `abc` atau `-500` | "Periksa kembali nama barang, harga, dan jumlah." |

### Uji keamanan: karakter berbahaya (pengujian kode, tanpa screenshot)

| Input | Tampilan di halaman |
|---|---|
| `<script>alert(1)</script>` | Tampil sebagai **teks**, tidak dijalankan |
| `Budi "Si" <b>Bold</b>` | Tampil apa adanya sebagai teks; tag `<b>` tidak membuat huruf tebal |
---

## 11. Jawaban Pertanyaan Evaluasi

**1. Apa perbedaan pemrosesan client-side dan server-side?**
Pemrosesan *client-side* dijalankan di browser pengguna (HTML, CSS, JavaScript). Kodenya diunduh ke komputer pengguna sehingga dapat dilihat dan diubah, dan tidak punya akses langsung ke database atau berkas server. Pemrosesan *server-side* (contoh PHP) dijalankan di server: menerima permintaan, memproses input, menerapkan aturan aplikasi, mengakses data, lalu mengirim **hasilnya saja** (biasanya HTML) ke browser. Kode server tidak pernah sampai ke pengguna, sehingga cocok untuk logika penting dan validasi yang tidak boleh dimanipulasi.

**2. Mengapa file PHP harus dijalankan melalui web server?**
Browser hanya memahami HTML, CSS, dan JavaScript; ia tidak punya interpreter PHP. File PHP harus diproses oleh web server (Apache/Nginx) yang terhubung dengan interpreter PHP, yang mengeksekusi kode di dalam `<?php ... ?>` dan menggantinya dengan hasil keluarannya. Jika file dibuka dengan klik ganda (`file:///...`), tidak ada server yang memprosesnya sehingga browser menampilkan kode mentah atau teks tanpa dieksekusi. Karena itu file diakses lewat `http://localhost/...`.

**3. Apa fungsi tanda `$` pada variabel PHP?**
Tanda `$` adalah penanda bahwa sebuah nama adalah **variabel**, yaitu tempat menyimpan nilai (misalnya `$nama = "Andi";`). Dengan awalan ini PHP dapat membedakan variabel dari nama function, konstanta, atau kata kunci. Nama variabel bersifat *case-sensitive* (`$nama` ≠ `$Nama`).

**4. Apa perbedaan metode GET dan POST?**

| | GET | POST |
|---|---|---|
| Lokasi data | Parameter di URL (`?kata=php`) | Body permintaan (tidak tampak di URL) |
| Akses di PHP | `$_GET` | `$_POST` |
| Kegunaan | Mengambil/mencari data, tidak mengubah data (pencarian, filter) | Mengirim form, membuat/mengubah data (pendaftaran, login) |
| Terlihat/tersimpan | Di URL, riwayat browser, log server; bisa di-*bookmark* | Tidak muncul di URL/bookmark |
| Batas ukuran | Terbatas panjang URL | Jauh lebih besar |
| Keamanan | Tidak untuk data sensitif | Lebih sesuai, **tetapi bukan enkripsi**; tetap butuh HTTPS |

**5. Mengapa input pengguna perlu divalidasi di sisi server?**
Karena validasi sisi client (atribut `required`, `type="number"`, JavaScript) bisa dilewati: pengguna dapat menonaktifkannya lewat DevTools, mengubah HTML, atau mengirim permintaan langsung dengan `curl`/Postman. Server adalah satu-satunya tempat yang dapat dipercaya. Validasi server memastikan data lengkap, bertipe benar, dan berada pada rentang wajar sebelum diproses atau disimpan, serta mencegah data rusak, kesalahan perhitungan, dan serangan seperti XSS atau SQL Injection. Validasi client hanya meningkatkan kenyamanan pengguna.

**6. Apa fungsi `htmlspecialchars()` ketika menampilkan data dari form?**
Fungsi ini mengubah karakter khusus HTML (`<`, `>`, `&`, `"`, `'`) menjadi entitas (`&lt;`, `&gt;`, `&amp;`, `&quot;`, `&#039;`). Akibatnya, jika pengguna memasukkan `<script>...</script>`, browser **menampilkannya sebagai teks**, bukan menjalankannya. Ini mencegah **XSS (Cross-Site Scripting)** dan rusaknya tampilan halaman. Fungsi ini dipakai saat **menampilkan** data (output), dan sebaiknya dengan `ENT_QUOTES` serta `"UTF-8"`.

**7. Apa manfaat penggunaan function dalam program PHP?**
(a) **Penggunaan ulang** (*reusability*): kode ditulis sekali dan dipanggil berkali-kali, misalnya `hitungDiskon()` bisa dipanggil untuk harga berapa pun, dan `e()`/`ambil()` dipakai di banyak halaman mini project dan eksperimen; (b) **kode lebih rapi dan mudah dibaca** karena dipecah menjadi bagian berfungsi jelas; (c) **mudah dirawat**: perbaikan cukup dilakukan di satu tempat; (d) **mudah diuji** secara terpisah; (e) **mengurangi duplikasi dan kesalahan**; (f) **abstraksi**: pemanggil hanya perlu tahu *apa* yang dilakukan function, bukan *bagaimana*.

---

## 12. Ringkasan Hasil dan Kesimpulan

| Bagian | File | Status |
|---|---|---|
| Latihan 1–7 | `latihan/` | Berjalan, seluruh skenario uji lulus |
| Mini Project | `miniproject/` + `includes/tampilan_mahasiswa.php` | Berjalan, validasi lengkap, logika dipisah dari tampilan |
| Eksperimen 1–5 | `eksperimen/` | Berjalan |
| Pertanyaan Evaluasi | README bagian 11 | Terjawab (7 soal) |
| Kasus uji | README bagian 10 | 2 valid + 2 tidak valid (1 dengan screenshot) + kasus tambahan |

**Kesimpulan:**
1. PHP dijalankan di server dan browser hanya menerima hasil keluarannya (HTML), sehingga file harus diakses lewat `localhost`.
2. Variabel, percabangan, perulangan, array, dan function membentuk fondasi logika program.
3. GET untuk permintaan yang tidak mengubah data, POST untuk pengiriman form.
4. Prinsip keamanan dasar: **validasi di server** (`trim`, `isset`/`??`, `is_numeric`, `ctype_digit`, `filter_var`, `preg_match`) dan **escape saat output** (`htmlspecialchars`). Validasi HTML hanya membantu pengguna, bukan pelindung utama.
5. Memisahkan logika dari tampilan dan memakai function bersama (`e()`, `formatRupiah()`, `ambil()`) membuat kode lebih rapi dan mudah dirawat.

