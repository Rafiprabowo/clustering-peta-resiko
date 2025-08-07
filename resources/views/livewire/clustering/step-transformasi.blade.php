<div>
    <style>
        .table-fixed {
            table-layout: fixed;
            width: 100%;
        }

        .table-fixed th,
        .table-fixed td {
            word-wrap: break-word;
        }
    </style>

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

    {{-- Fitur yang Akan Ditransformasi --}}
    {{-- Skala Konversi IKU --}}
    <strong>Klasifikasi Atribut IKU dan Bobot Penilaian</strong>
    <table class="table table-bordered mt-2 table-fixed">
        <thead>
            <tr>
                <th>Kategori Indikator</th>
                <th>Bobot</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Indikator Kinerja Utama (IKU)</td>
                <td>0.7</td>
            </tr>
            <tr>
                <td>Indikator Kinerja Tambahan (IKT)</td>
                <td>0.3</td>
            </tr>
        </tbody>
    </table>

    {{-- Skala Konversi Dampak --}}
    <strong>Skala Konversi Nilai Dampak</strong>
    <table class="table table-bordered mt-2 table-fixed">
        <thead>
            <tr>
                <th>Nilai Kategorikal</th>
                <th>Nilai Numerik</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Sangat Berpengaruh</td>
                <td>5</td>
            </tr>
            <tr>
                <td>Berpengaruh</td>
                <td>4</td>
            </tr>
            <tr>
                <td>Cukup Berpengaruh</td>
                <td>3</td>
            </tr>
            <tr>
                <td>Sedikit Berpengaruh</td>
                <td>2</td>
            </tr>
            <tr>
                <td>Sangat Sedikit Berpengaruh</td>
                <td>1</td>
            </tr>
        </tbody>
    </table>

    {{-- Skala Konversi Probabilitas --}}
    <strong>Skala Konversi Nilai Probabilitas</strong>
    <table class="table table-bordered mt-2 table-fixed">
        <thead>
            <tr>
                <th>Nilai Kategorikal</th>
                <th>Nilai Numerik</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Sangat Sering</td>
                <td>5</td>
            </tr>
            <tr>
                <td>Sering</td>
                <td>4</td>
            </tr>
            <tr>
                <td>Kadang-kadang</td>
                <td>3</td>
            </tr>
            <tr>
                <td>Jarang</td>
                <td>2</td>
            </tr>
            <tr>
                <td>Sangat Jarang</td>
                <td>1</td>
            </tr>
        </tbody>
    </table>


    <hr>

    <strong>Fitur Baru:</strong>
    <table class="table table-bordered mt-2">
        <thead>
            <tr>
                <th>Nama Kolom</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tingkat Risiko</td>
            </tr>
        </tbody>
    </table>

    <hr>

    {{-- Tabel Data Sebelum Transformasi --}}
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="mb-0">Data Sebelum Transformasi</h6>
        <button wire:click="transform" wire:loading.attr="disabled" wire:target="transform" class="btn btn-primary">
            <span wire:loading.remove wire:target="transform">Transformasi</span>
            <span wire:loading wire:target="transform">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Memproses...
            </span>
        </button>
    </div>


    @if ($cleanedData->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Usulan</th>
                    <th>Nama Kegiatan</th>
                    <th>IKU</th>
                    <th>Dampak</th>
                    <th>Probabilitas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cleanedData as $index => $row)
                    <tr>
                        <td>{{ $cleanedData->firstItem() + $index }}</td>
                        <td>{{ $row->id_usulan }}</td>
                        <td>{{ $row->nama_kegiatan ?? '-' }}</td>
                        <td>{{ $row->iku }}</td>
                        <td>{{ $row->dampak }}</td>
                        <td>{{ $row->probabilitas }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $cleanedData->links() }}
    @else
        <p class="text-muted">Tidak ada data yang ditemukan untuk transformasi.</p>
    @endif

    <hr>

    {{-- Data Hasil Transformasi --}}
    <h6>Data Hasil Transformasi</h6>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>IKU</th>
                <th>Dampak</th>
                <th>Probabilitas</th>
                <th>Skor Risiko</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transformedData as $index => $item)
                <tr>
                    <td>{{ $transformedData->firstItem() + $index }}</td>
                    <td>{{ $item->iku }}</td>
                    <td>{{ $item->dampak }}</td>
                    <td>{{ $item->probabilitas }}</td>
                    <td>{{ $item->skor_risiko }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Tombol Lanjut --}}
    @if ($transformedData->count() > 0)
        <div class="d-flex justify-content-end">
            <button wire:click="lanjut" class="btn btn-primary mt-3">Lanjut ke Normalisasi</button>
        </div>
    @endif


</div>

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@endpush
