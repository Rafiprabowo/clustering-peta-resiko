<div>

    @if (session()->has('message'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                };
                toastr.success("{{ session('message') }}");
            });
        </script>
    @endif

    {{-- Jika Belum Ditranformasi --}}
    @if (!$transformedData->count())
        <p>Fitur yang akan ditransformasikan:</p>
        <ul>
            <li><strong>IKU</strong></li>
            <li><strong>Dampak</strong></li>
            <li><strong>Probabilitas</strong></li>
        </ul>

        <button wire:click="transform" class="btn btn-primary mt-2">
            Jalankan Transformasi
        </button>
    @endif

    {{-- Jika Sudah Ditranformasi --}}
    @if ($transformedData->count())
        <h6>Data Hasil Transformasi</h6>
        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>No</th>
                    <th>IKU</th>
                    <th>Nilai RAB Usulan</th>
                    <th>Dampak</th>
                    <th>Probabilitas</th>
                    <th>Tingkat Risiko</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transformedData as $index => $item)
                    <tr>
                        <td>{{ $transformedData->firstItem() + $index }}</td>
                        <td>{{ $item->iku }}</td>
                        <td>{{ number_format($item->nilai_rab_usulan, 0, ',', '.') }}</td>
                        <td>{{ $item->dampak }}</td>
                        <td>{{ $item->probabilitas }}</td>
                        <td>{{ $item->skor_risiko }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $transformedData->links() }}

        <button wire:click="lanjut" class="btn btn-primary mt-3">Lanjut ke Pilih Fitur</button>
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
