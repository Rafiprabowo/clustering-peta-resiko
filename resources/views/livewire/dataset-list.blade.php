<div class="mt-4">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama File</th>
                <th>Waktu Upload</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($datasets as $i => $dataset)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $dataset->original_name }}</td>
                    <td>{{ $dataset->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <button wire:click="$emit('triggerDelete', {{ $dataset->id }})" class="btn btn-danger">
                            Hapus
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Dataset belum tersedia</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $datasets->links('pagination::bootstrap-4') }}

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Livewire.on('triggerDelete', id => {
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.emit('confirmDelete', id);
                        }
                    });
                });
            });
        </script>
    @endpush

</div>
