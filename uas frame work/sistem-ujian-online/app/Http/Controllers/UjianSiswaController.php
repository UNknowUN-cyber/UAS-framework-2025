<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\Soal;
use App\Models\HasilUjian;
use App\Models\JawabanSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UjianSiswaController extends Controller
{
    public function index()
    {
        $ujians = Ujian::where('waktu_selesai', '>=', now())
                        ->orderBy('waktu_mulai')
                        ->get();
        return view('siswa.daftar_ujian', compact('ujians'));
    }

    public function mulaiUjian(Ujian $ujian)
    {
        $user = Auth::user();
        $now = now();

        // Cek apakah ujian sudah dimulai atau sudah selesai
        if ($now->lt($ujian->waktu_mulai) || $now->gt($ujian->waktu_selesai)) {
            return redirect()->route('siswa.daftar_ujian')->with('error', 'Ujian belum dimulai atau sudah berakhir.');
        }

        // Cek apakah siswa sudah pernah mengerjakan ujian ini
        $hasilUjian = HasilUjian::where('user_id', $user->id)
                                ->where('ujian_id', $ujian->id)
                                ->first();

        if ($hasilUjian && $hasilUjian->status == 'selesai') {
            return redirect()->route('siswa.daftar_ujian')->with('error', 'Anda sudah mengerjakan ujian ini.');
        }

        // Jika belum ada hasil ujian, buat baru
        if (!$hasilUjian) {
            $hasilUjian = HasilUjian::create([
                'user_id' => $user->id,
                'ujian_id' => $ujian->id,
                'waktu_mulai_ujian' => $now,
                'status' => 'belum_selesai',
            ]);
        }

        // Hitung sisa waktu
        $waktuSelesaiUjian = $hasilUjian->waktu_mulai_ujian->addMinutes($ujian->durasi);
        $sisa_waktu_detik = $now->diffInSeconds($waktuSelesaiUjian, false); // false agar bisa negatif jika sudah lewat

        if ($sisa_waktu_detik <= 0) {
            // Jika waktu sudah habis, langsung submit ujian
            return $this->submitUjian(request(), $ujian);
        }

        // Ambil soal-soal ujian
        $soals = $ujian->soals;

        // Acak soal jika diatur
        if ($ujian->acak_soal) {
            $soals = $soals->shuffle();
        }

        // Acak opsi jika diatur (hanya untuk pilihan ganda)
        if ($ujian->acak_opsi) {
            $soals->map(function ($soal) {
                if ($soal->tipe_soal == 'pilihan_ganda' && is_array($soal->opsi_jawaban)) {
                    $opsi = $soal->opsi_jawaban;
                    $shuffledOpsi = [];
                    $keys = array_keys($opsi);
                    shuffle($keys);
                    foreach ($keys as $key) {
                        $shuffledOpsi[$key] = $opsi[$key];
                    }
                    $soal->opsi_jawaban = $shuffledOpsi;
                }
                return $soal;
            });
        }

        // Ambil jawaban yang sudah tersimpan (jika ada)
        $jawaban_tersimpan = JawabanSiswa::where('user_id', $user->id)
                                        ->where('ujian_id', $ujian->id)
                                        ->pluck('jawaban_siswa', 'soal_id')
                                        ->toArray();

        return view('siswa.kerjakan_ujian', compact('ujian', 'soals', 'sisa_waktu_detik', 'jawaban_tersimpan'));
    }

    public function submitUjian(Request $request, Ujian $ujian)
    {
        $user = Auth::user();
        $now = now();

        $hasilUjian = HasilUjian::where('user_id', $user->id)
                                ->where('ujian_id', $ujian->id)
                                ->first();

        if (!$hasilUjian) {
            return redirect()->route('siswa.daftar_ujian')->with('error', 'Anda belum memulai ujian ini.');
        }

        // Simpan jawaban siswa
        foreach ($request->jawaban as $soalId => $jawaban) {
            $soal = Soal::find($soalId);
            if ($soal) {
                $isCorrect = null;
                if ($soal->tipe_soal == 'pilihan_ganda') {
                    $isCorrect = ($jawaban == $soal->jawaban_benar);
                }

                JawabanSiswa::updateOrCreate(
                    ['user_id' => $user->id, 'ujian_id' => $ujian->id, 'soal_id' => $soalId],
                    ['jawaban_siswa' => $jawaban, 'is_correct' => $isCorrect]
                );
            }
        }

        // Update status hasil ujian
        $hasilUjian->update([
            'status' => 'selesai',
            'waktu_selesai_ujian' => $now,
        ]);

        // Hitung skor total berdasarkan bobot
        $totalSkor = 0;
        $totalBobot = 0;

        foreach ($ujian->soals as $soal) {
            $bobotSoal = $soal->pivot->bobot ?? 1;
            $totalBobot += $bobotSoal;

            $jawaban = JawabanSiswa::where('user_id', $user->id)
                                    ->where('ujian_id', $ujian->id)
                                    ->where('soal_id', $soal->id)
                                    ->first();

            if ($jawaban) {
                if ($jawaban->is_correct) {
                    $totalSkor += $bobotSoal;
                }
            }
        }

        // Hitung skor akhir berdasarkan bobot
        $finalSkor = ($totalBobot > 0) ? round(($totalSkor / $totalBobot) * 100) : 0;

        $hasilUjian->update(['skor' => $finalSkor]);

        return redirect()->route('siswa.daftar_ujian')->with('success', 'Ujian berhasil diselesaikan. Skor Anda: ' . $finalSkor . '.');
    }

    public function showMyResults()
    {
        $hasilUjians = HasilUjian::where('user_id', Auth::id())
                                ->with('ujian')
                                ->latest()
                                ->paginate(10);
        return view('siswa.my_results', compact('hasilUjians'));
    }
}