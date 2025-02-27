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
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form class="mt-4" action="{{ route('faq-store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">Judul</label>
                                    <input type="text" class="form-control" id="name" name="title">
                                </div>
                            </div>
                            <div class="table-responsive mb-3">
                                <label for="name" class="form-label">Isi</label>
                                <textarea type="text" class="form-control" id="" name="detail"></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn more-btn" type="submit">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
