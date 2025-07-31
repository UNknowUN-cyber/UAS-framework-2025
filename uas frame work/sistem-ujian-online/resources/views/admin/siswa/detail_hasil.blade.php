@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Hasil Ujian untuk Siswa: ' . $user->name) }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Ujian</th>
                                <th>Skor</th>
                                <th>Status</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hasilUjians as $key => $hasil)
                                <tr>
                                    <td>{{ $hasilUjians->firstItem() + $key }}</td>
                                    <td>{{ $hasil->ujian->nama_ujian }}</td>
                                    <td>{{ $hasil->skor ?? '-' }}</td>
                                    <td>{{ ucwords(str_replace('_', ' ', $hasil->status)) }}</td>
                                    <td>{{ $hasil->waktu_mulai_ujian->format('d M Y H:i') }}</td>
                                    <td>{{ $hasil->waktu_selesai_ujian ? $hasil->waktu_selesai_ujian->format('d M Y H:i') : '-' }}</td>
                                    <td>
                                        <a href="{{ route('ujian.detail_hasil', ['ujian' => $hasil->ujian->id, 'hasilUjian' => $hasil->id, 'from' => 'admin_siswa_hasil', 'user_id' => $user->id]) }}" class="btn btn-sm btn-info">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada hasil ujian untuk siswa ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $hasilUjians->links() }}
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary mt-3">Kembali ke Data Siswa</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
