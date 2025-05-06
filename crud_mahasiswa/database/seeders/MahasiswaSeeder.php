<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mahasiswa::create([
            'nama' => 'Budi Santoso',
            'nim' => '1234567890',
            'jurusan' => 'Teknik Informatika',
        ]);

        Mahasiswa::create([
            'nama' => 'Siti Aminah',
            'nim' => '0987654321',
            'jurusan' => 'Sistem Informasi',
        ]);
    }}