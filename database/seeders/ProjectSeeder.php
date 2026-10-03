<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
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
            [
                'title' => 'Aplikasi Point of Sales (POS) Kasir Pintar',
                'description' => 'Sistem pencatatan transaksi kasir, manajemen stok barang otomatis, dan laporan pendapatan harian secara realtime.',
                'teknologi' => 'Laravel & Alpine.js',
                'image' => 'project4.jpg',
                'status' => 'Selesai',
            ],
            [
                'title' => 'Dashboard Monitoring Sensor IoT Lingkungan',
                'description' => 'Aplikasi visualisasi data telemetri suhu udara, kelembaban tanah, dan kualitas udara berbasis sensor mikrokontroler.',
                'teknologi' => 'Laravel, Chart.js & MQTT',
                'image' => 'project5.jpg',
                'status' => 'In Progress',
            ],
            [
                'title' => 'Sistem Antrean Online Klinik Medika',
                'description' => 'Web aplikasi pemesanan nomor antrean pasien secara online, pemanggilan loket poli, dan rekam medis elektronik sederhana.',
                'teknologi' => 'PHP Native & Bootstrap',
                'image' => 'project6.jpg',
                'status' => 'Selesai',
            ],
            [
                'title' => 'Platform Crowdfunding & Donasi Sosial',
                'description' => 'Portal penggalangan dana amal terbuka dengan pelaporan transparansi penggunaan dana donatur secara akuntabel.',
                'teknologi' => 'Laravel & Vue.js',
                'image' => 'project7.jpg',
                'status' => 'In Progress',
            ],
            [
                'title' => 'Portal Berita & Warta Kampus',
                'description' => 'Website publikasi karya tulis, liputan kegiatan mahasiswa, dan pengelolaan artikel dengan content management system (CMS).',
                'teknologi' => 'Laravel & MySQL',
                'image' => 'project8.jpg',
                'status' => 'Selesai',
            ],
            [
                'title' => 'Sistem Reservasi Laboratorium & Ruang Rapat',
                'description' => 'Layanan peminjaman fasilitas ruangan praktikum dan aula kampus dengan alur persetujuan bertingkat.',
                'teknologi' => 'Laravel & Bootstrap',
                'image' => 'project9.jpg',
                'status' => 'Selesai',
            ],
            [
                'title' => 'Perancangan UI/UX Aplikasi Mobile Belajar Bahasa',
                'description' => 'Riset pengalaman pengguna, pembuatan user persona, wireframe, dan prototype interaktif antarmuka aplikasi edukasi bahasa.',
                'teknologi' => 'Figma & Canva',
                'image' => 'project10.jpg',
                'status' => 'Selesai',
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);

        }
    }
}
