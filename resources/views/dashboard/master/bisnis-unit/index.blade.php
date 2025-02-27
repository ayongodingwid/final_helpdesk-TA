@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>Bisnis Unit</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Master</li>
                <li class="breadcrumb-item active">Bisnis Unit</li>
            </ol>
        </nav>
    </div>
@endsection

@section('body')
    <section class="section dashboard">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <b>Error !</b> Pastikan semua input data terisi.
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show alert-berhasil" role="alert">
                <strong>Berhasil !</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        @if (in_array('create', json_decode(Auth::user()->role->permission->bisnis_unit_option)))
                            <button class="btn btn-primary me-md-2" data-bs-toggle="modal"
                                data-bs-target="#modaldata">Tambah
                                Data</button>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- Table with stripped rows -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Bisnis Unit</th>
                                        <th scope="col">Kode</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (in_array('read', json_decode(Auth::user()->role->permission->bisnis_unit_option)))
                                        @foreach ($bUnits as $item)
                                            @php
                                                $id = Crypt::encrypt($item->id);
                                            @endphp
                                            <tr>
                                                <td>{{ $item->name_bu }}</td>
                                                <td>{{ $item->code }}</td>
                                                <td class="col-sm-3">
                                                    @if (in_array('delete', json_decode(Auth::user()->role->permission->bisnis_unit_option)))
                                                        <form action="{{ route('bu-delete', $id) }}" method="post">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger btn-sm me-2">
                                                                <i class="bi bi-trash-fill"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                <small class="text-muted">Belum ada data</small>
                                            </td>
                                        </tr>
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
                                        <form action="{{ route('bu-store') }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <label for="name_bu" class="form-label">Nama Bisnis Unit</label>
                                                <input type="text" class="form-control" id="name_bu" name="name_bu">
                                            </div>
                                            <div class="modal-body">
                                                <label for="code" class="form-label">Kode</label>
                                                <input type="text" class="form-control" id="code" name="code">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Tambah</button>
                                            </div>
                                        </form>
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
