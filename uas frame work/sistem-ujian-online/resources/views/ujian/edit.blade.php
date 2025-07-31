@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Ujian') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ujian.update', $ujian->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="nama_ujian">Nama Ujian</label>
                            <input type="text" class="form-control" id="nama_ujian" name="nama_ujian" value="{{ old('nama_ujian', $ujian->nama_ujian) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $ujian->deskripsi) }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="mapel">Mata Pelajaran</label>
                            <input type="text" class="form-control" id="mapel" name="mapel" value="{{ old('mapel', $ujian->mapel) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="kelas">Kelas</label>
                            <input type="text" class="form-control" id="kelas" name="kelas" value="{{ old('kelas', $ujian->kelas) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="kategori">Kategori (Opsional)</label>
                            <input type="text" class="form-control" id="kategori" name="kategori" value="{{ old('kategori', $ujian->kategori) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="waktu_mulai">Waktu Mulai</label>
                            <input type="datetime-local" class="form-control" id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai', $ujian->waktu_mulai ? $ujian->waktu_mulai->format('Y-m-d\TH:i') : '') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="waktu_selesai">Waktu Selesai</label>
                            <input type="datetime-local" class="form-control" id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai', $ujian->waktu_selesai ? $ujian->waktu_selesai->format('Y-m-d\TH:i') : '') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="durasi">Durasi (menit)</label>
                            <input type="number" class="form-control" id="durasi" name="durasi" value="{{ old('durasi', $ujian->durasi) }}" required min="1">
                        </div>

                        <div class="form-group mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="acak_soal" name="acak_soal" value="1" {{ old('acak_soal', $ujian->acak_soal) ? 'checked' : '' }}>
                            <label class="form-check-label" for="acak_soal">Acak Urutan Soal</label>
                        </div>

                        <div class="form-group mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="acak_opsi" name="acak_opsi" value="1" {{ old('acak_opsi', $ujian->acak_opsi) ? 'checked' : '' }}>
                            <label class="form-check-label" for="acak_opsi">Acak Urutan Opsi Jawaban</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Ujian</button>
                        <a href="{{ route('ujian.manage_soal', $ujian->id) }}" class="btn btn-info">Kelola Soal</a>
                        <a href="{{ route('ujian.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
