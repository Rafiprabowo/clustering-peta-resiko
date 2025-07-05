<div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="input-group mb-2">
                <select wire:model="fileId" class="form-control mr-2">
                    <option value="">Pilih File Clustering</option>
                    @foreach ($files as $file)
                        <option value="{{ $file->id }}">{{ $file->nama_file }} </option>
                        {{-- ({{ \Carbon\Carbon::parse($file->created_at)->format('Y') }}) --}}
                    @endforeach
                </select>

                <select wire:model="year" class="form-control mr-2">
                    <option value="">Pilih Tahun</option>
                    @foreach ($years as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>

                <select wire:model="cluster" class="form-control mr-2">
                    <option value="">Pilih Cluster</option>
                    @foreach ($clusters as $c)
                        <option value="{{ $c }}">Cluster {{ $c }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <table class="table table-bordered mt-2">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Unit Kerja</th>
                <th>Judul</th>
                <th>IKU</th>
                <th>Anggaran</th>
                <th>Skor Dampak</th>
                <th>Skor Probabilitas</th>
                <th>Tingkat Risiko</th>
                <th>Tahun</th>
                <th>File Excel</th>
                <th>Cluster</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($hasilClusterings as $item)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration + ($hasilClusterings->currentPage() - 1) * $hasilClusterings->perPage() }}
                    </td>
                    <td>{{ $item->nmUnit }}</td>
                    <td>{{ $item->nmKegiatan }}</td>
                    <td>{{ $item->iku }}</td>
                    <td class="text-right">{{ number_format($item->nilRabUsulan, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $item->preprocessing->transform['dampak'] ?? '-' }}</td>
                    <td class="text-center">{{ $item->preprocessing->transform['probaBilitas'] ?? '-' }}</td>
                    <td class="text-center">{{ $item->preprocessing->transform['tingkat_risiko'] ?? '-' }}</td>
                    <td class="text-center">{{ $item->clusteringRun ? \Carbon\Carbon::parse($item->clusteringRun->created_at)->format('Y') : '-' }}</td>
                    <td class="text-center">{{ $item->clusteringRun->nama_file ?? '-' }}</td>
                    <td class="text-center">
                        {{ $item->cluster->cluster ?? '-' }}
                        ({{ $item->cluster && $item->cluster->interpretasi ? $item->cluster->interpretasi->interpretasi : '-' }})
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center">Data tidak tersedia</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-start">
        {{ $hasilClusterings->links() }}
    </div>
</div>
