@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="ict-dashboard.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
@endsection

@section('body')
    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Tiket <span>| Hari</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-ticket"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $ticket }}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- WO Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">

                            <div class="card-body">
                                <h5 class="card-title">Perintah Kerja <span>| Hari</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-workspace"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $uncomplete }}</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Berhasil Card -->
                    <div class="col-xxl-4 col-xl-12">

                        <div class="card info-card customers-card">

                            <div class="card-body">
                                <h5 class="card-title">Tugas Selesai <span>| Hari</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $persentaseSelesai }}%</h6>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->

                    <!-- Tiket Masuk Terkini -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">

                            <div class="filter">
                                <a class="icon" href="{{ route('list-ticket') }}">Lihat
                                    Semua</a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Tiket Masuk Terkini</h5>

                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">No. Tiket</th>
                                            <th scope="col">Kategori</th>
                                            <th scope="col">Nama Peminta</th>
                                            <th scope="col">Divisi</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tickets as $item)
                                            <tr>
                                                <th scope="row"><a href="#">{{ $item->ticket_number }}</a></th>
                                                <td>{{ $item->subcategory->category->name }}</td>
                                                <td><strong>{{ $item->name }}</strong></td>
                                                <td>{{ $item->division ? $item->division->division_name : '-' }}</td>
                                                <td>
                                                    <span @class([
                                                        'badge',
                                                        'bg-info text-dark ' => $item->status == 'Terkirim',
                                                        'bg-warning text-dark' => $item->status == 'Verifikasi',
                                                        'bg-info-light text-dark' => $item->status == 'Penugasan',
                                                        'bg-primary' => $item->status == 'Pengerjaan',
                                                        'text-bg-success' => $item->status == 'Selesai',
                                                        'text-bg-danger' => $item->status == 'Ditolak',
                                                    ])>{{ $item->status }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div><!-- End Recent Sales -->

                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">

                <!-- Tiket Traffic -->
                <div class="card">

                    <div class="card-body pb-0">
                        <h5 class="card-title">Trafik Tiket <span>| Hari ini</span></h5>

                        <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                echarts.init(document.querySelector("#trafficChart")).setOption({
                                    tooltip: {
                                        trigger: 'item'
                                    },
                                    legend: {
                                        top: '5%',
                                        left: 'center'
                                    },
                                    series: [{
                                        name: 'Access From',
                                        type: 'pie',
                                        radius: ['40%', '70%'],
                                        avoidLabelOverlap: false,
                                        label: {
                                            show: false,
                                            position: 'center'
                                        },
                                        emphasis: {
                                            label: {
                                                show: true,
                                                fontSize: '18',
                                                fontWeight: 'bold'
                                            }
                                        },
                                        labelLine: {
                                            show: false
                                        },
                                        data: [{
                                                value: "{{ $graph[0] }}",
                                                name: 'Hardware & Jaringan'
                                            },
                                            {
                                                value: "{{ $graph[1] }}",
                                                name: 'Promo'
                                            },
                                            {
                                                value: "{{ $graph[2] }}",
                                                name: 'Selisi Harga'
                                            },
                                            {
                                                value: "{{ $graph[3] }}",
                                                name: 'Diskon'
                                            },
                                            {
                                                value: "{{ $graph[4] }}",
                                                name: 'Aset'
                                            }
                                        ]
                                    }]
                                });
                            });
                        </script>

                    </div>
                </div><!-- End Website Traffic -->

            </div><!-- End Right side columns -->

        </div>
    </section>
@endsection
