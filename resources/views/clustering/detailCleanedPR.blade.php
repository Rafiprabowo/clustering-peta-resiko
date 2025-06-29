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
                        <span class="span0">Detail Peta Risiko</span>
                    </h4>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <div class="card border-0 shadow rounded">
                            <div class="card-body">

                                <table class="table table-white table-sm">
                                    <tr>
                                        <th class="col-2">Judul Kegiatan : </th>
                                        <td>{{ $peta->nmKegiatan }}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-2">Unit Kerja : </th>
                                        <td>{{ $peta->nmUnit }}</td>
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
                                                        <td>{{ $peta->nilRabUsulan }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-3">Pernyataan Risiko:</th>
                                                        <td>{{ $peta->pernyataanRisiko }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-3">Kategori Risiko:</th>
                                                        <td>{{ $peta->Resiko }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-3">Uraian Dampak:</th>
                                                        <td>{{ $peta->uraianDampak }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-3">Pengendalian:</th>
                                                        <td>{{ $peta->pengendalian }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-3">Probabilitas:</th>
                                                        <td>{{ $peta->probaBilitas }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-3">Dampak:</th>
                                                        <td>{{ $peta->dampak }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                {{-- <table class="table table-responsive">
                                    @if (Auth::user()->id_level == 1 ||
                                            Auth::user()->id_level == 2 ||
                                            Auth::user()->id_level == 3 ||
                                            Auth::user()->id_level == 4 ||
                                            Auth::user()->id_level == 6)
                                        <tr>
                                            <th class="col-2">Komentar : </th>
                                            <td>
                                                <div class="card mt-4">
                                                    <div class="card-header">Tambah Komentar Aspek Keungan
                                                    </div>
                                                    <div class="card-body">
                                                        <form action="{{ route('postComment', $petas->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" value="keuangan" name="jenis">
                                                            <div class="form-group">
                                                                <textarea name="comment" class="form-control" rows="3" placeholder="Masukkan komentar" required></textarea>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Kirim</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="card mt-4">
                                                    <div class="card-header">Tambah Komentar Analisis Risiko
                                                    </div>
                                                    <div class="card-body">
                                                        <form action="{{ route('postComment', $petas->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" value="analisis" name="jenis">
                                                            <div class="form-group">
                                                                <textarea name="comment" class="form-control" rows="3" placeholder="Masukkan komentar" required></textarea>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Kirim</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($comment_prs_aspek->isNotEmpty() || $comment_prs_analisis->isNotEmpty())
                                        <tr>
                                            <th class="col-2">Daftar Komentar:</th>
                                            <td colspan="2">
                                                <div class="d-flex justify-content-between">
                                                    <div class="card mt-4 flex-grow-1 me-3">
                                                        <div class="card-header">Komentar Aspek Keuangan</div>
                                                        <div class="card-body">
                                                            @forelse($comment_prs_aspek as $comment)
                                                                <div class="media mb-3">
                                                                    <div class="media-body">
                                                                        <h5 class="mt-0">{{ $comment->user->name }}</h5>
                                                                        <p>{{ $comment->comment }}</p>
                                                                        <small>{{ $comment->created_at->format('d M Y') }}</small>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                            @empty
                                                                <p>Belum ada komentar.</p>
                                                            @endforelse
                                                        </div>
                                                    </div>

                                                    <div class="card mt-4 flex-grow-1 ms-3">
                                                        <div class="card-header">Komentar Analisis Risiko</div>
                                                        <div class="card-body">
                                                            @forelse($comment_prs_analisis as $comment)
                                                                <div class="media mb-3">
                                                                    <div class="media-body">
                                                                        <h5 class="mt-0">{{ $comment->user->name }}</h5>
                                                                        <p>{{ $comment->comment }}</p>
                                                                        <small>{{ $comment->created_at->format('d M Y') }}</small>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                            @empty
                                                                <p>Belum ada komentar.</p>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif

                                </table> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

