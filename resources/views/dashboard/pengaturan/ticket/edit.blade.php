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
    <form id="fdtsc" method="post">
        @method('delete')
        @csrf
    </form>
    <section class="section dashboard">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show alert-berhasil" role="alert">
                <strong>Berhasil !</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show alert-berhasil" role="alert">
                <strong>Berhasil !</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @php
                            $catId = Crypt::encrypt($category->id);
                        @endphp
                        <form action="{{ route('pengaturan-update-ticket', $catId) }}" class="mt-4" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">Nama Kategori</label>
                                    <input type="text" class="form-control" id="name" value="{{ $category->name }}"
                                        name="name">
                                </div>
                                <div class="col">
                                    <label for="whatsapp" class="form-label">Kode</label>
                                    <input type="text" class="form-control" value="{{ $category->code }}" name="code">
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
                                        @if ($category->ticketSubcategories->count() > 0)
                                            @foreach ($category->ticketSubcategories as $item)
                                                @php
                                                    $tscId = Crypt::encrypt($item->id);
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            value="{{ $item->name }}" name="subName[]">
                                                        <input type="hidden" class="form-control"
                                                            value="{{ $item->name }}, {{ $tscId }}" name="sub[]">
                                                    </td>
                                                    <td><input type="text" class="form-control"
                                                            value="{{ $item->code }}" name="subCode[]"></td>
                                                    <td>
                                                        <button type="button" onclick="subFor({{ $item->id }})"
                                                            class="btn btn-danger btn-sm remove-row"><i
                                                                class="bi bi-x-circle"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
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

@section('script')
    <script>
        function subFor(id) {

            const fdtsc = document.querySelector('#fdtsc');
            fdtsc.setAttribute('action', "/sub-category/delete/" + id);
            fdtsc.submit();

        }
    </script>
@endsection
