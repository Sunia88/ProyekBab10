<?php
// core/Validator.php - validasi deklaratif berbasis aturan
namespace Core;

class Validator
{
    public array $galat = [];
    public array $data = [];

    // Contoh aturan: ['nim' => 'required|digits:10', ...]
    public function __construct(array $input, array $aturan)
    {
        foreach ($aturan as $kolom => $daftar) {
            $nilai = trim((string)($input[$kolom] ?? ''));
            $this->data[$kolom] = $nilai;
            foreach (explode('|', $daftar) as $a) {
                [$nama, $arg] = array_pad(explode(':', $a, 2), 2, null);
                $pesan = $this->cek($nama, $arg, $nilai);
                if ($pesan) { $this->galat[$kolom] = $pesan; break; }
            }
        }
    }

    private function cek(string $nama, ?string $arg, string $v): ?string
    {
        return match ($nama) {
            'required' => $v === '' ? 'Wajib diisi' : null,
            'digits'   => preg_match('/^\d{' . (int)$arg . '}$/', $v)
                          ? null : "Harus $arg digit angka",
            'email'    => filter_var($v, FILTER_VALIDATE_EMAIL)
                          ? null : 'Format email tidak valid',
            'min'      => mb_strlen($v) >= (int)$arg
                          ? null : "Minimal $arg karakter",
            'max'      => mb_strlen($v) <= (int)$arg
                          ? null : "Maksimal $arg karakter",
            'integer'  => filter_var($v, FILTER_VALIDATE_INT) !== false
                          ? null : 'Harus bilangan bulat',
            'between'  => (function () use ($arg, $v) {
                              [$a, $b] = explode(',', $arg);
                              return ($v >= $a && $v <= $b)
                                  ? null : "Harus antara $a dan $b";
                          })(),
            default    => null,
        };
    }

    public function gagal(): bool
    {
        return $this->galat !== [];
    }
}
