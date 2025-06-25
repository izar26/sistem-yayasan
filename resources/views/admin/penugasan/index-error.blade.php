@extends('layouts.admin')
@section('title', 'Kesalahan Penugasan')
@section('content')
<div class="alert alert-danger text-center">
    <h4 class="alert-heading">Aksi Diperlukan!</h4>
    <p>{{ $message }}</p>
    <hr>
    <a href="{{ route('admin.tahun-pelajaran.index') }}" class="btn btn-danger">Buka Halaman Tahun Pelajaran</a>
</div>
@endsection