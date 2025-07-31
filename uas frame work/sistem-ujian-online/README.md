# Sistem Ujian Online

Sebuah aplikasi web untuk manajemen ujian online, memungkinkan guru untuk membuat dan mengelola ujian, serta siswa untuk mengerjakan ujian dan melihat hasilnya. Aplikasi ini mendukung soal pilihan ganda dan dilengkapi dengan fitur bank soal per mata pelajaran dan kelas, serta manajemen pengguna.

## Fitur Utama

-   **Manajemen Ujian**: Buat, edit, dan hapus ujian dengan pengaturan waktu, durasi, acak soal, dan acak opsi.
-   **Bank Soal Terintegrasi**: Tambah dan kelola soal pilihan ganda langsung dari halaman manajemen ujian, dengan filter berdasarkan mata pelajaran dan kelas.
-   **Ujian untuk Siswa**: Siswa dapat melihat daftar ujian yang tersedia, mengerjakan ujian dengan timer, dan melihat hasil mereka.
-   **Manajemen Siswa (Admin/Guru)**: Guru dapat melihat daftar semua siswa dan detail hasil ujian masing-masing siswa.
-   **Autentikasi Pengguna**: Login dan registrasi dengan peran (guru/siswa).
-   **Mode Gelap/Terang**: Opsi untuk mengubah tampilan aplikasi ke mode gelap atau terang.
-   **Pencarian & Pengurutan**: Fungsionalitas pencarian dan pengurutan pada daftar ujian dan data siswa.

## User Stories

Sebagai Guru, saya ingin dapat membuat ujian baru dengan menentukan nama, deskripsi, mata pelajaran, kelas, waktu mulai, waktu selesai, durasi, serta opsi acak soal dan acak opsi jawaban, agar saya dapat mengatur ujian sesuai kebutuhan.
Sebagai Guru, saya ingin dapat mengelola soal untuk ujian tertentu, termasuk membuat soal pilihan ganda baru langsung di halaman ujian, agar saya dapat dengan mudah menambahkan soal yang relevan.
Sebagai Guru, saya ingin dapat melihat daftar semua ujian yang saya buat, agar saya dapat melacak dan mengelola ujian-ujian tersebut.
Sebagai Guru, saya ingin dapat melihat daftar semua siswa dan hasil ujian mereka, agar saya dapat memantau kinerja siswa.
Sebagai Siswa, saya ingin dapat melihat daftar ujian yang tersedia untuk saya, agar saya tahu ujian apa saja yang bisa saya kerjakan.
Sebagai Siswa, saya ingin dapat mengerjakan ujian pilihan ganda dengan timer, agar saya dapat menyelesaikan ujian dalam batas waktu yang ditentukan.
Sebagai Siswa, saya ingin dapat melihat hasil ujian saya setelah selesai mengerjakan, agar saya tahu skor yang saya peroleh.
Sebagai Pengguna, saya ingin dapat mendaftar dan masuk ke sistem dengan peran yang sesuai (guru/siswa), agar saya dapat mengakses fitur-fitur yang relevan.
Sebagai Pengguna, saya ingin dapat beralih antara mode terang dan gelap, agar saya dapat menyesuaikan tampilan aplikasi sesuai preferensi visual saya.

## Instalasi

Ikuti langkah-langkah berikut untuk menginstal dan menjalankan proyek ini di lingkungan lokal Anda:

1.  **Clone Repositori:**
    ```bash
    git clone <URL_REPOSITORI_ANDA>
    cd sistem-ujian-online
    ```

2.  **Instal Dependensi Composer:**
    ```bash
    composer install
    ```

3.  **Instal Dependensi Node.js:**
    ```bash
    npm install
    ```

4.  **Buat File `.env`:**
    Salin file `.env.example` dan ganti namanya menjadi `.env`.
    ```bash
    cp .env.example .env
    ```

5.  **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```

6.  **Konfigurasi Database:**
    Edit file `.env` dan sesuaikan pengaturan database Anda (misalnya, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

7.  **Jalankan Migrasi Database:**
    ```bash
    php artisan migrate
    ```

8.  **Jalankan Seeder (Opsional, untuk data dummy):**
    ```bash
    php artisan db:seed
    ```

9.  **Kompilasi Aset Frontend:**
    ```bash
    npm run dev   # Untuk pengembangan
    # atau
    # npm run build # Untuk produksi
    ```

10. **Jalankan Server Lokal:**
    ```bash
    php artisan serve
    ```

    Aplikasi akan tersedia di `http://127.0.0.1:8000`.

## Penggunaan

-   Akses aplikasi melalui browser Anda.
-   Daftar sebagai pengguna baru (secara default akan menjadi 'siswa').
-   Untuk peran 'guru', Anda mungkin perlu mengubah peran pengguna secara manual di database atau melalui seeder.
-   Jelajahi fitur-fitur manajemen ujian, bank soal, dan data siswa.

## Kontribusi

Jika Anda ingin berkontribusi pada proyek ini, silakan fork repositori, buat branch baru, lakukan perubahan Anda, dan ajukan pull request.

## Lisensi

Proyek ini dilisensikan di bawah [Nama Lisensi Anda, contoh: MIT License]. Lihat file `LICENSE` untuk detail lebih lanjut.
