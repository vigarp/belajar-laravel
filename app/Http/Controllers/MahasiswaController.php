<?php

namespace App\Http\Controllers;

class MahasiswaController extends Controller
{
    //
    public function index()
    {
        $mahasiswa = [
            'nim' => '251011700088',
            'nama' => 'Vigar Rivai Putra',
            'prodi' => 'Sistem Informasi',
            'kampus' => 'Universitas Pamulang',
            'email' => 'vigar.ext@gmail.com',
            'status' => 'aktif',
        ];

        return view('mahasiswa', compact('mahasiswa'));
    }
}