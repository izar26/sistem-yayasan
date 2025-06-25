<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfilLembaga;
use Illuminate\Support\Facades\Storage;

class ProfilLembagaController extends Controller
{
    /**
     * Menampilkan halaman form untuk mengedit profil lembaga.
     */
    public function edit()
    {
        // Ambil data profil pertama yang ada, atau buat instance baru jika kosong
        $profil = ProfilLembaga::firstOrNew(['id' => 1]);
        
        // Tampilkan view dan kirim data profil ke dalamnya
        return view('admin.profil-lembaga.edit', compact('profil'));
    }

    /**
     * Memperbarui data profil lembaga di database.
     */
    public function update(Request $request)
    {
        // 1. Validasi data yang masuk dari form
        $request->validate([
            'nama' => 'required|string|max:255',
            'npyn' => 'required|string|max:16',
            'thn_berdiri' => 'nullable|date',
            'luas' => 'required|string|max:15',
            'moto' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:800', // max 800KB
            'alamat' => 'nullable|string',
            'desa' => 'required|string|max:50',
            'kecamatan' => 'required|string|max:50',
            'kabupaten' => 'required|string|max:50',
            'provinsi' => 'required|string|max:50',
            'kode_pos' => 'required|string|max:10',
            'telepon' => 'required|string|max:20',
            'fax' => 'required|string|max:20',
            'email' => 'required|email|max:50',
            'situs_web' => 'nullable|url',
            'facebook' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
        ]);

        // 2. Temukan data profil yang ada atau buat baru jika tidak ada
        $profil = ProfilLembaga::firstOrNew(['id' => 1]);
        
        // 3. Ambil semua data kecuali 'logo' dan '_token'
        $data = $request->except('logo', '_token');

        // 4. Proses upload logo jika ada file baru yang diupload
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($profil->logo && Storage::disk('public')->exists($profil->logo)) {
                Storage::disk('public')->delete($profil->logo);
            }
            // Simpan logo baru dan dapatkan path-nya
            $path = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $path;
        }

        // 5. Update atau Create data di database
        $profil->fill($data)->save();

        // 6. Redirect kembali ke halaman edit dengan pesan sukses
        return redirect()->route('admin.profil-lembaga.edit')
                         ->with('success', 'Profil lembaga berhasil diperbarui!');
    }
}
