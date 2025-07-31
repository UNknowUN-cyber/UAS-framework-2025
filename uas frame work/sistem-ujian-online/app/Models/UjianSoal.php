<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjianSoal extends Model
{
    use HasFactory;

    protected $table = 'ujian_soals';

    protected $fillable = [
        'ujian_id',
        'soal_id',
        'bobot',
    ];
}