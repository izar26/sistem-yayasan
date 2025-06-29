@extends('layouts.admin')

@section('title', 'Edit Tahun Pelajaran')

@section('content')
<div class="card-header d-flex justify-content-between align-items-center">
    <span>Edit Data Tapel</span>
    <a href="{{ route('admin.tahun-pelajaran.index') }}" class="btn btn-success mb-2">
        <i class="bi bi-arrow-left-circle me-2"></i>Kembali
    </a>
</div>
<div class="card-body">
    <form action="{{ route('admin.tahun-pelajaran.update', $tahunPelajaran->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="tapel" class="form-label">Tahun Pelajaran (Contoh: 2024/2025)</label>
                <input type="text" class="form-control @error('tapel') is-invalid @enderror" 
                       id="tapel" name="tapel" value="{{ old('tapel', $tahunPelajaran->tapel) }}" required>
                @error('tapel')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="ket" class="form-label">Keterangan</label>
                <input type="text" class="form-control @error('ket') is-invalid @enderror" 
                       id="ket" name="ket" value="{{ old('ket', $tahunPelajaran->ket) }}">
                @error('ket')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
