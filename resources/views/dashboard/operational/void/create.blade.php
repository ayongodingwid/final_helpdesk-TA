@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>Form Permintaan Void</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Operational</li>
                <li class="breadcrumb-item active">Void</li>
                <li class="breadcrumb-item active">Form Permintaan void</li>
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
                        <form action="{{ route('void-store') }}" method="POST" class="mt-4">
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
                                    <label for="category" class="form-label">Kategori</label>
                                    <input type="text" class="form-control" value="Permintaan " disabled>

                                    <input type="hidden" name="ticket_subcategory_id" value="{{ $tsc->id }}">
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
                                <div class="col">
                                    <label for="location" class="form-label">Nama Outlet</label>
                                    <input type="text" class="form-control" name="outlet_name">
                                </div>
                            </div>
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered" id="discount-table">
                                    <thead>
                                        <tr>
                                            <th>Sales Mode</th>
                                            <th>Nomor Transaksi</th>
                                            <th>Alasan Void</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-select" name="sales_mode_id">
                                                    <option selected disabled></option>
                                                    @foreach ($sm as $item)
                                                        <option value="{{ $item->id }}">{{ $item->sales_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" id="subject"
                                                    name="transaction_no">
                                            </td>
                                            <td><input type="text" class="form-control" name="reason_void"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12">
                                <button class="btn more-btn" type="submit">Kirim</button>
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
