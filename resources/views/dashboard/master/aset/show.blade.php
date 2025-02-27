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
            </ol>
        </nav>
    </div>
@endsection

@section('body')
    <section class="section dashboard">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show alert-berhasil" role="alert">
                <strong>Berhasil !</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @php
                            $idAsset = Crypt::encrypt($asset->id);
                        @endphp
                        <form class="mt-4" action="{{ route('asset-update', $idAsset) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">ID Aset</label>
                                    <input type="text" class="form-control" id=""
                                        value="{{ $asset->no_idasset }}" disabled>
                                </div>
                                <div class="col">
                                    <label for="whatsapp" class="form-label">Kategori Aset</label>
                                    <select class="form-select" id="" name="asset_category_id">
                                        <option selected disabled>Pilih Kategori</option>
                                        @foreach ($ac as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == $asset->asset_category_id) selected @endif>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="" class="form-label">Nama Aset</label>
                                    <input type="text" class="form-control" name="asset_name"
                                        value="{{ $asset->asset_name }}">
                                </div>
                                <div class="col">
                                    <label for="" class="form-label">Tanggal Pembelian</label>
                                    <input type="date" class="form-control" name="buy_date" id=""
                                        value="{{ \Carbon\Carbon::parse($asset->buy_date)->format('Y-m-d') }}">
                                </div>
                                <div class="col">
                                    <label for="" class="form-label">Harga Beli</label>
                                    <input type="text" class="form-control" name="buy_price"
                                        value="{{ $asset->buy_price }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="" class="form-label">Status Aset</label>
                                    <select class="form-select" id="" name="status">
                                        <option selected></option>
                                        <option value="Used" @if ($asset->status == 'Used') selected @endif>Used
                                        </option>
                                        <option value="Vacant" @if ($asset->status == 'Vacant') selected @endif>Vacant
                                        </option>
                                        <option value="Lost or Stolen" @if ($asset->status == 'Lost or Stolen') selected @endif>
                                            Lost or Stolen</option>
                                        <option value="Out of Repair" @if ($asset->status == 'Out of Repair') selected @endif>Out
                                            of Repair</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="division" class="form-label">Bisnis Unit</label>
                                    <select class="form-select" id="division" name="business_unit_id">
                                        <option selected disabled>Pilih Bisnis Unit</option>
                                        @foreach ($bu as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == $asset->business_unit_id) selected @endif>{{ $item->name_bu }}
                                            </option>
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
                                            <td><input type="text" class="form-control" name="user"
                                                    value="{{ $asset->user }}"></td>
                                            <td><input type="text" class="form-control" name="departemen"
                                                    value="{{ $asset->departemen }}"></td>
                                            <td><input type="text" class="form-control" name="position_employee"
                                                    value="{{ $asset->position_employee }}"></td>
                                            <td>
                                                <select class="form-select" id="" name="level_employee">
                                                    <option selected disabled></option>
                                                    <option value="GM"
                                                        @if ($asset->level_employee == 'GM') selected @endif>General Manager
                                                    </option>
                                                    <option value="Manager"
                                                        @if ($asset->level_employee == 'Manager') selected @endif>Manager</option>
                                                    <option value="SPV"
                                                        @if ($asset->level_employee == 'SPV') selected @endif>Supervisor
                                                    </option>
                                                    <option value="Staff"
                                                        @if ($asset->level_employee == 'Staff') selected @endif>Staff</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mb-3">
                                <label for="details" class="form-label">Spesifikasi</label>
                                <textarea class="form-control" id="details" rows="4" name="specification">{{ $asset->specification }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Catatan Tambahan</label>
                                <input type="text" class="form-control" id="subject" name="notes"
                                    value="{{ $asset->notes }}">
                            </div>
                            <div class="col-12">
                                @if (in_array('update', json_decode(Auth::user()->role->permission->aset_option)))
                                    <button class="btn cta-btn btn-warning" type="submit">Edit</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <h5 class="card-title">Riwayat Perbaikan</h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Teknisi</th>
                                        <th scope="col">Kerusakan</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($repair->count() > 0)
                                        @foreach ($repair as $item)
                                            <tr>
                                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                                <td>{{ $item->teknisi->account_name }}</td>
                                                <td>{{ $item->title }}</td>
                                                <td class="">
                                                    <button type="button" onclick='modalData("{{ $item->id }}")'
                                                        class="btn rounded-pill btn-primary btn-sm me-2"
                                                        data-bs-toggle="modal" data-bs-target="#modaldata">
                                                        <i class="bi bi-info-circle"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="col-12">
                                <a class="btn cta-btn btn-success" type="submit"
                                    href="{{ route('repair-create', $idAsset) }}">Tambah
                                    Data</a>
                            </div>
                            <!-- End Table with stripped rows -->

                            <!-- Modal -->
                            <div class="modal fade" id="modaldata" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Catatan Perbaikan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="subject" class="form-label">Judul Perbaikan</label>
                                            <input type="text" class="form-control" id="repairTitle" disabled>
                                            <label for="subject" class="form-label mt-3">Keterangan</label>
                                            <textarea type="text" class="form-control" id="repairDesc" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modaldata2" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Catatan Perbaikan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="subject" class="form-label">Judul Perbaikan</label>
                                            <input type="text" class="form-control" id="subject"
                                                value="Ganti Beterai" disabled>
                                            <label for="subject" class="form-label mt-3">Keterangan</label>
                                            <textarea type="text" class="form-control" id="subject" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        function modalData(dataModal) {
            let url = "/master/get-repair-history/" + dataModal;


            fetch(url)
                .then(response => {
                    // Check if the response is successful (status code 200-299)
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json(); // Parse the JSON data from the response
                })
                .then(data => {
                    let title = document.querySelector('#repairTitle');
                    let desc = document.querySelector('#repairDesc');


                    title.value = data.title;
                    desc.value = data.description;
                })
                .catch(error => {
                    alert('Ada kesalahan saat mengambil data:', error); // Handle errors here
                });


        }
    </script>
@endsection
