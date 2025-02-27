@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>Form Permintaan Aset</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Master</li>
                <li class="breadcrumb-item active">Daftar Aset</li>
                <li class="breadcrumb-item active">Tambah Data Aset</li>
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
                        <form class="mt-4" action="{{ route('asset-store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">ID Aset</label>
                                    <input type="text" class="form-control" id="" disabled>
                                </div>
                                <div class="col">
                                    <label for="whatsapp" class="form-label">Kategori Aset</label>
                                    <select class="form-select" id="" name="asset_category_id">
                                        <option selected disabled>Pilih Kategori</option>
                                        @foreach ($ac as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="" class="form-label">Nama Aset</label>
                                    <input type="text" class="form-control" name="asset_name">
                                </div>
                                <div class="col">
                                    <label for="" class="form-label">Tanggal Pembelian</label>
                                    <input type="date" class="form-control" name="buy_date">
                                </div>
                                <div class="col">
                                    <label for="" class="form-label">Harga Beli</label>
                                    <input type="text" class="form-control" name="buy_price">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="" class="form-label">Status Aset</label>
                                    <select class="form-select" id="" name="status">
                                        <option selected></option>
                                        <option value="Used">Used</option>
                                        <option value="Vacant">Vacant</option>
                                        <option value="Lost or Stolen">Lost or Stolen</option>
                                        <option value="Out of Repair">Out of Repair</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="division" class="form-label">Bisnis Unit</label>
                                    <select class="form-select" id="division" name="business_unit_id">
                                        <option selected disabled>Pilih Bisnis Unit</option>
                                        @foreach ($bu as $item)
                                            <option value="{{ $item->id }}">{{ $item->name_bu }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered" id="asset-table">
                                    <thead>
                                        <tr>
                                            <th>Pengguna</th>
                                            <th>Departemen/Divisi</th>
                                            <th>Jabatan</th>
                                            <th>Level</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" class="form-control" name="user"></td>
                                            <td><input type="text" class="form-control" name="departemen"></td>
                                            <td><input type="text" class="form-control" name="position_employee"></td>
                                            <td>
                                                <select class="form-select" id="" name="level_employee">
                                                    <option selected></option>
                                                    <option value="GM">General Manager</option>
                                                    <option value="Manager">Manager</option>
                                                    <option value="SPV">Supervisor</option>
                                                    <option value="Staff">Staff</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mb-3">
                                <label for="details" class="form-label">Spesifikasi</label>
                                <textarea class="form-control" id="details" rows="4" name="specification"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Catatan Tambahan</label>
                                <input type="text" class="form-control" id="subject" name="notes">
                            </div>
                            <div class="col-12">
                                <button class="btn more-btn" type="submit">Simpan</button>
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
