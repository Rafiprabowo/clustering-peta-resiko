@extends('layout.app')
@section('title', 'Heat Map Cluster')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url()->previous() }}" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Heatmap IKU / Cluster</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-body">
                                <div class="" id="heatmap"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        const options = {
            chart: {
                type: 'heatmap',
                height: 600,
                toolbar: {
                    show: true
                }
            },
            plotOptions: {
                heatmap: {
                    shadeIntensity: 0.5,
                    radius: 4,
                    useFillColorAsStroke: false,
                    colorScale: {
                        ranges: [{
                                from: 0,
                                to: 0,
                                name: 'Tidak Ada',
                                color: '#f2f2f2'
                            },
                            {
                                from: 1,
                                to: 5,
                                name: 'Rendah',
                                color: '#99ccff'
                            },
                            {
                                from: 6,
                                to: 10,
                                name: 'Sedang',
                                color: '#3399ff'
                            },
                            {
                                from: 11,
                                to: 9999,
                                name: 'Tinggi',
                                color: '#004080'
                            },
                        ]
                    }
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '12px'
                }
            },
            xaxis: {
                categories: [
                    @for ($i = 0; $i < $clusterCount; $i++)
                        "Cluster {{ $i }}"
                        {{ $i < $clusterCount - 1 ? ',' : '' }}
                    @endfor
                ]
            },
            yaxis: {
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            tooltip: {
                enabled: true,
                y: {
                    formatter: val => `${val} data`
                }
            },
            series: {!! json_encode($heatmapData) !!}
        };

        const chart = new ApexCharts(document.querySelector("#heatmap"), options);
        chart.render();
    </script>
@endpush
