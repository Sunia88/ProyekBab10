<?php
// core/Model.php - kelas induk untuk semua Model (Active Record mini)
namespace Core;

abstract class Model
{
    protected static string $tabel;      // diisi oleh kelas turunan
    protected static array $fillable = []; // kolom yang boleh diisi

    protected static function db(): \PDO
    {
        return Database::pdo();
    }

    public static function find(int $id): ?array
    {
        $s = static::db()->prepare(
            'SELECT * FROM ' . static::$tabel . ' WHERE id = ?');
        $s->execute([$id]);
        return $s->fetch() ?: null;
    }

    public static function create(array $data): int
    {
        $data = static::saring($data);
        $kolom = implode(', ', array_keys($data));
        $tanda = implode(', ', array_fill(0, count($data), '?'));
        static::db()->prepare('INSERT INTO ' . static::$tabel
            . " ($kolom) VALUES ($tanda)")->execute(array_values($data));
        return (int)static::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $data = static::saring($data);
        $set = implode(', ', array_map(fn($k) => "$k = ?",
                                       array_keys($data)));
        $s = static::db()->prepare('UPDATE ' . static::$tabel
            . " SET $set WHERE id = ?");
        $s->execute([...array_values($data), $id]);
        return $s->rowCount() > 0;
    }

    public static function delete(int $id): bool
    {
        $s = static::db()->prepare(
            'DELETE FROM ' . static::$tabel . ' WHERE id = ?');
        $s->execute([$id]);
        return $s->rowCount() > 0;
    }

    // Anti mass assignment: buang kolom yang tidak terdaftar
    protected static function saring(array $data): array
    {
        return array_intersect_key($data, array_flip(static::$fillable));
    }
}
