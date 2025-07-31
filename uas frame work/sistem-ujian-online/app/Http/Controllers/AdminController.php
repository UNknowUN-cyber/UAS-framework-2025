<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\HasilUjian;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function indexSiswa(Request $request)
    {
        $query = User::where('role', 'siswa');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $query->orderBy($sortBy, $sortOrder);

        $siswas = $query->paginate(10)->appends($request->except('page'));

        return view('admin.siswa.index', compact('siswas', 'sortBy', 'sortOrder'));
    }

    public function showSiswaHasil(User $user)
    {
        // Pastikan user yang diminta adalah siswa
        if ($user->role !== 'siswa') {
            abort(404);
        }

        $hasilUjians = HasilUjian::where('user_id', $user->id)
                                ->with('ujian')
                                ->latest()
                                ->paginate(10);

        return view('admin.siswa.detail_hasil', compact('user', 'hasilUjians'));
    }
}
