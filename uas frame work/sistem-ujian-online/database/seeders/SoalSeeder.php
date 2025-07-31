<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Soal;
use App\Models\User;

class SoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guru = User::where('email', 'guru@example.com')->first();

        if ($guru) {
            Soal::create([
                'user_id' => $guru->id,
                'kategori' => 'Matematika',
                'tipe_soal' => 'pilihan_ganda',
                'pertanyaan' => 'Berapakah hasil dari 2 + 2?',
                'opsi_jawaban' => [
                    'a' => '3',
                    'b' => '4',
                    'c' => '5',
                    'd' => '6',
                ],
                'jawaban_benar' => 'b',
            ]);

            Soal::create([
                'user_id' => $guru->id,
                'kategori' => 'Bahasa Indonesia',
                'tipe_soal' => 'esai',
                'pertanyaan' => 'Jelaskan pengertian dari puisi!',
                'opsi_jawaban' => null,
                'jawaban_benar' => 'Puisi adalah bentuk karya sastra yang terikat oleh irama, rima, dan bait.',
            ]);

            Soal::create([
                'user_id' => $guru->id,
                'kategori' => 'Matematika',
                'tipe_soal' => 'pilihan_ganda',
                'pertanyaan' => 'Berapakah hasil dari 5 x 3?',
                'opsi_jawaban' => [
                    'a' => '10',
                    'b' => '12',
                    'c' => '15',
                    'd' => '20',
                ],
                'jawaban_benar' => 'c',
            ]);
        }
    }
}