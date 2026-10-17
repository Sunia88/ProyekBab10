<!-- app/Views/mahasiswa/index.php - HANYA tampilan, tanpa SQL -->
<form method="GET" action="/mahasiswa">
    <input name="cari" value="<?= e($kata) ?>" placeholder="Nama / NIM">
    <button>Cari</button>
    <a href="/mahasiswa/tambah">+ Tambah</a>
</form>

<table>
    <tr><th>NIM</th><th>Nama</th><th>Prodi</th><th>Aksi</th></tr>
    <?php foreach ($daftar as $m): $url = '/mahasiswa/' . (int)$m['id']; ?>
    <tr>
        <td><?= e($m['nim']) ?></td>
        <td><a href="<?= $url ?>"><?= e($m['nama']) ?></a></td>
        <td><?= e($m['prodi']) ?></td>
        <td>
            <a href="<?= $url ?>/ubah">Ubah</a>
            <form method="POST" action="<?= $url ?>/hapus"
                  style="display:inline"
                  onsubmit="return confirm('Hapus?')">
                <?= csrf_field() ?><button>Hapus</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php $jml = max(1, (int)ceil($total / 10)); ?>
<p>Halaman <?= $hal ?> / <?= $jml ?> (<?= $total ?> data)
<?php if ($hal < $jml): ?>
    <a href="?cari=<?= urlencode($kata) ?>&amp;hal=<?= $hal + 1 ?>">
        Berikutnya</a>
<?php endif; ?></p>
