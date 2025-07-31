<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route untuk Manajemen Soal (hanya untuk user yang sudah login)
Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::resource('soal', App\Http\Controllers\SoalController::class);
    Route::resource('ujian', App\Http\Controllers\UjianController::class);
    Route::get('ujian/{ujian}/soal', [App\Http\Controllers\UjianController::class, 'manageSoal'])->name('ujian.manage_soal');
    Route::post('ujian/{ujian}/soal', [App\Http\Controllers\UjianController::class, 'syncSoal'])->name('ujian.sync_soal');
    Route::post('ujian/{ujian}/soal/store', [App\Http\Controllers\SoalController::class, 'storeFromUjian'])->name('soal.store_from_ujian');
    Route::get('ujian/{ujian}/hasil', [App\Http\Controllers\UjianController::class, 'showHasil'])->name('ujian.show_hasil');
    Route::get('ujian/{ujian}/hasil/{hasilUjian}/detail', [App\Http\Controllers\UjianController::class, 'showDetailHasil'])->name('ujian.detail_hasil');

    // Admin Routes for Students
    Route::get('/admin/siswa', [App\Http\Controllers\AdminController::class, 'indexSiswa'])->name('admin.siswa.index');
    Route::get('/admin/siswa/{user}/hasil', [App\Http\Controllers\AdminController::class, 'showSiswaHasil'])->name('admin.siswa.hasil');
    
});

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/daftar-ujian', [App\Http\Controllers\UjianSiswaController::class, 'index'])->name('siswa.daftar_ujian');
    Route::get('/ujian-mulai/{ujian}', [App\Http\Controllers\UjianSiswaController::class, 'mulaiUjian'])->name('siswa.mulai_ujian');
    Route::post('/ujian-submit/{ujian}', [App\Http\Controllers\UjianSiswaController::class, 'submitUjian'])->name('siswa.submit_ujian');
    Route::get('/hasil-ujian-saya', [App\Http\Controllers\UjianSiswaController::class, 'showMyResults'])->name('siswa.my_results');
});
