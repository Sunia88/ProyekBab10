<?php
// core/helpers.php - fungsi global kecil yang dipakai di View

function e(mixed $nilai): string {             // output encoding
    return htmlspecialchars((string)$nilai, ENT_QUOTES, 'UTF-8');
}

function csrf_token(): string {
    return $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
}

function csrf_field(): string {
    return '<input type="hidden" name="csrf" value="' . csrf_token() . '">';
}

function old(string $kolom, mixed $bawaan = ''): string {
    // nilai isian sebelumnya (dipakai saat validasi gagal)
    return e($GLOBALS['__old'][$kolom] ?? $bawaan);
}
