@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Hasil Ujian: ' . $ujian->nama_ujian) }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Skor</th>
                                <th>Status</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hasilUjians as $hasil)
                                <tr>
                                    <td>{{ $hasil->user->name }}</td>
                                    <td>{{ $hasil->skor ?? 'Belum Dinilai' }}</td>
                                    <td>{{ ucwords(str_replace('_', ' ', $hasil->status)) }}</td>
                                    <td>{{ $hasil->waktu_mulai_ujian->format('d M Y H:i') }}</td>
                                    <td>{{ $hasil->waktu_selesai_ujian ? $hasil->waktu_selesai_ujian->format('d M Y H:i') : '-' }}</td>
                                    <td>
                                        <a href="{{ route('ujian.detail_hasil', ['ujian' => $ujian->id, 'hasilUjian' => $hasil->id, 'from' => 'ujian_hasil']) }}" class="btn btn-sm btn-info">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada siswa yang mengerjakan ujian ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <a href="{{ route('ujian.index') }}" class="btn btn-secondary">Kembali ke Daftar Ujian</a>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">{{ __('Analisis Skor Ujian') }}</div>
                <div class="card-body">
                    <canvas id="skorChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('skorChart').getContext('2d');
        const skorData = @json($hasilUjians->pluck('skor')->filter()->toArray());

        const skorCounts = {};
        skorData.forEach(skor => {
            skorCounts[skor] = (skorCounts[skor] || 0) + 1;
        });

        const labels = Object.keys(skorCounts).sort((a, b) => a - b);
        const data = labels.map(label => skorCounts[label]);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Siswa'
                        },
                        ticks: {
                            stepSize: 1, // Ensure integer steps
                            callback: function(value) {
                                if (Number.isInteger(value)) {
                                    return value; // Only return integers
                                }
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Skor'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
