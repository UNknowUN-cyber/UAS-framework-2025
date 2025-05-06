<?php

use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::resource('mahasiswa', MahasiswaController::class);