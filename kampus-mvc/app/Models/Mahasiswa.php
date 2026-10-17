<?php
// app/Models/Mahasiswa.php - aturan data & query khusus mahasiswa
namespace App\Models;

use Core\Model;

class Mahasiswa extends Model
{
    protected static string $tabel = 'mahasiswa';
    protected static array $fillable =
        ['nim', 'nama', 'email', 'prodi_id', 'angkatan'];

    // Aturan validasi milik domain mahasiswa
    public static function aturan(): array
    {
        $tahun = date('Y');
        return [
            'nim'      => 'required|digits:10',
            'nama'     => 'required|min:3|max:100',
            'email'    => 'required|email|max:150',
            'prodi_id' => 'required|integer',
            'angkatan' => "required|integer|between:2000,$tahun",
        ];
    }

    public static function cari(string $kata, int $hal, int $batas): array
    {
        $s = static::db()->prepare(
            'SELECT m.id, m.nim, m.nama, m.angkatan, m.ipk, p.kode AS prodi
             FROM mahasiswa m JOIN prodi p ON p.id = m.prodi_id
             WHERE m.nama LIKE :a OR m.nim LIKE :b
             ORDER BY m.nim LIMIT :batas OFFSET :offset');
        $s->bindValue(':a', "%$kata%");
        $s->bindValue(':b', "%$kata%");
        $s->bindValue(':batas', $batas, \PDO::PARAM_INT);
        $s->bindValue(':offset', ($hal - 1) * $batas, \PDO::PARAM_INT);
        $s->execute();
        return $s->fetchAll();
    }

    public static function hitung(string $kata): int
    {
        $s = static::db()->prepare('SELECT COUNT(*) FROM mahasiswa
                                    WHERE nama LIKE ? OR nim LIKE ?');
        $s->execute(["%$kata%", "%$kata%"]);
        return (int)$s->fetchColumn();
    }

    // Logika domain: predikat kelulusan berdasarkan IPK
    public static function predikat(float $ipk): string
    {
        return match (true) {
            $ipk >= 3.51 => 'Dengan Pujian',
            $ipk >= 3.01 => 'Sangat Memuaskan',
            $ipk >= 2.76 => 'Memuaskan',
            default      => '-',
        };
    }
}
