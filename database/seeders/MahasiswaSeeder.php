<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $mahasiswas = [
            [
                'nim' => '251011700088',
                'nama' => 'Vigar Rivai Putra',
                'prodi' => 'Sistem Informasi',
                'kampus' => 'Universitas Pamulang',
                'email' => 'vigar.ext@gmail.com',
                'status' => 'Aktif'
            ],
        ];

        foreach ($mahasiswas as $mahasiswa) {
            Mahasiswa::create($mahasiswa);
        }
}
}