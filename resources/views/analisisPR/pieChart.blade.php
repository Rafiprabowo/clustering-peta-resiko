@extends('layout.app')
@section('title', 'Pie Chart')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url()->previous() }}" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Pie Chart</h1>
            </div>

            <div class="section-body">
                @foreach ($chartData as $cluster => $ikus)
                    <div class="row mb-4"> {{-- <== row per chart --}}
                        <div class="col-12">
                            <div class="card border-0 shadow rounded">
                                <div class="card-body">
                                    <h5 class="card-title">Cluster {{ $cluster }}</h5>
                                    <canvas id="chartCluster{{ $cluster }}"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        @foreach ($chartData as $cluster => $ikus)
            const ctx{{ $cluster }} = document.getElementById('chartCluster{{ $cluster }}');

            new Chart(ctx{{ $cluster }}, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($ikus->keys()) !!},
                    datasets: [{
                        label: 'Jumlah IKU',
                        data: {!! json_encode($ikus->map(fn($d) => $d['count'])->values()) !!},
                        backgroundColor: [
                            '#f87171', '#60a5fa', '#facc15', '#34d399',
                            '#a78bfa', '#fb923c', '#4ade80', '#f472b6',
                            '#38bdf8', '#c084fc'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Distribusi IKU - Cluster {{ $cluster }}'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label;
                                    const value = context.raw;
                                    const usulans = {!! json_encode($ikus->map(fn($d) => $d['usulans'])->toArray()) !!};
                                    const usulanList = usulans[label].join(', ');
                                    return `${label}: ${value} kegiatan\nidUsulan: ${usulanList}`;
                                }
                            }
                        }
                    }
                }
            });
        @endforeach
    </script>
@endpush
