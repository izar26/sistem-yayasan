<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Data Pegawai</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            margin: 40px;
            color: #000;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .foto {
            text-align: center;
            margin-bottom: 20px;
        }

        .foto img {
            width: 120px;
            height: 150px;
            object-fit: cover;
            border: 1px solid #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td, th {
            padding: 6px 10px;
            vertical-align: top;
        }

        .label {
            width: 30%;
            font-weight: bold;
        }

        .footer {
            text-align: right;
            margin-top: 50px;
        }

        @media print {
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <h2>Data Pegawai</h2>

    <div class="foto">
        <img src="{{ $pegawai->photo ? asset('storage/' . $pegawai->photo) : 'https://placehold.co/120x150?text=Foto' }}" alt="Foto Pegawai">
    </div>

    <table>
        <tr><td class="label">Nama</td><td>: {{ $pegawai->nama }}</td></tr>
        <tr><td class="label">NIK</td><td>: {{ $pegawai->nik }}</td></tr>
        <tr><td class="label">Tempat, Tgl Lahir</td><td>: {{ $pegawai->tmp_lahir }}, {{ \Carbon\Carbon::parse($pegawai->tgl_lahir)->isoFormat('D MMMM Y') }}</td></tr>
        <tr><td class="label">Jenis Kelamin</td><td>: {{ $pegawai->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
        <tr><td class="label">Agama</td><td>: {{ $pegawai->agama }}</td></tr>
        <tr><td class="label">Kewarganegaraan</td><td>: {{ $pegawai->kewarganegaraan }}</td></tr>
        <tr><td class="label">Status Kepegawaian</td><td>: {{ $pegawai->status_kepegawaian }}</td></tr>
        <tr><td class="label">Pendidikan</td><td>: {{ $pegawai->jenjang_pendidikan }}</td></tr>
        <tr><td class="label">NUPTK</td><td>: {{ $pegawai->nuptk ?? '-' }}</td></tr>
        <tr><td class="label">NIP</td><td>: {{ $pegawai->nip ?? '-' }}</td></tr>
        <tr><td class="label">NIPY</td><td>: {{ $pegawai->nipy ?? '-' }}</td></tr>
        <tr><td class="label">NPWP</td><td>: {{ $pegawai->npwp ?? '-' }}</td></tr>
        <tr><td class="label">Nama Ibu</td><td>: {{ $pegawai->nama_ibu }}</td></tr>
        <tr><td class="label">Status Pernikahan</td><td>: {{ $pegawai->status_pernikahan }}</td></tr>

        @if($pegawai->status_pernikahan == 'Menikah')
        <tr><td class="label">{{ $pegawai->jk == 'L' ? 'Nama Istri' : 'Nama Suami' }}</td><td>: {{ $pegawai->nama_suami_istri ?? '-' }}</td></tr>
        <tr><td class="label">Jumlah Anak</td><td>: {{ $pegawai->jml_anak ?? '0' }}</td></tr>
        @elseif(in_array($pegawai->status_pernikahan, ['Duda', 'Janda']))
        <tr><td class="label">Jumlah Anak</td><td>: {{ $pegawai->jml_anak ?? '0' }}</td></tr>
        @endif

        <tr><td class="label">Alamat</td><td>: {{ $pegawai->alamat }}, {{ $pegawai->desa }}, {{ $pegawai->kecamatan }}, {{ $pegawai->kabupaten }}, {{ $pegawai->provinsi }} {{ $pegawai->kode_pos }}</td></tr>
        <tr><td class="label">Kontak</td><td>: {{ $pegawai->kontak ?? '-' }}</td></tr>
        <tr><td class="label">Status</td>
            <td>: {{ $pegawai->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>{{ $pegawai->kabupaten }}, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Admin</p>
        <br><br>
        <p>_______________________</p>
    </div>

    <script>
        window.print();
    </script>

</body>
</html>
