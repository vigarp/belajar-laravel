# 📖 Panduan Praktikum Pertemuan 5 - Rekayasa Web
### Topik: Database Migration, Eloquent Model & Seeder (Laravel)

Dokumen ini merupakan panduan langkah-demi-langkah praktikum **Pertemuan 5** pada matakuliah **Rekayasa Web**. Pada sesi ini, kita mempelajari dan mengimplementasikan modul database di Laravel:
1. **Migration & Eloquent Model `Project`** (untuk data portofolio)
2. **Migration & Eloquent Model `Mahasiswa`** (untuk data profil mahasiswa)
3. **Database Seeder** untuk pengisian data otomatis (*dummy data*)

Panduan ini ditujukan untuk dijalankan di terminal (Laragon / Command Prompt / Terminal biasa).

---

## 📑 Daftar Isi
1. [Langkah 1: Membuat Model & Migration Project](#1-membuat-model--migration-project)
2. [Langkah 2: Membuat Model & Migration Mahasiswa](#2-membuat-model--migration-mahasiswa)
3. [Langkah 3: Konfigurasi Model ($fillable)](#3-konfigurasi-model-fillable)
4. [Langkah 4: Menjalankan Migrasi Tabel](#4-menjalankan-migrasi-tabel)
5. [Langkah 5: Membuat & Mengisi Seeder](#5-membuat--mengisi-seeder)
6. [Langkah 6: Mendaftarkan Seeder di DatabaseSeeder](#6-mendaftarkan-seeder-di-databaseseeder)
7. [Langkah 7: Eksekusi Seeder ke Database](#7-eksekusi-seeder-ke-database)
8. [Langkah 8: Simpan & Push ke Git Repository (GitHub)](#8-simpan--push-ke-git-repository-github)
9. [Rangkuman Perintah Singkat](#rangkuman-perintah-singkat)

---

## 1. Membuat Model & Migration Project

Jalankan perintah berikut di terminal:
```bash
php artisan make:model Project -m
```
> **Catatan:** Flag `-m` berfungsi otomatis membuatkan file migration baru bersamaan dengan modelnya.

### Mengatur Skema Tabel Migration Project
Buka file migration yang baru dibuat di folder `database/migrations/xxxx_create_projects_table.php`, lalu sesuaikan method `up()`:

```php
public function up(): void
{
    Schema::create('projects', function (Blueprint $table) {
        $table->id();
        $table->string("title")->nullable();
        $table->text("description")->nullable();
        $table->string("teknologi")->nullable();
        $table->string("image")->nullable();
        $table->string("status")->default("Selesai");
        $table->timestamps();
    });
}
```

---

## 2. Membuat Model & Migration Mahasiswa

Jalankan perintah berikut di terminal:
```bash
php artisan make:model Mahasiswa -m
```

### Mengatur Skema Tabel Migration Mahasiswa
Buka file migration `database/migrations/xxxx_create_mahasiswas_table.php`, lalu sesuaikan method `up()`:

```php
public function up(): void
{
    Schema::create('mahasiswas', function (Blueprint $table) {
        $table->id();
        $table->string("nim")->unique();
        $table->string("nama")->nullable();
        $table->string("prodi")->nullable();
        $table->string("kampus")->nullable();
        $table->string("email")->nullable();
        $table->string("status")->default("aktif");
        $table->timestamps();
    });
}
```

---

## 3. Konfigurasi Model ($fillable)

Agar data bisa diisi secara massal (*Mass Assignment*) melalui Eloquent `create()`, kita wajib mendaftarkan kolom-kolom yang diizinkan di dalam Model:

### A. Model Project (`app/Models/Project.php`)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = "projects";

    protected $fillable = [
        'title',
        'description',
        'teknologi',
        'image',
        'status',
    ];
}
```

### B. Model Mahasiswa (`app/Models/Mahasiswa.php`)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = "mahasiswas";

    protected $fillable = [
        'nim',
        'nama',
        'prodi',
        'kampus',
        'email',
        'status',
    ];
}
```

---

## 4. Menjalankan Migrasi Tabel

Untuk membuat tabel-tabel di atas ke dalam database MySQL, jalankan:
```bash
php artisan migrate
```

Jika berhasil, tabel `projects` dan `mahasiswas` akan langsung muncul di database kamu (bisa dicek melalui HeidiSQL / phpMyAdmin).

---

## 5. Membuat & Mengisi Seeder

Seeder digunakan untuk mengisi data awal (*dummy data*) secara otomatis ke dalam database.

### A. Membuat ProjectSeeder
Ketik di terminal:
```bash
php artisan make:seeder ProjectSeeder
```
Buka file `database/seeders/ProjectSeeder.php`, lalu isi dengan array data project:

```php
<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Sistem Informasi Arsip Digital',
                'description' => 'Aplikasi berbasis web untuk digitalisasi, pengarsipan surat masuk dan keluar, serta temu kembali dokumen cepat.',
                'teknologi' => 'Laravel & Tailwind CSS',
                'image' => 'project1.jpg',
                'status' => 'Selesai',
            ],
            [
                'title' => 'Portal E-Commerce Fashion & Aksesori',
                'description' => 'Platform toko online responsif dengan fitur katalog interaktif, keranjang belanja, dan integrasi payment gateway.',
                'teknologi' => 'Laravel & Bootstrap 5',
                'image' => 'project2.jpg',
                'status' => 'In Progress',
            ],
            [
                'title' => 'Sistem Rekomendasi Destinasi Wisata',
                'description' => 'Sistem pendukung keputusan pemilihan tempat wisata lokal menggunakan metode Simple Additive Weighting (SAW).',
                'teknologi' => 'PHP, MySQL & Leaflet JS',
                'image' => 'project3.jpg',
                'status' => 'Selesai',
            ],
            // ... tambahkan data lainnya
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
```

### B. Membuat MahasiswaSeeder
Ketik di terminal:
```bash
php artisan make:seeder MahasiswaSeeder
```
Buka file `database/seeders/MahasiswaSeeder.php`, lalu masukkan data mahasiswa:

```php
<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswas = [
            [
                'nim' => '251011700088',
                'nama' => 'Vigar Rivai Putra',
                'prodi' => 'Sistem Informasi',
                'kampus' => 'Universitas Pamulang',
                'email' => 'vigar.ext@gmail.com',
                'status' => 'Aktif',
            ],
        ];

        foreach ($mahasiswas as $mahasiswa) {
            Mahasiswa::create($mahasiswa);
        }
    }
}
```

---

## 6. Mendaftarkan Seeder di DatabaseSeeder

Buka file `database/seeders/DatabaseSeeder.php` dan panggil kedua seeder tersebut di dalam array `$this->call([...])`:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            ProjectSeeder::class,
            MahasiswaSeeder::class,
        ]);
    }
}
```

---

## 7. Eksekusi Seeder ke Database

Ada 2 cara menjalankan seeder:

### Cara 1: Menjalankan Seeder Saja
```bash
php artisan db:seed
```

### Cara 2: Reset Ulang Database + Isi Ulang Seeder (Paling Sering Dipakai)
Jika ingin mereset semua tabel dari awal agar bersih lalu mengisikan data seeder:
```bash
php artisan migrate:fresh --seed
```

---

## 8. Simpan & Push ke Git Repository (GitHub)

Setelah semua file model, migration, dan seeder selesai dibuat serta diuji coba, langkah terakhir adalah menyimpan perubahan tersebut ke Git dan mengunggahnya (*push*) ke repository GitHub:

### A. Memeriksa Status File
Ketik di terminal untuk melihat file-file baru dan yang mengalami perubahan:
```bash
git status
```

### B. Menambahkan File ke Staging Area
Tambahkan seluruh file baru (model, migration, seeder) ke staging area:
```bash
git add .
```

### C. Menyimpan Perubahan (Commit)
Buat commit dengan pesan yang jelas mengenai tugas Pertemuan 5:
```bash
git commit -m "feat: menambah model, migration, dan seeder project serta mahasiswa (pertemuan 5)"
```

### D. Mengunggah ke GitHub (Push)
Kirim commit ke repository remote di GitHub:
```bash
git push origin main
```
> **Catatan:** Ganti `main` dengan nama branch kamu jika menggunakan branch lain (misal `master`).

---

## 💡 Rangkuman Perintah Singkat

| Perintah | Fungsi |
| :--- | :--- |
| `php artisan make:model NamaModel -m` | Membuat Model sekaligus file Migration |
| `php artisan migrate` | Mengeksekusi file migrasi ke database |
| `php artisan make:seeder NamaSeeder` | Membuat file Seeder baru |
| `php artisan db:seed` | Menjalankan file DatabaseSeeder |
| `php artisan migrate:fresh --seed` | Menghapus semua tabel, membuat ulang tabel, dan mengisi seeder |
| `git status` | Melihat status file yang baru/diubah |
| `git add .` | Menambahkan semua perubahan ke staging area Git |
| `git commit -m "pesan commit"` | Menyimpan riwayat perubahan (*snapshot*) di Git lokal |
| `git push origin main` | Mengunggah perubahan lokal ke repository GitHub |

