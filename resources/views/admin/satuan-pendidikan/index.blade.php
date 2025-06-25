{{-- Langkah 1: Memberitahu file ini untuk menggunakan Master Layout --}}
@extends('layouts.admin')

{{-- Langkah 2: Mengisi 'title' di Master Layout --}}
@section('title', 'Manajemen Satuan Pendidikan')

{{-- Langkah 3: Semua konten halaman ini sekarang berada di dalam section 'content' --}}
@section('content')
<div class="card-header d-flex justify-content-between align-items-center">
    <span>Daftar Satuan Pendidikan</span>
    <a href="{{ route('admin.satuan-pendidikan.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah
    </a>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($satuanPendidikans as $satuan)
                <tr>
                    <th scope="row">{{ $loop->iteration + $satuanPendidikans->firstItem() - 1 }}</th>
                    <td>{{ $satuan->nama }}</td>
                    <td>
                        <a href="{{ route('admin.satuan-pendidikan.edit', $satuan->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" 
                                data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                data-id="{{ $satuan->id }}" data-name="{{ $satuan->nama }}">
                            <i class="bi bi-trash3"></i> Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">Belum ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Tampilkan pagination links -->
    <div class="mt-3">
        {{ $satuanPendidikans->links() }}
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deleteModalLabel">Konfirmasi Hapus</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus satuan pendidikan: <strong id="delete-item-name"></strong>?
      </div>
      <div class="modal-footer">
        <form id="delete-form" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

{{-- Script untuk modal hapus akan dimasukkan ke dalam slot 'scripts' di Master Layout --}}
@push('scripts')
<script>
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            
            const deleteForm = deleteModal.querySelector('#delete-form');
            const itemName = deleteModal.querySelector('#delete-item-name');
            
            deleteForm.action = `/admin/satuan-pendidikan/${id}`;
            itemName.textContent = name;
        });
    }
</script>
@endpush