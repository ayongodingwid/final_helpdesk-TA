@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>Form Program Promo</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Operational</li>
                <li class="breadcrumb-item active">Program Promo</li>
                <li class="breadcrumb-item active">Form Program Promo</li>
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
                        <form action="{{ route('pp-store') }}" method="POST" enctype="multipart/form-data" class="mt-5">
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="col">
                                    <label for="division" class="form-label">Divisi</label>
                                    <select class="form-select" id="division" name="division_id">
                                        <option selected disabled></option>
                                        @foreach ($divisi as $item)
                                            <option value="{{ $item->id }}">{{ $item->division_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="whatsapp" class="form-label">Nomor Whatsapp</label>
                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp_number">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="category" class="form-label">Kategori Tiket</label>
                                    <input type="text" class="form-control" value="Program Promo" disabled>
                                    <input type="hidden" name="ticket_subcategory_id" value="{{ $tsc->id }}">
                                </div>
                                <div class="col">
                                    <label for="sales" class="form-label">Sale Mode</label>
                                    <select class="form-select" id="sales" name="sales_mode_id">
                                        <option selected disabled></option>
                                        @foreach ($sales as $item)
                                            <option value="{{ $item->id }}">{{ $item->sales_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="bu" class="form-label">Bisnis Unit</label>
                                    <select class="form-select" id="bu" name="business_unit_id">
                                        <option selected disabled></option>
                                        @foreach ($bu as $item)
                                            <option value="{{ $item->id }}">{{ $item->name_bu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col mb-3">
                                    <label for="name" class="form-label">Nama Program</label>
                                    <input type="text" class="form-control" id="name" name="name_program">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="inputDate" class="form-label">Tgl Mulai</label>
                                    <input type="date" class="form-control" name="date_start">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputDate" class="form-label">Tgl Berakhir</label>
                                    <input type="date" class="form-control" name="date_end">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Lampiran File</label>
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
