@extends('layouts.admin')

@section('title', 'Detail Pegawai: ' . $pegawai->nama)

@section('content')
<div class="card shadow-sm border-0 p-4">
    <div class="text-center mb-4">
        <img src="{{ $pegawai->photo ? asset('storage/' . $pegawai->photo) : 'https://placehold.co/180x180?text=' . strtoupper(substr($pegawai->nama, 0, 1)) }}"
             alt="Foto {{ $pegawai->nama }}" class="img-thumbnail rounded" width="180">
        <h4 class="mt-3">{{ $pegawai->nama }}</h4>
        <span class="badge bg-{{ $pegawai->status == 1 ? 'success' : 'danger' }}">
            {{ $pegawai->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
        </span>
    </div>
    <!-- Informasi Pribadi -->
    <h5 class="mb-3"><i class="bi bi-person-circle me-2"></i>Data Pribadi</h5>
    <ul class="list-group list-group-flush mb-4">
        <li class="list-group-item">NAMA LENGKAP: {{ $pegawai->nama }}</li>
        <li class="list-group-item">NIK: {{ $pegawai->nik }}</li>
        <li class="list-group-item">Tempat, Tanggal Lahir: {{ $pegawai->tmp_lahir }}, {{ \Carbon\Carbon::parse($pegawai->tgl_lahir)->isoFormat('D MMMM Y') }}</li>
        <li class="list-group-item">Jenis Kelamin: {{ $pegawai->jk === 'L' ? 'Laki-laki' : 'Perempuan' }}</li>
        <li class="list-group-item">Agama: {{ $pegawai->agama }}</li>
        <li class="list-group-item">Kewarganegaraan: {{ $pegawai->kewarganegaraan }}</li>
        <li class="list-group-item">Email: {{ $pegawai->email ?? '-' }}</li>
    </ul>

    <!-- Informasi Kepegawaian -->
    <h5 class="mb-3"><i class="bi bi-briefcase me-2"></i>Info Kepegawaian</h5>
    <ul class="list-group list-group-flush mb-4">
        <li class="list-group-item">Pendidikan Terakhir: {{ $pegawai->jenjang_pendidikan }}</li>
        <li class="list-group-item">NUPTK: {{ $pegawai->nuptk ?? '-' }}</li>
        <li class="list-group-item">NIP: {{ $pegawai->nip ?? '-' }}</li>
        <li class="list-group-item">NIPY: {{ $pegawai->nipy ?? '-' }}</li>
        <li class="list-group-item">NPWP: {{ $pegawai->npwp ?? '-' }}</li>
        <li class="list-group-item">Status Kepegawaian: {{ $pegawai->status_kepegawaian ?? '-' }}</li>
        <li class="list-group-item">Satuan Pendidikan: {{ $pegawai->satuanPendidikan->nama ?? '-' }}</li>
    </ul>

    <!-- Informasi Keluarga & Alamat -->
    <h5 class="mb-3"><i class="bi bi-house-door me-2"></i>Data Keluarga & Alamat</h5>
    <ul class="list-group list-group-flush mb-4">
        <li class="list-group-item">Nama Ibu Kandung: {{ $pegawai->nama_ibu }}</li>
        <li class="list-group-item">Status Pernikahan: {{ $pegawai->status_pernikahan }}</li>

        @if($pegawai->status_pernikahan == 'Menikah')
            <li class="list-group-item">
                {{ $pegawai->jk == 'L' ? 'Nama Istri' : 'Nama Suami' }}: {{ $pegawai->nama_suami_istri ?? '-' }}
            </li>
            <li class="list-group-item">Jumlah Anak: {{ $pegawai->jml_anak ?? '0' }}</li>
        @elseif(in_array($pegawai->status_pernikahan, ['Duda', 'Janda']))
            <li class="list-group-item">Jumlah Anak: {{ $pegawai->jml_anak ?? '0' }}</li>
        @endif

        <li class="list-group-item">
            Alamat: {{ $pegawai->alamat }}, {{ $pegawai->desa }}, {{ $pegawai->kecamatan }},
            {{ $pegawai->kabupaten }}, {{ $pegawai->provinsi }} {{ $pegawai->kode_pos }}
        </li>
        <li class="list-group-item">Kontak: {{ $pegawai->kontak ?? '-' }}</li>
    </ul>

    <!-- Footer Tanggal -->
    <div class="mt-5 text-end">
        <p class="mb-0">Cianjur, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
    </div>
    <div class="text-center mt-4">
    <a href="{{ route('admin.pegawai.index') }}" class="btn btn-success me-2">
        <i class="bi bi-arrow-left-circle me-1"></i> Kembali
    </a>
    <a href="{{ route('admin.pegawai.print', $pegawai->id) }}" target="_blank" class="btn btn-info">
        <i class="bi bi-printer me-1"></i> Cetak
    </a>
</div>
</div>
@endsection
