@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>FaQ</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Pengaturan</li>
                <li class="breadcrumb-item active">FaQ</li>
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
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        @if (in_array('create', json_decode(Auth::user()->role->permission->faq_option)))
                            <a class="btn btn-primary me-md-2" href="{{ route('faq-create') }}">Tambah Data</a>
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
                                        <th scope="col">Judul</th>
                                        <th scope="col">Status</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (in_array('read', json_decode(Auth::user()->role->permission->faq_option)))
                                        @foreach ($faqs as $item)
                                            <tr>
                                                <td>{{ $item->title }}</td>
                                                <td>
                                                    <span @class([
                                                        'badge',
                                                        'bg-primary' => $item->status == 'Aktif',
                                                        'bg-secondary' => $item->status == 'Nonaktif',
                                                    ])>{{ $item->status }}</span>
                                                </td>
                                                <td class="col-sm-3 d-flex gap-1">
                                                    <a class="btn btn-primary btn-sm me-2"
                                                        href="{{ route('faq-edit', $item->id) }}">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <form action="{{ route('faq-delete', $item->id) }}" method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm me-2">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </form>
                                                </td>
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
