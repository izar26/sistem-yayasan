<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    /**
     * Menampilkan halaman daftar Pegawai Aktif.
     */
    public function index()
    {
        // Ambil data pegawai dengan status = 1 (Aktif)
        $pegawais = Pegawai::where('status', 1)->latest()->paginate(10);
        return view('admin.pegawai.index', compact('pegawais'));
    }

    /**
     * Menampilkan halaman daftar Pegawai Keluar (Tidak Aktif).
     */
    public function pegawaiKeluar()
    {
        // Ambil data pegawai dengan status bukan 1 (Tidak Aktif)
        $pegawais = Pegawai::where('status', '!=', 1)->latest()->paginate(10);
        return view('admin.pegawai.pegawai-keluar', compact('pegawais'));
    }

    /**
     * Menampilkan halaman form untuk membuat data pegawai baru.
     */
    public function create()
    {
        return view('admin.pegawai.create');
    }

    /**
     * Menyimpan data pegawai baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk dari form
        $request->validate([
            'nama' => 'required|string|max:50',
            'jenjang_pendidikan' => 'required|string|max:50',
            'jabatan' => 'required|string|max:50',
            'status' => 'required|boolean',
            'kewarganegaraan' => 'required|in:WNI,WNA',
            'nik' => 'required|numeric|digits:16|unique:pegawais,nik',
            'nuptk' => 'nullable|string|max:16',
            'nip' => 'nullable|string|max:18',
            'nipy' => 'nullable|string|max:16',
            'npwp' => 'nullable|string|max:16',
            'tmp_lahir' => 'required|string|max:50',
            'tgl_lahir' => 'required|date',
            'jk' => 'required|in:L,P',
            'agama' => 'required|in:Islam,Kristen,Katolik,Buddha,Hindu',
            'nama_ibu' => 'required|string|max:50',
            'status_pernikahan' => 'required|in:Menikah,Lajang,Duda,Janda',
            'nama_suami_istri' => 'nullable|string|max:50',
            'jml_anak' => 'nullable|numeric',
            'alamat' => 'required|string',
            'desa' => 'required|string|max:25',
            'kecamatan' => 'required|string|max:25',
            'kabupaten' => 'required|string|max:25',
            'provinsi' => 'required|string|max:25',
            'kode_pos' => 'required|string|max:15',
            'kontak' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:1024', // max 1MB
        ]);

        $data = $request->all();

        // Proses upload foto jika ada
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('pegawai_photos', 'public');
            $data['photo'] = $path;
        }
        
        // Logika untuk membersihkan data jika status 'Lajang'
        if ($request->status_pernikahan === 'Lajang') {
            $data['nama_suami_istri'] = null;
            $data['jml_anak'] = null;
        }

        // Buat dan simpan data pegawai baru
        Pegawai::create($data);

        // Redirect kembali ke halaman daftar dengan pesan sukses
        return redirect()->route('admin.pegawai.index')
                         ->with('success', 'Data pegawai baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan halaman detail lengkap seorang pegawai.
     */
    public function show(Pegawai $pegawai)
    {
        return view('admin.pegawai.show', compact('pegawai'));
    }

    /**
     * Menampilkan form untuk mengedit data pegawai yang sudah ada.
     */
    public function edit(Pegawai $pegawai)
    {
        return view('admin.pegawai.edit', compact('pegawai'));
    }

    /**
     * Memperbarui data pegawai di database.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
            'jenjang_pendidikan' => 'required|string|max:50',
            'jabatan' => 'required|string|max:50',
            'status' => 'required|boolean',
            'kewarganegaraan' => 'required|in:WNI,WNA',
            'nik' => ['required', 'numeric', 'digits:16', Rule::unique('pegawais')->ignore($pegawai->id)],
            'nuptk' => 'nullable|string|max:16',
            'nip' => 'nullable|string|max:18',
            'nipy' => 'nullable|string|max:16',
            'npwp' => 'nullable|string|max:16',
            'tmp_lahir' => 'required|string|max:50',
            'tgl_lahir' => 'required|date',
            'jk' => 'required|in:L,P',
            'agama' => 'required|in:Islam,Kristen,Katolik,Buddha,Hindu',
            'nama_ibu' => 'required|string|max:50',
            'status_pernikahan' => 'required|in:Menikah,Lajang,Duda,Janda',
            'nama_suami_istri' => 'nullable|string|max:50',
            'jml_anak' => 'nullable|numeric',
            'alamat' => 'required|string',
            'desa' => 'required|string|max:25',
            'kecamatan' => 'required|string|max:25',
            'kabupaten' => 'required|string|max:25',
            'provinsi' => 'required|string|max:25',
            'kode_pos' => 'required|string|max:15',
            'kontak' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:1024', // max 1MB
        ]);
        
        $data = $request->except('_token', '_method');

        // === PERBAIKAN LOGIKA PEMBERSIHAN DATA ADA DI SINI ===
        $statusPernikahan = $request->status_pernikahan;

        if ($statusPernikahan === 'Lajang') {
            // Jika Lajang, kosongkan keduanya
            $data['nama_suami_istri'] = null;
            $data['jml_anak'] = null;
        } elseif ($statusPernikahan === 'Duda' || $statusPernikahan === 'Janda') {
            // Jika Duda/Janda, HANYA kosongkan nama pasangan
            $data['nama_suami_istri'] = null;
        }
        // =======================================================

        // Proses upload foto baru jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($pegawai->photo && Storage::disk('public')->exists($pegawai->photo)) {
                Storage::disk('public')->delete($pegawai->photo);
            }
            // Simpan foto baru
            $path = $request->file('photo')->store('pegawai_photos', 'public');
            $data['photo'] = $path;
        }

        // Update data pegawai
        $pegawai->update($data);

        return redirect()->route('admin.pegawai.index')
                         ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Menghapus data pegawai dari database.
     */
    public function destroy(Pegawai $pegawai)
    {
        // Hapus foto terkait jika ada
        if ($pegawai->photo && Storage::disk('public')->exists($pegawai->photo)) {
            Storage::disk('public')->delete($pegawai->photo);
        }

        $pegawai->delete();

        return redirect()->route('admin.pegawai.index')
                         ->with('success', 'Data pegawai berhasil dihapus permanen.');
    }
    
    /**
     * Menampilkan halaman print untuk seorang pegawai.
     */
    public function print(Pegawai $pegawai)
    {
        return view('admin.pegawai.print', compact('pegawai'));
    }
}
