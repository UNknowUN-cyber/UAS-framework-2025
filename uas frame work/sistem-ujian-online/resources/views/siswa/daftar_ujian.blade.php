@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Daftar Ujian Tersedia') }}</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Ujian</th>
                                <th>Mapel</th>
                                <th>Kelas</th>
                                <th>Deskripsi</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Durasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ujians as $ujian)
                                <tr>
                                    <td>{{ $ujian->nama_ujian }}</td>
                                    <td>{{ $ujian->mapel ?? '-' }}</td>
                                    <td>{{ $ujian->kelas ?? '-' }}</td>
                                    <td>{{ $ujian->deskripsi ?? '-' }}</td>
                                    <td>{{ $ujian->waktu_mulai->format('d M Y H:i') }}</td>
                                    <td>{{ $ujian->waktu_selesai->format('d M Y H:i') }}</td>
                                    <td>{{ $ujian->durasi }} menit</td>
                                    <td>
                                        @php
                                            $now = now();
                                            $canStart = $now->between($ujian->waktu_mulai, $ujian->waktu_selesai);
                                            $hasTaken = Auth::user()->hasilUjians()->where('ujian_id', $ujian->id)->exists();
                                        @endphp

                                        @if ($canStart && !$hasTaken)
                                            <a href="{{ route('siswa.mulai_ujian', $ujian->id) }}" class="btn btn-success btn-sm">Mulai Ujian</a>
                                        @elseif ($hasTaken)
                                            <span class="badge bg-info">Sudah Dikerjakan</span>
                                        @else
                                            <span class="badge bg-secondary">Belum/Sudah Lewat Waktu</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada ujian yang tersedia saat ini.</td>
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
