@extends('layouts.admin')

@section('title', 'Form Alasan Pegawai Keluar')

@section('content')
<div class="card">
    <div class="card-header">
        Form Alasan Pegawai Keluar
    </div>
    <div class="card-body">
        @if($pegawai)
        <form action="{{ url('admin/pegawai/' . $pegawai->id . '/keluar') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Pegawai</label>
                <input type="text" class="form-control" value="{{ $pegawai->nama }}" disabled>
            </div>
            <div class="mb-3">
                <label for="alasan" class="form-label">Alasan Keluar</label>
                <select class="form-select" name="alasan" id="alasan" required>
    <option value="">Pilih Alasan...</option>
    <option value="Mutasi">Mutasi</option> <!-- ✅ ini yang benar -->
    <option value="Dikeluarkan">Dikeluarkan</option>
    <option value="Mengundurkan Diri">Mengundurkan Diri</option>
    <option value="Wafat">Wafat</option>
    <option value="Hilang">Hilang</option>
    <option value="Alih Fungsi">Alih Fungsi</option>
    <option value="Pensiun">Pensiun</option>
</select>

            </div>
            <button type="submit" class="btn btn-danger">Simpan Alasan & Nonaktifkan</button>
        </form>
        @else
<div class="alert alert-danger">Data pegawai tidak ditemukan.</div>
@endif
    </div>
</div>
@endsection
