@extends('layouts.admin')

@section('title', 'Arsip Pegawai Keluar')

@section('content')
<div class="card-header d-flex justify-content-between align-items-center">
    <span>Arsip Pegawai Keluar / Tidak Aktif</span>
    {{-- Tombol Tambah Dihilangkan dari halaman ini --}}
</div>
<div class="card-body">
    <div class="table-responsive">
        <table id="dt" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Nama</th>
                    <th>NUPTK</th>
                    <th>NIPY</th>
                    <th>Jenis Kelamin</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pegawais as $pegawai)
                <tr>
                    <td>{{ $loop->iteration + $pegawais->firstItem() - 1 }}</td>
                    <td>
                        <img src="{{ $pegawai->photo ? asset('storage/' . $pegawai->photo) : 'https://placehold.co/60x60/696cff/FFFFFF?text=' . strtoupper(substr($pegawai->nama, 0, 1)) }}" 
                             alt="Foto {{ $pegawai->nama }}" class="rounded" width="60">
                    </td>
                    <td>{{ $pegawai->nama }}</td>
                    <td>{{ $pegawai->nuptk ?? '-' }}</td>
                    <td>{{ $pegawai->nipy ?? '-' }}</td>
                    <td>{{ $pegawai->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td><span class="badge bg-danger">Tidak Aktif</span></td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.pegawai.show', $pegawai->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            {{-- Tombol Edit dan Hapus ditambahkan --}}
                            <a href="{{ route('admin.pegawai.edit', $pegawai->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            {{-- <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                    data-id="{{ $pegawai->id }}" data-name="{{ $pegawai->nama }}">
                                <i class="bi bi-trash3"></i>
                            </button> --}}
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada data pegawai keluar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $pegawais->links() }}
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
        Apakah Anda yakin ingin menghapus permanen data pegawai: <strong id="delete-item-name"></strong>?
      </div>
      <div class="modal-footer">
        <form id="delete-form" action="#" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Ya, Hapus Permanen</button>
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
            
            deleteForm.action = `/admin/pegawai/${id}`;
            itemName.textContent = name;
        });
    }
</script>
@endpush
