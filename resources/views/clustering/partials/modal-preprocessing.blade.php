<div class="border rounded bg-light p-3">
    <h6 class="text-primary font-weight-bold mb-3">Nilai Skala (Hasil Preprocessing)</h6>
    <dl class="row mb-0">
        <dt class="col-sm-12 font-weight-bold">Sebelum Scaling</dt>
        <dt class="col-sm-4">IKU</dt>
        <dd class="col-sm-8">{{ $item->iku }}</dd>
        <dt class="col-sm-4">Nilai Anggaran</dt>
        <dd class="col-sm-8">{{ $item->nilai_anggaran }}</dd>
        <dt class="col-sm-4">Tingkat Risiko</dt>
        <dd class="col-sm-8">{{ $item->tingkat_risiko }}</dd>

        <hr class="col-12 my-2">

        <dt class="col-sm-12 font-weight-bold">Sesudah Scaling</dt>
        <dt class="col-sm-4">Nilai IKU (Skor)</dt>
        <dd class="col-sm-8">{{ $item->nilai_iku }}</dd>
        <dt class="col-sm-4">Nilai Anggaran Scaled</dt>
        <dd class="col-sm-8">{{ $item->nilai_anggaran_scaled }}</dd>
        <dt class="col-sm-4">Tingkat Risiko Scaled</dt>
        <dd class="col-sm-8">{{ $item->tingkat_risiko_scaled }}</dd>
    </dl>
</div>
