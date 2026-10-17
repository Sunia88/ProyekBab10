<!-- app/Views/mahasiswa/show.php - detail satu mahasiswa -->
<dl>
    <dt>NIM</dt>      <dd><?= e($m['nim']) ?></dd>
    <dt>Email</dt>    <dd><?= e($m['email']) ?></dd>
    <dt>Angkatan</dt> <dd><?= e($m['angkatan']) ?></dd>
    <dt>IPK</dt>
    <dd><?= e($m['ipk']) ?> (<?= e($m['predikat']) ?>)</dd>
</dl>
<a href="/mahasiswa/<?= (int)$m['id'] ?>/ubah">Ubah</a> |
<a href="/mahasiswa">Kembali</a>
