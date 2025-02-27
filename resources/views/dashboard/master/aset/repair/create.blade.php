@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>Form Data Aset</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Master</li>
                <li class="breadcrumb-item active">Daftar Aset</li>
                <li class="breadcrumb-item active">Lihat Data Aset</li>
                <li class="breadcrumb-item active">Data Perbaikan Aset</li>
            </ol>
        </nav>
    </div>
@endsection

@section('body')
    <section class="section dashboard">
        @if (session('error'))
            <div class="alert alert-success alert-dismissible fade show " role="alert">
                <strong>Berhasil !</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form class="mt-4" action="{{ route('repair-store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">ID Aset</label>
                                    <input type="text" class="form-control" value="{{ $asset->no_idasset }}" disabled>
                                    <input type="hidden" class="form-control" name="asset_id" value="{{ $asset->id }}">
                                </div>
                                <div class="col">
                                    <label for="whatsapp" class="form-label">Kategori Aset</label>
                                    <select class="form-select" id="" disabled>
                                        <option>Pilih Kategori</option>
                                        <option selected>{{ $asset->category->name }}</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="" class="form-label">Nama Aset</label>
                                    <input type="text" class="form-control" value="{{ $asset->asset_name }}" disabled>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Judul Perbaikan</label>
                                <input type="text" class="form-control" id="subject" name="title">
                            </div>
                            <div class="mb-3">
                                <label for="details" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="details" rows="4" name="description"></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn cta-btn btn-info" type="submit">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
