@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Buat Ujian Baru') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ujian.store') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="nama_ujian">Nama Ujian</label>
                            <input type="text" class="form-control" id="nama_ujian" name="nama_ujian" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="mapel">Mata Pelajaran</label>
                            <input type="text" class="form-control" id="mapel" name="mapel" value="{{ old('mapel') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="kelas">Kelas</label>
                            <input type="text" class="form-control" id="kelas" name="kelas" value="{{ old('kelas') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="kategori">Kategori (Opsional)</label>
                            <input type="text" class="form-control" id="kategori" name="kategori" value="{{ old('kategori') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="waktu_mulai">Waktu Mulai</label>
                            <input type="datetime-local" class="form-control" id="waktu_mulai" name="waktu_mulai" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="waktu_selesai">Waktu Selesai</label>
                            <input type="datetime-local" class="form-control" id="waktu_selesai" name="waktu_selesai" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="durasi">Durasi (menit)</label>
                            <input type="number" class="form-control" id="durasi" name="durasi" required min="1">
                        </div>

                        <div class="form-group mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="acak_soal" name="acak_soal" value="1">
                            <label class="form-check-label" for="acak_soal">Acak Urutan Soal</label>
                        </div>

                        <div class="form-group mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="acak_opsi" name="acak_opsi" value="1">
                            <label class="form-check-label" for="acak_opsi">Acak Urutan Opsi Jawaban</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Ujian</button>
                        <a href="{{ route('ujian.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
