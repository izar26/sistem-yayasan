@extends('layouts.admin')

@section('title', 'Manajemen Tahun Pelajaran')

@section('content')
<div class="card-header d-flex justify-content-between align-items-center">
    <span>Data Tapel</span>
    <a href="{{ route('admin.tahun-pelajaran.create') }}" class="btn btn-primary mb-2">
        <i class="bi bi-plus-circle me-2"></i>Tambah Tapel
    </a>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tapel</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tapels as $tapel)
                <tr>
                    <th scope="row">{{ $loop->iteration + $tapels->firstItem() - 1 }}</th>
                    <td>{{ $tapel->tapel }}</td>
                    <td>{{ $tapel->ket ?? '-' }}</td>
                    <td>
                        @if($tapel->status == 1)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <form action="{{ route('admin.tahun-pelajaran.set-active', $tapel->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-secondary">Aktifkan</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.tahun-pelajaran.edit', $tapel->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" 
                                data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                data-id="{{ $tapel->id }}" data-name="{{ $tapel->tapel }}">
                            <i class="bi bi-trash3"></i> Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $tapels->links() }}
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
        Apakah Anda yakin ingin menghapus Tahun Pelajaran: <strong id="delete-item-name"></strong>?
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
            deleteForm.action = `/admin/tahun-pelajaran/${id}`;
            itemName.textContent = name;
        });
    }
</script>
@endpush
