@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>Permintaan Aset</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">General</li>
                <li class="breadcrumb-item active">Daftar Tiket</li>
            </ol>
        </nav>
    </div>
@endsection

@section('body')
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        @if (in_array('create', json_decode(Auth::user()->role->permission->pengajuan_aset_option)))
                            <a class="btn btn-primary me-md-2" type="button" href="{{ route('pa-create') }}">Buat
                                Permintaan</a>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Nomor Tiket</th>
                                        <th scope="col">Nama Pengguna</th>
                                        <th scope="col">Divisi</th>
                                        <th scope="col">Bisnis Unit</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (in_array('read', json_decode(Auth::user()->role->permission->pengajuan_aset_option)))
                                        @foreach ($tickets as $item)
                                            @php
                                                $data = Crypt::encrypt([$item->ticket->tipe, $item->ticket_id]);
                                            @endphp
                                            <tr>
                                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                                <td>{{ $item->ticket->ticket_number }}</td>
                                                <td>{{ $item->ticket->name }}</td>
                                                <td>{{ $item->division ? $item->division->division_name : '-' }}</td>
                                                <td>{{ $item->business_unit ? optional($item->business_unit)->name_bu : '-' }}
                                                </td>
                                                <td>
                                                    <span @class([
                                                        'badge',
                                                        'bg-secondary ' => $item->ticket->status == 'Terkirim',
                                                        'bg-warning text-dark' => $item->ticket->status == 'Verifikasi',
                                                        'bg-info-light text-dark' => $item->ticket->status == 'Penugasan',
                                                        'bg-primary' => $item->ticket->status == 'Pengerjaan',
                                                        'text-bg-success' => $item->ticket->status == 'Selesai',
                                                        'text-bg-danger' => $item->ticket->status == 'Ditolak',
                                                    ])>{{ $item->ticket->status }}</span>
                                                </td>
                                                <td>
                                                    <button type="button" data-modalData="{{ $data }}"
                                                        onclick="modalData(this)" class="btn btn-primary btn-sm me-2"
                                                        data-bs-toggle="modal" data-bs-target="#modalTerkirim">
                                                        <i class="bi bi-info-circle"></i>
                                                    </button>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                            <!-- Modal -->
                            <div class="modal fade" id="modalTerkirim" tabindex="-1">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tiket : <span id="ticNumber"></span></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="modalBody">
                                            {{--  --}}
                                        </div>
                                        <div class="modal-footer" id="modalFooter">
                                            {{--  --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="modal-penolakan" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">

                                        <form action="{{ route('ticket-reject') }}" method="post">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Alasan penolakan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="text" class="form-control" name="alasan_pembatalan"
                                                    required>
                                                <input type="hidden" class="form-control" name="ticket_id" id="ticketId">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" onclick="this.closest('form').submit()"
                                                    class="btn btn-primary">Kirim</button>
                                            </div>
                                        </form>
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
        function getBadgeStat(status) {
            let badgeData;
            if (status === "Terkirim") {
                badgeData = `<span class="badge bg-info text-dark">${status}</span>`;
            }
            if (status === "Verifikasi") {
                badgeData = `<span class="badge bg-warning text-dark">${status}</span>`;
            }
            if (status === "Penugasan") {
                badgeData = `<span class="badge bg-info-light text-dark">${status}</span>`;
            }
            if (status === "Pengerjaan") {
                badgeData = `<span class="badge bg-primary">${status}</span>`;
            }
            if (status === "Selesai") {
                badgeData = `<span class="badge text-bg-success">${status}</span>`;
            }
            if (status === "Ditolak") {
                badgeData = `<span class="badge text-bg-danger">${status}</span>`;
            }

            return badgeData;
        }

        function modalData(dataModal) {
            const set = dataModal.getAttribute('data-modalData');
            let url = "/get-ticket/" + set;


            fetch(url)
                .then(response => {
                    // Check if the response is successful (status code 200-299)
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json(); // Parse the JSON data from the response
                })
                .then(data => {
                    // console.log(data); // Handle the data here


                    const modalBody = document.querySelector('#modalBody');
                    const modalFooter = document.querySelector('#modalFooter');

                    modalBody.innerHTML = "";
                    modalFooter.innerHTML = "";

                    document.querySelector('#ticNumber').innerHTML = data.dataTicket.ticket.ticket_number;
                    document.querySelector('#ticketId').value = data.dataTicket.ticket.id;


                    if (data.dataTicket.ticket.tipe == "permintaan-asset") {
                        const asName = JSON.parse(data.dataTicket.asset_name);
                        const receiver = JSON.parse(data.dataTicket.asset_receiver);
                        const receiverPos = JSON.parse(data.dataTicket.asset_receiver_position);
                        const pos = JSON.parse(data.dataTicket.position);
                        const qty = JSON.parse(data.dataTicket.quantity);

                        if (data.dataTicket.ticket.status == "Terkirim") {
                            modalContent = `<div class="row">
                                                        <div class="col-sm-5">
                                                            <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                                            <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                                            <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                                            <p>No. WA : ${data.dataTicket.ticket.whatsapp_number}</p>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                                            <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                                            <p>Total Aset : 2 Jenis</p>
                                                        </div>
                                                        <div class="table-responsive mt-4">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Nama Aset</th>
                                                                    <th>Qty</th>
                                                                    <th>Nama Penerima</th>
                                                                    <th>Departemen/Divisi</th>
                                                                    <th>Jabatan</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>`

                            asName.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${asName[index]}</td>                        
                                                    <td>${qty[index]}</td>
                                                    <td>${receiver[index]}</td>
                                                    <td>${receiverPos[index]} </td>
                                                    <td>${pos[index]} </td>
                                                </tr>`
                            })

                            modalContent += `</tbody>
                                            </table>
                                        </div>
                                        <div class="py-1">
                                        <p class="h6">Harapan Aset Diterima : <strong>${data.dataTicket.expectation}</strong></p>
                                        </div>
                                        <div class="py-1">
                                        <p class="h6"><strong>Form Permintaan</strong></p>
                                        <a type="button" class="btn btn-primary" href="/permintaan-aset/form/${data.dataForm}"><i class="bi bi-file-earmark-pdf me-1"></i>Cetak</a>
                                        </div>
                                        <div class="py-1">
                                        <p style="color: red; font-size: 12px;">**Catatan: Proses masih perlu memberikan form fisik yang sudah di cetak/print dan di tanda tangani pihak yang mengajukan untuk diserahkan ke tim ICT</p>
                                        </div>
                                    </div>`;

                            modalBody.innerHTML = modalContent;

                            if (
                                "{{ in_array('approve', json_decode(Auth::user()->role->permission->pengajuan_aset_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Proses</button>
                                    </form>`;
                            }
                        }
                        if (data.dataTicket.ticket.status == "Verifikasi") {
                            modalContent = `<div class="row">
                                                        <div class="col-sm-5">
                                                            <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                                            <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                                            <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                                            <p>No. WA : ${data.dataTicket.ticket.whatsapp_number}</p>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                                            <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                                            <p>Total Aset : 2 Jenis</p>
                                                        </div>
                                                        <div class="table-responsive mt-4">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Nama Aset</th>
                                                                    <th>Qty</th>
                                                                    <th>Nama Penerima</th>
                                                                    <th>Departemen/Divisi</th>
                                                                    <th>Jabatan</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>`

                            asName.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${asName[index]}</td>                        
                                                    <td>${qty[index]}</td>
                                                    <td>${receiver[index]}</td>
                                                    <td>${receiverPos[index]} </td>
                                                    <td>${pos[index]} </td>
                                                </tr>`
                            })

                            modalContent += `</tbody>
                                            </table>
                                        </div>
                                        <div class="py-1">
                                        <p class="h6">Harapan Aset Diterima : <strong>${data.dataTicket.expectation}</strong></p>
                                        </div>
                                        <div class="py-1">
                                        <p class="h6"><strong>Form Permintaan</strong></p>
                                        <a type="button" class="btn btn-primary" href="/permintaan-aset/form/${data.dataForm}"><i class="bi bi-file-earmark-pdf me-1"></i>Cetak</a>
                                        </div>
                                    </div>`;

                            modalBody.innerHTML = modalContent;

                            if (
                                "{{ in_array('approve', json_decode(Auth::user()->role->permission->pengajuan_aset_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">Verifikasi</button>
                                    </form>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-penolakan">Tolak</button>`;
                            }
                        }
                        if (data.dataTicket.ticket.status == "Penugasan") {
                            modalContent = `<div class="row">
                                                        <div class="col-sm-5">
                                                            <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                                            <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                                            <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                                            <p>No. WA : ${data.dataTicket.ticket.whatsapp_number}</p>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                                            <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                                            <p>Total Aset : 2 Jenis</p>
                                                        </div>
                                                        <div class="table-responsive mt-4">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Nama Aset</th>
                                                                    <th>Qty</th>
                                                                    <th>Nama Penerima</th>
                                                                    <th>Departemen/Divisi</th>
                                                                    <th>Jabatan</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>`

                            asName.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${asName[index]}</td>                        
                                                    <td>${qty[index]}</td>
                                                    <td>${receiver[index]}</td>
                                                    <td>${receiverPos[index]} </td>
                                                    <td>${pos[index]} </td>
                                                </tr>`
                            })

                            modalContent += `</tbody>
                                            </table>
                                        </div>
                                        <div class="py-1">
                                        <p class="h6">Harapan Aset Diterima : <strong>${data.dataTicket.expectation}</strong></p>
                                        </div>
                                        <div class="py-1">
                                        <p class="h6"><strong>Form Permintaan</strong></p>
                                        <a type="button" class="btn btn-primary" href="/permintaan-aset/form/${data.dataForm}"><i class="bi bi-file-earmark-pdf me-1"></i>Cetak</a>
                                        </div>
                                    </div>`;

                            modalBody.innerHTML = modalContent;
                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->pengajuan_aset_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Kerjakan</button>
                                    </form>`;
                            }
                        }
                        if (data.dataTicket.ticket.status == "Pengerjaan") {
                            modalContent = `<div class="row">
                                                        <div class="col-sm-5">
                                                            <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                                            <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                                            <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                                            <p>No. WA : ${data.dataTicket.ticket.whatsapp_number}</p>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                                            <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                                            <p>Total Aset : 2 Jenis</p>
                                                        </div>
                                                        <div class="table-responsive mt-4">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Nama Aset</th>
                                                                    <th>Qty</th>
                                                                    <th>Nama Penerima</th>
                                                                    <th>Departemen/Divisi</th>
                                                                    <th>Jabatan</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>`

                            asName.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${asName[index]}</td>                        
                                                    <td>${qty[index]}</td>
                                                    <td>${receiver[index]}</td>
                                                    <td>${receiverPos[index]} </td>
                                                    <td>${pos[index]} </td>
                                                </tr>`
                            })

                            modalContent += `</tbody>
                                            </table>
                                        </div>
                                        <div class="py-1">
                                        <p class="h6">Harapan Aset Diterima : <strong>${data.dataTicket.expectation}</strong></p>
                                        </div>
                                        <div class="py-1">
                                        <p class="h6"><strong>Form Permintaan</strong></p>
                                        <a type="button" class="btn btn-primary" href="/permintaan-aset/form/${data.dataForm}"><i class="bi bi-file-earmark-pdf me-1"></i>Cetak</a>
                                        </div>
                                    </div>`;

                            modalBody.innerHTML = modalContent;
                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->pengajuan_aset_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Selesai</button>
                                    </form>`;
                            }
                        }
                        if (data.dataTicket.ticket.status == "Selesai") {
                            modalContent = `<div class="row">
                                                        <div class="col-sm-5">
                                                            <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                                            <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                                            <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                                            <p>No. WA : ${data.dataTicket.ticket.whatsapp_number}</p>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                                            <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                                            <p>Total Aset : 2 Jenis</p>
                                                        </div>
                                                        <div class="table-responsive mt-4">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Nama Aset</th>
                                                                    <th>Qty</th>
                                                                    <th>Nama Penerima</th>
                                                                    <th>Departemen/Divisi</th>
                                                                    <th>Jabatan</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>`

                            asName.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${asName[index]}</td>                        
                                                    <td>${qty[index]}</td>
                                                    <td>${receiver[index]}</td>
                                                    <td>${receiverPos[index]} </td>
                                                    <td>${pos[index]} </td>
                                                </tr>`
                            })

                            modalContent += `</tbody>
                                            </table>
                                        </div>
                                        <div class="py-1">
                                        <p class="h6">Harapan Aset Diterima : <strong>${data.dataTicket.expectation}</strong></p>
                                        </div>
                                        <div class="py-1">
                                        <p class="h6"><strong>Form Permintaan</strong></p>
                                        <a type="button" class="btn btn-primary" href="/permintaan-aset/form/${data.dataForm}"><i class="bi bi-file-earmark-pdf me-1"></i>Cetak</a>
                                        </div>
                                    </div>`;

                            modalBody.innerHTML = modalContent;
                        }
                        if (data.dataTicket.ticket.status == "Ditolak") {
                            modalContent = `<div class="row">
                                                        <div class="col-sm-5">
                                                            <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                                            <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                                            <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                                            <p>No. WA : ${data.dataTicket.ticket.whatsapp_number}</p>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                                            <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                                            <p>Total Aset : 2 Jenis</p>
                                                        </div>
                                                        <div class="table-responsive mt-4">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Nama Aset</th>
                                                                    <th>Qty</th>
                                                                    <th>Nama Penerima</th>
                                                                    <th>Departemen/Divisi</th>
                                                                    <th>Jabatan</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>`

                            asName.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${asName[index]}</td>                        
                                                    <td>${qty[index]}</td>
                                                    <td>${receiver[index]}</td>
                                                    <td>${receiverPos[index]} </td>
                                                    <td>${pos[index]} </td>
                                                </tr>`
                            })

                            modalContent += `</tbody>
                                            </table>
                                        </div>
                                        <div class="py-1">
                                        <p class="h6">Harapan Aset Diterima : <strong>${data.dataTicket.expectation}</strong></p>
                                        </div>
                                        <div class="py-1">
                                        <p class="h6"><strong>Form Permintaan</strong></p>
                                        <a type="button" class="btn btn-primary" href="/permintaan-aset/form/${data.dataForm}"><i class="bi bi-file-earmark-pdf me-1"></i>Cetak</a>
                                        </div>
                                    </div>`;

                            modalBody.innerHTML = modalContent;

                            modalFooter.innerHTML =
                                `<p>Alasan Penolakan : <b>${data.dataTicket.ticket.alasan_pembatalan}</b></p>`;
                        }
                    }
                })
                .catch(error => {
                    alert(error);
                    console.log(error);
                    // Handle errors here
                });


        }
    </script>
@endsection
