<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori',
        'mapel',
        'kelas',
        'tipe_soal',
        'pertanyaan',
        'opsi_jawaban',
        'jawaban_benar',
    ];

    protected $casts = [
        'opsi_jawaban' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}