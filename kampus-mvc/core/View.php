<?php
// core/View.php - merender templat di dalam layout
namespace Core;

class View
{
    public static function render(string $nama, array $data = [],
                                  string $layout = 'layout'): void
    {
        $dir = BASE_PATH . '/app/Views/';
        extract($data, EXTR_SKIP);       // ['judul' => ..] -> $judul

        ob_start();                       // tangkap keluaran view
        require $dir . $nama . '.php';
        $konten = ob_get_clean();

        require $dir . $layout . '.php';  // layout mencetak $konten
    }
}
