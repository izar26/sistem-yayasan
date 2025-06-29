<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Surat Keputusan - {{ $penugasan->pegawai->nama }}</title>
  <style>
    body {
      font-family: 'Times New Roman', Times, serif;
      font-size: 11pt;
      margin: 0;
      background-color: #e0e0e0;
      display: flex;
      justify-content: center;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .page {
      width: 21cm;
      min-height: 29.7cm;
      background: white;
      margin: 0.5cm auto;
      padding: 5cm 2cm 1cm 2cm; /* Ruang header fisik */
      box-sizing: border-box;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    h1, h2, h3, p, ol, ul, table {
      margin: 0;
      padding: 0;
    }

    .surat-header {
      text-align: center;
      margin-bottom: 8px;
    }

    .judul {
      font-size: 13pt;
      font-weight: bold;
      text-transform: uppercase;
      text-decoration: underline;
    }

    .nomor-surat {
      margin-top: 2px;
    }

    .tentang-block {
      text-align: center;
      margin: 10px 0 12px;
      line-height: 1.1;
    }

    .tentang-block p {
      font-weight: bold;
      text-transform: uppercase;
    }

    .pemimpin {
      text-align: center;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .konsideran, .pasal {
      margin-top: 6px;
      line-height: 1.05;
    }

    .konsideran-table, .pasal-table {
      width: 100%;
    }

    .konsideran-table td, .pasal-table td {
      vertical-align: top;
      padding-bottom: 1pt;
    }

    .konsideran-table td:first-child,
    .pasal-table td:first-child {
      width: 17%;
    }

    .konsideran-table td:nth-child(2),
    .pasal-table td:nth-child(2) {
      width: 2%;
    }

    .konsideran-table ol,
    .pasal-table ol {
      padding-left: 18px;
    }

    .konsideran-table ol li,
    .pasal-table ol li {
      padding-bottom: 1pt;
    }

    .diktum {
      text-align: center;
      font-weight: bold;
      font-size: 12pt;
      letter-spacing: 3px; /* Untuk tampilan M E M U T U S K A N */
      margin: 10px 0;
    }

    .pasal-table ul {
      list-style: none;
      line-height: 1.05;
      margin-top: 3px;
      padding-left: 0;
    }

    .pasal-table li {
      padding-bottom: 1pt;
    }

    .pasal-table span {
      display: inline-block;
      width: 160px;
    }

    .tanda-tangan-container {
      width: 100%;
      margin-top: 6px;
    }

    .tanda-tangan {
      float: right;
      width: 45%;
      font-size: 10.5pt;
      line-height: 1.2;
      text-align: left;
    }

    .clearfix::after {
      content: "";
      display: table;
      clear: both;
    }

    .tembusan {
      font-size: 10pt;
      line-height: 1.1;
      margin-top: 10px;
    }

    .tembusan p {
      font-weight: bold;
      text-decoration: underline;
      margin-bottom: 3px;
    }

    .tembusan ol {
      padding-left: 18px;
    }

    @page {
      size: A4;
      margin: 0;
    }

    @media print {
      body {
        background-color: white;
      }

      .page {
        margin: 0;
        padding: 5cm 2cm 1cm 2cm;
        box-shadow: none;
      }
    }
  </style>
</head>
<body onload="window.print()">
  <div class="page">
    <div class="surat-header">
      <p class="judul">Surat Keputusan</p>
      {{-- <p>Ketua Yayasan Nurul Islam Affandiyah</p> --}}
      Nomor : {{ $penugasan->nomorSurat->no_surat }}
    </div>

    <div class="tentang-block">
      <p>TENTANG :</p>
      <p>&nbsp;</p>
      <p>PENGANGKATAN PENDIDIK DAN TENAGA KEPENDIDIKAN <br> DI YAYASAN NURUL ISLAM AFFANDIYAH TAHUN PELAJARAN {{ $penugasan->tapel->tapel }}</p>
    </div>

    <p class="pemimpin">KETUA YAYASAN NURUL ISLAM AFFANDIYAH</p>

    <div class="konsideran">
      <table class="konsideran-table">
        <tr>
          <td>Menimbang</td>
          <td>:</td>
          <td>
            <ol type="1">
              <li>Bahwa untuk kelancaran dan ketertiban kegiatan Belajar Mengajar serta kinerja ketatausahaan di Yayasan Nurul Islam dipandang perlu untuk mengangkat Guru dan Tenaga Kependidikan;</li>
              <li>Bahwa nama yang tercantum dalam surat keputusan ini dipandang cakap dan memenuhi syarat untuk menjadi Guru dan Tenaga Kependidikan di Yayasan Nurul Islam.</li>
            </ol>
          </td>
        </tr>
        <tr>
          <td>Mengingat</td>
          <td>:</td>
          <td>
            <ol type="1">
              <li>Undang – undang Pendidikan Nomor 20 Tahun 2003 tentang Sistem Pendidikan Nasional;</li>
              <li>Peraturan Pemerintah Nomor 28 tahun 1990 tentang Pendidikan Dasar;</li>
              <li>Peraturan Pemerintah Nomor 29 tahun 1990 tentang pendidikan menengah;</li>
              <li>Keputusan Menteri Negara Pendayagunaan Aparatur Negara Nomor 84 tahun 1983 tentang Jabatan Fungsional Guru dan Angka Kreditnya;</li>
              <li>Keputusan Bersama Menteri Pendidikan dan Kepala BAKN Nomor: 0433/P/1993 dan Nomor 25 tahun 1993;</li>
              <li>Program Kerja Yayasan Tahun Pelajaran {{ $penugasan->tapel->tapel }}.</li>
            </ol>
          </td>
        </tr>
        <tr>
          <td>Memperhatikan</td>
          <td>:</td>
          <td>
            <ol type="1">
              <li>AD & ART Yayasan Nurul Islam Affandiyah;</li>
              <li>Saran dan Pendapat unsur pimpinan Yayasan pada tanggal {{ $penugasan->nomorSurat->tgl_sp->isoFormat('D MMMM Y') }}.</li>
            </ol>
          </td>
        </tr>
      </table>
    </div>

    <p class="diktum">M E M U T U S K A N</p>

    <table class="pasal-table">
      <tr>
        <td>Menetapkan</td>
        <td>:</td>
        <td></td>
      </tr>
      <tr>
        <td>Pertama</td>
        <td>:</td>
        <td>
          Menunjuk Saudara/i:
          <ul>
            <li><span>Nama</span>: <b>{{ $penugasan->pegawai->nama }}</b></li>
            <li><span>Tempat, Tanggal Lahir</span>: {{ $penugasan->pegawai->tmp_lahir }}, {{ $penugasan->pegawai->tgl_lahir->isoFormat('D MMMM Y') }}</li>
            <li><span>Jenjang/Pend. Terakhir</span>: {{ $penugasan->pegawai->jenjang_pendidikan }}</li>
            <li><span>Jabatan/Unit Kerja</span>: {{ $penugasan->pegawai->status_kepegawaian }}/di {{ $penugasan->satuanPendidikan->nama }}</li>
          </ul>
        </td>
      </tr>
      <tr>
        <td>Kedua</td>
        <td>:</td>
        <td>Kepada nama yang tercantum di atas diberikan honorarium sesuai dengan peraturan dan ketentuan yang berlaku di Yayasan Nurul Islam.</td>
      </tr>
      <tr>
        <td>Ketiga</td>
        <td>:</td>
        <td>Keputusan mulai berlaku sejak tanggal ditetapkan sampai dengan adanya perubahan yang dianggap perlu.</td>
      </tr>
    </table>

    <div class="tanda-tangan-container clearfix">
      <div class="tanda-tangan">
        Ditetapkan di: Cianjur<br>
        <u>Pada Tanggal: {{ $penugasan->nomorSurat->tmt->isoFormat('D MMMM Y') }}</u>
        <p style="margin-top: 0px;">Ketua Yayasan,</p>
        <div style="height: 50px;"></div>
        <p>
          <u style="font-weight: bold;">{{ $penugasan->nomorSurat->nama_pimpinan }}</u><br>
          <span>NIPY. -</span>
        </p>
      </div>
    </div>

    <div class="tembusan">
      <p>Tembusan disampaikan Kepada:</p>
      <ol>
        <li>Yth. Kepala Dinas Pendidikan Provinsi Jawa Barat</li>
        <li>Yth. Pembina Yayasan Nurul Islam Affandiyah</li>
        <li>Yth. Guru dan Tenaga Pendidikan yang bersangkutan;</li>
        <li>Pertinggal.</li>
      </ol>
    </div>
  </div>
  <script>
    window.onafterprint = () => window.close();
  </script>
</body>
</html>
