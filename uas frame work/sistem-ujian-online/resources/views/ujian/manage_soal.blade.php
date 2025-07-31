@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Kelola Soal untuk Ujian: ' . $ujian->nama_ujian) }}</div>

                <div class="card-body">
                    

                    <hr class="my-4">

                    <h5>Soal-soal dalam Ujian Ini:</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pertanyaan</th>
                                
                                <th>Mapel</th>
                                <th>Kelas</th>
                                <th>Bobot</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ujian->soals as $key => $soal)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ Str::limit($soal->pertanyaan, 50) }}</td>
                                    
                                    <td>{{ $soal->mapel ?? '-' }}</td>
                                    <td>{{ $soal->kelas ?? '-' }}</td>
                                    <td>{{ $soal->pivot->bobot ?? 1 }}</td>
                                    <td>
                                        <a href="{{ route('soal.edit', $soal->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('soal.destroy', $soal->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus soal ini dari bank soal?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada soal dalam ujian ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <hr class="my-4">

                    <h5>Buat Soal Baru untuk Ujian Ini:</h5>
                    <form method="POST" action="{{ route('soal.store_from_ujian', $ujian->id) }}">
                        @csrf

                        
                            <div class="form-group mb-3">
                            <label for="pertanyaan">Pertanyaan</label>
                            <textarea class="form-control" id="pertanyaan" name="pertanyaan" rows="3" required>{{ old('pertanyaan') }}</textarea>
                        </div>

                        <div class="form-group mb-2">
                            <label>Opsi Jawaban</label>
                            <input type="text" class="form-control mb-1" name="opsi[a]" placeholder="Opsi A" value="{{ old('opsi.a') }}" required>
                            <input type="text" class="form-control mb-1" name="opsi[b]" placeholder="Opsi B" value="{{ old('opsi.b') }}" required>
                            <input type="text" class="form-control mb-1" name="opsi[c]" placeholder="Opsi C" value="{{ old('opsi.c') }}" required>
                            <input type="text" class="form-control mb-1" name="opsi[d]" placeholder="Opsi D" value="{{ old('opsi.d') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="jawaban_benar">Jawaban Benar (A, B, C, atau D)</label>
                            <select class="form-control" id="jawaban_benar" name="jawaban_benar" required>
                                @foreach (['a', 'b', 'c', 'd'] as $option)
                                    <option value="{{ $option }}" {{ old('jawaban_benar') == $option ? 'selected' : '' }}>{{ strtoupper($option) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Tambah Soal ke Ujian</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
