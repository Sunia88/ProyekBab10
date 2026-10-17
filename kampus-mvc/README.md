# kampus-mvc — Proyek Mini BAB 10 dengan Docker + PhpStorm (tanpa XAMPP)

Docker menggantikan XAMPP: **PHP 8.3 + Apache** (pengganti Apache/PHP XAMPP), **MySQL 8.4**
(pengganti MySQL XAMPP), dan **phpMyAdmin** — masing-masing di container sendiri.

| Layanan     | Alamat                      | Keterangan                              |
|-------------|-----------------------------|-----------------------------------------|
| Aplikasi    | http://localhost:8000       | document root = `public/`               |
| phpMyAdmin  | http://localhost:8080       | login otomatis sebagai root             |
| MySQL       | `localhost:3307` (dari laptop) | db `db_kampus`, user `app_kampus` / `rahasia123` (root: `root`) |

## 1. Pasang Docker Desktop (sekali saja)
1. Unduh **Docker Desktop for Windows** dari docker.com, pasang dengan opsi **WSL 2** dicentang.
2. Restart laptop jika diminta, lalu buka Docker Desktop sampai statusnya **Engine running**.
3. Cek di terminal: `docker --version` dan `docker compose version`.

## 2. Buka proyek di PhpStorm
`File > Open…` → pilih folder `kampus-mvc`.

Hubungkan PhpStorm ke Docker: `Settings > Build, Execution, Deployment > Docker` → `+` →
**Docker for Windows** → pastikan muncul *Connection successful*.

## 3. Jalankan container
Pilih salah satu:
- **Dari PhpStorm:** buka `docker-compose.yml`, klik ikon ▶ hijau di samping `services:`.
  Container tampil di jendela **Services** (Alt+8).
- **Dari Terminal PhpStorm** (Alt+F12):
  ```
  docker compose up -d --build
  ```

Build pertama butuh beberapa menit (mengunduh image). Saat MySQL pertama kali dibuat,
`docker/mysql/init.sql` otomatis membuat tabel `prodi` & `mahasiswa` + 12 data contoh.

Buka **http://localhost:8000** → diarahkan ke `/mahasiswa`.

> Di buku (10.6.6) aplikasi dijalankan dengan `php -S localhost:8000 -t public public/index.php`.
> Dengan Docker, perintah itu **tidak diperlukan**: Apache di container sudah memakai `public/`
> sebagai document root dan membaca `public/.htaccess`, jadi alamatnya tetap `localhost:8000`.
> Perubahan kode di PhpStorm langsung berlaku — cukup refresh browser.

## 4. Atur PHP Interpreter di PhpStorm (agar tidak perlu PHP terpasang di Windows)
`Settings > PHP` → **CLI Interpreter** `…` → `+` → **From Docker, Vagrant, VM, WSL, Remote…**
→ pilih **Docker Compose**, Service: **web** → OK. Set **PHP language level: 8.3**.
Path mapping: folder proyek → `/var/www/html`.

## 5. (Opsional) Lihat database dari PhpStorm
Jendela **Database** → `+` → Data Source → **MySQL**:
Host `localhost`, Port `3307`, User `app_kampus`, Password `rahasia123`, Database `db_kampus`.
Unduh driver jika diminta → Test Connection.

## 6. (Opsional) Debugging dengan Xdebug
1. `Settings > PHP > Servers` → `+` → Name **kampus-docker**, Host `localhost`, Port `8000`,
   centang **Use path mappings**: folder proyek → `/var/www/html`.
2. Klik ikon **Start Listening for PHP Debug Connections** (telepon) di toolbar.
3. Pasang breakpoint, lalu buka URL dengan `?XDEBUG_TRIGGER=1`
   (mis. `http://localhost:8000/mahasiswa?XDEBUG_TRIGGER=1`) atau pakai ekstensi *Xdebug Helper*.

## 7. Pengujian sesuai Sub-bab 10.6.6
- **Rute:** `/`, `/mahasiswa`, `/mahasiswa/tambah`, `/mahasiswa/abc` (harus 404).
- **CRUD & PRG:** tambah, ubah, hapus → muncul flash message; F5 tidak mengirim ulang form.
- **Validasi:** NIM 5 digit, nama 1 huruf, angkatan 1990 → muncul tiga pesan galat.
- **Mass assignment:** tambahkan `<input name="ipk" value="4">` lewat DevTools → IPK tetap 0.
- **CSRF & XSS:** hapus input `csrf` lewat DevTools → 403; nama `<b>Uji</b>` tampil sebagai teks.
- **Logika domain:** ubah IPK jadi 3.60 lewat **phpMyAdmin (localhost:8080)** → detail menampilkan
  "Dengan Pujian".

## Perintah yang sering dipakai
| Tujuan | Perintah |
|---|---|
| Menyalakan | `docker compose up -d` |
| Mematikan | `docker compose down` |
| Reset database ke data awal | `docker compose down -v` lalu `docker compose up -d` |
| Lihat log PHP/Apache | `docker compose logs -f web` |
| Masuk ke MySQL CLI | `docker compose exec db mysql -uapp_kampus -prahasia123 db_kampus` |
| Masuk shell container PHP | `docker compose exec web bash` |

## Catatan
- `config/database.php` adalah pengganti Kode 8.7 (Bab 8). Host-nya **`db`** (nama service),
  bukan `127.0.0.1`, karena PHP dan MySQL ada di container berbeda.
- Port bentrok? Ubah angka kiri di `docker-compose.yml` (mis. `"8001:80"`).
- Folder ini ada di **OneDrive**. Jika container lambat atau file terkunci saat sinkronisasi,
  pindahkan proyek ke folder di luar OneDrive (mis. `C:\dev\kampus-mvc`).

## Struktur
```
kampus-mvc/
├── app/ (Controllers, Models, Views)   ← kode aplikasi (Kode 10.26–10.34)
├── core/                               ← mini framework (Kode 10.3–10.12)
├── config/database.php                 ← kredensial (versi Docker)
├── public/ (index.php, .htaccess)      ← satu-satunya folder publik
├── routes.php
├── Dockerfile                          ← PHP 8.3 + Apache + pdo_mysql + Xdebug
├── docker-compose.yml                  ← web + db + phpmyadmin
└── docker/ (php/kampus.ini, mysql/init.sql)
```
