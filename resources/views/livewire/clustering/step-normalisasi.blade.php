<div>
    @if (session()->has('message'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                };
                toastr.success("{{ session('message') }}");
            });
        </script>
    @endif

    @if (!$isNormalized)
        <div class="text-left">
            <button wire:click="normalisasi" wire:loading.attr="disabled" wire:target="normalisasi"
                class="btn btn-primary mb-3">
                <span wire:loading.remove wire:target="normalisasi">Jalankan Normalisasi</span>
                <span wire:loading wire:target="normalisasi">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Memproses...
                </span>
            </button>
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>IKU</th>
                <th>Nilai RAB Usulan</th>
                <th>Tingkat Risiko</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $index => $item)
                <tr>
                    <td>{{ $data->firstItem() + $index }}</td>
                    <td>{{ $item->iku }}</td>
                    @if ($isNormalized)
                        <td>{{ $item->nilai_rab_usulan }}</td>
                    @else
                        <td>{{ number_format($item->nilai_rab_usulan, 0, ',', '.') }}</td>
                    @endif
                    <td>{{ $item->skor_risiko }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $data->links() }}

    @if ($isNormalized && $data->count())
        <button wire:click="lanjut" class="btn btn-primary mt-3">
            Lanjut ke Clustering
        </button>
    @endif
</div>
@push('styles')
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@push('scripts')
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@endpush
