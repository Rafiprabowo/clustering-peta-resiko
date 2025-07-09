<dl class="row">
    <dt class="col-sm-4">IKU</dt>
    <dd class="col-sm-8">{{ $item->iku ?? '-' }}</dd>

    <dt class="col-sm-4">Nilai Anggaran</dt>
    <dd class="col-sm-8">Rp {{ number_format($item->nilai_anggaran) }}</dd>

    <dt class="col-sm-4">Kategori Risiko</dt>
    <dd class="col-sm-8">{{ $item->kategori_risiko }}</dd>

    <dt class="col-sm-4">Dampak</dt>
    <dd class="col-sm-8">{{ $item->dampak }}</dd>

    <dt class="col-sm-4">Probabilitas</dt>
    <dd class="col-sm-8">{{ $item->probabilitas }}</dd>

    <dt class="col-sm-4">Tingkat Risiko</dt>
    <dd class="col-sm-8">{{ $level }}</dd>

    <dt class="col-sm-4">Pernyataan Risiko</dt>
    <dd class="col-sm-8">{{ $item->pernyataan_risiko }}</dd>

    <dt class="col-sm-4">Uraian Dampak</dt>
    <dd class="col-sm-8">{{ $item->uraian_dampak }}</dd>

    <dt class="col-sm-4">Pengendalian</dt>
    <dd class="col-sm-8">{{ $item->pengendalian }}</dd>

    <dt class="col-sm-4">Rekomendasi Umum</dt>
    <dd class="col-sm-8">{{ $item->rekomendasi ?? '-' }}</dd>

    <dt class="col-sm-4">Status Telaah</dt>
    <dd class="col-sm-8">{{ $item->status_telaah }}</dd>
</dl>
