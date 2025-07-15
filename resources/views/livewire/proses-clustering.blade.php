<div class="section-body">
    <div class="row mb-3">
        <div class="col-md-4">
            <label>Tahun</label>
            <select wire:model="tahunTerpilih" class="form-control">
                <option value="">-- Pilih Tahun --</option>
                @foreach ($tahunList as $tahun)
                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label>Nama File</label>
            <select wire:model="namaFileTerpilih" class="form-control" {{ !$tahunTerpilih ? 'disabled' : '' }}>
                <option value="">-- Pilih File --</option>
                @foreach ($daftarFile as $file)
                    <option value="{{ $file }}">{{ $file }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if ($namaFileTerpilih && $dataTable->count())
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <button wire:click="prosesCleaning" class="btn btn-primary btn-sm" wire:loading.attr="disabled">
                        <span wire:loading wire:target="prosesCleaning" class="spinner-border spinner-border-sm"></span>
                        Cleaning
                    </button>
                    <button wire:click="prosesTransform" class="btn btn-success btn-sm" wire:loading.attr="disabled">
                        <span wire:loading wire:target="prosesTransform"
                            class="spinner-border spinner-border-sm"></span>
                        Transform
                    </button>
                    <button wire:click="prosesNormalize" class="btn btn-info btn-sm" wire:loading.attr="disabled">
                        <span wire:loading wire:target="prosesNormalize"
                            class="spinner-border spinner-border-sm"></span>
                        Normalize
                    </button>
                    <button wire:click="prosesClustering" class="btn btn-warning btn-sm" wire:loading.attr="disabled">
                        <span wire:loading wire:target="prosesClustering"
                            class="spinner-border spinner-border-sm"></span>
                        Clustering
                    </button>
                </div>
            </div>

            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Unit Kerja</th>
                        <th>ID Usulan</th>
                        <th>Nama Program</th>
                        <th>IKU</th>
                        <th>Anggaran</th>
                        <th>Dampak</th>
                        <th>Probabilitas</th>
                        @if ($step === 'transform' || $step === 'normalize')
                            <th>Tingkat Risiko</th>
                        @endif
                        <th>Risiko</th>
                        <th>Pernyataan Risiko</th>
                        <th>Uraian Dampak</th>
                        <th>Pengendalian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataTable as $index => $row)
                        <tr>
                            <td>{{ ($dataTable->firstItem() ?? 0) + $index }}</td>
                            <td>{{ $row->nama_unit }}</td>
                            <td>{{ $row->id_usulan }}</td>
                            <td>{{ $row->nama_kegiatan }}</td>
                            <td>{{ $row->iku }}</td>
                            <td>{{ $row->nilai_rab_usulan }}</td>
                            <td>{{ $row->dampak }}</td>
                            <td>{{ $row->probabilitas }}</td>
                            @if ($step === 'transform' || $step === 'normalize')
                                <td>{{ $row->tingkat_risiko ?? $row->dampak * $row->probabilitas }}</td>
                            @endif
                            <td>{{ $row->risiko }}</td>
                            <td>{{ $row->pernyataan_risiko }}</td>
                            <td>{{ $row->uraian_dampak }}</td>
                            <td>{{ $row->pengendalian }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-2">
                {{ $dataTable->links() }}
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 4000,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "#28a745",
                    close: true,
                    stopOnFocus: true
                }).showToast();
            @elseif (session('error'))
                Toastify({
                    text: "{{ session('error') }}",
                    duration: 4000,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "#dc3545",
                    close: true,
                    stopOnFocus: true
                }).showToast();
            @endif
        });
    </script>
@endpush
