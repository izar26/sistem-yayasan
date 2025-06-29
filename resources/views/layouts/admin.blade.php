<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Aset -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('assets/css/admin-dashboard.css') }}" rel="stylesheet">
    
    <!-- Toastify.js -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>
<body>
    <div class="admin-layout">
        <!-- =========== Sidebar =========== -->
        <aside class="sidebar">
            <div class="sidebar-header">
                {{-- <i class="bi bi-shield-shaded"></i> --}}
                <span>{{ old('inisial_lembaga', $profil->inisial_lembaga ?? '-') }}</span>
            </div>
            <ul class="sidebar-menu">
                {{-- Menu Dashboard --}}
                <li class="sidebar-menu-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Grup Menu Lembaga --}}
                @php $isLembagaActive = Route::is('admin.profil-lembaga.*') || Route::is('admin.satuan-pendidikan.*'); @endphp
                <li class="sidebar-menu-item {{ $isLembagaActive ? 'active' : '' }}">
                    <a class="sidebar-menu-link" data-bs-toggle="collapse" href="#lembagaCollapse" role="button" aria-expanded="{{ $isLembagaActive ? 'true' : 'false' }}">
                        <i class="bi bi-building"></i>
                        <span>Lembaga</span>
                    </a>
                    <div class="collapse collapse-menu {{ $isLembagaActive ? 'show' : '' }}" id="lembagaCollapse">
                        <ul class="sidebar-menu">
                            <li class="sidebar-menu-item {{ Route::is('admin.profil-lembaga.*') ? 'active' : '' }}">
                                <a href="{{ route('admin.profil-lembaga.edit') }}" class="sidebar-menu-link">Profil Lembaga</a>
                            </li>
                            <li class="sidebar-menu-item {{ Route::is('admin.satuan-pendidikan.*') ? 'active' : '' }}">
                                <a href="{{ route('admin.satuan-pendidikan.index') }}" class="sidebar-menu-link">Satuan Pendidikan</a>
                            </li>
                        </ul>
                    </div>
                </li>

                @php
    $isPegawaiActive = Route::is('admin.pegawai.*');
@endphp
<li class="sidebar-menu-item {{ $isPegawaiActive ? 'active' : '' }}">
    <a class="sidebar-menu-link" data-bs-toggle="collapse" href="#pegawaiCollapse" role="button" aria-expanded="{{ $isPegawaiActive ? 'true' : 'false' }}">
        <i class="bi bi-people-fill"></i>
        <span>Pegawai</span>
    </a>
    <div class="collapse collapse-menu {{ $isPegawaiActive ? 'show' : '' }}" id="pegawaiCollapse">
        <ul class="sidebar-menu">
            {{-- Pendidik --}}
            <li class="sidebar-menu-item {{ Route::is('admin.pegawai.pendidik') ? 'active' : '' }}">
                <a href="{{ route('admin.pegawai.pendidik') }}" class="sidebar-menu-link">Pendidik</a>
            </li>
            {{-- Tenaga Kependidikan --}}
            <li class="sidebar-menu-item {{ Route::is('admin.pegawai.tenaga-kependidikan') ? 'active' : '' }}">
                <a href="{{ route('admin.pegawai.tenaga-kependidikan') }}" class="sidebar-menu-link">Tenaga Kependidikan</a>
            </li>
            {{-- PTK Keluar --}}
<li class="sidebar-menu-item {{ request()->is('admin/pegawai/keluar') ? 'active' : '' }}">
    <a href="{{ route('admin.pegawai.keluar.index') }}" class="sidebar-menu-link text-danger">PTK Keluar</a>
</li>


        </ul>
    </div>
</li>

                
                {{-- Grup Menu Penugasan --}}
@php 
    $isPenugasanActive = Route::is('admin.tahun-pelajaran.*') || 
                         Route::is('admin.nomor-surat.*') || 
                         Route::is('admin.penugasan.*'); 
@endphp
<li class="sidebar-menu-item {{ $isPenugasanActive ? 'active' : '' }}">
    <a class="sidebar-menu-link" data-bs-toggle="collapse" href="#penugasanCollapse" role="button" aria-expanded="{{ $isPenugasanActive ? 'true' : 'false' }}">
        <i class="bi bi-briefcase-fill"></i>
        <span>Penugasan</span>
    </a>
    <div class="collapse collapse-menu {{ $isPenugasanActive ? 'show' : '' }}" id="penugasanCollapse">
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item {{ Route::is('admin.tahun-pelajaran.*') ? 'active' : '' }}">
                <a href="{{ route('admin.tahun-pelajaran.index') }}" class="sidebar-menu-link">Tahun Pelajaran</a>
            </li>
            <li class="sidebar-menu-item {{ Route::is('admin.nomor-surat.*') ? 'active' : '' }}">
                <a href="{{ route('admin.nomor-surat.index') }}" class="sidebar-menu-link">Nomor Surat</a>
            </li>
            <li class="sidebar-menu-item {{ Route::is('admin.penugasan.*') ? 'active' : '' }}">
    <a href="{{ route('admin.penugasan.index') }}" class="sidebar-menu-link">Penugasan</a>
</li>
        </ul>
    </div>
</li>

                {{-- Menu Logout --}}
                <li class="sidebar-menu-item mt-auto">
                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <a href="{{ route('logout') }}" class="sidebar-menu-link" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-left"></i>
                            <span>Logout</span>
                        </a>
                    </form>
                </li>
            </ul>
        </aside>

        <!-- =========== Konten Utama =========== -->
        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    @yield('title', 'Dashboard')
                </div>
                <div class="header-profile">
                    <span class="profile-name">{{ auth()->user()->username }}</span>
                    <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://placehold.co/40x40/696cff/FFFFFF?text=' . strtoupper(substr(auth()->user()->username, 0, 1)) }}" 
                         alt="Avatar" class="profile-avatar">
                </div>
            </header>
            <div class="content-card">
                 @yield('content')
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        @if(session('success'))
            Toastify({ text: "{{ session('success') }}", duration: 3000, close: true, gravity: "top", position: "right", backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)" }).showToast();
        @elseif(session('error'))
            Toastify({ text: "{{ session('error') }}", duration: 3000, close: true, gravity: "top", position: "right", backgroundColor: "linear-gradient(to right, #e85858, #c94040)" }).showToast();
        @endif
    </script>

    <!-- link data dataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap5.js"></script>
<script>
    $(document).ready(function () {
        $('#dt').DataTable();
    });
</script>
    @stack('scripts')
</body>
</html>
