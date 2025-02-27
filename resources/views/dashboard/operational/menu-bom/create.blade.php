@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>From Permintaan Menu & BoM</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Operational</li>
                <li class="breadcrumb-item active">Menu & BoM</li>
                <li class="breadcrumb-item active">From Permintaan Menu & BoM</li>
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
                        <form action="{{ route('mnb-store') }}" method="POST" class="mt-5" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="col">
                                    <label for="division" class="form-label">Divisi</label>
                                    <select class="form-select" id="division" name="division_id">
                                        <option selected disabled>Pilih divisi</option>
                                        @foreach ($divisi as $item)
                                            <option value="{{ $item->id }}">{{ $item->division_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="col-4">
                                    <label for="whatsapp" class="form-label">Nomor Whatsapp</label>
                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp_number">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="category" class="form-label">Kategori Tiket</label>
                                    <input type="text" class="form-control" value="Menu & BoM" disabled>
                                </div>
                                <div class="col">
                                    <label for="tsc" class="form-label">Subjek</label>
                                    <select class="form-select" id="tsc" name="ticket_subcategory_id">
                                        <option selected disabled>Pilih Subjek</option>
                                        @foreach ($tsc as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="bu" class="form-label">Bisnis Unit</label>
                                    <select class="form-select" id="bu" name="business_unit_id">
                                        <option selected disabled>Pilih Bisnis Unit</option>
                                        @foreach ($bu as $item)
                                            <option value="{{ $item->id }}">{{ $item->name_bu }}</option>
                                        @endforeach
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
