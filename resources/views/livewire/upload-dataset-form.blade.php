<div>
    <form wire:submit.prevent="upload">
        <div class="form-group">
            <label for="file">Pilih Dataset (CSV/XLSX)</label>
            <input type="file" wire:model="file" class="form-control">
            @error('file')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button class="btn btn-primary">Unggah</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('upload-success', function(event) {
                Swal.fire({
                    title: event.detail.title,
                    text: event.detail.message,
                    icon: event.detail.icon,
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
</div>
