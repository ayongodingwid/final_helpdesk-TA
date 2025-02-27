@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>Form Tambah Akun</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Setting</li>
                <li class="breadcrumb-item active">Daftar Akun</li>
                <li class="breadcrumb-item active">Form Tambah Akun</li>
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
                        <form class="mt-4" action="{{ route('la-store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">User Id</label>
                                    <input type="text" class="form-control" id="name" name="userid">
                                </div>
                                <div class="col">
                                    <label for="whatsapp" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="whatsapp" name="account_name">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="pw" class="form-label">Kata Sandi</label>
                                    <input type="text" class="form-control" id="pw" name="password">
                                </div>
                                <div class="col">
                                    <label for="whatsapp" class="form-label">Role</label>
                                    <select class="form-select" id="division" name="role_id">
                                        <option selected disabled></option>
                                        @foreach ($roles as $item)
                                            <option value="{{ $item->id }}">{{ $item->name_role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn more-btn" type="submit">Tambah</button>
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
