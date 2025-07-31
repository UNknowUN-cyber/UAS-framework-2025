<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoalController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya guru yang bisa mengakses
        $this->middleware('can:manage-soal,soal')->only(['edit', 'update', 'destroy']);
    }

    public function index(Request $request)
    {
        $query = Ujian::where('user_id', Auth::id());

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_ujian', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->orWhere('mapel', 'like', '%' . $search . '%')
                  ->orWhere('kelas', 'like', '%' . $search . '%');
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $query->orderBy($sortBy, $sortOrder);

        $ujians = $query->paginate(10)->appends($request->except('page'));

        return view('soal.index', compact('ujians', 'sortBy', 'sortOrder'));
    }

    public function create()
    {
        return view('soal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'kategori' => 'nullable|string|max:255',
            'mapel' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'opsi' => 'required|array',
            'jawaban_benar' => 'required|string|max:255',
        ]);

        Soal::create([
            'user_id' => Auth::id(),
            'pertanyaan' => $request->pertanyaan,
            'kategori' => $request->kategori,
            'mapel' => $request->mapel,
            'kelas' => $request->kelas,
            'tipe_soal' => 'pilihan_ganda', // Always multiple choice
            'opsi_jawaban' => $request->opsi,
            'jawaban_benar' => $request->jawaban_benar,
        ]);

        return redirect()->route('soal.index')->with('success', 'Soal berhasil dibuat.');
    }

    public function show(Soal $soal)
    {
        // Tidak digunakan untuk saat ini
    }

    public function edit(Soal $soal)
    {
        return view('soal.edit', compact('soal'));
    }

    public function update(Request $request, Soal $soal)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'kategori' => 'nullable|string|max:255',
            'mapel' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'opsi' => 'required|array',
            'jawaban_benar' => 'required|string|max:255',
        ]);

        $soal->update([
            'pertanyaan' => $request->pertanyaan,
            'kategori' => $request->kategori,
            'mapel' => $request->mapel,
            'kelas' => $request->kelas,
            'tipe_soal' => 'pilihan_ganda', // Always multiple choice
            'opsi_jawaban' => $request->opsi,
            'jawaban_benar' => $request->jawaban_benar,
        ]);

        return redirect()->route('soal.index')->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroy(Soal $soal)
    {
        $soal->delete();
        return redirect()->route('soal.index')->with('success', 'Soal berhasil dihapus.');
    }

    public function storeFromUjian(Request $request, Ujian $ujian)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'kategori' => 'nullable|string|max:255',
            'opsi' => 'required|array',
            'opsi.a' => 'required|string',
            'opsi.b' => 'required|string',
            'opsi.c' => 'required|string',
            'opsi.d' => 'required|string',
            'jawaban_benar' => 'required|string|max:255',
        ]);

        $soal = Soal::create([
            'user_id' => Auth::id(),
            'pertanyaan' => $request->pertanyaan,
            'kategori' => $request->kategori,
            'mapel' => $ujian->mapel, // Ambil dari ujian
            'kelas' => $ujian->kelas, // Ambil dari ujian
            'tipe_soal' => 'pilihan_ganda',
            'opsi_jawaban' => $request->opsi,
            'jawaban_benar' => $request->jawaban_benar,
        ]);

        // Attach the newly created question to the exam with a default bobot
        $ujian->soals()->attach($soal->id, ['bobot' => 1]);

        return redirect()->route('ujian.manage_soal', $ujian->id)->with('success', 'Soal baru berhasil dibuat dan ditambahkan ke ujian.');
    }
}
