@extends('layouts.admin')

@section('title', 'Tambah Data Nomor Surat')

@section('content')
<div class="card-header d-flex justify-content-between align-items-center">
    <span>Tambah Data Nomor Surat</span>
    <a href="{{ route('admin.nomor-surat.index') }}" class="btn btn-success">
        <i class="bi bi-arrow-left-circle me-2"></i>Kembali
    </a>
</div>
<div class="card-body">
    <form action="{{ route('admin.nomor-surat.store') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Baris 1 -->
            <div class="col-md-6 mb-3">
                <label for="id_tapel" class="form-label">Tahun Pelajaran (Tapel)</label>
                <select class="form-select @error('id_tapel') is-invalid @enderror" id="id_tapel" name="id_tapel" required>
                    <option value="">Pilih Tahun Pelajaran</option>
                    @foreach($tapels as $tapel)
                        <option value="{{ $tapel->id }}" @if($tapel->status == 1) selected @endif>
                            {{ $tapel->tapel }} {{ $tapel->status == 1 ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
                @error('id_tapel')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="no_surat" class="form-label">Nomor Surat</label>
                <input type="text" class="form-control @error('no_surat') is-invalid @enderror" 
                       id="no_surat" name="no_surat" value="{{ old('no_surat') }}" required>
                @error('no_surat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Baris 2 -->
            <div class="col-md-12 mb-3">
                <label for="nama_pimpinan" class="form-label">Nama Pimpinan</label>
                <input type="text" class="form-control @error('nama_pimpinan') is-invalid @enderror" 
                       id="nama_pimpinan" name="nama_pimpinan" value="{{ old('nama_pimpinan') }}" required>
                @error('nama_pimpinan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Baris 3 -->
            <div class="col-md-6 mb-3">
                <label for="tgl_sp" class="form-label">Tanggal SP</label>
                <input type="date" class="form-control @error('tgl_sp') is-invalid @enderror" 
                       id="tgl_sp" name="tgl_sp" value="{{ old('tgl_sp') }}" required>
                @error('tgl_sp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="tmt" class="form-label">TMT (Terhitung Mulai Tanggal)</label>
                <input type="date" class="form-control @error('tmt') is-invalid @enderror" 
                       id="tmt" name="tmt" value="{{ old('tmt') }}" required>
                @error('tmt')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection