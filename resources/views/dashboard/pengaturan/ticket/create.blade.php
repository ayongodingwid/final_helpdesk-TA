@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>Form Tambah Kategori Tiket</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Setting</li>
                <li class="breadcrumb-item active">Kategori Tiket</li>
                <li class="breadcrumb-item active">Form Tambah Kategori</li>
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
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('pengaturan-store-ticket') }}" class="mt-4" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">Nama Kategori</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="col">
                                    <label for="code" class="form-label">Kode</label>
                                    <input type="text" class="form-control" id="code" name="code">
                                </div>
                            </div>
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered" id="subticket-table">
                                    <thead>
                                        <tr>
                                            <th>Sub Kategori</th>
                                            <th>Kode</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="subticket-list">
                                        <tr>
                                            <td><input type="text" class="form-control" name="sub[]"></td>
                                            <td><input type="text" class="form-control" name="subCode[]"></td>
                                            <td>
                                                <button onclick="deleteList(event)" type="button"
                                                    class="btn btn-danger btn-sm remove-row"><i
                                                        class="bi bi-x-circle"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-light btn-sm" onclick="addList()"
                                    id="add-table-subticket"><i class="bi-plus-circle-fill"></i> Tambah Tabel</button>
                            </div>
                            <div class="col-12">
                                <button class="btn more-btn" type="submit">Tambah</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">

                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
