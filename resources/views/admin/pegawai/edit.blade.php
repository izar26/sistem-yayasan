@extends('layouts.admin')

@section('title', 'Edit Data Pegawai')

@section('content')
<div class="card-header d-flex justify-content-between align-items-center">
    <span>Edit Data Pegawai</span>
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

    <form action="{{ route('admin.pegawai.update', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- BAGIAN 1: IDENTITAS UTAMA --}}
        <div class="row mb-12 align-items-center">
            <div class="col-md-4"></div>
            <div class="col-md-3 text-center">
                <label class="form-label">Foto Pegawai</label>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-3 text-center">
                <img src="{{ $pegawai->photo ? asset('storage/' . $pegawai->photo) : 'https://placehold.co/200x200/696cff/FFFFFF?text=Foto' }}" 
                     alt="Foto Preview" class="img-thumbnail rounded-circle mb-2" id="photo-preview" width="180" height="180">
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-3 text-center">
                <input class="form-control form-control-sm @error('photo') is-invalid @enderror" type="file" id="photo" name="photo" onchange="previewImage()">
                @error('photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $pegawai->nama) }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
    <label for="status_kepegawaian" class="form-label">Status Kepegawaian</label>
    <select class="form-select" id="status_kepegawaian" name="status_kepegawaian" required>
        <option value="">Pilih Status...</option>
        <option value="Pendidik" {{ old('status_kepegawaian', $pegawai->status_kepegawaian) == 'Pendidik' ? 'selected' : '' }}>Pendidik</option>
        <option value="Tenaga Kependidikan" {{ old('status_kepegawaian', $pegawai->status_kepegawaian) == 'Tenaga Kependidikan' ? 'selected' : '' }}>Tenaga Kependidikan</option>
    </select>
</div>


            <div class="col-md-6 mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $pegawai->nik) }}" required>
                @error('nik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                <select class="form-select @error('kewarganegaraan') is-invalid @enderror" id="kewarganegaraan" name="kewarganegaraan" required>
                    <option value="">Pilih Kewarganegaraan</option>
                    <option value="WNI" {{ old('kewarganegaraan', $pegawai->kewarganegaraan) == 'WNI' ? 'selected' : '' }}>Warga Negara Indonesia (WNI)</option>
                    <option value="WNA" {{ old('kewarganegaraan', $pegawai->kewarganegaraan) == 'WNA' ? 'selected' : '' }}>Warga Negara Asing (WNA)</option>
                </select>
                @error('kewarganegaraan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="tmp_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control @error('tmp_lahir') is-invalid @enderror" id="tmp_lahir" name="tmp_lahir" value="{{ old('tmp_lahir', $pegawai->tmp_lahir) }}" required>
                @error('tmp_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control @error('tgl_lahir') is-invalid @enderror" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir', $pegawai->tgl_lahir?->format('Y-m-d')) }}" required>
                @error('tgl_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="jk" class="form-label">Jenis Kelamin</label>
                <select class="form-select @error('jk') is-invalid @enderror" id="jk" name="jk" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L" {{ old('jk', $pegawai->jk) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jk', $pegawai->jk) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="agama" class="form-label">Agama</label>
                <select class="form-select @error('agama') is-invalid @enderror" id="agama" name="agama" required>
                    <option value="">Pilih Agama</option>
                    <option value="Islam" {{ old('agama', $pegawai->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                    <option value="Kristen" {{ old('agama', $pegawai->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                    <option value="Katolik" {{ old('agama', $pegawai->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                    <option value="Buddha" {{ old('agama', $pegawai->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                    <option value="Hindu" {{ old('agama', $pegawai->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                </select>
                @error('agama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="jenjang_pendidikan" class="form-label">Pendidikan Terakhir</label>
                <input type="text" class="form-control @error('jenjang_pendidikan') is-invalid @enderror" id="jenjang_pendidikan" name="jenjang_pendidikan" value="{{ old('jenjang_pendidikan', $pegawai->jenjang_pendidikan) }}" required>
                @error('jenjang_pendidikan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="id_satuan_pendidikan" class="form-label">Satuan Pendidikan</label>
                <select class="form-select @error('id_satuan_pendidikan') is-invalid @enderror" name="id_satuan_pendidikan" id="id_satuan_pendidikan" required>
                    <option value="">Pilih Satuan Pendidikan...</option>
                    @foreach($satuanPendidikans as $sp)
                        <option value="{{ $sp->id }}" {{ old('id_satuan_pendidikan', $pegawai->id_satuan_pendidikan) == $sp->id ? 'selected' : '' }}>
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
                <input type="text" class="form-control @error('nuptk') is-invalid @enderror" id="nuptk" name="nuptk" value="{{ old('nuptk', $pegawai->nuptk) }}">
                @error('nuptk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip', $pegawai->nip) }}">
                @error('nip')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="nipy" class="form-label">NIPY</label>
                <input type="text" class="form-control @error('nipy') is-invalid @enderror" id="nipy" name="nipy" value="{{ old('nipy', $pegawai->nipy) }}">
                @error('nipy')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="npwp" class="form-label">NPWP</label>
                <input type="text" class="form-control @error('npwp') is-invalid @enderror" id="npwp" name="npwp" value="{{ old('npwp', $pegawai->npwp) }}">
                @error('npwp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <hr>

        {{-- BAGIAN 4: DATA KELUARGA --}}
        <h5 class="mb-3">C. Data Keluarga</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama_ibu" class="form-label">Nama Ibu Kandung</label>
                <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu', $pegawai->nama_ibu) }}" required>
                @error('nama_ibu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="status_pernikahan" class="form-label">Status Pernikahan</label>
                <select class="form-select @error('status_pernikahan') is-invalid @enderror" id="status_pernikahan" name="status_pernikahan" required>
                    <option value="">Pilih Status</option>
                    <option value="Lajang" {{ old('status_pernikahan', $pegawai->status_pernikahan) == 'Lajang' ? 'selected' : '' }}>Lajang</option>
                    <option value="Menikah" {{ old('status_pernikahan', $pegawai->status_pernikahan) == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                    <option value="Duda" {{ old('status_pernikahan', $pegawai->status_pernikahan) == 'Duda' ? 'selected' : '' }}>Duda</option>
                    <option value="Janda" {{ old('status_pernikahan', $pegawai->status_pernikahan) == 'Janda' ? 'selected' : '' }}>Janda</option>
                </select>
                @error('status_pernikahan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3" id="pasangan_field_container">
                <label for="nama_suami_istri" class="form-label">Nama Suami/Istri</label>
                <input type="text" class="form-control @error('nama_suami_istri') is-invalid @enderror" id="nama_suami_istri" name="nama_suami_istri" value="{{ old('nama_suami_istri', $pegawai->nama_suami_istri) }}">
                @error('nama_suami_istri')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3" id="anak_field_container">
                <label for="jml_anak" class="form-label">Jumlah Anak</label>
                <input type="number" class="form-control @error('jml_anak') is-invalid @enderror" id="jml_anak" name="jml_anak" value="{{ old('jml_anak', $pegawai->jml_anak) }}">
                @error('jml_anak')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <hr>

        {{-- BAGIAN 5: ALAMAT & KONTAK --}}
        <h5 class="mb-3">D. Alamat & Kontak</h5>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat Lengkap</label>
            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $pegawai->alamat) }}</textarea>
            @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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
                <input type="text" class="form-control @error('desa') is-invalid @enderror" id="desa" name="desa" value="{{ old('desa', $pegawai->desa) }}" required>
                @error('desa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <input type="text" class="form-control @error('kecamatan') is-invalid @enderror" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $pegawai->kecamatan) }}" required>
                @error('kecamatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="kabupaten" class="form-label">Kabupaten</label>
                <input type="text" class="form-control @error('kabupaten') is-invalid @enderror" id="kabupaten" name="kabupaten" value="{{ old('kabupaten', $pegawai->kabupaten) }}" required>
                @error('kabupaten')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="provinsi" class="form-label">Provinsi</label>
                <input type="text" class="form-control @error('provinsi') is-invalid @enderror" id="provinsi" name="provinsi" value="{{ old('provinsi', $pegawai->provinsi) }}" required>
                @error('provinsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="kode_pos" class="form-label">Kode Pos</label>
                <input type="text" class="form-control @error('kode_pos') is-invalid @enderror" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $pegawai->kode_pos) }}" required>
                @error('kode_pos')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="kontak" class="form-label">Kontak (HP/Telepon)</label>
                <input type="text" class="form-control @error('kontak') is-invalid @enderror" id="kontak" name="kontak" value="{{ old('kontak', $pegawai->kontak) }}">
                @error('kontak')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <hr>

        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary">Update Data Pegawai</button>
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

            if (status === 'Menikah') {
                pasanganContainer.style.display = 'block';
            } else {
                pasanganContainer.style.display = 'none';
            }

            if (status === 'Lajang' || status === '') {
                anakContainer.style.display = 'none';
            } else {
                anakContainer.style.display = 'block';
            }
        }

        toggleMaritalFields();
        statusPernikahan.addEventListener('change', toggleMaritalFields);
    });
</script>
@endpush
