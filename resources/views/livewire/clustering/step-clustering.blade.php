<div>
    @if (!$showHasil)
        <div class="row g-3 mb-3">

            {{-- <div class="col-md-3">
                <label class="form-label">Jumlah Cluster</label>
                <input type="number" min="2" max="10" wire:model.defer="jumlahCluster" class="form-control"
                    disabled>
            </div> --}}


            <div class="col-md-4">
                <label class="form-label">Bobot IKU</label>
                <input type="number" step="0.01" wire:model.defer="weightIku" class="form-control">
            </div>


            <div class="col-md-4">
                <label class="form-label">Bobot Nilai RAB</label>
                <input type="number" step="0.01" wire:model.defer="weightNilaiRab" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Bobot Skor Risiko</label>
                <input type="number" step="0.01" wire:model.defer="weightSkorRisiko" class="form-control">
            </div>
        </div>

        @if (session()->has('error'))
            <div class="row mb-2">
                <div class="col-12">
                    <div class="alert alert-danger mb-0">
                        <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                    </div>
                </div>
            </div>
        @endif


        <div class="row">
            <div class="col-12 justify-content-end text-end">
                <div class="mt-2 text-end">
                    <button wire:click="clustering" wire:loading.attr="disabled" class="btn btn-primary">
                        <span wire:loading.remove wire:target="clustering">Jalankan Clustering</span>
                        <span wire:loading wire:target="clustering">
                            <span class="spinner-border spinner-border-sm"></span> Memproses...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12 text-right">
                <button wire:click="simpanHasilClustering" wire:loading.attr="disabled" class="btn btn-success btn-sm ">
                    <span wire:loading.remove wire:target="simpanHasilClustering">
                        <i class="fas fa-save mr-1"></i> Simpan Hasil Clustering
                    </span>
                    <span wire:loading wire:target="simpanHasilClustering">
                        <span class="spinner-border spinner-border-sm"></span> Menyimpan...
                    </span>
                </button>

                <div class="col-12 text-right mt-4">
                    <a href="{{ route('clustering.export.pdf', $prosesClusteringId) }}"
                        class="btn btn-danger btn-sm ml-2 text-right">
                        <i class="fas fa-file-pdf me-1"></i> Export PDF
                    </a>
                </div>


            </div>
        </div>

        @livewire('clustering.hasil-clustering', ['prosesClusteringId' => $prosesClusteringId], key('hasil-' . $prosesClusteringId))

        <button wire:click="lanjut" class="btn btn-primary mt-3">Lanjut ke Visualisasi </button>
    @endif

    <div />
