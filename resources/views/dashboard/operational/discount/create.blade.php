@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>Form Permintaan Diskon</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Operational</li>
                <li class="breadcrumb-item active">Diskon</li>
                <li class="breadcrumb-item active">Form Permintaan Diskon</li>
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
                        <form action="{{ route('discount-store') }}" method="POST" class="mt-4">
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
                                    <input type="text" class="form-control" value="Permintaan Diskon" disabled>
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
                                            <th>Potongan</th>
                                            <th>Nominal Diskon</th>
                                            <th>Pajak</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="asset-list">
                                        <tr>
                                            <td>
                                                <select class="form-select" name="sales_mode[]">
                                                    <option selected disabled></option>
                                                    @foreach ($sm as $item)
                                                        <option value="{{ $item->sales_name }}">{{ $item->sales_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select" name="tipe[]">
                                                    <option selected></option>
                                                    <option value="Rupiah">Rp.</option>
                                                    <option value="Persentase">%</option>
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control" name="nominal[]"></td>
                                            <td>
                                                <input class="form-check-input false" type="hidden" name="tax_status[]"
                                                    value="off">
                                                <input class="form-check-input" type="checkbox" name="tax_status[]"
                                                    onclick="replace(event)">
                                            </td>
                                            <td>
                                                <button type="button" onclick="deleteList(event)"
                                                    class="btn btn-danger btn-sm remove-row"><i
                                                        class="bi bi-x-circle"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" onclick="add()" class="btn btn-light btn-sm"
                                    id="add-table-discount"><i class="bi-plus-circle-fill"></i> Tambah Tabel</button>
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
        function replace(e) {

            if (e.target.checked) {
                const parent = e.target.parentNode;
                const childrenArray = Array.from(parent.children)
                childrenArray.forEach((child, index) => {
                    if (child.classList.contains('false')) {
                        child.remove();
                    }
                });
            } else {

                const input = document.createElement("input");
                input.type = "hidden";
                input.value = "off";
                input.className = "form-control false";
                input.setAttribute('name', 'tax_status[]');
                e.target.parentNode.appendChild(input);
            }

        }

        function add() {
            const table = document.getElementById("asset-list");

            // Create a new row element
            const newRow = document.createElement("tr");

            const data = @json($sm);
            let smOption = "";

            data.forEach(function(data, index) {
                smOption +=
                    `<option value="${data.sales_name}">${data.sales_name}</option>`;
            });

            // console.log(smOption);


            const cell1 = document.createElement("td");
            cell1.innerHTML = `<td>
                                    <select class="form-select" name="sales_mode[]">
                                        <option selected disabled></option>
                                        ${smOption}
                                        select>
                                </td>`;

            const cell2 = document.createElement("td");
            cell2.innerHTML = ` <select class="form-select" name="tipe[]">
                                    <option selected></option>
                                    <option value="Rupiah">Rp.</option>
                                    <option value="Persentase">%</option>
                                </select>`;

            const cell3 = document.createElement("td");
            cell3.innerHTML = `<input type="text" class="form-control" name="nominal[]">`;

            const cell4 = document.createElement("td");
            cell4.innerHTML = `<input class="form-check-input false" type="hidden" 
                                 name="tax_status[]" value="off">
                                <input class="form-check-input" type="checkbox" name="tax_status[]"
                                    onclick="replace(event)">`;

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
            newRow.appendChild(cell3);
            newRow.appendChild(cell4);
            newRow.appendChild(cell5);

            table.appendChild(newRow);
        }
    </script>
@endsection
