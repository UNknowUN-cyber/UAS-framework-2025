@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Hasil Ujian Saya') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Ujian</th>
                                <th>Skor</th>
                                <th>Status</th>
                                <th>Waktu Mulai Ujian</th>
                                <th>Waktu Selesai Ujian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hasilUjians as $hasil)
                                <tr>
                                    <td>{{ $hasil->ujian->nama_ujian }}</td>
                                    <td>{{ $hasil->skor ?? 'Belum Dinilai' }}</td>
                                    <td>{{ ucwords(str_replace('_', ' ', $hasil->status)) }}</td>
                                    <td>{{ $hasil->waktu_mulai_ujian->format('d M Y H:i') }}</td>
                                    <td>{{ $hasil->waktu_selesai_ujian ? $hasil->waktu_selesai_ujian->format('d M Y H:i') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Anda belum mengerjakan ujian apapun.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $hasilUjians->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
