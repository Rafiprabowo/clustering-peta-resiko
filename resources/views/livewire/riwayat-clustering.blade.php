<div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama File</th>
                        <th class="text-center">Data</th>
                        <th class="text-center">Akurasi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayats as $index => $r)
                        <tr>
                            <td class="text-center">{{ $riwayats->firstItem() + $index }}</td>
                            <td class="text-center">{{ $r->nama_file }}</td>
                            <td class="text-center">{{ $r->clustered_data_count }}</td>
                            <td class="text-center">{{ $r->akurasi }}</td>
                            <td class="text-center">
                                <button wire:click="$emit('konfirmasiHapus', {{ $r->id }})"
                                    class="btn btn-sm btn-danger">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Data riwayat belum tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Livewire.on('konfirmasiHapus', id => {
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data akan dihapus permanen.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e3342f',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.emit('hapusRiwayat', id);
                        }
                    });
                });

                window.addEventListener('upload-success', event => {
                    Swal.fire({
                        title: event.detail.title,
                        text: event.detail.message,
                        icon: event.detail.icon,
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
            });
        </script>
    @endpush
</div>
