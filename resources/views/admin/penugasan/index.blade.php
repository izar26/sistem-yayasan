@extends('layouts.admin')

@section('title', 'Manajemen Penugasan')

@section('content')
<div class="row">
    <!-- Kolom Kiri: Form Input Dinamis -->
    <div class="col-md-5">
        {{-- Judul form yang akan berubah secara dinamis --}}
        <div class="card-header">
            <span id="form-title">Form Penugasan</span>
        </div>
        <div class="card-body">
            {{-- Form utama dengan ID untuk dimanipulasi JS --}}
            <form id="penugasan-form" action="{{ route('admin.penugasan.store') }}" method="POST">
                @csrf
                {{-- Method spoofing untuk PUT akan disisipkan oleh JS di sini --}}
                <div id="form-method"></div>

                <div class="mb-3">
                    <label for="id_tapel" class="form-label">Tahun Pelajaran</label>
                    <input type="text" class="form-control" value="{{ $tapelAktif->tapel }} (Aktif)" disabled>
                    <input type="hidden" name="id_tapel" value="{{ $tapelAktif->id }}">
                </div>

                <div class="mb-3">
                    <label for="id_nomor_surat" class="form-label">Nomor Surat</label>
                    <select class="form-select @error('id_nomor_surat') is-invalid @enderror" id="id_nomor_surat" name="id_nomor_surat" required>
                        <option value="">Pilih Nomor Surat...</option>
                        @foreach ($nomorSurats as $surat)
                            <option value="{{ $surat->id }}">{{ $surat->no_surat }}</option>
                        @endforeach
                    </select>
                    @error('id_nomor_surat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="id_pegawai" class="form-label">Nama Pegawai</label>
                    <select class="form-select @error('id_pegawai') is-invalid @enderror" id="id_pegawai" name="id_pegawai" required>
                        <option value="">Pilih Nama Pegawai...</option>
                        @foreach ($pegawais as $pegawai)
                            <option value="{{ $pegawai->id }}">{{ $pegawai->nama }}</option>
                        @endforeach
                    </select>
                    @error('id_pegawai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="id_satuan_pendidikan" class="form-label">Tugaskan di Satuan Pendidikan (SPK)</label>
                    <select class="form-select @error('id_satuan_pendidikan') is-invalid @enderror" id="id_satuan_pendidikan" name="id_satuan_pendidikan" required>
                        <option value="">Pilih SPK...</option>
                        @foreach ($satuanPendidikans as $spk)
                            <option value="{{ $spk->id }}">{{ $spk->nama }}</option>
                        @endforeach
                    </select>
                    @error('id_satuan_pendidikan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" id="submit-button" class="btn btn-primary">Submit</button>
                    {{-- Tombol Batal Edit, awalnya tersembunyi --}}
                    <button type="button" id="cancel-edit-button" class="btn btn-secondary" style="display: none;">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Kolom Kanan: Tabel Data -->
    <div class="col-md-7">
        <div class="card-header">
            <span>Data Penugasan</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nomor Surat</th>
                            <th>Nama Pegawai</th>
                            <th>SPK</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penugasans as $penugasan)
                        <tr>
                            <td>{{ $loop->iteration + $penugasans->firstItem() - 1 }}</td>
                            <td>{{ $penugasan->nomorSurat->no_surat ?? 'N/A' }}</td>
                            <td>{{ $penugasan->pegawai->nama ?? 'N/A' }}</td>
                            <td>{{ $penugasan->satuanPendidikan->nama ?? 'N/A' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.penugasan.print', $penugasan->id) }}" target="_blank" class="btn btn-sm btn-info" title="Print SK">
    <i class="bi bi-printer"></i>
</a>
                                    
                                    {{-- Tombol Edit dengan data attributes --}}
                                    <button class="btn btn-sm btn-warning edit-button" title="Edit"
                                            data-id="{{ $penugasan->id }}"
                                            data-pegawai-id="{{ $penugasan->id_pegawai }}"
                                            data-pegawai-nama="{{ $penugasan->pegawai->nama ?? '' }}"
                                            data-nomor-surat-id="{{ $penugasan->id_nomor_surat }}"
                                            data-spk-id="{{ $penugasan->id_satuan_pendidikan }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    
                                    {{-- Tombol Hapus dengan modal trigger --}}
                                    <button type="button" class="btn btn-sm btn-danger delete-button" title="Hapus"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-id="{{ $penugasan->id }}"
                                            data-name="{{ $penugasan->pegawai->nama ?? 'Data' }}">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data penugasan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $penugasans->links() }}
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
        Apakah Anda yakin ingin menghapus penugasan untuk: <strong id="delete-item-name"></strong>?
      </div>
      <div class="modal-footer">
        <form id="delete-form" action="#" method="POST">
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
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('penugasan-form');
    const formTitle = document.getElementById('form-title');
    const submitButton = document.getElementById('submit-button');
    const cancelEditButton = document.getElementById('cancel-edit-button');
    const formMethodDiv = document.getElementById('form-method');

    const defaultFormAction = "{{ route('admin.penugasan.store') }}";
    
    // Fungsi untuk mereset form ke mode "Tambah"
    function resetForm() {
        form.reset(); // Mengosongkan semua input
        form.action = defaultFormAction; // Kembalikan action ke rute 'store'
        formMethodDiv.innerHTML = ''; // Hapus method spoofing PUT
        formTitle.textContent = 'Form Penugasan';
        submitButton.textContent = 'Submit';
        submitButton.classList.replace('btn-warning', 'btn-primary');
        cancelEditButton.style.display = 'none';
        document.getElementById('id_nomor_surat').value = '';
        document.getElementById('id_pegawai').value = '';
        document.getElementById('id_satuan_pendidikan').value = '';
    }

    // Event listener untuk tombol "Batal Edit"
    cancelEditButton.addEventListener('click', function() {
        resetForm();
    });

    // Event listener untuk semua tombol "Edit"
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function () {
            // Ambil data dari tombol yang diklik
            const id = this.dataset.id;
            const pegawaiId = this.dataset.pegawaiId;
            const pegawaiNama = this.dataset.pegawaiNama;
            const nomorSuratId = this.dataset.nomorSuratId;
            const spkId = this.dataset.spkId;
            
            // Ubah action form ke rute 'update'
            form.action = `/admin/penugasan/${id}`;
            
            // Tambahkan method spoofing untuk PUT
            formMethodDiv.innerHTML = '@method("PUT")';

            // Isi form dengan data
            document.getElementById('id_nomor_surat').value = nomorSuratId;
            document.getElementById('id_pegawai').value = pegawaiId;
            document.getElementById('id_satuan_pendidikan').value = spkId;
            
            // Ubah tampilan form
            formTitle.textContent = 'Edit Penugasan: ' + pegawaiNama;
            submitButton.textContent = 'Update Perubahan';
            submitButton.classList.replace('btn-primary', 'btn-warning');
            cancelEditButton.style.display = 'inline-block';
            
            // Scroll ke atas agar form terlihat
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });

    // Event listener untuk modal hapus
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const id = button.dataset.id;
            const name = button.dataset.name;
            const deleteForm = deleteModal.querySelector('#delete-form');
            const itemName = deleteModal.querySelector('#delete-item-name');
            deleteForm.action = `/admin/penugasan/${id}`;
            itemName.textContent = name;
        });
    }
});
</script>
@endpush
