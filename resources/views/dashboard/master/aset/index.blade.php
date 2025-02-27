@extends('template.dashboard');

@section('title')
    <div class="pagetitle">
        <h1>Daftar Aset</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Master</li>
                <li class="breadcrumb-item active">Daftar Aset</li>
            </ol>
        </nav>
    </div>
@endsection

@section('body')
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a class="btn btn-warning me-md-2" href="{{ route('repair-history') }}">Histori Perbaikan</a>
                        @if (in_array('create', json_decode(Auth::user()->role->permission->aset_option)))
                            <a class="btn btn-primary me-md-2" href="{{ route('asset-create') }}">Tambah Data</a>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-body mt-2">
                        <div class="table-responsive">
                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Aset id</th>
                                        <th scope="col">Kategory Aset</th>
                                        <th scope="col">Nama Aset</th>
                                        <th scope="col">Status Aset</th>
                                        <th scope="col">Pengguna</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (in_array('read', json_decode(Auth::user()->role->permission->aset_option)))
                                        @foreach ($asset as $item)
                                            @php
                                                $id = Crypt::encrypt($item->id);
                                            @endphp
                                            <tr>
                                                <td>{{ $item->no_idasset }}</td>
                                                <td>{{ $item->category->name }}</td>
                                                <td>{{ $item->asset_name }}</td>
                                                <td>
                                                    <span @class([
                                                        'badge border-primary border-1',
                                                        'text-primary' => $item->status == 'Used',
                                                        'text-warning' => $item->status == 'Vacant',
                                                        'text-danger' => $item->status == 'Lost or Stolen',
                                                        'text-info' => $item->status == 'Out of Repair',
                                                    ])>
                                                        {{ $item->status }}
                                                    </span>
                                                    {{-- <span class="badge border-primary border-1 text-primary">Used</span> --}}
                                                </td>
                                                <td>{{ $item->user }}</td>
                                                <td class="col-sm-3">
                                                    <a type="button" class="btn rounded-pill btn-primary btn-sm me-2"
                                                        href="{{ route('asset-detail', $id) }}">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
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
                                            <h5 class="modal-title">Tambah Data</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="subject" class="form-label">Kategori Tiket</label>
                                            <input type="text" class="form-control" id="subject">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary">Tambah</button>
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
