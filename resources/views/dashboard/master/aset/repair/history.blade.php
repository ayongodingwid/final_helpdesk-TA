@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>Riwayat Perbaikan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Master</li>
                <li class="breadcrumb-item active">Daftar Aset</li>
                <li class="breadcrumb-item active">Riwayat Perbaikan Aset</li>
            </ol>
        </nav>
    </div>
@endsection

@section('body')
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body mt-2">
                        <div class="table-responsive">
                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Aset id</th>
                                        <th scope="col">Kategory Aset</th>
                                        <th scope="col">Nama Aset</th>
                                        <th scope="col">Teknisi</th>
                                        <th scope="col">Pengguna</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($logs->count() > 0)
                                        @foreach ($logs as $item)
                                            <tr>
                                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                                <td>{{ $item->asset->no_idasset }}</td>
                                                <td>{{ $item->asset->category->name }}</td>
                                                <td>{{ $item->asset->asset_name }}</td>
                                                <td>{{ $item->teknisi->account_name }}</td>
                                                <td>{{ $item->asset->user }}</td>
                                                <td class="col-sm-3">
                                                    <button type="button" onclick='modalData("{{ $item->id }}")'
                                                        class="btn rounded-pill btn-primary btn-sm me-2"
                                                        data-bs-toggle="modal" data-bs-target="#modaldata"
                                                        href="form-viewasset.html">
                                                        <i class="bi bi-info-circle"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                            <!-- Modal -->
                            <div class="modal fade" id="modaldata" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Catatan Perbaikan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="subject" class="form-label">Judul Perbaikan</label>
                                            <input type="text" class="form-control" id="repairTitle" disabled>
                                            <label for="subject" class="form-label mt-3">Keterangan</label>
                                            <textarea type="text" class="form-control" id="repairDesc" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        function modalData(dataModal) {
            let url = "/master/get-repair-history/" + dataModal;


            fetch(url)
                .then(response => {
                    // Check if the response is successful (status code 200-299)
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json(); // Parse the JSON data from the response
                })
                .then(data => {
                    let title = document.querySelector('#repairTitle');
                    let desc = document.querySelector('#repairDesc');


                    title.value = data.title;
                    desc.value = data.description;
                })
                .catch(error => {
                    alert('Ada kesalahan saat mengambil data:', error); // Handle errors here
                });


        }
    </script>
@endsection
