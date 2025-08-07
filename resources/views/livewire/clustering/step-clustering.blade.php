<div>
    @if (!$showHasil)
        <div class="row g-3 mb-3">
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
            <div class="col-12 text-end">
                <div class="mt-2">
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
        @livewire('clustering.hasil-clustering', ['prosesClusteringId' => $prosesClusteringId], key('hasil-' . $prosesClusteringId))

     
    @endif
</div>
