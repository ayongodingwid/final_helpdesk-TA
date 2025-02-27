@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>Form Tambah Kategori Tiket</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">FaQ</li>
                <li class="breadcrumb-item active">Form Tambah FaQ</li>
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
                <div class="card">
                    <div class="card-body">
                        <form class="mt-4" action="{{ route('faq-update', $faq->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">Judul</label>
                                    <input type="text" class="form-control" id="name" name="title"
                                        value="{{ $faq->title }}">
                                </div>
                            </div>
                            <div class="table-responsive mb-3">
                                <label for="name" class="form-label">Isi</label>
                                <textarea type="text" class="form-control" id="" name="detail">{{ $faq->detail }}</textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-warning" type="submit">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
