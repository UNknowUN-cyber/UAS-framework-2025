<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\JawabanSiswa;
use App\Models\Soal;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing JawabanSiswa records for multiple choice questions
        JawabanSiswa::chunk(100, function ($jawabanSiswaCollection) {
            foreach ($jawabanSiswaCollection as $jawabanSiswa) {
                $soal = Soal::find($jawabanSiswa->soal_id);
                if ($soal && $soal->tipe_soal === 'pilihan_ganda') {
                    $isCorrect = ($jawabanSiswa->jawaban_siswa === $soal->jawaban_benar);
                    $jawabanSiswa->update(['is_correct' => $isCorrect]);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jawaban_siswas', function (Blueprint $table) {
            $table->boolean('is_correct')->nullable()->change();
        });
        JawabanSiswa::query()->update(['is_correct' => null]);
    }
};
