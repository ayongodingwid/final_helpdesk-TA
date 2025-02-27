@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>From Permintaan Supplier</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Purchasing</li>
                <li class="breadcrumb-item active">Supplier</li>
                <li class="breadcrumb-item active">From Permintaan Supplier</li>
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
                        <form class="mt-5" action="{{ route('supplier-store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="col">
                                    <label for="whatsapp" class="form-label">Nomor Whatsapp</label>
                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp_number">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="category" class="form-label">Kategori Tiket</label>
                                    <input type="text" class="form-control" value="Supplier" disabled>
                                </div>
                                <div class="col">
                                    <label for="subcaetegory" class="form-label">Subjek</label>
                                    <select class="form-select" id="subcaetegory" name="ticket_subcategory_id">
                                        <option selected disabled>Pilih Subjek</option>
                                        @if ($tsc->count() > 0)
                                            @foreach ($tsc as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="division" class="form-label">Divisi</label>
                                    <select class="form-select" id="division" name="division_id">
                                        <option selected disabled>Pilih Division</option>
                                        @if ($division->count() > 0)
                                            @foreach ($division as $item)
                                                <option value="{{ $item->id }}">{{ $item->division_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="col-3">
                                    <label for="bu" class="form-label">Bisnis Unit</label>
                                    <select class="form-select" id="bu" name="business_unit_id">
                                        <option selected disabled>Pilih Bisnis Unit</option>
                                        @if ($bu->count() > 0)
                                            @foreach ($bu as $item)
                                                <option value="{{ $item->id }}">{{ $item->name_bu }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Lampiran FIle</label>
                                <input class="form-control" type="file" id="formFile" name="attachment">
                            </div>
                            <div class="mb-3">
                                <label for="details" class="form-label">Detail permintaan</label>
                                <textarea class="form-control" id="details" rows="4" name="description"></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn more-btn" type="submit">Buat Permintaan</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
