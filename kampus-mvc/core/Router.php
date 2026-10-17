<?php
// core/Router.php - mencocokkan METODE + PATH ke Controller@aksi
namespace Core;

class Router
{
    private array $rute = [];

    public function get(string $pola, array $aksi): void
    {
        $this->tambah('GET', $pola, $aksi);
    }

    public function post(string $pola, array $aksi): void
    {
        $this->tambah('POST', $pola, $aksi);
    }

    private function tambah(string $metode, string $pola, array $aksi): void
    {
        // '/mahasiswa/{id}/ubah' -> '#^/mahasiswa/(?P<id>[0-9]+)/ubah$#'
        $regex = preg_replace('#\{(\w+)\}#', '(?P<$1>[0-9]+)', $pola);
        $this->rute[] = [$metode, '#^' . $regex . '$#', $aksi];
    }

    public function dispatch(string $metode, string $path): void
    {
        $path = rtrim($path, '/') ?: '/';
        foreach ($this->rute as [$m, $regex, [$kelas, $fungsi]]) {
            if ($m === $metode && preg_match($regex, $path, $cocok)) {
                $param = array_filter($cocok, 'is_string',
                                      ARRAY_FILTER_USE_KEY);
                (new $kelas())->$fungsi(...array_map('intval', $param));
                return;
            }
        }
        http_response_code(404);
        View::render('errors/404', ['path' => $path]);
    }
}
