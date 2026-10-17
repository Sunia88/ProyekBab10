<?php
// core/autoload.php - memuat kelas otomatis berdasarkan namespace
// App\Models\Mahasiswa -> app/Models/Mahasiswa.php
// Core\Router          -> core/Router.php
spl_autoload_register(function (string $kelas): void {
    $peta = [
        'App\\'  => BASE_PATH . '/app/',
        'Core\\' => BASE_PATH . '/core/',
    ];
    foreach ($peta as $awalan => $folder) {
        if (str_starts_with($kelas, $awalan)) {
            $relatif = substr($kelas, strlen($awalan));
            $berkas = $folder . str_replace('\\', '/', $relatif) . '.php';
            if (is_file($berkas)) require $berkas;
            return;
        }
    }
});
require __DIR__ . '/helpers.php';
