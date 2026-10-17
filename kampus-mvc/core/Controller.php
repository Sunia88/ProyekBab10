<?php
// core/Controller.php - kelas induk untuk semua Controller
namespace Core;

abstract class Controller
{
    protected function view(string $nama, array $data = []): void
    {
        $data['flash'] = $_SESSION['flash'] ?? null;   // flash message
        unset($_SESSION['flash']);
        View::render($nama, $data);
    }

    protected function redirect(string $url, ?string $flash = null): never
    {
        if ($flash) $_SESSION['flash'] = $flash;
        header('Location: ' . $url, true, 303);       // pola PRG
        exit;
    }

    protected function cekCsrf(): void
    {
        if (!hash_equals(csrf_token(), $_POST['csrf'] ?? '')) {
            http_response_code(403);
            exit('Token CSRF tidak valid.');
        }
    }

    protected function abort(int $kode = 404): never
    {
        http_response_code($kode);
        View::render('errors/404', ['path' => $_SERVER['REQUEST_URI']]);
        exit;
    }
}
