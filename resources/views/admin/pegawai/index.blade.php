{{-- Memberitahu file ini untuk menggunakan Master Layout --}}
@extends('layouts.admin')

{{-- Mengisi 'title' di Master Layout --}}
@php
switch (Route::currentRouteName()) {
    case 'admin.pegawai.pendidik':
        $judul = 'Daftar Pendidik';
        break;
    case 'admin.pegawai.tenaga-kependidikan':
        $judul = 'Daftar Tenaga Kependidikan';
        break;
    case 'admin.pegawai.keluar':
        $judul = 'Daftar PTK Keluar';
        break;
    default:
        $judul = 'Data Pegawai Aktif';
}
@endphp
@section('title', $judul)

{{-- Semua konten halaman ini sekarang berada di dalam section 'content' --}}
@section('content')
<div class="card-header d-flex justify-content-between align-items-center">

    <span>{{ $judul }}</span>
    <div>
        <a href="#" class="btn btn-info mb-2">
            <i class="bi bi-printer me-2"></i>Cetak Laporan
        </a>
        <a href="{{ route('admin.pegawai.create') }}" class="btn btn-primary mb-2">
            <i class="bi bi-plus-circle me-2"></i>Tambah
        </a>
    </div>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table id="dt" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Nama</th>
                    <th>NUPTK</th>
                    <th>NIPY</th>
                    <th>Jenis Kelamin</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pegawais as $pegawai)
                <tr>
                    <td>{{ $loop->iteration + $pegawais->firstItem() - 1 }}</td>
                    <td>
                        <img src="{{ $pegawai->photo ? asset('storage/' . $pegawai->photo) : 'https://placehold.co/60x60/696cff/FFFFFF?text=' . strtoupper(substr($pegawai->nama, 0, 1)) }}" 
                             alt="Foto {{ $pegawai->nama }}" class="rounded" width="60">
                    </td>
                    <td>{{ $pegawai->nama }}</td>
                    <td>{{ $pegawai->nuptk ?? '-' }}</td>
                    <td>{{ $pegawai->nipy ?? '-' }}</td>
                    <td>{{ $pegawai->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>
    <a href="{{ route('admin.pegawai.formKeluar', $pegawai->id) }}" class="badge bg-success text-decoration-none">
        Aktif
    </a>
</td>

                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.pegawai.show', $pegawai->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.pegawai.edit', $pegawai->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            {{-- <button type="button" class="btn btn-sm btn-danger" title="Hapus">
                                <i class="bi bi-trash3"></i>
                            </button> --}}
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada data pegawai aktif.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $pegawais->links() }}
    </div>
</div>
@endsection
