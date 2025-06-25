@extends('layouts.admin')

@section('title', 'Profil Lembaga')

@section('content')
<form action="{{ route('admin.profil-lembaga.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <!-- Kolom Kiri -->
        <div class="col-md-12">
            <div class="content-card">
                <div class="card-header">
                    <h4>Pengaturan Lembaga</h4>
                </div>
                <div class="card-body">
                    
                    {{-- Menampilkan Error Validasi --}}
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Upload Logo -->
                    <div class="mb-3">
                        <label class="form-label">Logo Preview</label>
                        <div>
                            <img src="{{ $profil->logo ? asset('storage/' . $profil->logo) : 'https://placehold.co/150x150/696cff/FFFFFF?text=Logo' }}" 
                                 alt="Logo Preview" class="img-thumbnail" width="150">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="logo" class="form-label">Upload Logo Baru</label>
                        <input class="form-control" type="file" id="logo" name="logo">
                        <div class="form-text">Diizinkan JPG atau PNG. Ukuran maks 800KB.</div>
                    </div>
                    <hr>

                    <!-- Baris 1: Nama & NPYN -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama Lembaga</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $profil->nama) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="npyn" class="form-label">NPYN</label>
                            <input type="text" class="form-control" id="npyn" name="npyn" value="{{ old('npyn', $profil->npyn) }}" required>
                        </div>
                    </div>

                    <!-- Baris 2: Tahun Berdiri & Luas -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="thn_berdiri" class="form-label">Tahun Berdiri</label>
                            <input type="date" class="form-control" id="thn_berdiri" name="thn_berdiri" value="{{ old('thn_berdiri', $profil->thn_berdiri) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="luas" class="form-label">Luas</label>
                            <input type="text" class="form-control" id="luas" name="luas" value="{{ old('luas', $profil->luas) }}" required>
                        </div>
                    </div>

                    <!-- Moto & Alamat -->
                    <div class="mb-3">
                        <label for="moto" class="form-label">Moto</label>
                        <input type="text" class="form-control" id="moto" name="moto" value="{{ old('moto', $profil->moto) }}">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ old('alamat', $profil->alamat) }}</textarea>
                    </div>

                    <!-- Baris Wilayah -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="desa" class="form-label">Desa</label>
                            <input type="text" class="form-control" id="desa" name="desa" value="{{ old('desa', $profil->desa) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $profil->kecamatan) }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kabupaten" class="form-label">Kabupaten</label>
                            <input type="text" class="form-control" id="kabupaten" name="kabupaten" value="{{ old('kabupaten', $profil->kabupaten) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="provinsi" class="form-label">Provinsi</label>
                            <input type="text" class="form-control" id="provinsi" name="provinsi" value="{{ old('provinsi', $profil->provinsi) }}" required>
                        </div>
                    </div>

                    <!-- Baris Kontak -->
                     <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kode_pos" class="form-label">Kode Pos</label>
                            <input type="text" class="form-control" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $profil->kode_pos) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="telepon" name="telepon" value="{{ old('telepon', $profil->telepon) }}" required>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fax" class="form-label">Fax</label>
                            <input type="text" class="form-control" id="fax" name="fax" value="{{ old('fax', $profil->fax) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $profil->email) }}" required>
                        </div>
                    </div>
                    
                    <!-- Baris Media Sosial -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="situs_web" class="form-label">Situs Web</label>
                            <input type="url" class="form-control" id="situs_web" name="situs_web" value="{{ old('situs_web', $profil->situs_web) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="facebook" class="form-label">Facebook</label>
                            <input type="text" class="form-control" id="facebook" name="facebook" value="{{ old('facebook', $profil->facebook) }}">
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="youtube" class="form-label">YouTube</label>
                            <input type="text" class="form-control" id="youtube" name="youtube" value="{{ old('youtube', $profil->youtube) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tiktok" class="form-label">TikTok</label>
                            <input type="text" class="form-control" id="tiktok" name="tiktok" value="{{ old('tiktok', $profil->tiktok) }}">
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
