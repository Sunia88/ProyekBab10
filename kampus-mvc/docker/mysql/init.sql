-- docker/mysql/init.sql
-- Dijalankan OTOMATIS oleh MySQL saat container db pertama kali dibuat.
-- Skema db_kampus (tabel prodi & mahasiswa) seperti pada Bab 8-9.
-- Untuk mengulang dari awal: docker compose down -v  lalu  docker compose up -d

SET NAMES utf8mb4;
USE db_kampus;

CREATE TABLE IF NOT EXISTS prodi (
    id        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode      VARCHAR(10)  NOT NULL UNIQUE,
    nama      VARCHAR(100) NOT NULL,
    fakultas  VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS mahasiswa (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nim        CHAR(10)     NOT NULL UNIQUE,
    nama       VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL UNIQUE,
    prodi_id   INT UNSIGNED NOT NULL,
    angkatan   SMALLINT UNSIGNED NOT NULL,
    ipk        DECIMAL(3,2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_mhs_prodi FOREIGN KEY (prodi_id) REFERENCES prodi(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO prodi (kode, nama, fakultas) VALUES
  ('TI', 'Teknik Informatika', 'Fakultas Teknik'),
  ('SI', 'Sistem Informasi',   'Fakultas Teknik'),
  ('MI', 'Manajemen Informatika', 'Fakultas Vokasi');

-- 12 data contoh (lebih dari 10 agar paginasi terlihat)
INSERT INTO mahasiswa (nim, nama, email, prodi_id, angkatan, ipk) VALUES
  ('2023010001', 'Andi Pratama',     'andi@kampus.ac.id',    1, 2023, 3.65),
  ('2023010002', 'Budi Santoso',     'budi@kampus.ac.id',    1, 2023, 3.20),
  ('2023010003', 'Citra Lestari',    'citra@kampus.ac.id',   2, 2023, 2.90),
  ('2023010004', 'Dewi Anggraini',   'dewi@kampus.ac.id',    2, 2023, 3.55),
  ('2024010005', 'Eko Saputra',      'eko@kampus.ac.id',     1, 2024, 2.50),
  ('2024010006', 'Fitri Handayani',  'fitri@kampus.ac.id',   3, 2024, 3.10),
  ('2024010007', 'Gilang Ramadhan',  'gilang@kampus.ac.id',  3, 2024, 3.80),
  ('2024010008', 'Hana Wulandari',   'hana@kampus.ac.id',    2, 2024, 3.00),
  ('2025010009', 'Indra Kurniawan',  'indra@kampus.ac.id',   1, 2025, 2.80),
  ('2025010010', 'Joko Susilo',      'joko@kampus.ac.id',    1, 2025, 3.40),
  ('2025010011', 'Kartika Sari',     'kartika@kampus.ac.id', 2, 2025, 3.70),
  ('2025010012', 'Lukman Hakim',     'lukman@kampus.ac.id',  3, 2025, 2.95);
