# 🚀 Belajar Laravel - Project Rekayasa Web

Repository latihan dan tugas matakuliah **Rekayasa Web (RW)** berbasis framework **Laravel**. Project ini memuat modul data portfolio project serta data profil mahasiswa.

> 📖 **Panduan Praktikum Pertemuan 5:** Langkah-langkah pembuatan Model, Migration, dan Seeder secara detail dapat dilihat di [PANDUAN_PRAKTIKUM.md](PANDUAN_PRAKTIKUM.md).

---

## 📋 Prasyarat Sistem

Sebelum memulai, pastikan perangkat kamu sudah terpasang:
- **[Laragon](https://laragon.org/)** (dengan PHP >= 8.3 / 8.4 dan MySQL aktif)
- **[Composer](https://getcomposer.org/)**
- **[Node.js & NPM](https://nodejs.org/)** (LTS version)
- **[Git](https://git-scm.com/)**

---

## 🛠️ Langkah-Langkah Instalasi (Untuk Laragon)

Ikuti langkah demi langkah berikut dari terminal Laragon (*Klik tombol **Terminal** di Laragon*):

### 1. Clone Repository
Masuk ke direktori `www` di Laragon (biasanya `C:\laragon\www`), lalu clone repo ini:
```bash
git clone <URL_REPO_GITHUB_KAMU> belajar-laravel
cd belajar-laravel
```

### 2. Install Dependensi PHP (Composer)
Unduh seluruh library Laravel yang dibutuhkan:
```bash
composer install
```

### 3. Konfigurasi Environment (`.env`)
Duplikasi file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
*(Bagi pengguna Windows Command Prompt / File Explorer, bisa copy-paste file `.env.example` dan ubah namanya menjadi `.env`)*.

Buka file `.env`, lalu pastikan konfigurasi database sesuai dengan pengaturan default MySQL Laragon:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_belajar_laravel_dev
DB_USERNAME=root
DB_PASSWORD=
```
> **Catatan:** Default Laragon menggunakan username `root` dan password **kosong**.

### 4. Buat Database di MySQL
Buka **HeidiSQL** atau **phpMyAdmin** bawaan Laragon (atau klik kanan di Laragon > MySQL > Create Database), lalu buat database baru:
- **Nama Database:** `db_belajar_laravel_dev`

### 5. Generate Application Key
Generate kunci keamanan aplikasi:
```bash
php artisan key:generate
```

### 6. Jalankan Migrasi & Seeder Database
Buat seluruh tabel dan isi data awal (dummy data project & mahasiswa):
```bash
php artisan migrate --seed
```
*(Perintah ini akan membuat tabel `projects`, `mahasiswas`, dan mengisikan 10 contoh project serta data profil mahasiswa).*

### 7. Install & Build Asset Frontend
Install dependensi CSS / JS (Tailwind & Vite) lalu build asetnya:
```bash
npm install
npm run build
```

---

## 💻 Menjalankan Aplikasi

Ada 2 cara untuk mengakses web:

### Cara 1: Menggunakan Artisan Serve (Rekomendasi)
Jalankan perintah berikut di terminal:
```bash
php artisan serve
```
Lalu buka browser di: **[http://localhost:8000](http://localhost:8000)**

### Cara 2: Virtual Host Otomatis Laragon
Jika menggunakan Laragon, pastikan tombol **Start All** sudah aktif, lalu buka:
**`http://belajar-laravel.test`**

> **Tips Development:** Jika sedang mengedit tampilan CSS / Blade secara aktif, jalankan Vite compiler di terminal terpisah:
> ```bash
> npm run dev
> ```

---

## 📌 Rute / Halaman yang Tersedia

| URL | Deskripsi |
| :--- | :--- |
| `/` | Halaman Home / Beranda |
| `/profile` | Halaman Profil Mahasiswa |
| `/about` | Halaman Tentang Aplikasi |

---

## 📂 Struktur Utama Project

- `app/Models/` : Berisi Model Eloquent (`Project.php`, `Mahasiswa.php`).
- `app/Http/Controllers/` : Controller logika aplikasi (`MahasiswaController.php`).
- `database/migrations/` : Skema struktur tabel database (`projects`, `mahasiswas`).
- `database/seeders/` : Data pengisian otomatis (`ProjectSeeder.php`, `MahasiswaSeeder.php`).
- `resources/views/` : Template tampilan antarmuka Blade (`home.blade.php`, `profile.blade.php`, dll).
- `routes/web.php` : Pendaftaran seluruh rute URL web.
