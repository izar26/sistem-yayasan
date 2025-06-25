<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tapel; // Pastikan Anda mengimpor Model Tapel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TahunPelajaranController extends Controller
{
    /**
     * Menampilkan halaman daftar Tahun Pelajaran.
     */
    public function index()
    {
        $tapels = Tapel::latest()->paginate(10);
        return view('admin.tahun-pelajaran.index', compact('tapels'));
    }

    /**
     * Menampilkan form untuk membuat data baru.
     */
    public function create()
    {
        return view('admin.tahun-pelajaran.create');
    }

    /**
     * Menyimpan data baru ke dalam database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tapel' => 'required|string|max:25|unique:tapels,tapel',
            'ket' => 'nullable|string',
        ]);

        Tapel::create($request->all());

        return redirect()->route('admin.tahun-pelajaran.index')
                         ->with('success', 'Tahun Pelajaran berhasil ditambahkan.');
    }
    
    /**
     * Mengaktifkan satu Tahun Pelajaran dan menonaktifkan yang lainnya.
     */
    public function setActive(Tapel $tapel)
    {
        // Gunakan transaksi database untuk menjamin integritas data
        DB::transaction(function () use ($tapel) {
            // 1. Nonaktifkan semua tahun pelajaran yang lain
            Tapel::where('status', 1)->update(['status' => 0]);

            // 2. Aktifkan tahun pelajaran yang dipilih
            $tapel->update(['status' => 1]);
        });

        return redirect()->route('admin.tahun-pelajaran.index')
                         ->with('success', "Tahun Pelajaran {$tapel->tapel} berhasil diaktifkan.");
    }


    // --- Method untuk Edit, Update, Destroy (CRUD Standar) ---

    public function edit(Tapel $tahunPelajaran)
    {
        return view('admin.tahun-pelajaran.edit', compact('tahunPelajaran'));
    }

    public function update(Request $request, Tapel $tahunPelajaran)
    {
        $request->validate([
            'tapel' => 'required|string|max:25|unique:tapels,tapel,' . $tahunPelajaran->id,
            'ket' => 'nullable|string',
        ]);

        $tahunPelajaran->update($request->all());

        return redirect()->route('admin.tahun-pelajaran.index')
                         ->with('success', 'Tahun Pelajaran berhasil diperbarui.');
    }

    public function destroy(Tapel $tahunPelajaran)
    {
        // Tambahkan validasi: jangan biarkan tapel yang aktif dihapus
        if ($tahunPelajaran->status == 1) {
            return redirect()->route('admin.tahun-pelajaran.index')
                             ->with('error', 'Tahun Pelajaran yang aktif tidak dapat dihapus.');
        }
        
        $tahunPelajaran->delete();

        return redirect()->route('admin.tahun-pelajaran.index')
                         ->with('success', 'Tahun Pelajaran berhasil dihapus.');
    }
}
