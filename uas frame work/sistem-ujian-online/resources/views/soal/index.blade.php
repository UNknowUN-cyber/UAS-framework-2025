@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Bank Soal') }}</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('soal.index') }}" class="mb-3">
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
                                <a href="{{ route('soal.index') }}" class="btn btn-secondary">Reset</a>
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
                                <th>Deskripsi</th>
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
                                    <td>{{ Str::limit($ujian->deskripsi ?? '-', 50) }}</td>
                                    <td>
                                        <a href="{{ route('ujian.manage_soal', $ujian->id) }}" class="btn btn-sm btn-info">Kelola Soal</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada ujian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
