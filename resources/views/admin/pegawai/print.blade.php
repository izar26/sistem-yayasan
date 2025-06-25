<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Pegawai - {{ $pegawai->nama }}</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body { 
            background-color: #fff; 
            font-size: 12pt;
        }
        .print-container { max-width: 800px; margin: auto; }
        .kop-surat { text-align: center; border-bottom: 3px double #000; padding-bottom: 1rem; margin-bottom: 2rem; }
        .kop-surat h3, .kop-surat h4 { margin: 0; }
        .table-data td, .table-data th { padding: 0.4rem; vertical-align: top;}
        .table-sm th[width="35%"] { width: 35% !important; } /* Memaksa lebar kolom */
        @media print {
            .print-container { padding: 0; }
            body { font-size: 11pt; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="print-container">
        <div class="kop-surat">
            {{-- Anda bisa mengambil nama lembaga dari DB nanti --}}
            <h3>YAYASAN NURUL ISLAM AFFANDIYAH</h3>
            <h4>DATA POKOK TENAGA PENDIDIK & KEPENDIDIKAN</h4>
        </div>

        <div class="row">
            <div class="col-8">
                <table class="table table-sm table-bordered">
                    <tr><th width="35%">Nama Lengkap</th><td>: {{ $pegawai->nama }}</td></tr>
                    <tr><th>NIK</th><td>: {{ $pegawai->nik }}</td></tr>
                    <tr><th>Tempat, Tgl Lahir</th><td>: {{ $pegawai->tmp_lahir }}, {{ \Carbon\Carbon::parse($pegawai->tgl_lahir)->isoFormat('D MMMM Y') }}</td></tr>
                    <tr><th>Jenis Kelamin</th><td>: {{ $pegawai->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
                    <tr><th>Jabatan</th><td>: {{ $pegawai->jabatan }}</td></tr>
                    <tr><th>Pendidikan Terakhir</th><td>: {{ $pegawai->jenjang_pendidikan }}</td></tr>
                    <tr><th>NUPTK</th><td>: {{ $pegawai->nuptk ?? '-' }}</td></tr>
                    <tr><th>NIPY</th><td>: {{ $pegawai->nipy ?? '-' }}</td></tr>
                    <tr><th>Status Pernikahan</th><td>: {{ $pegawai->status_pernikahan }}</td></tr>
                    
                    {{-- Logika dinamis untuk data keluarga di halaman cetak --}}
                    @if($pegawai->status_pernikahan == 'Menikah')
                        <tr>
                            <th>{{ $pegawai->jk == 'L' ? 'Nama Istri' : 'Nama Suami' }}</th>
                            <td>: {{ $pegawai->nama_suami_istri ?? '-' }}</td>
                        </tr>
                        <tr><th>Jumlah Anak</th><td>: {{ $pegawai->jml_anak ?? '0' }}</td></tr>
                    
                    @elseif($pegawai->status_pernikahan == 'Duda' || $pegawai->status_pernikahan == 'Janda')
                        <tr><th>Jumlah Anak</th><td>: {{ $pegawai->jml_anak ?? '0' }}</td></tr>
                    
                    @endif
                    
                    <tr><th>Alamat</th><td>: {{ $pegawai->alamat }}, {{ $pegawai->desa }}</td></tr>
                </table>
            </div>
            <div class="col-4 text-center">
                <p class="mb-1">Foto Pegawai</p>
                <img src="{{ $pegawai->photo ? asset('storage/' . $pegawai->photo) : 'https://placehold.co/150x200/6c757d/FFFFFF?text=Foto' }}" 
                     alt="Foto {{ $pegawai->nama }}" class="img-thumbnail" width="150">
            </div>
        </div>
        
    </div>
</body>
</html>
