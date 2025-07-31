@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Data Siswa') }}</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.siswa.index') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="search" class="form-control" placeholder="Cari siswa..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-4">
                                <select name="sort_by" class="form-control">
                                    <option value="created_at" {{ $sortBy == 'created_at' ? 'selected' : '' }}>Tanggal Dibuat</option>
                                    <option value="name" {{ $sortBy == 'name' ? 'selected' : '' }}>Nama Siswa</option>
                                    <option value="email" {{ $sortBy == 'email' ? 'selected' : '' }}>Email</option>
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
                                <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Siswa</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswas as $key => $siswa)
                                <tr>
                                    <td>{{ $siswas->firstItem() + $key }}</td>
                                    <td>{{ $siswa->name }}</td>
                                    <td>{{ $siswa->email }}</td>
                                    <td>
                                        <a href="{{ route('admin.siswa.hasil', $siswa->id) }}" class="btn btn-sm btn-info">Lihat Hasil Ujian</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data siswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $siswas->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
