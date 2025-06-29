<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NomorSurat;
use App\Models\Pegawai;
use App\Models\Penugasan;
use App\Models\SatuanPendidikan;
use App\Models\Tapel;
use Illuminate\Http\Request;

class PenugasanController extends Controller
{
    /**
     * Menampilkan halaman daftar Penugasan dan form input.
     */
    public function index()
    {
        // 1. Cari Tahun Pelajaran yang aktif
        $tapelAktif = Tapel::where('status', 1)->first();

        // Jika tidak ada tapel aktif, kembali dengan pesan error
        if (!$tapelAktif) {
            return view('admin.penugasan.index-error', [
                'message' => 'Tidak ada Tahun Pelajaran yang aktif. Silakan aktifkan satu Tahun Pelajaran terlebih dahulu.'
            ]);
        }

        // 2. Ambil data penugasan HANYA untuk tapel yang aktif
        // MODIFIKASI: Menambahkan relasi 'pegawai.satuanPendidikan' untuk fitur otomatisasi
        $penugasans = Penugasan::with(['pegawai.satuanPendidikan', 'nomorSurat', 'satuanPendidikan'])
                                ->where('id_tapel', $tapelAktif->id)
                                ->latest()
                                ->paginate(10);

        // 3. Ambil data untuk mengisi dropdown di form
        
        // --- LOGIKA CERDAS UNTUK NOMOR SURAT ---
        // Ambil semua nomor surat yang relevan untuk tapel aktif
        $nomorSurats = NomorSurat::where('id_tapel', $tapelAktif->id)->get();
        // Cek jika hanya ada satu nomor surat, maka kirim sebagai objek tunggal
        $nomorSuratDefault = ($nomorSurats->count() === 1) ? $nomorSurats->first() : null;
        // --- LOGIKA CERDAS SELESAI ---

        // Ambil pegawai aktif dan urutkan berdasarkan nama
        $pegawais = Pegawai::where('status', 1)->orderBy('nama', 'asc')->get();
        // Ambil semua satuan pendidikan
        $satuanPendidikans = SatuanPendidikan::orderBy('nama', 'asc')->get();

        // 4. Kirim semua data yang diperlukan ke view
        return view('admin.penugasan.index', compact(
            'penugasans', 
            'tapelAktif', 
            'nomorSurats', 
            'pegawais', 
            'satuanPendidikans', 
            'nomorSuratDefault'
        ));
    }

    /**
     * Menyimpan data penugasan baru ke dalam database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_tapel' => 'required|exists:tapels,id',
            'id_nomor_surat' => 'required|exists:nomor_surats,id',
            'id_pegawai' => 'required|exists:pegawais,id|unique:penugasans,id_pegawai,NULL,id,id_tapel,' . $request->id_tapel,
            'id_satuan_pendidikan' => 'required|exists:satuan_pendidikans,id',
        ], [
            'id_pegawai.unique' => 'Pegawai ini sudah memiliki penugasan di tahun pelajaran yang sama.'
        ]);

        Penugasan::create($request->all());

        return redirect()->route('admin.penugasan.index')
                         ->with('success', 'Data penugasan berhasil ditambahkan.');
    }

    /**
     * Memperbarui data penugasan yang ada di database.
     */
    public function update(Request $request, Penugasan $penugasan)
    {
        $request->validate([
            'id_tapel' => 'required|exists:tapels,id',
            'id_nomor_surat' => 'required|exists:nomor_surats,id',
            'id_pegawai' => ['required', 'exists:pegawais,id', Rule::unique('penugasans')->ignore($penugasan->id)->where('id_tapel', $request->id_tapel)],
            'id_satuan_pendidikan' => 'required|exists:satuan_pendidikans,id',
        ], [
            'id_pegawai.unique' => 'Pegawai ini sudah memiliki penugasan di tahun pelajaran yang sama.'
        ]);

        $penugasan->update($request->all());

        return redirect()->route('admin.penugasan.index')
                         ->with('success', 'Data penugasan berhasil diperbarui.');
    }

    /**
     * Menghapus data penugasan dari database.
     */
    public function destroy(Penugasan $penugasan)
    {
        $penugasan->delete();

        return redirect()->route('admin.penugasan.index')
                         ->with('success', 'Data penugasan berhasil dihapus.');
    }
    
    /**
     * Menampilkan halaman print untuk penugasan.
     */
    public function print(Penugasan $penugasan)
    {
        // Eager load semua relasi yang dibutuhkan untuk halaman cetak
        $penugasan->load(['pegawai', 'nomorSurat.tapel', 'satuanPendidikan']);

        // Kirim data penugasan yang lengkap ke view 'print.blade.php'
        return view('admin.penugasan.print', compact('penugasan'));
    }
}
