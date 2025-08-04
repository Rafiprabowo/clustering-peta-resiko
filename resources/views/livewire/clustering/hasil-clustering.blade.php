@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-selectric/1.13.0/selectric.css"
        integrity="sha512-iVvvEOEkekcVGxDdD5kKzRuQg+Ib4+ok3g+nq8rmY8ByosVXGO8eg9ofsv1dZFVAcbBIz+XjTfrrKJApHuUqxA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

<div>
    <div class="row">
        <div class="col-12">
            @if (!empty($jumlahPerCluster))
                <h5 class="text-center">Tabel Jumlah Data per Klaster</h5>
                <table class="table table-bordered table-striped mb-4">
                    <thead class="text-center">
                        <tr>
                            <th>Klaster</th>
                            <th>Label</th>
                            <th>Jumlah Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jumlahPerCluster as $item)
                            <tr class="text-center">
                                <td>{{ $item['cluster'] }}</td>
                                <td>{{ $item['label'] }}</td>
                                <td>{{ $item['jumlah'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <h5 class="mt-4 text-center">Tabel Indikator Kinerja Utama (IKU)</h5>
            <table class="table table-striped table-bordered mb-2">
                <thead class="text-center">
                    <tr>
                        <th>Kode IKU</th>
                        <th>Klaster</th>
                        <th>Label</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->uniqueIkuPerCluster as $item)
                        <tr>
                            <td>
                                @foreach ($item['ikus'] as $iku)
                                    <span class="badge bg-primary text-white me-1">{{ $iku }}</span>
                                @endforeach
                            </td>
                            <td class="text-center">{{ $item['cluster'] }}</td>
                            <td class="text-center">{{ $item['label'] }}</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
    <h5 class="mt-4 text-center mb-2">Tabel ID Usulan</h5>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="">Filter Indikator Kinerja Utama</label>
            <select wire:model="filterIku" class="form-control selectric">
                <option value="all">Semua IKU</option>
                @foreach ($ikuOptions as $iku)
                    <option value="{{ $iku }}">{{ $iku }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="">Filter Label Klaster</label>
            <select wire:model="filterLabel" class="form-control selectric">
                <option value="all">Semua Label</option>
                @foreach ($labelOptions as $label)
                    <option value="{{ $label }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <div>
                <label>Total data: {{ count($this->filteredData) }}</label>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>ID Usulan</th>
                <th>IKU</th>
                <th>Klaster</th>
                <th>Label</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($paginatedData as $index => $row)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration + ($paginatedData->currentPage() - 1) * $paginatedData->perPage() }}</td>
                    <td>{{ $row['id_usulan'] }}</td>
                    <td>{{ $row['iku'] }}</td>
                    <td class="text-center">{{ $row['cluster'] }}</td>
                    <td>{{ $row['label'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $paginatedData->links() }}
    </div>
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-selectric/1.13.0/jquery.selectric.min.js"
        integrity="sha512-/V5D/OG9tAErOtOXkZZ8nh5idZlM+hGRR7LqkFd+M7JbZZfvogqCd3P9IpFCU14EGbF7IygAvbI+0CR0yoV02Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        document.addEventListener('livewire:load', function() {
            $('select.selectric').selectric();
            Livewire.hook('message.processed', () => {
                $('select.selectric').selectric('refresh');
            });
        });
    </script>
@endpush
