@extends('layouts.admin')

@section('title', 'Satuan Pendidikan')

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card-header">
            <span id="form-title">Form Satuan Pendidikan</span>
        </div>
        <div class="card-body">
            <form id="spk-form" action="{{ route('admin.satuan-pendidikan.store') }}" method="POST">
                @csrf
                <div id="form-method"></div> {{-- Tempat method spoofing PUT untuk edit --}}
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Satuan Pendidikan</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                        id="nama" name="nama" value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" id="submit-button" class="btn btn-primary">Tambah</button>
                    <button type="button" id="cancel-edit-button" class="btn btn-secondary" style="display:none;">Batal</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card-header">
            <span>Daftar Satuan Pendidikan</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($satuanPendidikans as $satuan)
                        <tr>
                            <th>{{ $loop->iteration + $satuanPendidikans->firstItem() - 1 }}</th>
                            <td>{{ $satuan->nama }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning edit-button"
                                    data-id="{{ $satuan->id }}"
                                    data-nama="{{ $satuan->nama }}">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
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
            <div class="mt-3">
                {{ $satuanPendidikans->links() }}
            </div>
        </div>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('spk-form');
    const formTitle = document.getElementById('form-title');
    const submitButton = document.getElementById('submit-button');
    const cancelEditButton = document.getElementById('cancel-edit-button');
    const formMethodDiv = document.getElementById('form-method');
    const namaInput = document.getElementById('nama');

    const defaultAction = "{{ route('admin.satuan-pendidikan.store') }}";

    function resetForm() {
        form.action = defaultAction;
        formMethodDiv.innerHTML = '';
        formTitle.textContent = 'Form Tambah Satuan Pendidikan';
        submitButton.textContent = 'Tambah';
        submitButton.classList.replace('btn-warning', 'btn-primary');
        cancelEditButton.style.display = 'none';
        namaInput.value = '';
    }

    cancelEditButton.addEventListener('click', resetForm);

    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            const nama = button.dataset.nama;

            form.action = `/admin/satuan-pendidikan/${id}`;
            formMethodDiv.innerHTML = '@method("PUT")';
            namaInput.value = nama;

            formTitle.textContent = 'Edit Satuan Pendidikan: ' + nama;
            submitButton.textContent = 'Update';
            submitButton.classList.replace('btn-primary', 'btn-warning');
            cancelEditButton.style.display = 'inline-block';

            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });

    // Modal delete
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
});
</script>
@endpush
