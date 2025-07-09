<div>

    <div class="row align-items-end mb-3">
        {{-- Filter Clustering --}}
        <div class="col-md-6">
            <label for="clustering" class="form-label">Pilih File Clustering:</label>
            <select wire:model="selectedClustering" id="clustering" class="form-control">
                <option value="">-- Pilih File --</option>
                @foreach ($clusterings as $clustering)
                    <option value="{{ $clustering->id }}">
                        {{ $clustering->nama_file }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tombol Export --}}
        <div class="col-md-6 text-right">
            @if ($selectedClustering && $data->count())
                <button wire:click="exportDataPdf" class="btn btn-danger mt-4">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </button>
            @endif

        </div>
    </div>



    @if ($selectedClustering)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Usulan</th>
                    <th>Nama Unit</th>
                    <th>Nama Kegiatan</th>
                    <th>Cluster</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->id_usulan }}</td>
                        <td>{{ $item->nama_unit }}</td>
                        <td>{{ $item->nama_kegiatan }}</td>

                        <td>{{ $item->cluster }}</td>
                        <td class="text-center">
                            <button wire:click="bukaModalPreprocessing({{ $item->id }})"
                                class="btn btn-sm btn-info">
                                Detail
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data untuk file ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $data->links() }}
    @else
        <div class="alert">
            Silakan pilih file clustering terlebih dahulu.
        </div>
    @endif
</div>

@push('modals')
    <div wire:ignore.self class="modal fade" id="modalPreprocessing" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPreprocessingTitle">Detail Preprocessing</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalPreprocessingBody">
                    <div class="text-center text-muted">Memuat...</div>
                </div>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
    <script>
        window.addEventListener('show-modal-preprocessing', event => {
            const {
                title,
                data
            } = event.detail;

            $('#modalPreprocessingTitle').text(title);
            const body = $('#modalPreprocessingBody');
            body.empty();

            body.append(`
    <div class="mb-3">
        <p class="text-muted">
            Berikut adalah detail preprocessing untuk ID Usulan <strong>${data.id_usulan}</strong>.
            Proses preprocessing ini mencakup transformasi data kategorikal ke numerik dan penyamaan skala (scaling) agar siap digunakan untuk analisis clustering.
        </p>
    </div>

    <table class="table table-bordered table-striped">
        <tr>
            <th>IKU</th>
            <td>${data.iku}</td>
        </tr>
        <tr>
            <th>IKU Angka</th>
            <td>
                ${data.iku_angka ?? '-'}<br>
                <small class="text-muted">Hasil konversi dari data IKU (kategorikal) ke bentuk numerik agar bisa dihitung dalam model.</small>
            </td>
        </tr>
        <tr>
            <th>Nilai Anggaran</th>
            <td>
                Rp${parseInt(data.nilai_anggaran).toLocaleString()}<br>
                <small class="text-muted">Nilai asli anggaran sebelum diubah skalanya.</small>
            </td>
        </tr>
        <tr>
            <th>Nilai Anggaran Scaled</th>
            <td>
                ${data.nilai_anggaran_scaled}<br>
                <small class="text-muted">Hasil normalisasi (scaling) agar sejajar dengan variabel lainnya dalam clustering.</small>
            </td>
        </tr>
        <tr>
            <th>Tingkat Risiko</th>
            <td>
                ${data.tingkat_risiko}<br>
                <small class="text-muted">Tingkat risiko asli sebelum normalisasi.</small>
            </td>
        </tr>
        <tr>
            <th>Tingkat Risiko Scaled</th>
            <td>
                ${data.tingkat_risiko_scaled}<br>
                <small class="text-muted">Nilai risiko setelah disesuaikan skalanya untuk analisis.</small>
            </td>
        </tr>
    </table>
`);


            $('#modalPreprocessing').modal('show');
        });
    </script>
@endpush
