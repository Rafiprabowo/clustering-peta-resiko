<div>

    @php
        $opsiDampak = [
            'Sangat Berpengaruh',
            'Berpengaruh',
            'Cukup berpengaruh',
            'Sedikit Berpengaruh',
            'Sangat Sedikit Berpengaruh',
        ];

        $opsiProbabilitas = ['Sangat Sering', 'Sering', 'Kadang-kadang', 'Jarang', 'Sangat Jarang'];

        $opsiRisiko = [
            'Risiko Strategis',
            'Risiko Operasional',
            'Risiko Keuangan',
            'Risiko Kepatuhan',
            'Risiko Kecurangan',
        ];
    @endphp

    @if ($sudahDibersihkan)
        @php
            $cleanedData = $this->cleanedData;
        @endphp

        @if ($cleanedData)
            <div class="row">
                <div class="col-12 text-right">
                    <label for="">Total Data Bersih :{{ $totalData }}</label>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>IKU</th>
                        <th>ID Usulan</th>
                        <th>Nama Kegiatan</th>
                        <th>Nilai RAB</th>
                        <th>Nama Unit</th>
                        <th>Resiko</th>
                        <th>Dampak</th>
                        <th>Probabilitas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cleanedData as $index => $item)
                        <tr wire:key="cleaned-{{ $item->id }}">
                            <td>{{ $cleanedData->firstItem() + $index }}</td>
                            <td>{{ $item->iku }}</td>
                            <td>{{ $item->id_usulan }}</td>
                            <td>{{ $item->nama_kegiatan }}</td>
                            <td>{{ number_format($item->nilai_rab_usulan, 0, ',', '.') }}</td>
                            <td>{{ $item->nama_unit }}</td>
                            <td>{{ $item->resiko }}</td>
                            <td>{{ $item->dampak }}</td>
                            <td>{{ $item->probabilitas }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $cleanedData->links() }}
        @endif
    @else
        @if (!$sudahDibersihkan && isset($missingCounts))
            <div class="alert">
                <strong>Informasi Data Hilang:</strong>
                <table class="table table-bordered mt-2">
                    <thead>
                        <tr>
                            <th>Nama Kolom</th>
                            <th>Jumlah Baris</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>IKU kosong</td>
                            <td>{{ $missingCounts['iku'] }}</td>
                        </tr>
                        <tr>
                            <td>Nilai RAB Usulan kosong</td>
                            <td>{{ $missingCounts['nilai_rab_usulan'] }}</td>
                        </tr>
                        <tr>
                            <td>Dampak kosong</td>
                            <td>{{ $missingCounts['dampak'] }}</td>
                        </tr>
                        <tr>
                            <td>Probabilitas kosong</td>
                            <td>{{ $missingCounts['probabilitas'] }}</td>
                        </tr>
                        <tr>
                            <td>Duplikat berdasarkan <code>Nama Kegiatan</code></td>
                            <td>{{ $duplicateCount }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif

        <div class="row mb-3 align-items-center">
            <div class="col-md-6">
                <label class="mb-0">Total Data: {{ $totalData }}</label>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <button wire:click="cleanData" wire:loading.attr="disabled" wire:target="cleanData"
                    class="btn btn-primary">
                    <span wire:loading.remove wire:target="cleanData">Bersihkan Data</span>
                    <span wire:loading wire:target="cleanData">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Memproses...
                    </span>
                </button>
            </div>

        </div>


        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Usulan</th>
                    <th>IKU</th>
                    <th>Nama Kegiatan</th>
                    <th>Nilai RAB</th>
                    <th>Nama Unit</th>
                    <th>Resiko</th>
                    <th>Dampak</th>
                    <th>Probabilitas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr @if (in_array($item->id, $invalidRows)) class="table-danger" @endif>
                        <td>{{ $data->firstItem() + $loop->index }}</td>

                        @if ($editingId === $item->id)
                            {{-- Form Edit --}}

                            <td>
                                {{-- <input type="text" wire:model.defer="editData.id_usulan"
                                    class="form-control form-control-sm"> --}}
                            </td>

                            <td><input type="text" wire:model.defer="editData.iku"
                                    class="form-control form-control-sm">
                            </td>
                            <td>
                                {{-- <input type="text" wire:model.defer="editData.nama_kegiatan"
                                    class="form-control form-control-sm"> --}}
                            </td>
                            <td>
                                {{-- <input type="text" wire:model.defer="editData.nilai_rab_usulan"
                                    class="form-control form-control-sm"> --}}
                            </td>
                            <td>
                                {{-- <input type="text" wire:model.defer="editData.nama_unit"
                                    class="form-control form-control-sm"> --}}
                            </td>
                            <td>
                                <select wire:model.defer="editData.resiko" class="form-control form-control-sm "
                                    id="">
                                    <option value="">--Pilih Risiko--</option>
                                    @foreach ($opsiRisiko as $val)
                                        <option value="{{ $val }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            <td>
                                <select wire:model.defer="editData.dampak" class="form-control form-control-sm">
                                    <option value="">-- Pilih Dampak --</option>
                                    @foreach ($opsiDampak as $val)
                                        <option value="{{ $val }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select wire:model.defer="editData.probabilitas" class="form-control form-control-sm">
                                    <option value="">-- Pilih Probabilitas --</option>
                                    @foreach ($opsiProbabilitas as $val)
                                        <option value="{{ $val }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-success"
                                    wire:click="update({{ $item->id }})">✔️</button>
                                <button class="btn btn-sm btn-secondary" wire:click="cancelEdit">✖️</button>
                            </td>
                        @else
                            {{-- Tampilan Normal --}}
                            <td>{{ $item->id_usulan }}</td>
                            <td>
                                {{ $item->iku }}
                                @if (in_array($item->id, $invalidRows) && (is_null($item->iku) || trim($item->iku) === ''))
                                    <span class="badge bg-danger">❗ kosong</span>
                                @endif
                            </td>
                            <td>{{ $item->nama_kegiatan }}</td>
                            <td>{{ number_format($item->nilai_rab_usulan, 0, ',', '.') }}</td>
                            <td>{{ $item->nama_unit }}</td>
                            <td>{{ $item->resiko }}</td>
                            <td>{{ $item->dampak }}</td>
                            <td>{{ $item->probabilitas }}</td>
                            <td>
                                <div style="display: flex">
                                    <button style="margin-right:4px" class="btn btn-sm btn-primary"
                                        wire:click="edit({{ $item->id }})">Edit</button>
                                    <button class="btn btn-sm btn-danger" wire:click="delete({{ $item->id }})"
                                        onclick="confirm('Yakin ingin menghapus?') || event.stopImmediatePropagation()">Hapus</button>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col d-flex align-items-center justify-content-between">
                {{-- Kiri --}}
                <div>
                    {{ $data->links() }}
                </div>

                {{-- Kanan --}}
                @if ($isDataBersih && !$sudahDibersihkan)
                    <div>
                        <button wire:click="lanjut" class="btn btn-primary">
                            Lanjut ke Transformasi
                        </button>
                    </div>
                @endif
            </div>
        </div>


    @endif
    <div />
