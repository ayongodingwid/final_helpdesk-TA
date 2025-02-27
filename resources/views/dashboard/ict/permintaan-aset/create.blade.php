@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>Form Permintaan Aset</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">ICT</li>
                <li class="breadcrumb-item active">Permintaan Aset</li>
                <li class="breadcrumb-item active">Form Permintaan Aset</li>
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
                        <form action="{{ route('pa-store') }}" class="mt-4" method="POST">
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
                                    <input type="text" class="form-control" value="Permintaan Aset" disabled>
                                    <input type="hidden" name="ticket_subcategory_id" value="{{ $data->id }}">
                                </div>
                                <div class="col">
                                    <label for="division_id" class="form-label">Divisi</label>
                                    <select class="form-select" id="division_id" name="division_id">
                                        <option selected disabled>Pilih Divisi</option>
                                        @foreach ($division as $item)
                                            <option value="{{ $item->id }}">{{ $item->division_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="business_unit_id" class="form-label">Bisnis Unit</label>
                                    <select class="form-select" id="business_unit_id" name="business_unit_id">
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
                                            <th>Nama Aset</th>
                                            <th>Qty</th>
                                            <th>Nama Penerima</th>
                                            <th>Departemen/Divisi</th>
                                            <th>Jabatan</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="asset-list">
                                        <tr>
                                            <td><input type="text" class="form-control" name="asset_name[]"></td>
                                            <td><input type="number" class="form-control" value="0" name="quantity[]">
                                            </td>
                                            <td><input type="text" class="form-control" name="asset_receiver[]"></td>
                                            <td><input type="text" class="form-control" name="asset_receiver_position[]">
                                            </td>
                                            <td><input type="text" class="form-control" name="position[]"></td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm remove-row"><i
                                                        class="bi bi-x-circle"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" onclick="add()" class="btn btn-light btn-sm" id="add-table-asset"><i
                                        class="bi-plus-circle-fill"></i> Tambah Tabel</button>
                            </div>
                            <div class="mb-3">
                                <label for="details" class="form-label">Spesifikasi</label>
                                <textarea class="form-control" id="details" rows="4" name="description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan Tambahan</label>
                                <input type="text" class="form-control" id="catatan" name="note">
                            </div>
                            <div class="mb-3">
                                <label for="harapan" class="form-label">Harapan Aset Diterima</label>
                                <input type="text" class="form-control" id="harapan" name="expectation">
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

@section('script')
    <script>
        function add() {
            const table = document.getElementById("asset-list");

            // Create a new row element
            const newRow = document.createElement("tr");

            const data = [
                'asset_name[]',
                'quantity[]',
                'asset_receiver[]',
                'asset_receiver_position[]',
                'position[]',
                'delete',
            ];



            data.forEach(function(data, index) {
                if (data == 'delete') {
                    // Create the third cell with a remove button
                    const cell3 = document.createElement("td");
                    const removeButton = document.createElement("button");
                    removeButton.className = "btn btn-danger btn-sm remove-row";
                    removeButton.setAttribute('type', 'button');
                    removeButton.setAttribute('onclick', 'deleteList(event)');
                    removeButton.innerHTML = '<i class="bi bi-x-circle"></i>';
                    cell3.appendChild(removeButton);

                    newRow.appendChild(cell3);
                } else if (data == 'quantity[]') {
                    const cell = document.createElement("td");
                    const input = document.createElement("input");
                    input.type = "number";
                    input.value = 0;
                    input.className = "form-control";
                    input.setAttribute('name', data);
                    input.setAttribute('required', 'true');
                    cell.appendChild(input);

                    newRow.appendChild(cell);

                } else {
                    const cell = document.createElement("td");
                    const input = document.createElement("input");
                    input.type = "text";
                    input.className = "form-control";
                    input.setAttribute('name', data);
                    input.setAttribute('required', 'true');
                    cell.appendChild(input);

                    newRow.appendChild(cell);

                }
            });

            table.appendChild(newRow);
        }
    </script>
@endsection
