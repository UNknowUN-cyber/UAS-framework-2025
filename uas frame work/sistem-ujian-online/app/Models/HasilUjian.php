<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilUjian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ujian_id',
        'skor',
        'status',
        'waktu_mulai_ujian',
        'waktu_selesai_ujian',
    ];

    protected $casts = [
        'waktu_mulai_ujian' => 'datetime',
        'waktu_selesai_ujian' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }
}