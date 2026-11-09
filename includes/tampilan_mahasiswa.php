<?php
/**
 * Tampilan (view) form mahasiswa + hasil. Variabel yang dibutuhkan:
 *   $hasil     : array dari prosesFormMahasiswa() atau null jika belum submit
 *   $infoNim   : (opsional) teks petunjuk tambahan untuk kolom NIM
 */
$old   = $hasil['old']   ?? ['nama'=>'','nim'=>'','prodi'=>'','semester'=>'','email'=>''];
$error = $hasil['error'] ?? [];
$data  = $hasil['data']  ?? null;
?>
    <?php if ($error): ?>
        <div class="pesan-error">
            <strong>Terdapat <?= count($error) ?> kesalahan:</strong>
            <ul>
                <?php foreach ($error as $pesan): ?><li><?= e($pesan) ?></li><?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="nama">Nama</label>
        <input id="nama" name="nama" type="text" value="<?= e($old['nama']) ?>">

        <label for="nim">NIM <?php if (!empty($infoNim)): ?><span class="catatan">(<?= e($infoNim) ?>)</span><?php endif; ?></label>
        <input id="nim" name="nim" type="text" value="<?= e($old['nim']) ?>">

        <label for="prodi">Program Studi</label>
        <input id="prodi" name="prodi" type="text" value="<?= e($old['prodi']) ?>">

        <label for="semester">Semester (1–14)</label>
        <input id="semester" name="semester" type="text" value="<?= e($old['semester']) ?>">

        <label for="email">Email</label>
        <input id="email" name="email" type="text" value="<?= e($old['email']) ?>">

        <button type="submit">Kirim Data</button>
    </form>
    <p class="catatan">Catatan: kolom sengaja tidak memakai atribut <code>required</code>/<code>type="email"</code>
        agar validasi <strong>server-side</strong> PHP dapat diuji langsung.</p>

    <?php if ($data): ?>
        <div class="pesan-ok">Data valid dan berhasil diterima.</div>
        <h3>Ringkasan Data Mahasiswa</h3>
        <table>
            <tr><th>Nama</th><td><?= e($data['nama']) ?></td></tr>
            <tr><th>NIM</th><td><?= e($data['nim']) ?></td></tr>
            <tr><th>Program Studi</th><td><?= e($data['prodi']) ?></td></tr>
            <tr><th>Semester</th><td><?= (int)$data['semester'] ?></td></tr>
            <tr><th>Email</th><td><?= e($data['email']) ?></td></tr>
        </table>
    <?php endif; ?>
