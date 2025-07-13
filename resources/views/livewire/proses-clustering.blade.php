@push('style')
    <style>
        .fixed-cell {
            max-width: 250px !important;
            height: 100px !important;
            overflow-y: auto !important;
            white-space: normal !important;
            word-wrap: break-word !important;
            display: block;
        }

        .highlight-kolom {
            background-color: #d4edda;
            color: #155724;
            /* teks hijau gelap supaya kontras */
        }
    </style>
@endpush


<div>
    <div class="card-body" x-data="{ tab: @entangle('activeTab') }">

        <div class="row mb-4">
            <div class="col-md-4">
                <label for="tahun">Pilih Tahun:</label>
                <select class="form-control" wire:model="selectedYear" id="tahun">
                    <option value="">-- Pilih Tahun --</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="clustering">Pilih File Peta Risiko:</label>
                @if ($selectedYear)
                    <select class="form-control" wire:model="selectedClustering" id="clustering">
                        <option value="">-- Pilih File --</option>
                        @foreach ($clusteringList as $id => $nama)
                            <option value="{{ $id }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                @else
                    <input type="text" class="form-control" value="Silakan pilih tahun terlebih dahulu" disabled>
                @endif
            </div>
        </div>

        <!-- TAB NAVIGATION -->
        <ul class="nav nav-pills mb-3" role="tablist">
            <li class="nav-item">
                <a href="#" class="nav-link" :class="{ 'active': tab === 'cleaning' }"
                    @click.prevent="tab = 'cleaning'">Cleaning</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" :class="{ 'active': tab === 'transform' }"
                    @click.prevent="tab = 'transform'">Transform</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" :class="{ 'active': tab === 'normalisasi' }"
                    @click.prevent="tab = 'normalisasi'">Normalisasi</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" :class="{ 'active': tab === 'cluster' }"
                    @click.prevent="tab = 'cluster'">Cluster</a>
            </li>
        </ul>

        <!-- TAB CONTENT -->
        <div class="tab-content">
            <!-- CLEANING -->
            <div x-show="tab === 'cleaning'" wire:ignore.self>
                @if ($selectedYear && $selectedClustering)
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Unit Kerja</th>
                                    <th>ID Usulan</th>
                                    <th class="highlight-kolom">IKU</th>
                                    <th>Nama Kegiatan</th>
                                    <th class="highlight-kolom">Anggaran</th>
                                    <th>Pernyataan</th>
                                    <th>Kategori</th>
                                    <th>Uraian</th>
                                    <th class="highlight-kolom">Probabilitas</th>
                                    <th class="highlight-kolom">Dampak</th>
                                    <th>Tingkat Risiko</th>
                                    <th>Pengendalian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $i => $item)
                                    <tr>
                                        <td class="align-top">{{ $items->firstItem() + $i }}</td>
                                        <td class="align-top text-wrap">{{ $item->nama_unit }}</td>
                                        <td class="align-top text-wrap">{{ $item->id_usulan }}</td>
                                        <td class="align-top text-wrap highlight-kolom">{{ $item->iku }}</td>

                                        <td class="align-top">
                                            <div class="fixed-cell">
                                                {{ $item->nama_kegiatan }}
                                            </div>
                                        </td>

                                        <td class="align-top text-right highlight-kolom">
                                            {{ number_format($item->nil_rab_usulan, 0, ',', '.') }}
                                        </td>

                                        <td class="align-top">
                                            <div class="fixed-cell">
                                                {{ $item->pernyataan_risiko }}
                                            </div>
                                        </td>

                                        <td class="align-top">
                                            <div class="fixed-cell">
                                                {{ $item->kategori_risiko }}
                                            </div>
                                        </td>

                                        <td class="align-top">
                                            <div class="fixed-cell">
                                                {{ $item->uraian_dampak }}
                                            </div>
                                        </td>

                                        <td class="align-top highlight-kolom">{{ $item->probabilitas }}</td>
                                        <td class="align-top highlight-kolom">{{ $item->dampak }}</td>
                                        <td class="align-top">-</td>

                                        <td class="align-top">
                                            <div class="fixed-cell">
                                                {{ $item->pengendalian }}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="text-center">Tidak ada data ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $items->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-start mt-3">
                        <em>Silakan pilih Tahun dan File Peta Risiko terlebih dahulu.</em>
                    </div>
                @endif
            </div>

            <!-- TRANSFORM -->
            <div x-show="tab === 'transform'" wire:ignore.self>
                @if ($selectedYear && $selectedClustering)
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Unit Kerja</th>
                                    <th>ID Usulan</th>
                                    <th class="highlight-kolom">IKU</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Anggaran</th>
                                    <th>Pernyataan</th>
                                    <th>Kategori</th>
                                    <th>Uraian</th>
                                    <th class="highlight-kolom">Probabilitas</th>
                                    <th class="highlight-kolom">Dampak</th>
                                    <th>Tingkat Risiko</th>
                                    <th>Pengendalian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $i => $item)
                                    <tr>
                                        <td class="align-top">{{ $items->firstItem() + $i }}</td>
                                        <td class="align-top text-wrap">{{ $item->nama_unit }}</td>
                                        <td class="align-top text-wrap">{{ $item->id_usulan }}</td>
                                        <td class="align-top text-wrap highlight-kolom">{{ $item->iku_numerik }}</td>
                                        <td class="align-top text-wrap fixed-cell">{{ $item->nama_kegiatan }}</td>
                                        <td class="align-top text-right">
                                            {{ number_format($item->nil_rab_usulan, 0, ',', '.') }}</td>

                                        <td class="align-top">
                                            <div class="fixed-cell">
                                                {{ $item->pernyataan_risiko }}
                                            </div>
                                        </td>

                                        <td class="align-top">
                                            <div class="fixed-cell">
                                                {{ $item->kategori_risiko }}
                                            </div>
                                        </td>

                                        <td class="align-top">
                                            <div class="fixed-cell">
                                                {{ $item->uraian_dampak }}
                                            </div>
                                        </td>

                                        <td class="align-top highlight-kolom">{{ $item->probabilitas }}</td>
                                        <td class="align-top highlight-kolom">{{ $item->dampak }}</td>
                                        <td class="align-top">-</td>
                                        <td class="align-top">
                                            <div class="fixed-cell">
                                                {{ $item->pengendalian }}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="text-center">Tidak ada data ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $items->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-start mt-3">
                        <em>Silakan pilih Tahun dan File Peta Risiko terlebih dahulu.</em>
                    </div>
                @endif
            </div>

            <!-- NORMALISASI -->
            <div x-show="tab === 'normalisasi'" wire:ignore.self>
                @if ($selectedYear && $selectedClustering)
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Unit Kerja</th>
                                    <th>ID Usulan</th>
                                    <th class="highlight-kolom">IKU</th>
                                    <th>Nama Kegiatan</th>
                                    <th class="highlight-kolom">Anggaran</th>
                                    <th>Pernyataan</th>
                                    <th>Kategori</th>
                                    <th>Uraian</th>
                                    <th>Probabilitas</th>
                                    <th>Dampak</th>
                                    <th class="highlight-kolom">Tingkat Risiko</th>
                                    <th>Pengendalian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $i => $item)
                                    <tr>
                                        <td class="align-top">{{ $items->firstItem() + $i }}</td>
                                        <td>{{ $item->nama_unit }}</td>
                                        <td>{{ $item->id_usulan }}</td>
                                        <td class="highlight-kolom">{{ $item->normal_iku_numerik }}</td>
                                        <td>{{ $item->nama_kegiatan }}</td>
                                        <td class="highlight-kolom">{{ $item->normal_nil_rab_usulan }}</td>
                                        <td class="align-top">
                                            <div class="fixed-cell">
                                                {{ $item->pernyataan_risiko }}
                                            </div>
                                        </td>

                                        <td class="align-top">
                                            <div class="fixed-cell">
                                                {{ $item->kategori_risiko }}
                                            </div>
                                        </td>

                                        <td class="align-top">
                                            <div class="fixed-cell">
                                                {{ $item->uraian_dampak }}
                                            </div>
                                        </td>
                                        <td>{{ $item->probabilitas_numerik }}</td>
                                        <td>{{ $item->dampak_numerik }}</td>
                                        <td class="highlight-kolom">{{ $item->normal_tingkat_risiko }}</td>
                                        <td class="align-top">
                                            <div class="fixed-cell">
                                                {{ $item->pengendalian }}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak ada data ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $items->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-start mt-3">
                        <em>Silakan pilih Tahun dan File Peta Risiko terlebih dahulu.</em>
                    </div>
                @endif
            </div>

            <!-- CLUSTER -->
            <div x-show="tab === 'cluster'" wire:ignore.self>
                @if ($selectedYear && $selectedClustering)
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Unit Kerja</th>
                                    <th>ID Usulan</th>
                                    <th>IKU</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Anggaran</th>
                                    <th>Pernyataan</th>
                                    <th>Kategori</th>
                                    <th>Uraian</th>
                                    <th>Probabilitas</th>
                                    <th>Dampak</th>
                                    <th>Tingkat Risiko</th>
                                    <th>Pengendalian</th>
                                    <th class="highlight-kolom">Cluster</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    function mapRiskLevelFromScore($score)
                                    {
                                        if ($score >= 21) {
                                            return 'EXTREME';
                                        } elseif ($score >= 16) {
                                            return 'HIGH';
                                        } elseif ($score >= 11) {
                                            return 'MIDDLE';
                                        } elseif ($score >= 6) {
                                            return 'LOW';
                                        } else {
                                            return 'VERY LOW';
                                        }
                                    }
                                @endphp
                                @forelse ($items as $i => $item)
                                    <tr>
                                        <td class="align-top">{{ $items->firstItem() + $i }}</td>
                                        <td>{{ $item->nama_unit }}</td>
                                        <td>{{ $item->id_usulan }}</td>
                                        <td>{{ $item->iku }}</td>
                                        <td>{{ $item->nama_kegiatan }}</td>
                                        <td>{{ number_format($item->nil_rab_usulan, 0, ',', '.') }}</td>
                                        <td class="align-top">
                                            <div class="fixed-cell">
                                                {{ $item->pernyataan_risiko }}
                                            </div>
                                        </td>

                                        <td class="align-top">
                                            <div class="fixed-cell">
                                                {{ $item->kategori_risiko }}
                                            </div>
                                        </td>

                                        <td class="align-top">
                                            <div class="fixed-cell">
                                                {{ $item->uraian_dampak }}
                                            </div>
                                        </td>
                                        <td>{{ $item->probabilitas }}</td>
                                        <td>{{ $item->dampak }}</td>
                                        <td>{{ mapRiskLevelFromScore($item->tingat_risiko) }}</td>
                                        <td class="align-top">
                                            <div class="fixed-cell">
                                                {{ $item->pengendalian }}
                                            </div>
                                        </td>
                                        <td class="highlight-kolom">{{ $item->cluster }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak ada data ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $items->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-start mt-3">
                        <em>Silakan pilih Tahun dan File Peta Risiko terlebih dahulu.</em>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
