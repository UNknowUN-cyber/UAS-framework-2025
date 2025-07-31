@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Buat Soal Baru') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('soal.store') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="pertanyaan">Pertanyaan</label>
                            <textarea class="form-control" id="pertanyaan" name="pertanyaan" rows="3" required></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="kategori">Kategori</label>
                            <input type="text" class="form-control" id="kategori" name="kategori">
                        </div>

                        <div class="form-group mb-3">
                            <label for="mapel">Mata Pelajaran</label>
                            <input type="text" class="form-control" id="mapel" name="mapel" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="kelas">Kelas</label>
                            <input type="text" class="form-control" id="kelas" name="kelas" required>
                        </div>

                        

                        {{-- Opsi untuk Pilihan Ganda (muncul/hilang dengan JS) --}}
                        <div id="opsi-pilihan-ganda">
                            <div class="form-group mb-2">
                                <label>Opsi Jawaban</label>
                                <input type="text" class="form-control mb-1" name="opsi[a]" placeholder="Opsi A">
                                <input type="text" class="form-control mb-1" name="opsi[b]" placeholder="Opsi B">
                                <input type="text" class="form-control mb-1" name="opsi[c]" placeholder="Opsi C">
                                <input type="text" class="form-control mb-1" name="opsi[d]" placeholder="Opsi D">
                            </div>
                             <div class="form-group mb-3">
                                <label for="jawaban_benar">Jawaban Benar</label>
                                <select class="form-control" id="jawaban_benar" name="jawaban_benar" required>
                                    @foreach (['a', 'b', 'c', 'd'] as $option)
                                        <option value="{{ $option }}" {{ old('jawaban_benar') == $option ? 'selected' : '' }}>{{ strtoupper($option) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Soal</button>
                        <a href="{{ route('soal.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

