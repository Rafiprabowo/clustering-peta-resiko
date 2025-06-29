@extends('layout.app')
@section('title', 'Detail Peta Risiko')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url()->previous() }}" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Detail Peta Risiko</h1>
            </div>
            <div class="section-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="tittle-1">
                        <span class="span0">Detail Peta</span>
                    </h4>
                    {{-- @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                        <a href="{{ route('petas.destroy', $petas->id) }}" class="btn btn-danger mb-2">
                            Hapus Kegiatan
                        </a>
                        <form action="{{ route('petas.destroy', $petas->id) }}" method=""></form>
                        <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                        action="{{ route('petas.destroy', $petas->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn bg-danger p-2 text-white"
                                                            title="Hapus Kegiatan"><i class="fa-solid fa-trash"></i> Hapus Kegiatan</button>
                                                    </form>
                    @endif --}}
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <div class="card border-0 shadow rounded">
                            <div class="card-body">

                                @php
                                    $skor_probabilitas = match ($petas->probaBilitas) {
                                        'Sangat Sering' => 5,
                                        'Sering' => 4,
                                        'Kadang-kadang' => 3,
                                        'Jarang' => 2,
                                        'Sangat Jarang' => 2,
                                    };
                                    $skor_dampak = match ($petas->dampak) {
                                        'Sangat Berpengaruh' => 5,
                                        'Berpengaruh' => 4,
                                        'Cukup Berpengaruh' => 3,
                                        'Sedikit Berpengaruh' => 3,
                                        'Sangat Sedikit Berpengaruh' => 3,
                                    };

                                    $tingkat_risiko = $skor_dampak * $skor_probabilitas;

                                    $level = match (true) {
                                        $tingkat_risiko >= 21 => 'EXTREME',
                                        $tingkat_risiko >= 16 => 'HIGH',
                                        $tingkat_risiko >= 11 => 'MIDDLE',
                                        $tingkat_risiko >= 6  => 'LOW',
                                        default => '',
                                    };


                                @endphp

                                <table class="table table-white table-sm">
                                    <tr>
                                        <th class="col-2">Judul Kegiatan : </th>
                                        <td>{{ $petas->nmKegiatan }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-2">Unit Kerja : </th>
                                        <td>{{ $petas->nmUnit }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <th class="col-2">PIC : </th>
                                        <td>{{ $petas->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-2">IKU : </th>
                                        <td>{{ $petas->kegiatan->iku }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-2">Kode Regist : </th>
                                        <td>{{ $petas->kode_regist }}</td>
                                    </tr> --}}
                                    <tr>
                                        <th class="col-2">Identifikasi Risiko : </th>
                                        <td>
                                            <table class="table table-bordered">
                                                <tbody>
                                                    {{-- <tr>
                                                        <th class="col-3">Sasaran Strategis:</th>
                                                        <td>{{ $petas->kegiatan->sasaran }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-3">Program Kerja:</th>
                                                        <td>{{ $petas->kegiatan->proker }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-3">Indikator:</th>
                                                        <td>{{ $petas->kegiatan->indikator }}</td>
                                                    </tr> --}}
                                                    <tr>
                                                        <th class="col-3">Anggaran:</th>
                                                        <td>{{ $petas->nilRabUsulan }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-3">Pernyataan Risiko:</th>
                                                        <td>{{ $petas->pernyataanRisiko }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-3">Kategori Risiko:</th>
                                                        <td>{{ $petas->Resiko }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-3">Uraian Dampak:</th>
                                                        <td>{{ $petas->uraianDampak }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-3">Metode Pencapaian:</th>
                                                        <td>{{ $petas->pengendalian }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th class="col-3">Skor Probabilitas:</th>
                                                        <td>{{ $skor_probabilitas }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-3">Skor Dampak:</th>
                                                        <td>{{ $skor_dampak }}</td>
                                                    </tr>
                                                    <tr>

                                                        <th class="col-3">Tingkat Risiko:</th>
                                                        <td>{{ $level }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
