@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Soal') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('soal.update', $soal->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="pertanyaan">Pertanyaan</label>
                            <textarea class="form-control" id="pertanyaan" name="pertanyaan" rows="3" required>{{ old('pertanyaan', $soal->pertanyaan) }}</textarea>
                        </div>

                        

                        <div class="form-group mb-3">
                            <label for="mapel">Mata Pelajaran</label>
                            <input type="text" class="form-control" id="mapel" name="mapel" value="{{ old('mapel', $soal->mapel) }}" required readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label for="kelas">Kelas</label>
                            <input type="text" class="form-control" id="kelas" name="kelas" value="{{ old('kelas', $soal->kelas) }}" required readonly>
                        </div>

                        

                        <div id="opsi-pilihan-ganda" style="{{ $soal->tipe_soal != 'pilihan_ganda' ? 'display:none' : '' }}">
                            <div class="form-group mb-2">
                                <label>Opsi Jawaban</label>
                                <input type="text" class="form-control mb-1" name="opsi[a]" placeholder="Opsi A" value="{{ old('opsi.a', $soal->opsi_jawaban['a'] ?? '') }}">
                                <input type="text" class="form-control mb-1" name="opsi[b]" placeholder="Opsi B" value="{{ old('opsi.b', $soal->opsi_jawaban['b'] ?? '') }}">
                                <input type="text" class="form-control mb-1" name="opsi[c]" placeholder="Opsi C" value="{{ old('opsi.c', $soal->opsi_jawaban['c'] ?? '') }}">
                                <input type="text" class="form-control mb-1" name="opsi[d]" placeholder="Opsi D" value="{{ old('opsi.d', $soal->opsi_jawaban['d'] ?? '') }}">
                            </div>
                             <div class="form-group mb-3">
                                <label for="jawaban_benar">Jawaban Benar</label>
                                <select class="form-control" id="jawaban_benar" name="jawaban_benar" required>
                                    @foreach (['a', 'b', 'c', 'd'] as $option)
                                        <option value="{{ $option }}" {{ old('jawaban_benar', $soal->jawaban_benar) == $option ? 'selected' : '' }}>{{ strtoupper($option) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Soal</button>
                        <a href="{{ route('soal.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


