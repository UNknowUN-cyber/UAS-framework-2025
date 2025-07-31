@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Detail Hasil Ujian: ' . $ujian->nama_ujian . ' - ' . $hasilUjian->user->name) }}</div>

                <div class="card-body">
                    <p><strong>Skor:</strong> {{ $hasilUjian->skor ?? 'Belum Dinilai' }}</p>
                    <p><strong>Status:</strong> {{ ucwords(str_replace('_', ' ', $hasilUjian->status)) }}</p>
                    <p><strong>Waktu Mulai:</strong> {{ $hasilUjian->waktu_mulai_ujian->format('d M Y H:i') }}</p>
                    <p><strong>Waktu Selesai:</strong> {{ $hasilUjian->waktu_selesai_ujian ? $hasilUjian->waktu_selesai_ujian->format('d M Y H:i') : '-' }}</p>

                    <hr>

                    <h5>Detail Jawaban:</h5>
                    @forelse ($jawabanSiswa as $jawaban)
                        <div class="mb-4 p-3 border rounded">
                            <h6>Soal:</h6>
                            <p>{!! nl2br(e($jawaban->soal->pertanyaan)) !!}</p>

                            @if ($jawaban->soal->tipe_soal == 'pilihan_ganda')
                                <p><strong>Jawaban Anda:</strong> {{ strtoupper($jawaban->jawaban_siswa) }}. {{ $jawaban->soal->opsi_jawaban[$jawaban->jawaban_siswa] ?? '-' }}</p>
                                <p><strong>Jawaban Benar:</strong> {{ strtoupper($jawaban->soal->jawaban_benar) }}. {{ $jawaban->soal->opsi_jawaban[$jawaban->soal->jawaban_benar] ?? '-' }}</p>
                                
                            
                            @endif
                        </div>
                    @empty
                        <p>Tidak ada jawaban yang ditemukan untuk ujian ini.</p>
                    @endforelse

                    @php
                        $backUrl = route('ujian.show_hasil', $ujian->id);
                        if (request('from') == 'admin_siswa_hasil' && request('user_id')) {
                            $backUrl = route('admin.siswa.hasil', request('user_id'));
                        }
                    @endphp
                    <a href="{{ $backUrl }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
