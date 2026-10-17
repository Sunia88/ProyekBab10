<!-- app/Views/layout.php - kerangka halaman yang dipakai semua view -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= e($judul ?? 'Kampus MVC') ?></title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: auto; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 6px; }
        .flash { background: #dcfce7; padding: 8px; }
        .galat { color: #b91c1c; font-size: .9em; }
    </style>
</head>
<body>
    <header><a href="/mahasiswa">Kampus MVC</a></header>
    <h1><?= e($judul ?? '') ?></h1>
    <?php if (!empty($flash)): ?>
        <p class="flash"><?= e($flash) ?></p>
    <?php endif; ?>

    <?= $konten ?>   <!-- hasil render view (sudah di-encode di view) -->

    <footer>
        <small>&copy; <?= date('Y') ?> Pemrograman Internet</small>
    </footer>
</body>
</html>
