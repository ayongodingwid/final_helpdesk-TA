@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>Form Permintaan COA</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">FAT</li>
                <li class="breadcrumb-item active">COA</li>
                <li class="breadcrumb-item active">Form Permintaan COA</li>
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
                        <form action="{{ route('coa-store') }}" method="POST" class="mt-4">
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">Nama</label>
                                    <input required type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="col">
                                    <label for="whatsapp" class="form-label">Nomor Whatsapp</label>
                                    <input required type="text" class="form-control" id="whatsapp"
                                        name="whatsapp_number">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="category" class="form-label">Kategori</label>
                                    <input required type="text" class="form-control" value="COA" disabled>
                                    <input type="hidden" name="ticket_subcategory_id" value="{{ $tsc->id }}">
                                </div>
                                <div class="col">
                                    <label for="division" class="form-label">Sistem</label>
                                    <select class="form-select" id="division" name="backoffice_id">
                                        <option selected disabled></option>
                                        @foreach ($system as $item)
                                            <option value="{{ $item->id }}">{{ $item->backoffice_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered" id="coa-table">
                                    <thead>
                                        <tr>
                                            <th>No. COA</th>
                                            <th>Nama COA</th>
                                        </tr>
                                    </thead>
                                    <tbody id="asset-list">
                                        <tr>
                                            <td><input required type="text" class="form-control" name="coa_no[]"></td>
                                            <td><input required type="text" class="form-control" name="coa_name[]"></td>
                                            <td>
                                                <button onclick="deleteList(event)"
                                                    class="btn btn-danger btn-sm remove-row"><i
                                                        class="bi bi-x-circle"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button onclick="add()" type="button" class="btn btn-light btn-sm" id="add-table-coa"><i
                                        class="bi-plus-circle-fill"></i> Tambah Tabel</button>
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



            const cell1 = document.createElement("td");
            cell1.innerHTML = `<td><input required type="text" class="form-control" name="coa_no[]"></td>`;

            const cell2 = document.createElement("td");
            cell2.innerHTML = ` <td><input required type="text" class="form-control" name="coa_name[]"></td>`;

            // Remove button
            const cell5 = document.createElement("td");
            const removeButton = document.createElement("button");
            removeButton.className = "btn btn-danger btn-sm remove-row";
            removeButton.setAttribute('type', 'button');
            removeButton.setAttribute('onclick', 'deleteList(event)');
            removeButton.innerHTML = '<i class="bi bi-x-circle"></i>';
            cell5.appendChild(removeButton);

            newRow.appendChild(cell1);
            newRow.appendChild(cell2);
            newRow.appendChild(cell5);

            table.appendChild(newRow);
        }
    </script>
@endsection
