@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>Kategori Aset</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Pengaturan</li>
                <li class="breadcrumb-item active">Kategori Aset</li>
            </ol>
        </nav>
    </div>
@endsection

@section('body')
    <section class="section dashboard">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show alert-berhasil" role="alert">
                <strong>Berhasil !</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error !</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        @if (in_array('create', json_decode(Auth::user()->role->permission->aset_kategori_option)))
                            <a class="btn btn-primary me-md-2" href="{{ route('pengaturan-create-aset') }}">Tambah
                                Data</a>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-body mt-2">
                        <div class="table-responsive">
                            <!-- Table with stripped rows -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Kategory</th>
                                        <th scope="col">Kode</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (in_array('read', json_decode(Auth::user()->role->permission->aset_kategori_option)))
                                        @foreach ($categories as $category)
                                            @php
                                                $id = Crypt::encrypt($category->id);
                                            @endphp
                                            <tr>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->code }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
