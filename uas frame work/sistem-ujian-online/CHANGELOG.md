# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/lang/id/).

## [Unreleased]

### Added
- Fitur manajemen siswa untuk admin/guru (daftar siswa, lihat hasil ujian siswa).
- Fungsionalitas pencarian dan pengurutan pada halaman Bank Soal, Manajemen Ujian, dan Data Siswa.
- Tombol toggle Dark/Light Mode di navbar, terlihat di semua halaman termasuk login/register.

### Changed
- Konsep desain dan warna aplikasi menjadi lebih profesional dan modern.
- Font aplikasi diubah menjadi Poppins, dengan font sistem untuk navbar.
- Warna font di Dark Mode navbar diubah menjadi putih murni untuk visibilitas yang lebih baik.
- Halaman utama (`/`) sekarang menjadi dashboard utama.
- Navigasi navbar disesuaikan: tautan 'Soal' diubah menjadi 'Bank Soal' dan menampilkan daftar ujian.
- Halaman 'Kelola Soal untuk Ujian' (`ujian/{id}/soal`) disederhanakan: filter dihapus, input mapel/kelas otomatis terisi dari data ujian.
- Input 'Jawaban Benar' di form tambah/edit soal (baik di Bank Soal maupun Kelola Soal Ujian) diubah menjadi dropdown (A, B, C, D).
- Kolom 'Waktu Mulai' dan 'Waktu Selesai' di halaman Bank Soal diganti dengan 'Deskripsi' ujian.
- Kolom 'Mapel' dan 'Kelas' ditambahkan di tabel Manajemen Ujian.
- Format angka di grafik analisis skor ujian (sumbu Y) diubah menjadi bilangan bulat tanpa koma.
- Tombol 'Kelola Soal' di halaman Manajemen Ujian dihapus.
- Tombol 'Detail' ditambahkan di halaman hasil ujian siswa untuk melihat detail jawaban.
- Logika tombol 'Kembali' di detail hasil ujian dibuat dinamis berdasarkan halaman asal.
- Pengguna baru setelah registrasi diarahkan ke dashboard utama (`/`).

### Removed
- Fungsionalitas soal esai sepenuhnya dihapus dari sistem (model, controller, view, migrasi, rute).
- Input 'Kategori' dari form tambah/edit soal di halaman 'Kelola Soal untuk Ujian'.
- Kolom 'Kategori' dari tabel soal di halaman 'Kelola Soal untuk Ujian'.

### Fixed
- Bug 'Unclosed {' di `UjianController.php`.
- Masalah zona waktu yang menyebabkan ujian tidak bisa diakses.
- Masalah 'Status Belum Dinilai' di detail hasil ujian (dengan migrasi perbaikan data).