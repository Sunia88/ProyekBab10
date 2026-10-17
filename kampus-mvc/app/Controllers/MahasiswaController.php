<?php
// app/Controllers/MahasiswaController.php
namespace App\Controllers;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use Core\Controller;
use Core\Validator;

class MahasiswaController extends Controller
{
    public function beranda(): void
    {
        $this->redirect('/mahasiswa');
    }

    // GET /mahasiswa
    public function index(): void
    {
        $kata = trim($_GET['cari'] ?? '');
        $hal  = max(1, (int)($_GET['hal'] ?? 1));
        $this->view('mahasiswa/index', [
            'judul'  => 'Data Mahasiswa',
            'daftar' => Mahasiswa::cari($kata, $hal, 10),
            'total'  => Mahasiswa::hitung($kata),
            'kata'   => $kata,
            'hal'    => $hal,
        ]);
    }

    // GET /mahasiswa/{id}
    public function show(int $id): void
    {
        $m = Mahasiswa::find($id) ?? $this->abort();
        $m['predikat'] = Mahasiswa::predikat((float)$m['ipk']);
        $this->view('mahasiswa/show', ['judul' => $m['nama'], 'm' => $m]);
    }

    // GET /mahasiswa/tambah
    public function create(): void
    {
        $this->form('Tambah Mahasiswa', '/mahasiswa', []);
    }

    // POST /mahasiswa
    public function store(): void
    {
        $this->cekCsrf();
        $v = new Validator($_POST, Mahasiswa::aturan());
        if ($v->gagal()) {
            $this->form('Tambah Mahasiswa', '/mahasiswa', $v->galat);
            return;
        }
        $this->simpan(fn() => Mahasiswa::create($v->data),
            'Data berhasil ditambahkan.', 'Tambah Mahasiswa', '/mahasiswa');
    }

    // GET /mahasiswa/{id}/ubah
    public function edit(int $id): void
    {
        $GLOBALS['__old'] = Mahasiswa::find($id) ?? $this->abort();
        $this->form('Ubah Mahasiswa', "/mahasiswa/$id", []);
    }

    // POST /mahasiswa/{id}
    public function update(int $id): void
    {
        $this->cekCsrf();
        Mahasiswa::find($id) ?? $this->abort();
        $v = new Validator($_POST, Mahasiswa::aturan());
        if ($v->gagal()) {
            $this->form('Ubah Mahasiswa', "/mahasiswa/$id", $v->galat);
            return;
        }
        $this->simpan(fn() => Mahasiswa::update($id, $v->data),
            'Data berhasil diperbarui.', 'Ubah Mahasiswa',
            "/mahasiswa/$id");
    }

    // POST /mahasiswa/{id}/hapus
    public function destroy(int $id): void
    {
        $this->cekCsrf();
        $ok = Mahasiswa::delete($id);
        $this->redirect('/mahasiswa',
            $ok ? 'Data berhasil dihapus.' : 'Data tidak ditemukan.');
    }

    // ---------- fungsi bantu privat ----------
    private function form(string $judul, string $aksi, array $galat): void
    {
        if ($_POST) $GLOBALS['__old'] = $_POST;   // isi ulang form
        $this->view('mahasiswa/form', [
            'judul' => $judul, 'aksi' => $aksi, 'galat' => $galat,
            'prodi' => Prodi::pilihan(),
        ]);
    }

    private function simpan(callable $aksiDb, string $pesan,
                            string $judul, string $url): void
    {
        try {
            $aksiDb();
            $this->redirect('/mahasiswa', $pesan);
        } catch (\PDOException $e) {
            if (($e->errorInfo[1] ?? 0) !== 1062) throw $e;
            $this->form($judul, $url,
                ['nim' => 'NIM/email sudah terdaftar']);
        }
    }
}
