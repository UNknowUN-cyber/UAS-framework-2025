<?php

namespace App\Http\Controllers;

use App\Models\Ujian;
use App\Models\Soal;
use App\Models\HasilUjian;
use App\Models\JawabanSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UjianController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya guru yang bisa mengakses
        $this->middleware('can:manage-ujian,ujian')->only(['edit', 'update', 'destroy', 'manageSoal', 'syncSoal', 'showHasil', 'showDetailHasil']);
    }

    /**
     * Display a listing of the resource.
     */
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

        return view('ujian.index', compact('ujians', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ujian.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_ujian' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'durasi' => 'required|integer|min:1',
            'acak_soal' => 'boolean',
            'acak_opsi' => 'boolean',
            'mapel' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
        ]);

        $ujian = Ujian::create([
            'user_id' => Auth::id(),
            'nama_ujian' => $request->nama_ujian,
            'deskripsi' => $request->deskripsi,
            'mapel' => $request->mapel,
            'kelas' => $request->kelas,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'durasi' => $request->durasi,
            'acak_soal' => $request->has('acak_soal'),
            'acak_opsi' => $request->has('acak_opsi'),
        ]);

        return redirect()->route('ujian.manage_soal', [
            'ujian' => $ujian->id,
            'mapel' => $request->mapel,
            'kelas' => $request->kelas,
            'kategori' => $request->kategori,
        ])->with('success', 'Ujian berhasil dibuat. Silakan kelola soal.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Tidak digunakan untuk saat ini
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ujian $ujian)
    {
        return view('ujian.edit', compact('ujian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ujian $ujian)
    {
        $request->validate([
            'nama_ujian' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'durasi' => 'required|integer|min:1',
            'acak_soal' => 'boolean',
            'acak_opsi' => 'boolean',
            'mapel' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
        ]);

        $ujian->update([
            'nama_ujian' => $request->nama_ujian,
            'deskripsi' => $request->deskripsi,
            'mapel' => $request->mapel,
            'kelas' => $request->kelas,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'durasi' => $request->durasi,
            'acak_soal' => $request->has('acak_soal'),
            'acak_opsi' => $request->has('acak_opsi'),
        ]);

        return redirect()->route('ujian.index')->with('success', 'Ujian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ujian $ujian)
    {
        $ujian->delete();
        return redirect()->route('ujian.index')->with('success', 'Ujian berhasil dihapus.');
    }

    /**
     * Show the form for managing questions for a specific exam.
     */
    public function manageSoal(Request $request, Ujian $ujian)
    {
        $soals = Soal::where('user_id', Auth::id())
                    ->where('mapel', $ujian->mapel)
                    ->where('kelas', $ujian->kelas)
                    ->latest()->get();

        // Get unique kategori for filter options (from the filtered soals)
        $allKategori = $soals->pluck('kategori')->unique();

        return view('ujian.manage_soal', compact('ujian', 'soals', 'allKategori'));
    }

    /**
     * Sync the questions for a specific exam.
     */
    public function syncSoal(Request $request, Ujian $ujian)
    {
        $request->validate([
            'soal_ids' => 'nullable|array',
            'soal_ids.*' => 'exists:soals,id',
            'bobot' => 'nullable|array',
            'bobot.*' => 'integer|min:1',
        ]);

        $soalData = [];
        if ($request->has('soal_ids')) {
            foreach ($request->soal_ids as $soalId) {
                $soalData[$soalId] = ['bobot' => $request->bobot[$soalId] ?? 1];
            }
        }

        $ujian->soals()->sync($soalData);

        return redirect()->route('ujian.manage_soal', $ujian->id)->with('success', 'Soal ujian berhasil diperbarui.');
    }

    /**
     * Display the results for a specific exam.
     */
    public function showHasil(Ujian $ujian)
    {
        $hasilUjians = HasilUjian::where('ujian_id', $ujian->id)->with('user')->get();
        return view('ujian.hasil', compact('ujian', 'hasilUjians'));
    }

    /**
     * Display detailed results for a specific student's exam.
     */
    public function showDetailHasil(Ujian $ujian, HasilUjian $hasilUjian)
    {
        // Pastikan hasil ujian ini milik ujian yang benar dan user yang benar
        if ($hasilUjian->ujian_id !== $ujian->id) {
            abort(404);
        }

        $jawabanSiswa = JawabanSiswa::where('user_id', $hasilUjian->user_id)
                                    ->where('ujian_id', $ujian->id)
                                    ->with('soal')
                                    ->get();

        return view('ujian.detail_hasil', compact('ujian', 'hasilUjian', 'jawabanSiswa'));
    }
}