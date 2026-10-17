<?php
// routes.php - tabel rute: metode + path -> [Controller, aksi]
use App\Controllers\MahasiswaController as M;

$router->get('/',                      [M::class, 'beranda']);
$router->get('/mahasiswa',             [M::class, 'index']);
$router->get('/mahasiswa/tambah',      [M::class, 'create']);
$router->post('/mahasiswa',            [M::class, 'store']);
$router->get('/mahasiswa/{id}',        [M::class, 'show']);
$router->get('/mahasiswa/{id}/ubah',   [M::class, 'edit']);
$router->post('/mahasiswa/{id}',       [M::class, 'update']);
$router->post('/mahasiswa/{id}/hapus', [M::class, 'destroy']);
