<div>
    {{-- <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ $currentStep === 'dataset' ? 'active' : '' }}"
                wire:click="$set('currentStep', 'dataset')">Pilih Dataset</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentStep === 'cleaning' ? 'active' : '' }} {{ $canAccess['cleaning'] ? '' : 'disabled' }}"
                wire:click="goToStep('cleaning')">Pembersihan Data</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentStep === 'transform' ? 'active' : '' }} {{ $canAccess['transform'] ? '' : 'disabled' }}"
                wire:click="goToStep('transform')">Transformasi Data</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentStep === 'pilih-fitur' ? 'active' : '' }} {{ $canAccess['pilih-fitur'] ? '' : 'disabled' }}"
                wire:click="goToStep('pilih-fitur')">Pemilihan Fitur</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentStep === 'normalisasi' ? 'active' : '' }} {{ $canAccess['normalisasi'] ? '' : 'disabled' }}"
                wire:click="goToStep('normalisasi')">Normalisasi</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentStep === 'clustering' ? 'active' : '' }} {{ $canAccess['clustering'] ? '' : 'disabled' }}"
                wire:click="goToStep('clustering')">Clustering</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentStep === 'visualisasi' ? 'active' : '' }} {{ $canAccess['visualisasi'] ? '' : 'disabled' }}"
                wire:click="goToStep('visualisasi')">Visualisasi</a>
        </li>
    </ul> --}}


    {{-- Konten Tab Aktif --}}
    {{-- @if ($currentStep === 'dataset')
        @livewire('clustering.step-dataset')
    @elseif ($currentStep === 'cleaning')
        @livewire('clustering.step-cleaning', ['prosesClusteringId' => $prosesClusteringId], key($prosesClusteringId . '-cleaning'))
    @elseif ($currentStep === 'transform')
        @livewire('clustering.step-transformasi', ['prosesClusteringId' => $prosesClusteringId], key('transform-' . $prosesClusteringId))
    @elseif ($currentStep === 'pilih-fitur')
        @livewire('clustering.step-select-features', ['prosesClusteringId' => $prosesClusteringId], key('features-' . $prosesClusteringId))
    @elseif($currentStep === 'normalisasi')
        @livewire('clustering.step-normalisasi', ['prosesClusteringId' => $prosesClusteringId], key('normalisasi-' . $prosesClusteringId))
    @elseif($currentStep === 'clustering')
        @livewire('clustering.step-clustering', ['prosesClusteringId' => $prosesClusteringId], key('clustering-' . $prosesClusteringId))
    @elseif($currentStep === 'visualisasi')
        @livewire('clustering.step-visualisasi', ['prosesClusteringId' => $prosesClusteringId], key('visualisasi-' . $prosesClusteringId))
    @endif --}}


    <div>
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ $currentStep === 'dataset' ? 'active' : '' }}"
                    wire:click="$set('currentStep', 'dataset')">Pilih Dataset</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $currentStep === 'cleaning' ? 'active' : '' }}"
                    wire:click="$set('currentStep', 'cleaning')">Pembersihan Data</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $currentStep === 'transform' ? 'active' : '' }}"
                    wire:click="$set('currentStep', 'transform')">Transformasi Data</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $currentStep === 'pilih-fitur' ? 'active' : '' }}"
                    wire:click="$set('currentStep', 'pilih-fitur')">Pemilihan Fitur</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $currentStep === 'normalisasi' ? 'active' : '' }}"
                    wire:click="$set('currentStep', 'normalisasi')">Normalisasi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $currentStep === 'clustering' ? 'active' : '' }}"
                    wire:click="$set('currentStep', 'clustering')">Clustering</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $currentStep === 'visualisasi' ? 'active' : '' }}"
                    wire:click="$set('currentStep', 'visualisasi')">Visualisasi</a>
            </li>
        </ul>

        {{-- Konten Tab Aktif --}}
        @if ($currentStep === 'dataset')
            @livewire('clustering.step-dataset')
        @elseif ($currentStep === 'cleaning')
            @livewire('clustering.step-cleaning', ['prosesClusteringId' => $prosesClusteringId], key($prosesClusteringId . '-cleaning'))
        @elseif ($currentStep === 'transform')
            @livewire('clustering.step-transformasi', ['prosesClusteringId' => $prosesClusteringId], key('transform-' . $prosesClusteringId))
        @elseif($currentStep === 'pilih-fitur')
            @livewire('clustering.step-select-features', ['prosesClusteringId' => $prosesClusteringId], key('features-' . $prosesClusteringId))
        @elseif($currentStep === 'normalisasi')
            @livewire('clustering.step-normalisasi', ['prosesClusteringId' => $prosesClusteringId], key('normalisasi-' . $prosesClusteringId))
        @elseif($currentStep === 'clustering')
            @livewire('clustering.step-clustering', ['prosesClusteringId' => $prosesClusteringId], key('clustering-' . $prosesClusteringId))
        @elseif($currentStep === 'visualisasi')
            @livewire('clustering.step-visualisasi', ['prosesClusteringId' => $prosesClusteringId], key('visualisasi-' . $prosesClusteringId))
        @endif
    </div>

</div>
