<div>
    <p>Fitur yang akan digunakan untuk proses clustering:</p>
    <ul>
        @php
            $labelMap = [
                'iku' => 'IKU',
                'nilai_rab_usulan' => 'Nilai RAB Usulan',
                'skor_risiko' => 'Tingkat Risiko',
            ];
        @endphp

        @foreach ($selectedFeatures as $feature)
            <li><strong>{{ $labelMap[$feature] ?? ucfirst(str_replace('_', ' ', $feature)) }}</strong></li>
        @endforeach

    </ul>

    <button wire:click="lanjut" class="btn btn-primary mt-3">
        Lanjut ke Tahap Normalisasi
    </button>
</div>
