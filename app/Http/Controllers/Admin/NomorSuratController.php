<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NomorSurat;
use App\Models\Tapel;
use Illuminate\Http\Request;

class NomorSuratController extends Controller
{
    /**
     * Menampilkan halaman daftar Nomor Surat.
     */
    public function index()
    {
        // Mengambil data dengan relasi 'tapel' untuk ditampilkan di tabel
        $nomorSurats = NomorSurat::with('tapel')->latest()->paginate(10);
        return view('admin.nomor-surat.index', compact('nomorSurats'));
    }

    /**
     * Menampilkan form untuk membuat data baru.
     */
    public function create()
    {
        // Ambil semua data Tahun Pelajaran untuk ditampilkan di dropdown
        $tapels = Tapel::orderBy('tapel', 'desc')->get();
        return view('admin.nomor-surat.create', compact('tapels'));
    }

    /**
     * Menyimpan data baru ke dalam database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_tapel' => 'required|exists:tapels,id',
            'no_surat' => 'required|string|max:100|unique:nomor_surats,no_surat',
            'nama_pimpinan' => 'required|string|max:25',
            'tgl_sp' => 'required|date',
            'tmt' => 'required|date',
        ]);

        NomorSurat::create($request->all());

        return redirect()->route('admin.nomor-surat.index')
                         ->with('success', 'Nomor Surat berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data.
     */
    public function edit(NomorSurat $nomorSurat)
    {
        $tapels = Tapel::orderBy('tapel', 'desc')->get();
        return view('admin.nomor-surat.edit', compact('nomorSurat', 'tapels'));
    }

    /**
     * Memperbarui data yang ada di database.
     */
    public function update(Request $request, NomorSurat $nomorSurat)
    {
        $request->validate([
            'id_tapel' => 'required|exists:tapels,id',
            'no_surat' => 'required|string|max:100|unique:nomor_surats,no_surat,' . $nomorSurat->id,
            'nama_pimpinan' => 'required|string|max:25',
            'tgl_sp' => 'required|date',
            'tmt' => 'required|date',
        ]);

        $nomorSurat->update($request->all());

        return redirect()->route('admin.nomor-surat.index')
                         ->with('success', 'Nomor Surat berhasil diperbarui.');
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy(NomorSurat $nomorSurat)
    {
        $nomorSurat->delete();

        return redirect()->route('admin.nomor-surat.index')
                         ->with('success', 'Nomor Surat berhasil dihapus.');
    }
}
