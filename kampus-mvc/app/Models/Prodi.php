<?php
// app/Models/Prodi.php
namespace App\Models;

use Core\Model;

class Prodi extends Model
{
    protected static string $tabel = 'prodi';
    protected static array $fillable = ['kode', 'nama', 'fakultas'];

    // [id => kode] untuk mengisi elemen <select>
    public static function pilihan(): array
    {
        return static::db()
            ->query('SELECT id, kode FROM prodi ORDER BY kode')
            ->fetchAll(\PDO::FETCH_KEY_PAIR);
    }
}
