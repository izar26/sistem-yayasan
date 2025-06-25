@extends('layouts.admin')

@section('title', 'Detail Pegawai: ' . $pegawai->nama)

@section('content')
<div class="card-header d-flex justify-content-between align-items-center">
    <span>Detail Pegawai</span>
    <div>
        <a href="{{ route('admin.pegawai.print', $pegawai->id) }}" target="_blank" class="btn btn-info">
            <i class="bi bi-printer me-2"></i>Cetak
        </a>
        <a href="{{ route('admin.pegawai.index') }}" class="btn btn-success">
            <i class="bi bi-arrow-left-circle me-2"></i>Kembali
        </a>
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-md-3 text-center">
            <img src="{{ $pegawai->photo ? asset('storage/' . $pegawai->photo) : 'https://placehold.co/200x200/696cff/FFFFFF?text=' . strtoupper(substr($pegawai->nama, 0, 1)) }}" 
                 alt="Foto {{ $pegawai->nama }}" class="img-thumbnail rounded-circle" width="200">
            <h4 class="mt-3">{{ $pegawai->nama }}</h4>
            <p class="text-muted">{{ $pegawai->jabatan }}</p>
        </div>
        <div class="col-md-9">
            <!-- Data Pribadi -->
            <h5><i class="bi bi-person-badge me-2"></i>Data Pribadi</h5>
            <table class="table table-sm table-borderless">
                <tr><th width="30%">NIK</th><td>: {{ $pegawai->nik }}</td></tr>
                <tr><th>Tempat, Tanggal Lahir</th><td>: {{ $pegawai->tmp_lahir }}, {{ \Carbon\Carbon::parse($pegawai->tgl_lahir)->isoFormat('D MMMM Y') }}</td></tr>
                <tr><th>Jenis Kelamin</th><td>: {{ $pegawai->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
                <tr><th>Agama</th><td>: {{ $pegawai->agama }}</td></tr>
                <tr><th>Kewarganegaraan</th><td>: {{ $pegawai->kewarganegaraan }}</td></tr>
            </table>
            <hr>
            <!-- Info Kepegawaian -->
            <h5><i class="bi bi-briefcase-fill me-2"></i>Info Kepegawaian</h5>
            <table class="table table-sm table-borderless">
                <tr><th width="30%">Status Pegawai</th><td>: <span class="badge bg-{{ $pegawai->status == 1 ? 'success' : 'danger' }}">{{ $pegawai->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</span></td></tr>
                <tr><th>Pendidikan Terakhir</th><td>: {{ $pegawai->jenjang_pendidikan }}</td></tr>
                <tr><th>NUPTK</th><td>: {{ $pegawai->nuptk ?? '-' }}</td></tr>
                <tr><th>NIP</th><td>: {{ $pegawai->nip ?? '-' }}</td></tr>
                <tr><th>NIPY</th><td>: {{ $pegawai->nipy ?? '-' }}</td></tr>
                <tr><th>NPWP</th><td>: {{ $pegawai->npwp ?? '-' }}</td></tr>
            </table>
            <hr>
            
            <!-- Data Keluarga & Alamat -->
            <h5><i class="bi bi-people-fill me-2"></i>Data Keluarga & Alamat</h5>
             <table class="table table-sm table-borderless">
                <tr><th width="30%">Nama Ibu Kandung</th><td>: {{ $pegawai->nama_ibu }}</td></tr>
                <tr><th>Status Pernikahan</th><td>: {{ $pegawai->status_pernikahan }}</td></tr>
                
                {{-- Logika dinamis untuk menampilkan data keluarga --}}
                @if($pegawai->status_pernikahan == 'Menikah')
                    <tr>
                        {{-- Label dinamis berdasarkan jenis kelamin --}}
                        <th>{{ $pegawai->jk == 'L' ? 'Nama Istri' : 'Nama Suami' }}</th>
                        <td>: {{ $pegawai->nama_suami_istri ?? '-' }}</td>
                    </tr>
                    <tr><th>Jumlah Anak</th><td>: {{ $pegawai->jml_anak ?? '0' }}</td></tr>
                
                @elseif($pegawai->status_pernikahan == 'Duda' || $pegawai->status_pernikahan == 'Janda')
                    {{-- Untuk Duda/Janda, HANYA tampilkan jumlah anak --}}
                    <tr><th>Jumlah Anak</th><td>: {{ $pegawai->jml_anak ?? '0' }}</td></tr>
                
                @endif
                {{-- Untuk status Lajang, tidak ada yang ditampilkan --}}
                
                <tr><th>Alamat Lengkap</th><td>: {{ $pegawai->alamat }}, {{ $pegawai->desa }}, {{ $pegawai->kecamatan }}, {{ $pegawai->kabupaten }}, {{ $pegawai->provinsi }} {{ $pegawai->kode_pos }}</td></tr>
                <tr><th>Kontak</th><td>: {{ $pegawai->kontak ?? '-' }}</td></tr>
            </table>
        </div>
    </div>
</div>
@endsection
