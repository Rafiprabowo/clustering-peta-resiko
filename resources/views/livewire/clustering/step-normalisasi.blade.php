<div>
    {{-- Notifikasi --}}
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

    {{-- Tombol Normalisasi --}}
    @if (!$isNormalized)
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0">Data Sebelum Normalisasi</h6>
            <button wire:click="normalisasi" wire:loading.attr="disabled" wire:target="normalisasi" class="btn btn-primary">
                <span wire:loading.remove wire:target="normalisasi">Jalankan Normalisasi</span>
                <span wire:loading wire:target="normalisasi">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Memproses...
                </span>
            </button>
        </div>
    @else
        <h6 class="mb-2">Data Sebelum Normalisasi</h6>
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
            @forelse ($dataBefore as $index => $item)
                <tr>
                    <td>{{ $dataBefore->firstItem() + $index }}</td>
                    <td>{{ $item->iku }}</td>
                    <td>{{ number_format($item->nilai_rab_usulan, 0, ',', '.') }}</td>
                    <td>{{ $item->skor_risiko }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $dataBefore->links() }}

    <hr>
    <h6 class="mt-4 mb-2">Hasil Normalisasi</h6>
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
            @forelse ($dataAfter as $index => $item)
                <tr>
                    <td>{{ $dataAfter->firstItem() + $index }}</td>
                    <td>{{ $item->iku }}</td>
                    <td>{{ $item->nilai_rab_usulan }}</td>
                    <td>{{ $item->skor_risiko }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($isNormalized)
        <div class="d-flex justify-content-end mt-2">
            <button wire:click="lanjut" wire:loading.attr="disabled" wire:target="lanjut" class="btn btn-primary">
                <span wire:loading.remove wire:target="lanjut">Lanjut ke Clustering</span>
                <span wire:loading wire:target="lanjut">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Memproses...
                </span>
            </button>
        </div>
    @endif


</div>
