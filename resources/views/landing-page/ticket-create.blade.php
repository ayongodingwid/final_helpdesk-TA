@extends('template.landing')

@section('content')
    @if (session('berhasil'))
        <section class="section">

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Permintaan Berhasi Dibuat</h5>
                                    <p class="text-center small">Berikut nomor tiket anda:</p>
                                </div>
                                <div class="col-12">
                                    <h3 class="card-title text-center pb-0 fs-4">{{ session('berhasil') }}</h3>
                                </div>
                            </div>
                        </div>
                        <a type="button" class="btn btn-link" href="{{ route('landing-page') }}"><i
                                class="bi bi-arrow-left me-1"></i>Kembali</a>
                    </div>
                </div>
            </div>
        </section>
    @else
        <div class="card">
            <div class="card-body p-lg-4">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <b>Error !</b> Pastikan semua input data terisi.
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error !</strong>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h4 class="card-title text-center pb-0 fs-4 mb-4">Buat Tiket : Komputer & Jaringan</h4>
                <form action="{{ route('pm-store') }}" method="POST" class="mt-5" enctype="multipart/form-data">
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
                            <input type="text" class="form-control" value="Penanganan Masalah" disabled>
                        </div>
                        <div class="col">
                            <label for="subjek" class="form-label">Subjek</label>
                            <select class="form-select" id="subjek" name="ticket_subcategory_id">
                                <option selected disabled>Pilih Subjek</option>
                                @if ($subcategory->count() > 0)
                                    @foreach ($subcategory as $item)
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
                        <div class="col">
                            <label for="location" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="location" name="location">
                        </div>
                    </div>
                    {{-- <div class="mb-3">
                        <label for="formFile" class="form-label">Lampiran Foto</label>
                        <input class="form-control" type="file" id="formFile" name="attachment">
                    </div> --}}
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
    @endif

@endsection
