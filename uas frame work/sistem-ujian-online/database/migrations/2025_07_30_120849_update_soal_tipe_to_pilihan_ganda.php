<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Soal;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Soal::query()->update(['tipe_soal' => 'pilihan_ganda']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert tipe_soal if needed, but we don't know the original type
        // Soal::query()->update(['tipe_soal' => null]); // Or to 'esai' if that was the default
    }
};
