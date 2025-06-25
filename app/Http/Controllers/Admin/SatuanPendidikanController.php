<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SatuanPendidikan;
use Illuminate\Http\Request;

class SatuanPendidikanController extends Controller
{
    /**
     * Menampilkan halaman daftar Satuan Pendidikan.
     */
    public function index()
    {
        $satuanPendidikans = SatuanPendidikan::latest()->paginate(10); // Ambil data terbaru, 10 per halaman
        return view('admin.satuan-pendidikan.index', compact('satuanPendidikans'));
    }

    /**
     * Menampilkan form untuk membuat data baru.
     */
    public function create()
    {
        return view('admin.satuan-pendidikan.create');
    }

    /**
     * Menyimpan data baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:100|unique:satuan_pendidikans,nama',
        ]);

        // Buat dan simpan data baru
        SatuanPendidikan::create($request->all());

        // Redirect kembali ke halaman daftar dengan pesan sukses
        return redirect()->route('admin.satuan-pendidikan.index')
                         ->with('success', 'Satuan Pendidikan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data.
     */
    public function edit(SatuanPendidikan $satuanPendidikan)
    {
        return view('admin.satuan-pendidikan.edit', compact('satuanPendidikan'));
    }

    /**
     * Memperbarui data yang ada di database.
     */
    public function update(Request $request, SatuanPendidikan $satuanPendidikan)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:100|unique:satuan_pendidikans,nama,' . $satuanPendidikan->id,
        ]);

        // Update data
        $satuanPendidikan->update($request->all());

        // Redirect kembali ke halaman daftar dengan pesan sukses
        return redirect()->route('admin.satuan-pendidikan.index')
                         ->with('success', 'Satuan Pendidikan berhasil diperbarui.');
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy(SatuanPendidikan $satuanPendidikan)
    {
        // Hapus data
        $satuanPendidikan->delete();

        // Redirect kembali ke halaman daftar dengan pesan sukses
        return redirect()->route('admin.satuan-pendidikan.index')
                         ->with('success', 'Satuan Pendidikan berhasil dihapus.');
    }
}