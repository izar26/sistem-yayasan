@extends('layouts.admin')

@section('title', 'Tambah Satuan Pendidikan')

@section('content')
<div class="card-header d-flex justify-content-between align-items-center">
    <span>Tambah Data Satuan Pendidikan</span>
    <a href="{{ route('admin.satuan-pendidikan.index') }}" class="btn btn-success">
        <i class="bi bi-arrow-left-circle me-2"></i>Kembali
    </a>
</div>
<div class="card-body">
    <form action="{{ route('admin.satuan-pendidikan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Satuan Pendidikan</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                   id="nama" name="nama" value="{{ old('nama') }}" required>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan Satuan Pendidikan</button>
    </form>
</div>
@endsection
