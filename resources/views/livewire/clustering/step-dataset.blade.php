<div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="year" class="form-label">Pilih Tahun Dataset</label>
                <select wire:model="selectedYear" id="year" class="form-control">
                    <option value="">-- Pilih Tahun --</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            @if ($selectedYear)
                <div class="mb-3">
                    <label for="dataset" class="form-label">Pilih Dataset</label>
                    <select wire:model="selectedDatasetId" id="dataset" class="form-control">
                        <option value="">-- Pilih Dataset --</option>
                        @foreach ($datasets as $dataset)
                            <option value="{{ $dataset->id }}">
                                {{ $dataset->original_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('selectedDatasetId')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            @if ($selectedDatasetId)
                <button wire:click="submit" wire:loading.attr="disabled" wire:target="submit"
                    class="btn btn-primary mt-2">
                    <span wire:loading.remove wire:target="submit">Lanjutkan ke Pembersihan Data</span>
                    <span wire:loading wire:target="submit">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Memproses...
                    </span>
                </button>
            @endif
        </div>
    </div>
</div>
