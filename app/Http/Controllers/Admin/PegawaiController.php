<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\SatuanPendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log; // Tambahkan ini jika menggunakan Log

class PegawaiController extends Controller
{
    /**
     * Menampilkan halaman daftar Pegawai Aktif.
     */
    public function index()
    {
        // PERBAIKAN: Menggabungkan query menjadi satu baris yang efisien
        $pegawais = Pegawai::with('satuanPendidikan')->where('status', 1)->latest()->paginate(10);
        return view('admin.pegawai.index', compact('pegawais'));
    }

    /**
     * Menampilkan halaman daftar Pegawai Keluar (Tidak Aktif).
     */
    public function pegawaiKeluar()
    {
        // Anda mungkin perlu menambahkan with('satuanPendidikan') di sini juga
        $pegawais = Pegawai::with('satuanPendidikan')->where('status', '!=', 1)->latest()->paginate(10);
        return view('admin.pegawai.pegawai-keluar', compact('pegawais'));
    }

    /**
     * Menampilkan halaman form untuk membuat data pegawai baru.
     */
    public function create()
    {
        // Kode ini sudah benar, mengambil data Satuan Pendidikan
        $satuanPendidikans = SatuanPendidikan::orderBy('nama', 'asc')->get();
        return view('admin.pegawai.create', compact('satuanPendidikans'));
    }

    /**
     * Menyimpan data pegawai baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi Anda sudah lengkap dan benar, tidak ada perubahan
        $request->validate([
            'nama' => 'required|string|max:50',
            'jenjang_pendidikan' => 'required|string|max:50',
            'status_kepegawaian' => 'required|in:Pendidik,Tenaga Kependidikan',
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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'id_satuan_pendidikan' => 'required|exists:satuan_pendidikans,id',
            'email' => 'nullable|email|max:255|unique:pegawais,email',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('pegawai_photos', 'public');
            $data['photo'] = $path;
        }

        if ($request->status_pernikahan === 'Lajang') {
            $data['nama_suami_istri'] = null;
            $data['jml_anak'] = null;
        }

        Pegawai::create($data);

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
        // Kode ini sudah benar, mengirim data satuan untuk edit
        $satuanPendidikans = SatuanPendidikan::orderBy('nama', 'asc')->get();
        return view('admin.pegawai.edit', compact('pegawai', 'satuanPendidikans'));
    }

    /**
     * Memperbarui data pegawai di database.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        // Validasi Anda sudah lengkap dan benar, tidak ada perubahan
        $request->validate([
            'nama' => 'required|string|max:50',
            'jenjang_pendidikan' => 'required|string|max:50',
            'status_kepegawaian' => 'required|in:Pendidik,Tenaga Kependidikan',
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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'id_satuan_pendidikan' => 'required|exists:satuan_pendidikans,id',
            'email' => ['nullable', 'email', 'max:255', Rule::unique('pegawais')->ignore($pegawai->id)],
        ]);

        $data = $request->except('_token', '_method');

        $statusPernikahan = $request->status_pernikahan;

        if ($statusPernikahan === 'Lajang') {
            $data['nama_suami_istri'] = null;
            $data['jml_anak'] = null;
        } elseif ($statusPernikahan === 'Duda' || $statusPernikahan === 'Janda') {
            $data['nama_suami_istri'] = null;
        }

        if ($request->hasFile('photo')) {
            if ($pegawai->photo && Storage::disk('public')->exists($pegawai->photo)) {
                Storage::disk('public')->delete($pegawai->photo);
            }
            $path = $request->file('photo')->store('pegawai_photos', 'public');
            $data['photo'] = $path;
        }

        $pegawai->update($data);

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Menghapus data pegawai dari database.
     */
    public function destroy(Pegawai $pegawai)
    {
        if ($pegawai->photo && Storage::disk('public')->exists($pegawai->photo)) {
            Storage::disk('public')->delete($pegawai->photo);
        }

        $pegawai->delete();

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil dihapus permanen.');
    }

    /**
     * Menampilkan halaman print untuk seorang pegawai.
     */
    public function print(Pegawai $pegawai)
    {
        return view('admin.pegawai.print', compact('pegawai'));
    }

    // --- FUNGSI KUSTOM ANDA (TIDAK DIUBAH) ---
    public function pendidik()
    {
        $pegawais = Pegawai::where('status', 1)
                            ->where('status_kepegawaian', 'Pendidik')
                            ->latest()
                            ->paginate(10);
        return view('admin.pegawai.index', compact('pegawais'));
    }

    public function tenagaKependidikan()
    {
        $pegawais = Pegawai::where('status', 1)
                            ->where('status_kepegawaian', 'Tenaga Kependidikan')
                            ->latest()
                            ->paginate(10);
        return view('admin.pegawai.index', compact('pegawais'));
    }

    public function keluar(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'alasan' => 'required|in:Mutasi,Dikeluarkan,Mengundurkan Diri,Wafat,Hilang,Alih Fungsi,Pensiun'
        ]);

        // Simpan ke tabel pegawai_keluar
        $pegawai->keluar()->create(['alasan' => $request->alasan]);

        Log::info('Alasan keluar:', ['alasan' => $request->alasan]);

        // Ubah status pegawai jadi nonaktif
        $pegawai->update(['status' => 0]);

        // Redirect ke halaman PTK Keluar
        return redirect()->route('admin.pegawai.keluar.index')
                         ->with('success', 'Pegawai berhasil dinonaktifkan dan dicatat sebagai keluar.');
    }

    public function formKeluar(Pegawai $pegawai)
    {
        Log::info('Masuk formKeluar', ['pegawai' => $pegawai->id]);
        return view('admin.pegawai.form-keluar', compact('pegawai'));
    }
}
