@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Manajemen Ujian') }}</div>

                <div class="card-body">
                    <a href="{{ route('ujian.create') }}" class="btn btn-primary mb-3">Buat Ujian Baru</a>

                    <form method="GET" action="{{ route('ujian.index') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="search" class="form-control" placeholder="Cari ujian..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-4">
                                <select name="sort_by" class="form-control">
                                    <option value="created_at" {{ $sortBy == 'created_at' ? 'selected' : '' }}>Tanggal Dibuat</option>
                                    <option value="nama_ujian" {{ $sortBy == 'nama_ujian' ? 'selected' : '' }}>Nama Ujian</option>
                                    <option value="mapel" {{ $sortBy == 'mapel' ? 'selected' : '' }}>Mapel</option>
                                    <option value="kelas" {{ $sortBy == 'kelas' ? 'selected' : '' }}>Kelas</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="sort_order" class="form-control">
                                    <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Descending</option>
                                    <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Ascending</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-2">
                                <button type="submit" class="btn btn-primary">Cari & Urutkan</button>
                                <a href="{{ route('ujian.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Ujian</th>
                                <th>Mapel</th>
                                <th>Kelas</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Durasi (menit)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ujians as $key => $ujian)
                                <tr>
                                    <td>{{ $ujians->firstItem() + $key }}</td>
                                    <td>{{ $ujian->nama_ujian }}</td>
                                    <td>{{ $ujian->mapel ?? '-' }}</td>
                                    <td>{{ $ujian->kelas ?? '-' }}</td>
                                    <td>{{ $ujian->waktu_mulai->format('d M Y H:i') }}</td>
                                    <td>{{ $ujian->waktu_selesai->format('d M Y H:i') }}</td>
                                    <td>{{ $ujian->durasi }}</td>
                                    <td>
                                        
                                        <a href="{{ route('ujian.show_hasil', $ujian->id) }}" class="btn btn-sm btn-primary">Lihat Hasil</a>
                                        <a href="{{ route('ujian.edit', $ujian->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('ujian.destroy', $ujian->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus ujian ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada ujian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $ujians->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
