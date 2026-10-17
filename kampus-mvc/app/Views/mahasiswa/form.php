<!-- app/Views/mahasiswa/form.php - dipakai untuk tambah & ubah -->
<form method="POST" action="<?= e($aksi) ?>">
    <?= csrf_field() ?>
    <?php $label = ['nim' => 'NIM', 'nama' => 'Nama',
                    'email' => 'Email', 'angkatan' => 'Angkatan']; ?>
    <?php foreach ($label as $k => $teks): ?>
        <p><label><?= $teks ?><br>
            <input name="<?= $k ?>" value="<?= old($k) ?>"></label>
            <br><span class="galat"><?= e($galat[$k] ?? '') ?></span></p>
    <?php endforeach; ?>

    <p><label>Prodi<br><select name="prodi_id">
        <?php foreach ($prodi as $id => $kode): ?>
            <option value="<?= $id ?>"
                <?= old('prodi_id') === (string)$id ? 'selected' : '' ?>>
                <?= e($kode) ?></option>
        <?php endforeach; ?>
    </select></label></p>

    <button>Simpan</button> <a href="/mahasiswa">Batal</a>
</form>
