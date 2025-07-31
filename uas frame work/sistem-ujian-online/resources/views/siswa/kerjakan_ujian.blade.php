@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Ujian: {{ $ujian->nama_ujian }}
                    <span class="float-end" id="timer"></span>
                </div>

                <div class="card-body">
                    <form id="ujianForm" method="POST" action="{{ route('siswa.submit_ujian', $ujian->id) }}">
                        @csrf

                        @foreach ($soals as $key => $soal)
                            <div class="soal-item mb-4" id="soal-{{ $key + 1 }}" style="display: {{ $key == 0 ? 'block' : 'none' }};">
                                <h5>Soal {{ $key + 1 }}.</h5>
                                <p>{!! nl2br(e($soal->pertanyaan)) !!}</p>

                                @foreach ($soal->opsi_jawaban as $opsiKey => $opsiValue)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jawaban[{{ $soal->id }}]" id="soal-{{ $soal->id }}-opsi-{{ $opsiKey }}" value="{{ $opsiKey }}" {{ (isset($jawaban_tersimpan[$soal->id]) && $jawaban_tersimpan[$soal->id] == $opsiKey) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="soal-{{ $soal->id }}-opsi-{{ $opsiKey }}">
                                                {{ strtoupper($opsiKey) }}. {{ $opsiValue }}
                                            </label>
                                        </div>
                                    @endforeach
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary" id="prevSoal" style="display: none;">Sebelumnya</button>
                            <button type="button" class="btn btn-primary" id="nextSoal">Selanjutnya</button>
                            <button type="submit" class="btn btn-success" id="submitUjian" style="display: none;">Selesai Ujian</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentSoal = 0;
        const soals = document.querySelectorAll('.soal-item');
        const prevBtn = document.getElementById('prevSoal');
        const nextBtn = document.getElementById('nextSoal');
        const submitBtn = document.getElementById('submitUjian');
        const timerDisplay = document.getElementById('timer');
        const ujianForm = document.getElementById('ujianForm');

        // Timer
        let timeLeft = {{ $sisa_waktu_detik }};
        const timerInterval = setInterval(function() {
            const hours = Math.floor(timeLeft / 3600);
            const minutes = Math.floor((timeLeft % 3600) / 60);
            const seconds = timeLeft % 60;

            timerDisplay.textContent = `Sisa Waktu: ${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                alert('Waktu ujian habis!');
                ujianForm.submit(); // Otomatis submit form
            }
            timeLeft--;
        }, 1000);

        function showSoal(index) {
            soals.forEach((soal, i) => {
                soal.style.display = (i === index) ? 'block' : 'none';
            });

            prevBtn.style.display = (index === 0) ? 'none' : 'inline-block';
            nextBtn.style.display = (index === soals.length - 1) ? 'none' : 'inline-block';
            submitBtn.style.display = (index === soals.length - 1) ? 'inline-block' : 'none';
        }

        prevBtn.addEventListener('click', () => {
            if (currentSoal > 0) {
                currentSoal--;
                showSoal(currentSoal);
            }
        });

        nextBtn.addEventListener('click', () => {
            if (currentSoal < soals.length - 1) {
                currentSoal++;
                showSoal(currentSoal);
            }
        });

        showSoal(currentSoal);
    });
</script>
@endpush
