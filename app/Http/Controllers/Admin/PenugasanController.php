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
        $tapelAktif = Tapel::where('status', 1)->first();

        if (!$tapelAktif) {
            return view('admin.penugasan.index-error', [
                'message' => 'Tidak ada Tahun Pelajaran yang aktif. Silakan aktifkan satu terlebih dahulu.'
            ]);
        }

        $penugasans = Penugasan::with(['pegawai', 'nomorSurat', 'satuanPendidikan'])
                                ->where('id_tapel', $tapelAktif->id)
                                ->latest()
                                ->paginate(10);

        $nomorSurats = NomorSurat::where('id_tapel', $tapelAktif->id)->get();
        $pegawais = Pegawai::where('status', 1)->orderBy('nama', 'asc')->get();
        $satuanPendidikans = SatuanPendidikan::orderBy('nama', 'asc')->get();

        return view('admin.penugasan.index', compact('penugasans', 'tapelAktif', 'nomorSurats', 'pegawais', 'satuanPendidikans'));
    }

    /**
     * Menyimpan data penugasan baru ke dalam database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_tapel' => 'required|exists:tapels,id',
            'id_nomor_surat' => 'required|exists:nomor_surats,id',
            'id_pegawai' => 'required|exists:pegawais,id',
            'id_satuan_pendidikan' => 'required|exists:satuan_pendidikans,id',
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
            'id_pegawai' => 'required|exists:pegawais,id',
            'id_satuan_pendidikan' => 'required|exists:satuan_pendidikans,id',
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
     * (Akan diimplementasikan nanti)
     */
    public function print(Penugasan $penugasan)
    {
        // Eager load semua relasi yang dibutuhkan untuk halaman cetak
        $penugasan->load(['pegawai', 'nomorSurat.tapel', 'satuanPendidikan']);

        // Kirim data penugasan yang lengkap ke view 'print.blade.php'
        return view('admin.penugasan.print', compact('penugasan'));
    }
}
