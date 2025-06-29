<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\ProfilLembagaController;
use App\Http\Controllers\Admin\SatuanPendidikanController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\TahunPelajaranController;
use App\Http\Controllers\Admin\NomorSuratController;
use App\Http\Controllers\Admin\PenugasanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// === PERUBAHAN UTAMA ADA DI SINI ===
// Mengalihkan rute utama ('/') ke halaman login.
Route::get('/', function () {
    return redirect()->route('login');
});


// RUTE UNTUK PROSES LOGIN & LOGOUT
Route::get('login', function () {
    return view('layouts.guest');
})->middleware('guest')->name('login');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest');

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth:admins') 
                ->name('logout');


// GRUP RUTE KHUSUS ADMIN
Route::prefix('admin')->name('admin.')->group(function() {
    Route::middleware('auth:admins')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/profil-lembaga', [ProfilLembagaController::class, 'edit'])->name('profil-lembaga.edit');
        Route::post('/profil-lembaga', [ProfilLembagaController::class, 'update'])->name('profil-lembaga.update');
        
        Route::resource('satuan-pendidikan', SatuanPendidikanController::class);
        
        Route::get('pegawai/keluar', [PegawaiController::class, 'pegawaiKeluar'])->name('pegawai.keluar.index');
Route::get('pegawai/pendidik', [PegawaiController::class, 'pendidik'])->name('pegawai.pendidik');
Route::get('pegawai/tenaga-kependidikan', [PegawaiController::class, 'tenagaKependidikan'])->name('pegawai.tenaga-kependidikan');
Route::get('pegawai/{pegawai}/print', [PegawaiController::class, 'print'])->name('pegawai.print');
Route::resource('pegawai', PegawaiController::class);
Route::get('pegawai/{pegawai}/form-keluar', [PegawaiController::class, 'formKeluar'])
    ->whereNumber('pegawai') // Biar lebih eksplisit
    ->name('pegawai.formKeluar');

Route::post('pegawai/{pegawai}/keluar', [PegawaiController::class, 'keluar'])->name('pegawai.keluar.store');
        
        Route::patch('tahun-pelajaran/{tapel}/set-active', [TahunPelajaranController::class, 'setActive'])->name('tahun-pelajaran.set-active');
        Route::resource('tahun-pelajaran', TahunPelajaranController::class);
        
        Route::resource('nomor-surat', NomorSuratController::class);
        
        Route::get('penugasan/{penugasan}/print', [PenugasanController::class, 'print'])->name('penugasan.print');
        Route::resource('penugasan', PenugasanController::class);
    });
});
