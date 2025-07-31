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
        Schema::create('hasil_ujians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ujian_id')->constrained()->onDelete('cascade');
            $table->integer('skor')->nullable();
            $table->enum('status', ['belum_selesai', 'selesai', 'dinilai'])->default('belum_selesai');
            $table->dateTime('waktu_mulai_ujian');
            $table->dateTime('waktu_selesai_ujian')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_ujians');
    }
};
