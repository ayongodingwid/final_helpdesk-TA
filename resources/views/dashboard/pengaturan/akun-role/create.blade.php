@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>Form Tambah Role</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Pengaturan</li>
                <li class="breadcrumb-item active">Role</li>
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
                        <form action="{{ route('ar-store') }}" class="mt-4" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">Nama Role</label>
                                    <input type="text" class="form-control" id="name" name="role_name">
                                </div>
                            </div>
                            <div class="table-responsive mb-3">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Menu</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="table-dark">
                                            <td>General</td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" id="lt"
                                                    name="lt_menu">
                                                <label class="form-check-label">Daftar Tiket</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input lt-option" type="checkbox" value="read"
                                                        name="lt_option[]">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="table-dark">
                                            <td>ICT</td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="pm_menu"
                                                    id="pm">
                                                <label class="form-check-label">Penanganan Masalah</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input pm-option" type="checkbox"
                                                        name="pm_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input pm-option" type="checkbox"
                                                        name="pm_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input pm-option" type="checkbox"
                                                        name="pm_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input pm-option" type="checkbox"
                                                        name="pm_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block">
                                                    <input class="form-check-input pm-option" type="checkbox"
                                                        name="pm_option[]" value="approve">
                                                    <label class="form-check-label">approve</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="pa_menu"
                                                    id="pa">
                                                <label class="form-check-label">Pengajuan Aset</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input pa-option" type="checkbox"
                                                        name="pa_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input pa-option" type="checkbox"
                                                        name="pa_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input pa-option" type="checkbox"
                                                        name="pa_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input pa-option" type="checkbox"
                                                        name="pa_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block">
                                                    <input class="form-check-input pa-option" type="checkbox"
                                                        name="pa_option[]" value="approve">
                                                    <label class="form-check-label">approve</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="table-dark">
                                            <td>Operational</td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="mnb_menu"
                                                    id="mnb">
                                                <label class="form-check-label">Menu & BOM</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input mnb-option" type="checkbox"
                                                        name="mnb_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input mnb-option" type="checkbox"
                                                        name="mnb_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input mnb-option" type="checkbox"
                                                        name="mnb_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input mnb-option" type="checkbox"
                                                        name="mnb_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block">
                                                    <input class="form-check-input mnb-option" type="checkbox"
                                                        name="mnb_option[]" value="approve">
                                                    <label class="form-check-label">approve</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="pp_menu"
                                                    id="pp">
                                                <label class="form-check-label">Program Promoo</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input pp-option" type="checkbox"
                                                        name="pp_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input pp-option" type="checkbox"
                                                        name="pp_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input pp-option" type="checkbox"
                                                        name="pp_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input pp-option" type="checkbox"
                                                        name="pp_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block">
                                                    <input class="form-check-input pp-option" type="checkbox"
                                                        name="pp_option[]" value="approve">
                                                    <label class="form-check-label">approve</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="dsc_menu"
                                                    id="dsc">
                                                <label class="form-check-label">Diskon</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input dsc-option" type="checkbox"
                                                        name="dsc_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input dsc-option" type="checkbox"
                                                        name="dsc_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input dsc-option" type="checkbox"
                                                        name="dsc_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input dsc-option" type="checkbox"
                                                        name="dsc_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block">
                                                    <input class="form-check-input dsc-option" type="checkbox"
                                                        name="dsc_option[]" value="approve">
                                                    <label class="form-check-label">approve</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="sh_menu"
                                                    id="sh">
                                                <label class="form-check-label">Selisi Harga</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input sh-option" type="checkbox"
                                                        name="sh_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input sh-option" type="checkbox"
                                                        name="sh_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input sh-option" type="checkbox"
                                                        name="sh_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input sh-option" type="checkbox"
                                                        name="sh_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block">
                                                    <input class="form-check-input sh-option" type="checkbox"
                                                        name="sh_option[]" value="approve">
                                                    <label class="form-check-label">approve</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="void_menu"
                                                    id="void">
                                                <label class="form-check-label">Void</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input void-option" type="checkbox"
                                                        name="void_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input void-option" type="checkbox"
                                                        name="void_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input void-option" type="checkbox"
                                                        name="void_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input void-option" type="checkbox"
                                                        name="void_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block">
                                                    <input class="form-check-input void-option" type="checkbox"
                                                        name="void_option[]" value="approve">
                                                    <label class="form-check-label">approve</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="lo_menu"
                                                    id="lo">
                                                <label class="form-check-label">List Outlet</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input lo-option" type="checkbox"
                                                        name="lo_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input lo-option" type="checkbox"
                                                        name="lo_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input lo-option" type="checkbox"
                                                        name="lo_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input lo-option" type="checkbox"
                                                        name="lo_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block">
                                                    <input class="form-check-input lo-option" type="checkbox"
                                                        name="lo_option[]" value="approve">
                                                    <label class="form-check-label">approve</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="table-dark">
                                            <td>FAT</td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="coa_menu"
                                                    id="coa">
                                                <label class="form-check-label">COA</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input coa-option" type="checkbox"
                                                        name="coa_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input coa-option" type="checkbox"
                                                        name="coa_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input coa-option" type="checkbox"
                                                        name="coa_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input coa-option" type="checkbox"
                                                        name="coa_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block">
                                                    <input class="form-check-input coa-option" type="checkbox"
                                                        name="coa_option[]" value="approve">
                                                    <label class="form-check-label">approve</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="table-dark">
                                            <td>Purchasing</td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="prd_menu"
                                                    id="prd">
                                                <label class="form-check-label">Product</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input prd-option" type="checkbox"
                                                        name="prd_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input prd-option" type="checkbox"
                                                        name="prd_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input prd-option" type="checkbox"
                                                        name="prd_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input prd-option" type="checkbox"
                                                        name="prd_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block">
                                                    <input class="form-check-input prd-option" type="checkbox"
                                                        name="prd_option[]" value="approve">
                                                    <label class="form-check-label">approve</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="sup_menu"
                                                    id="sup">
                                                <label class="form-check-label">Supplier</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input sup-option" type="checkbox"
                                                        name="sup_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input sup-option" type="checkbox"
                                                        name="sup_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input sup-option" type="checkbox"
                                                        name="sup_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input sup-option" type="checkbox"
                                                        name="sup_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block">
                                                    <input class="form-check-input sup-option" type="checkbox"
                                                        name="sup_option[]" value="approve">
                                                    <label class="form-check-label">approve</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="table-dark">
                                            <td>Master</td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="bu_menu"
                                                    id="bu">
                                                <label class="form-check-label">Bisnis Unit</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input bu-option" type="checkbox"
                                                        name=" bu_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input bu-option" type="checkbox"
                                                        name=" bu_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input bu-option" type="checkbox"
                                                        name=" bu_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input bu-option" type="checkbox"
                                                        name=" bu_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="dvs_menu"
                                                    id="dvs">
                                                <label class="form-check-label">Divis</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input dvs-option" type="checkbox"
                                                        name="dvs_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input dvs-option" type="checkbox"
                                                        name="dvs_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input dvs-option" type="checkbox"
                                                        name="dvs_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input dvs-option" type="checkbox"
                                                        name="dvs_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="kry_menu"
                                                    id="kry">
                                                <label class="form-check-label">Karyawan</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input kry-option" type="checkbox"
                                                        name="kry_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input kry-option" type="checkbox"
                                                        name="kry_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input kry-option" type="checkbox"
                                                        name="kry_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input kry-option" type="checkbox"
                                                        name="kry_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="slm_menu"
                                                    id="slm">
                                                <label class="form-check-label">Mode Penjualan</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input slm-option" type="checkbox"
                                                        name="slm_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input slm-option" type="checkbox"
                                                        name="slm_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input slm-option" type="checkbox"
                                                        name="slm_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input slm-option" type="checkbox"
                                                        name="slm_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="bco_menu"
                                                    id="bco">
                                                <label class="form-check-label">Sistem Backoffice</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input bco-option" type="checkbox"
                                                        name="bco_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input bco-option" type="checkbox"
                                                        name="bco_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input bco-option" type="checkbox"
                                                        name="bco_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input bco-option" type="checkbox"
                                                        name="bco_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="asset_menu"
                                                    id="asset">
                                                <label class="form-check-label">Aset</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input asset-option" type="checkbox"
                                                        name="asset_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input asset-option" type="checkbox"
                                                        name="asset_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input asset-option" type="checkbox"
                                                        name="asset_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input asset-option" type="checkbox"
                                                        name="asset_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="table-dark">
                                            <td>Pengaturan</td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="tkt_menu"
                                                    id="tkt">
                                                <label class="form-check-label">Tiket Kategori</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input tkt-option" type="checkbox"
                                                        name="tkt_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input tkt-option" type="checkbox"
                                                        name="tkt_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input tkt-option" type="checkbox"
                                                        name="tkt_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input tkt-option" type="checkbox"
                                                        name="tkt_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="akt_menu"
                                                    id="akt">
                                                <label class="form-check-label">Aset Kategori</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input akt-option" type="checkbox"
                                                        name="akt_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input akt-option" type="checkbox"
                                                        name="akt_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input akt-option" type="checkbox"
                                                        name="akt_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input akt-option" type="checkbox"
                                                        name="akt_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="arl_menu"
                                                    id="arl">
                                                <label class="form-check-label">Akun Role</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input arl-option" type="checkbox"
                                                        name="arl_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input arl-option" type="checkbox"
                                                        name="arl_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input arl-option" type="checkbox"
                                                        name="arl_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input arl-option" type="checkbox"
                                                        name="arl_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="lak_menu"
                                                    id="lak">
                                                <label class="form-check-label">List Akun</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input lak-option" type="checkbox"
                                                        name="lak_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input lak-option" type="checkbox"
                                                        name="lak_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input lak-option" type="checkbox"
                                                        name="lak_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input lak-option" type="checkbox"
                                                        name="lak_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input input class="form-check-input" type="checkbox" name="faq_menu"
                                                    id="faq">
                                                <label class="form-check-label">FAQ</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input faq-option" type="checkbox"
                                                        name="faq_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input faq-option" type="checkbox"
                                                        name="faq_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input faq-option" type="checkbox"
                                                        name="faq_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input faq-option" type="checkbox"
                                                        name="faq_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                            </td>
                                        </tr>



                                        <tr>
                                            <td>Master Data</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input class="form-check-input" type="checkbox" name="articles_menu"
                                                    id="articles">
                                                <label class="form-check-label">Articles</label>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input articles-option" type="checkbox"
                                                        name="articles_option[]" value="create">
                                                    <label class="form-check-label">create</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input articles-option" type="checkbox"
                                                        name="articles_option[]" value="read">
                                                    <label class="form-check-label">read</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input articles-option" type="checkbox"
                                                        name="articles_option[]" value="update">
                                                    <label class="form-check-label">update</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block me-2">
                                                    <input class="form-check-input articles-option" type="checkbox"
                                                        name="articles_option[]" value="delete">
                                                    <label class="form-check-label">delete</label>
                                                </div>
                                                <div class="form-check form-switch d-inline-block">
                                                    <input class="form-check-input articles-option" type="checkbox"
                                                        name="articles_option[]" value="approve">
                                                    <label class="form-check-label">approve</label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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

@section('script')
    <script>
        // Ambil elemen checkbox utama dan opsi checkbox untuk kedua menu
        const lt = document.getElementById('lt');
        const ltOptions = document.querySelectorAll('.lt-option');

        const pm = document.getElementById('pm');
        const pmOptions = document.querySelectorAll('.pm-option');

        const pa = document.getElementById('pa');
        const paOptions = document.querySelectorAll('.pa-option');

        const mnb = document.getElementById('mnb');
        const mnbOptions = document.querySelectorAll('.mnb-option');

        const pp = document.getElementById('pp');
        const ppOptions = document.querySelectorAll('.pp-option');

        const dsc = document.getElementById('dsc');
        const dscOptions = document.querySelectorAll('.dsc-option');

        const sh = document.getElementById('sh');
        const shOptions = document.querySelectorAll('.sh-option');

        const voids = document.getElementById('void');
        const voidOptions = document.querySelectorAll('.void-option');

        const lo = document.getElementById('lo');
        const loOptions = document.querySelectorAll('.lo-option');

        const coa = document.getElementById('coa');
        const coaOptions = document.querySelectorAll('.coa-option');

        const prd = document.getElementById('prd');
        const prdOptions = document.querySelectorAll('.prd-option');

        const sup = document.getElementById('sup');
        const supOptions = document.querySelectorAll('.sup-option');

        const bu = document.getElementById('bu');
        const buOptions = document.querySelectorAll('.bu-option');

        const dvs = document.getElementById('dvs');
        const dvsOptions = document.querySelectorAll('.dvs-option');

        const kry = document.getElementById('kry');
        const kryOptions = document.querySelectorAll('.kry-option');

        const slm = document.getElementById('slm');
        const slmOptions = document.querySelectorAll('.slm-option');

        const bco = document.getElementById('bco');
        const bcoOptions = document.querySelectorAll('.bco-option');

        const asset = document.getElementById('asset');
        const assetOptions = document.querySelectorAll('.asset-option');

        const tkt = document.getElementById('tkt');
        const tktOptions = document.querySelectorAll('.tkt-option');

        const akt = document.getElementById('akt');
        const aktOptions = document.querySelectorAll('.akt-option');

        const arl = document.getElementById('arl');
        const arlOptions = document.querySelectorAll('.arl-option');

        const lak = document.getElementById('lak');
        const lakOptions = document.querySelectorAll('.lak-option');

        const faq = document.getElementById('faq');
        const faqOptions = document.querySelectorAll('.faq-option');

        const articles = document.getElementById('articles');
        const articlesOptions = document.querySelectorAll('.articles-option');

        // Fungsi untuk menyesuaikan status disabled pada opsi checkbox
        function toggleOptions(menuCheckbox, options) {
            options.forEach(option => {
                option.disabled = !menuCheckbox.checked;
            });
        }

        // Panggil fungsi setiap kali status checkbox utama berubah
        lt.addEventListener('change', function() {
            toggleOptions(lt, ltOptions);
        });
        pm.addEventListener('change', function() {
            toggleOptions(pm, pmOptions);
        });
        pa.addEventListener('change', function() {
            toggleOptions(pa, paOptions);
        });
        mnb.addEventListener('change', function() {
            toggleOptions(mnb, mnbOptions);
        });
        pp.addEventListener('change', function() {
            toggleOptions(pp, ppOptions);
        });
        dsc.addEventListener('change', function() {
            toggleOptions(dsc, dscOptions);
        });
        sh.addEventListener('change', function() {
            toggleOptions(sh, shOptions);
        });
        voids.addEventListener('change', function() {
            toggleOptions(voids, voidOptions);
        });
        lo.addEventListener('change', function() {
            toggleOptions(lo, loOptions);
        });
        coa.addEventListener('change', function() {
            toggleOptions(coa, coaOptions);
        });
        prd.addEventListener('change', function() {
            toggleOptions(prd, prdOptions);
        });
        sup.addEventListener('change', function() {
            toggleOptions(sup, supOptions);
        });
        bu.addEventListener('change', function() {
            toggleOptions(bu, buOptions);
        });
        dvs.addEventListener('change', function() {
            toggleOptions(dvs, dvsOptions);
        });
        kry.addEventListener('change', function() {
            toggleOptions(kry, kryOptions);
        });
        slm.addEventListener('change', function() {
            toggleOptions(slm, slmOptions);
        });
        bco.addEventListener('change', function() {
            toggleOptions(bco, bcoOptions);
        });
        asset.addEventListener('change', function() {
            toggleOptions(asset, assetOptions);
        });
        tkt.addEventListener('change', function() {
            toggleOptions(tkt, tktOptions);
        });
        akt.addEventListener('change', function() {
            toggleOptions(akt, aktOptions);
        });
        arl.addEventListener('change', function() {
            toggleOptions(arl, arlOptions);
        });
        lak.addEventListener('change', function() {
            toggleOptions(lak, lakOptions);
        });
        faq.addEventListener('change', function() {
            toggleOptions(faq, faqOptions);
        });
        articles.addEventListener('change', function() {
            toggleOptions(articles, articlesOptions);
        });

        // Inisialisasi status pada halaman pertama kali
        toggleOptions(lt, ltOptions);
        toggleOptions(pm, pmOptions);
        toggleOptions(pa, paOptions);
        toggleOptions(mnb, mnbOptions);
        toggleOptions(pp, ppOptions);
        toggleOptions(dsc, dscOptions);
        toggleOptions(sh, shOptions);
        toggleOptions(voids, voidOptions);
        toggleOptions(lo, loOptions);
        toggleOptions(coa, coaOptions);
        toggleOptions(prd, prdOptions);
        toggleOptions(sup, supOptions);
        toggleOptions(bu, buOptions);
        toggleOptions(dvs, dvsOptions);
        toggleOptions(kry, kryOptions);
        toggleOptions(slm, slmOptions);
        toggleOptions(bco, bcoOptions);
        toggleOptions(asset, assetOptions);
        toggleOptions(tkt, tktOptions);
        toggleOptions(akt, aktOptions);
        toggleOptions(arl, arlOptions);
        toggleOptions(lak, lakOptions);
        toggleOptions(faq, faqOptions);
        toggleOptions(articles, articlesOptions);
    </script>
@endsection
