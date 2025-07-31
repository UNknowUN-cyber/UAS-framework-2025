<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Guru pembuat soal
            $table->string('kategori')->nullable();
            $table->enum('tipe_soal', ['pilihan_ganda', 'esai']);
            $table->text('pertanyaan');
            $table->json('opsi_jawaban')->nullable(); // Untuk pilihan ganda: {"a": "opsi 1", "b": "opsi 2", ...}
            $table->string('jawaban_benar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soals');
    }
};
