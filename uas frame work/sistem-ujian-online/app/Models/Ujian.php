<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_ujian',
        'deskripsi',
        'mapel',
        'kelas',
        'waktu_mulai',
        'waktu_selesai',
        'durasi',
        'acak_soal',
        'acak_opsi',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'acak_soal' => 'boolean',
        'acak_opsi' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function soals()
    {
        return $this->belongsToMany(Soal::class, 'ujian_soals', 'ujian_id', 'soal_id');
    }
}