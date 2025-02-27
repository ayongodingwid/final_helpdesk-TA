@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>Kategori Tiket</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Pengaturan</li>
                <li class="breadcrumb-item active">Kategori Tiket</li>
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
            <div class="alert alert-danger alert-dismissible fade show alert-berhasil" role="alert">
                <strong>Error !</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        @if (in_array('create', json_decode(Auth::user()->role->permission->ticket_kategori_option)))
                            <a class="btn btn-primary me-md-2" href="{{ route('pengaturan-create-ticket') }}">Tambah
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
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (in_array('read', json_decode(Auth::user()->role->permission->ticket_kategori_option)))
                                        @foreach ($categories as $category)
                                            @php
                                                $id = Crypt::encrypt($category->id);
                                            @endphp
                                            <tr>
                                                <td>{{ $category->name }}</td>
                                                <td class="col-sm-3">
                                                    @if (in_array('update', json_decode(Auth::user()->role->permission->ticket_kategori_option)))
                                                        <a href="{{ route('pengaturan-edit-ticket', $id) }}"
                                                            class="btn btn-primary btn-sm me-2"
                                                            href="form-addcategory-edit.html">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                    @endif
                                                    {{-- <form action="{{ route('delete-category', $id) }}" method="post"
                                                        class="d-inline">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm me-2">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </form> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
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
