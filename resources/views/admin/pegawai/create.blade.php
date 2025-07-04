@extends('layouts.admin')

@section('title', 'Tambah Data Pegawai')

@section('content')
<div class="card-header d-flex justify-content-between align-items-center">
    <span>Tambah Data Pegawai</span>
    <a href="{{ route('admin.pegawai.index') }}" class="btn btn-success mb-2">
        <i class="bi bi-arrow-left-circle me-2"></i>Kembali
    </a>
</div>
<div class="card-body">
    {{-- Menampilkan Error Validasi --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <p><strong>Oops!</strong> Terdapat beberapa masalah dengan input Anda.</p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.pegawai.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        {{-- BAGIAN 1: IDENTITAS UTAMA --}}
        <div class="row mb-12 align-items-center">
            <div class="col-md-4"></div>
            <div class="col-md-3 text-center">
                <label class="form-label">Foto Pegawai</label>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-3 text-center">
                <img src="https://placehold.co/200x200/696cff/FFFFFF?text=Foto" alt="Foto Preview" class="img-thumbnail rounded-circle mb-2" id="photo-preview" width="180" height="180">
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-3 text-center">
                <input class="form-control form-control-sm" type="file" id="photo" name="photo" onchange="previewImage()">
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-3 text-center">
                <div class="form-text">Ukuran maks 1MB.</div>
            </div>
            <div class="col-md-4"></div>
        </div>
        <hr>
        
        {{-- BAGIAN 2: DATA PRIBADI & KEPENDIDIKAN --}}
        <h5 class="mb-3">A. Data Pribadi & Kependidikan</h5>
        <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">Nama Lengkap (dengan gelar)</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
    <label for="status_kepegawaian" class="form-label">Status Kepegawaian</label>
    <select class="form-select" id="status_kepegawaian" name="status_kepegawaian" required>
        <option value="">Pilih Status...</option>
        <option value="Pendidik" {{ old('status_kepegawaian') == 'Pendidik' ? 'selected' : '' }}>Pendidik</option>
        <option value="Tenaga Kependidikan" {{ old('status_kepegawaian') == 'Tenaga Kependidikan' ? 'selected' : '' }}>Tenaga Kependidikan</option>
    </select>
</div>

             <div class="col-md-6 mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                 <select class="form-select" id="kewarganegaraan" name="kewarganegaraan" required>
                    <option value="">Pilih Kewarganegaraan</option>
                    <option value="WNI" @if(old('kewarganegaraan') == 'WNI') selected @endif>Warga Negara Indonesia (WNI)</option>
                    <option value="WNA" @if(old('kewarganegaraan') == 'WNA') selected @endif>Warga Negara Asing (WNA)</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="tmp_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="tmp_lahir" name="tmp_lahir" value="{{ old('tmp_lahir') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="jk" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jk" name="jk" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L" @if(old('jk') == 'L') selected @endif>Laki-laki</option>
                    <option value="P" @if(old('jk') == 'P') selected @endif>Perempuan</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="agama" class="form-label">Agama</label>
                <select class="form-select" id="agama" name="agama" required>
                    <option value="">Pilih Agama</option>
                    <option value="Islam" @if(old('agama') == 'Islam') selected @endif>Islam</option>
                    <option value="Kristen" @if(old('agama') == 'Kristen') selected @endif>Kristen</option>
                    <option value="Katolik" @if(old('agama') == 'Katolik') selected @endif>Katolik</option>
                    <option value="Buddha" @if(old('agama') == 'Buddha') selected @endif>Buddha</option>
                    <option value="Hindu" @if(old('agama') == 'Hindu') selected @endif>Hindu</option>
                </select>
            </div>
             <div class="col-md-6 mb-3">
                <label for="jenjang_pendidikan" class="form-label">Pendidikan Terakhir</label>
                <input type="text" class="form-control" id="jenjang_pendidikan" name="jenjang_pendidikan" value="{{ old('jenjang_pendidikan') }}" required>
            </div>
             <div class="col-md-6 mb-3">
                <label for="id_satuan_pendidikan" class="form-label">Satuan Pendidikan</label>
    <select class="form-select @error('id_satuan_pendidikan') is-invalid @enderror" name="id_satuan_pendidikan" id="id_satuan_pendidikan" required>
        <option value="">Pilih Satuan Pendidikan...</option>
        @foreach($satuanPendidikans as $sp)
            <option value="{{ $sp->id }}" {{ old('id_satuan_pendidikan', $pegawai->id_satuan_pendidikan ?? '') == $sp->id ? 'selected' : '' }}>
                {{ $sp->nama }}
            </option>
        @endforeach
    </select>
    @error('id_satuan_pendidikan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
            </div>
        </div>
        <hr>

        {{-- BAGIAN 3: NOMOR INDUK KEPEGAWAIAN --}}
        <h5 class="mb-3">B. Data Kepegawaian</h5>
        <div class="row">
             <div class="col-md-6 mb-3">
                <label for="nuptk" class="form-label">NUPTK</label>
                <input type="text" class="form-control" id="nuptk" name="nuptk" value="{{ old('nuptk') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="nipy" class="form-label">NIPY</label>
                <input type="text" class="form-control" id="nipy" name="nipy" value="{{ old('nipy') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="npwp" class="form-label">NPWP</label>
                <input type="text" class="form-control" id="npwp" name="npwp" value="{{ old('npwp') }}">
            </div>
        </div>
        <hr>

        {{-- BAGIAN 4: DATA KELUARGA --}}
        <h5 class="mb-3">C. Data Keluarga</h5>
        <div class="row">
             <div class="col-md-6 mb-3">
                <label for="nama_ibu" class="form-label">Nama Ibu Kandung</label>
                <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="status_pernikahan" class="form-label">Status Pernikahan</label>
                <select class="form-select" id="status_pernikahan" name="status_pernikahan" required>
                    <option value="">Pilih Status</option>
                    <option value="Lajang" @if(old('status_pernikahan') == 'Lajang') selected @endif>Lajang</option>
                    <option value="Menikah" @if(old('status_pernikahan') == 'Menikah') selected @endif>Menikah</option>
                    <option value="Duda" @if(old('status_pernikahan') == 'Duda') selected @endif>Duda</option>
                    <option value="Janda" @if(old('status_pernikahan') == 'Janda') selected @endif>Janda</option>
                </select>
            </div>
            {{-- Form Dinamis --}}
            <div class="col-md-6 mb-3" id="pasangan_field_container">
                <label for="nama_suami_istri" class="form-label">Nama Suami/Istri</label>
                <input type="text" class="form-control" id="nama_suami_istri" name="nama_suami_istri" value="{{ old('nama_suami_istri') }}">
            </div>
             <div class="col-md-6 mb-3" id="anak_field_container">
                <label for="jml_anak" class="form-label">Jumlah Anak</label>
                <input type="number" class="form-control" id="jml_anak" name="jml_anak" value="{{ old('jml_anak') }}">
            </div>
        </div>
        <hr>

        {{-- BAGIAN 5: ALAMAT & KONTAK --}}
        <h5 class="mb-3">D. Alamat & Kontak</h5>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat Lengkap</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
           value="{{ old('email', $pegawai->email ?? '') }}">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

            <div class="col-md-6 mb-3">
                <label for="desa" class="form-label">Desa</label>
                <input type="text" class="form-control" id="desa" name="desa" value="{{ old('desa') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="kabupaten" class="form-label">Kabupaten</label>
                <input type="text" class="form-control" id="kabupaten" name="kabupaten" value="{{ old('kabupaten') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="provinsi" class="form-label">Provinsi</label>
                <input type="text" class="form-control" id="provinsi" name="provinsi" value="{{ old('provinsi') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="kode_pos" class="form-label">Kode Pos</label>
                <input type="text" class="form-control" id="kode_pos" name="kode_pos" value="{{ old('kode_pos') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="kontak" class="form-label">Kontak (HP/Telepon)</label>
                <input type="text" class="form-control" id="kontak" name="kontak" value="{{ old('kontak') }}">
            </div>
        </div>
        <hr>

        <div class="d-grid mt-4">
             <button type="submit" class="btn btn-primary">Simpan Data Pegawai</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Fungsi untuk menampilkan preview gambar
    function previewImage() {
        const image = document.querySelector('#photo');
        const imgPreview = document.querySelector('#photo-preview');
        imgPreview.style.display = 'block';
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }

    // Fungsi untuk form dinamis status pernikahan
    document.addEventListener('DOMContentLoaded', function () {
        const statusPernikahan = document.getElementById('status_pernikahan');
        const pasanganContainer = document.getElementById('pasangan_field_container');
        const anakContainer = document.getElementById('anak_field_container');

        function toggleMaritalFields() {
            const status = statusPernikahan.value;

            // Logika untuk field Nama Suami/Istri
            if (status === 'Menikah') {
                pasanganContainer.style.display = 'block';
            } else {
                pasanganContainer.style.display = 'none';
            }

            // Logika untuk field Jumlah Anak
            if (status === 'Lajang' || status === '') {
                anakContainer.style.display = 'none';
            } else {
                anakContainer.style.display = 'block';
            }
        }
        
        // Jalankan saat halaman dimuat untuk memeriksa nilai awal
        toggleMaritalFields();
        // Jalankan saat pilihan berubah
        statusPernikahan.addEventListener('change', toggleMaritalFields);
    });
</script>
@endpush
