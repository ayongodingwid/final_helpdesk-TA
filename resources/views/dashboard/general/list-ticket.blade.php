@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>List Tiket</h1>
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
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show alert-berhasil" role="alert">
                <strong>Berhasil !</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show alert-berhasil" role="alert">
                <strong>Gagal !</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <b>Error !</b> Pastikan semua input data terisi.
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Nomor Tiket</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Nama Pengguna</th>
                                        <th scope="col">Divisi</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (in_array('read', json_decode(Auth::user()->role->permission->daftar_tiket_option)))
                                        @foreach ($tickets as $item)
                                            @php
                                                $data = Crypt::encrypt([$item->tipe, $item->id]);
                                            @endphp
                                            <tr>
                                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                                <td>{{ $item->ticket_number }}</td>
                                                <td>{{ $item->tsc_name }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->division ? $item->division->division_name : '-' }}</td>
                                                <td>
                                                    <span @class([
                                                        'badge',
                                                        'bg-info text-dark ' => $item->status == 'Terkirim',
                                                        'bg-warning text-dark' => $item->status == 'Verifikasi',
                                                        'bg-info-light text-dark' => $item->status == 'Penugasan',
                                                        'bg-primary' => $item->status == 'Pengerjaan',
                                                        'text-bg-success' => $item->status == 'Selesai',
                                                        'text-bg-danger' => $item->status == 'Ditolak',
                                                    ])>{{ $item->status }}</span>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm me-2"
                                                        data-modalData="{{ $data }}" onclick="modalData(this)"
                                                        data-bs-toggle="modal" data-bs-target="#modalVerifikasi">
                                                        <i class="bi bi-info-circle"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                            <!-- Modal -->
                            <div class="modal fade" id="modalVerifikasi" tabindex="-1">
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
                            </div><!-- End Modal Dialog Scrollable-->

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


                    if (data.dataTicket.ticket.tipe == "problem-handling") {

                        if (data.dataTicket.ticket.status == "Verifikasi") {
                            modalBody.innerHTML = `<div class="row">
                                                        <div class="col-sm-5">
                                                            <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                                            <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                                            <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                                            <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                                            <p>Verifikasi : - </p>
                                                            <p>Staff Support : - </p>
                                                        </div>
                                                        </div>
                                                        <div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Permintaan Perbaikan</strong></p>
                                                            <p>${data.dataTicket.ticket.subcategory.name}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Detail</strong></p>
                                                            <p>${data.dataTicket.description}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Laporan Perbaikan</strong></p>
                                                            <p>-</p>
                                                        </div>
                                                    </div>`;

                            if (
                                "{{ in_array('approve', json_decode(Auth::user()->role->permission->penanganan_masalah_option)) }}"
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
                            modalBody.innerHTML = `<div class="row">
                                                        <div class="col-sm-5">
                                                            <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                                            <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                                            <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                                            <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                                            <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name} </p>
                                                            <p>Staff Support : - </p>
                                                        </div>
                                                        </div>
                                                        <div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Permintaan Perbaikan</strong></p>
                                                            <p>${data.dataTicket.ticket.subcategory.name}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Detail</strong></p>
                                                            <p>${data.dataTicket.description}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Laporan Perbaikan</strong></p>
                                                            <textarea class="form-control" style="height: 100px" disabled=""></textarea>
                                                        </div>
                                                    </div>`;

                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->penanganan_masalah_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Kerjakan</button>
                                    </form>`;
                            }

                        }
                        if (data.dataTicket.ticket.status == "Pengerjaan") {
                            modalBody.innerHTML = `<div class="row">
                                                        <div class="col-sm-5">
                                                            <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                                            <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                                            <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                                            <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                                            <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name} </p>
                                                            <p>Staff Support : ${data.dataTicket.ticket.handle.account_name} </p>
                                                        </div>
                                                        </div>
                                                        <div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Permintaan Perbaikan</strong></p>
                                                            <p>${data.dataTicket.ticket.subcategory.name}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Detail</strong></p>
                                                            <p>${data.dataTicket.description}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <form action="/ticket/update/${data.dataForm}" method="POST" id="complete">
                                                                @csrf
                                                                <p class="h6"><strong>Laporan Perbaikan</strong></p>
                                                                <textarea class="form-control" style="height: 100px" name="laporan_perbaikan" required></textarea>
                                                            </form>
                                                        </div>
                                                    </div>`;

                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->penanganan_masalah_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<button type="submit" class="btn btn-success" form="complete">Selesai</button>`;
                            }

                        }
                        if (data.dataTicket.ticket.status == "Selesai") {
                            modalBody.innerHTML = `<div class="row">
                                                        <div class="col-sm-5">
                                                            <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                                            <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                                            <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                                            <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                                            <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name} </p>
                                                            <p>Staff Support : ${data.dataTicket.ticket.handle.account_name} </p>
                                                        </div>
                                                        </div>
                                                        <div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Permintaan Perbaikan</strong></p>
                                                            <p>${data.dataTicket.ticket.subcategory.name}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Detail</strong></p>
                                                            <p>${data.dataTicket.description}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Laporan Perbaikan</strong></p>
                                                            <p>${data.dataTicket.laporan_perbaikan}</p>
                                                        </div>
                                                    </div>`;

                        }
                        if (data.dataTicket.ticket.status == "Ditolak") {
                            modalBody.innerHTML = `<div class="row">
                                                        <div class="col-sm-5">
                                                            <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                                            <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                                            <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                                            <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                                            <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name} </p>
                                                            <p>Staff Support : - </p>
                                                        </div>
                                                        </div>
                                                        <div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Permintaan Perbaikan</strong></p>
                                                            <p>${data.dataTicket.ticket.subcategory.name}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Detail</strong></p>
                                                            <p>${data.dataTicket.description}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Laporan Perbaikan</strong></p>
                                                            <p>-</p>
                                                        </div>
                                                    </div>`;

                            modalFooter.innerHTML =
                                `<p>Alasan Penolakan : <b>${data.dataTicket.ticket.alasan_pembatalan}</b></p>`;

                        }
                    }
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
                    if (data.dataTicket.ticket.tipe == "menu-bom") {
                        if (data.dataTicket.ticket.status == "Terkirim") {
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                    <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                    <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                </div>
                                </div>
                                <div>
                                <div class="py-1">
                                    <p class="h6"><strong>Subjek</strong></p>
                                    <p>${data.dataTicket.ticket.subcategory.name}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>Detail</strong></p>
                                    <p>${data.dataTicket.description}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>File Pendukung</strong></p>
                                    <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                </div>
                            </div>`;

                            if (
                                "{{ in_array('approve', json_decode(Auth::user()->role->permission->menu_bom_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Proses</button>
                                    </form>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-penolakan">Tolak</button>`;
                            }
                        }
                        if (data.dataTicket.ticket.status == "Verifikasi") {
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                    <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                    <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                </div>
                                </div>
                                <div>
                                <div class="py-1">
                                    <p class="h6"><strong>Subjek</strong></p>
                                    <p>${data.dataTicket.ticket.subcategory.name}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>Detail</strong></p>
                                    <p>${data.dataTicket.description}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>File Pendukung</strong></p>
                                    <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                </div>
                            </div>`;

                            if (
                                "{{ in_array('approve', json_decode(Auth::user()->role->permission->menu_bom_option)) }}"
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
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                    <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                    <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                </div>
                                </div>
                                <div>
                                <div class="py-1">
                                    <p class="h6"><strong>Subjek</strong></p>
                                    <p>${data.dataTicket.ticket.subcategory.name}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>Detail</strong></p>
                                    <p>${data.dataTicket.description}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>File Pendukung</strong></p>
                                    <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                </div>
                            </div>`;

                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->menu_bom_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Kerjakan</button>
                                    </form>`;
                            }
                        }
                        if (data.dataTicket.ticket.status == "Pengerjaan") {
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                    <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                    <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                </div>
                                </div>
                                <div>
                                <div class="py-1">
                                    <p class="h6"><strong>Subjek</strong></p>
                                    <p>${data.dataTicket.ticket.subcategory.name}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>Detail</strong></p>
                                    <p>${data.dataTicket.description}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>File Pendukung</strong></p>
                                    <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                </div>
                            </div>`;

                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->menu_bom_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Selesai</button>
                                    </form>`;
                            }
                        }
                        if (data.dataTicket.ticket.status == "Selesai") {
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                    <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                    <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                </div>
                                </div>
                                <div>
                                <div class="py-1">
                                    <p class="h6"><strong>Subjek</strong></p>
                                    <p>${data.dataTicket.ticket.subcategory.name}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>Detail</strong></p>
                                    <p>${data.dataTicket.description}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>File Pendukung</strong></p>
                                    <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                </div>
                            </div>`;
                        }
                        if (data.dataTicket.ticket.status == "Ditolak") {
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                    <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                    <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                </div>
                                </div>
                                <div>
                                <div class="py-1">
                                    <p class="h6"><strong>Subjek</strong></p>
                                    <p>${data.dataTicket.ticket.subcategory.name}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>Detail</strong></p>
                                    <p>${data.dataTicket.description}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>File Pendukung</strong></p>
                                    <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                </div>
                            </div>`;

                            modalFooter.innerHTML =
                                `<p>Alasan Penolakan : <b>${data.dataTicket.ticket.alasan_pembatalan}</b></p>`;
                        }
                    }
                    if (data.dataTicket.ticket.tipe == "program-promo") {
                        if (data.dataTicket.ticket.status == "Terkirim") {
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                    <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                    <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                </div>
                                </div>
                                <div>
                                <div class="py-1">
                                    <p class="h6"><strong>Subjek</strong></p>
                                    <p>${data.dataTicket.ticket.subcategory.name}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>Detail</strong></p>
                                    <p>${data.dataTicket.description}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>File Pendukung</strong></p>
                                    <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                </div>
                            </div>`;

                            if (
                                "{{ in_array('approve', json_decode(Auth::user()->role->permission->program_promo_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Proses</button>
                                    </form>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-penolakan">Tolak</button>`;
                            }
                        }
                        if (data.dataTicket.ticket.status == "Verifikasi") {
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                    <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                    <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                </div>
                                </div>
                                <div>
                                <div class="py-1">
                                    <p class="h6"><strong>Subjek</strong></p>
                                    <p>${data.dataTicket.ticket.subcategory.name}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>Detail</strong></p>
                                    <p>${data.dataTicket.description}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>File Pendukung</strong></p>
                                    <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                </div>
                            </div>`;

                            if (
                                "{{ in_array('approve', json_decode(Auth::user()->role->permission->program_promo_option)) }}"
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
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                    <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                    <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                </div>
                                </div>
                                <div>
                                <div class="py-1">
                                    <p class="h6"><strong>Subjek</strong></p>
                                    <p>${data.dataTicket.ticket.subcategory.name}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>Detail</strong></p>
                                    <p>${data.dataTicket.description}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>File Pendukung</strong></p>
                                    <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                </div>
                            </div>`;

                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->program_promo_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Kerjakan</button>
                                    </form>`;
                            }
                        }
                        if (data.dataTicket.ticket.status == "Pengerjaan") {
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                    <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                    <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                </div>
                                </div>
                                <div>
                                <div class="py-1">
                                    <p class="h6"><strong>Subjek</strong></p>
                                    <p>${data.dataTicket.ticket.subcategory.name}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>Detail</strong></p>
                                    <p>${data.dataTicket.description}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>File Pendukung</strong></p>
                                    <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                </div>
                            </div>`;

                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->program_promo_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Selesai</button>
                                    </form>`;
                            }
                        }
                        if (data.dataTicket.ticket.status == "Selesai") {
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                    <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                    <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                </div>
                                </div>
                                <div>
                                <div class="py-1">
                                    <p class="h6"><strong>Subjek</strong></p>
                                    <p>${data.dataTicket.ticket.subcategory.name}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>Detail</strong></p>
                                    <p>${data.dataTicket.description}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>File Pendukung</strong></p>
                                    <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                </div>
                            </div>`;
                        }
                        if (data.dataTicket.ticket.status == "Ditolak") {
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                    <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                    <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                </div>
                                </div>
                                <div>
                                <div class="py-1">
                                    <p class="h6"><strong>Subjek</strong></p>
                                    <p>${data.dataTicket.ticket.subcategory.name}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>Detail</strong></p>
                                    <p>${data.dataTicket.description}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>File Pendukung</strong></p>
                                    <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                </div>
                            </div>`;

                            modalFooter.innerHTML =
                                `<p>Alasan Penolakan : <b>${data.dataTicket.ticket.alasan_pembatalan}</b></p>`;
                        }
                    }
                    if (data.dataTicket.ticket.tipe == "discount") {
                        const sm = JSON.parse(data.dataTicket.sales_mode);
                        const tipe = JSON.parse(data.dataTicket.tipe);
                        const nominal = JSON.parse(data.dataTicket.nominal);
                        const tax = JSON.parse(data.dataTicket.tax_status);
                        const permission =
                            "{{ in_array('update', json_decode(Auth::user()->role->permission->diskon_option)) }}";

                        if (data.dataTicket.ticket.status == "Verifikasi") {
                            let modalContent = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>Nama Outlet : ${data.dataTicket.outlet_name}</p>
                                    <p>WA Outlet : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                    <p>Verifikasi : - </p>
                                </div>
                                </div>
                                <div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Sales Mode</th>
                                                <th>Potongan</th>
                                                <th>Nominal Diskon</th>
                                                <th>Pajak</th>
                                                <th>Nama Diskon</th>
                                            </tr>
                                            </thead>
                                            <tbody>`;

                            sm.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${sm[index]}</td>
                                                    <td>${tipe[index]}</td>                        
                                                    <td>${nominal[index]}</td>
                                                    <td><input class="form-check-input" type="checkbox" id="gridCheck2" ${tax[index] === "on" ? 'checked' : ''}  disabled></td>
                                                    <td><input type="text" class="form-control" disabled></td>
                                                </tr>`;
                            });

                            modalContent += `</tbody>
                                        </table>
                                        </div>
                            </div>`;

                            modalBody.innerHTML = modalContent;

                            if (
                                "{{ in_array('approve', json_decode(Auth::user()->role->permission->diskon_option)) }}"
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
                            let modalContent = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>Nama Outlet : ${data.dataTicket.outlet_name}</p>
                                    <p>WA Outlet : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"}</p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name} </p>
                                </div>
                                </div>
                                <div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Sales Mode</th>
                                                <th>Potongan</th>
                                                <th>Nominal Diskon</th>
                                                <th>Pajak</th>
                                                <th>Nama Diskon</th>
                                            </tr>
                                            </thead>
                                            <tbody>`;

                            sm.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${sm[index]}</td>
                                                    <td>${tipe[index]}</td>                        
                                                    <td>${nominal[index]}</td>
                                                    <td><input class="form-check-input" type="checkbox" id="gridCheck2" ${tax[index] === "on" ? 'checked' : ''}  disabled></td>
                                                    <td><input type="text" class="form-control" disabled></td>
                                                </tr>`;
                            });

                            modalContent += `</tbody>
                                        </table>
                                        </div>
                            </div>`;

                            modalBody.innerHTML = modalContent;

                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->diskon_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Kerjakan</button>
                                    </form>`;
                            }
                        }
                        if (data.dataTicket.ticket.status == "Pengerjaan") {
                            let modalContent = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>Nama Outlet : ${data.dataTicket.outlet_name}</p>
                                    <p>WA Outlet : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name} </p>
                                </div>
                                </div>
                                <div>
                                    <div class="table-responsive">
                                        <form action="/ticket/update/${data.dataForm}" method="post" id="discForm">
                                            @csrf
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Sales Mode</th>
                                                <th>Potongan</th>
                                                <th>Nominal Diskon</th>
                                                <th>Pajak</th>
                                                <th>Nama Diskon</th>
                                            </tr>
                                            </thead>
                                            <tbody>`;

                            sm.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${sm[index]}</td>
                                                    <td>${tipe[index]}</td>                        
                                                    <td>${nominal[index]}</td>
                                                    <td><input class="form-check-input" type="checkbox" id="gridCheck2" ${tax[index] === "on" ? 'checked' : ''}  disabled></td>
                                                    <td><input type="text" class="form-control" name="diskon_name[]" ${ permission ? " " : 'disabled'}></td>
                                                </tr>`;
                            });

                            modalContent += `</tbody>
                                        </table>
                                        <form>
                                        </div>
                            </div>`;

                            modalBody.innerHTML = modalContent;

                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->diskon_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<button type="submit" class="btn btn-success" form="discForm">Selesai</button>`;
                            }
                        }
                        if (data.dataTicket.ticket.status == "Selesai") {
                            const disc_name = JSON.parse(data.dataTicket.diskon_name);

                            let modalContent = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>Nama Outlet : ${data.dataTicket.outlet_name}</p>
                                    <p>WA Outlet : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name} </p>
                                </div>
                                </div>
                                <div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Sales Mode</th>
                                                <th>Potongan</th>
                                                <th>Nominal Diskon</th>
                                                <th>Pajak</th>
                                                <th>Nama Diskon</th>
                                            </tr>
                                            </thead>
                                            <tbody>`;

                            sm.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${sm[index]}</td>
                                                    <td>${tipe[index]}</td>                        
                                                    <td>${nominal[index]}</td>
                                                    <td><input class="form-check-input" type="checkbox" id="gridCheck2" ${tax[index] === "on" ? 'checked' : ''}  disabled></td>
                                                    <td><input type="text" class="form-control" disabled value="${disc_name[index]}"></td>
                                                </tr>`;
                            });

                            modalContent += `</tbody>
                                        </table>
                                        </div>
                            </div>`;

                            modalBody.innerHTML = modalContent;
                        }
                        if (data.dataTicket.ticket.status == "Ditolak") {
                            let modalContent = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>Nama Outlet : ${data.dataTicket.outlet_name}</p>
                                    <p>WA Outlet : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name} </p>
                                </div>
                                </div>
                                <div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Sales Mode</th>
                                                <th>Potongan</th>
                                                <th>Nominal Diskon</th>
                                                <th>Pajak</th>
                                                <th>Nama Diskon</th>
                                            </tr>
                                            </thead>
                                            <tbody>`;

                            sm.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${sm[index]}</td>
                                                    <td>${tipe[index]}</td>                        
                                                    <td>${nominal[index]}</td>
                                                    <td><input class="form-check-input" type="checkbox" id="gridCheck2" ${tax[index] === "on" ? 'checked' : ''}  disabled></td>
                                                    <td><input type="text" class="form-control" disabled></td>
                                                </tr>`;
                            });

                            modalContent += `</tbody>
                                        </table>
                                        </div>
                            </div>`;

                            modalBody.innerHTML = modalContent;
                            modalFooter.innerHTML =
                                `<p>Alasan Penolakan : <b>${data.dataTicket.ticket.alasan_pembatalan}</b></p>`;
                        }
                    }
                    if (data.dataTicket.ticket.tipe == "coa") {
                        const name = JSON.parse(data.dataTicket.coa_name);
                        const no = JSON.parse(data.dataTicket.coa_no);

                        if (data.dataTicket.ticket.status == "Verifikasi") {
                            let modalContent = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>No. WA : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Sistem : ${data.dataTicket.backoffice.backoffice_name}</p>
                                    <p>Verifikasi : - </p>
                                    <p>Staff Support : - </p>
                                </div>
                                </div>
                                <div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Nomor COA</th>
                                                <th>Keterangan Nama</th>
                                            </tr>
                                            </thead>
                                            <tbody>`;

                            name.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${no[index]}</td>                        
                                                    <td>${name[index]}</td>
                                                </tr>`;
                            });

                            modalContent += `</tbody>
                                        </table>
                                        </div>
                            </div>`;

                            modalBody.innerHTML = modalContent;

                            if (
                                "{{ in_array('approve', json_decode(Auth::user()->role->permission->coa_option)) }}"
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
                            let modalContent = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>No. WA : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Sistem : ${data.dataTicket.backoffice.backoffice_name}</p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name}</p>
                                    <p>Staff Support : - </p>
                                </div>
                                </div>
                                <div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Nomor COA</th>
                                                <th>Keterangan Nama</th>
                                            </tr>
                                            </thead>
                                            <tbody>`;

                            name.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${no[index]}</td>                        
                                                    <td>${name[index]}</td>
                                                </tr>`;
                            });

                            modalContent += `</tbody>
                                        </table>
                                        </div>
                            </div>`;

                            modalBody.innerHTML = modalContent;

                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->coa_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Kerjakan</button>
                                    </form>`;
                            }
                        }
                        if (data.dataTicket.ticket.status == "Pengerjaan") {
                            let modalContent = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>No. WA : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Sistem : ${data.dataTicket.backoffice.backoffice_name}</p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name}</p>
                                    <p>Staff Support : ${data.dataTicket.ticket.handle.account_name}</p>
                                </div>
                                </div>
                                <div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Nomor COA</th>
                                                <th>Keterangan Nama</th>
                                            </tr>
                                            </thead>
                                            <tbody>`;

                            name.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${no[index]}</td>                        
                                                    <td>${name[index]}</td>
                                                </tr>`;
                            });

                            modalContent += `</tbody>
                                        </table>
                                        </div>
                            </div>`;

                            modalBody.innerHTML = modalContent;

                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->coa_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Selesai</button>
                                    </form>`;
                            }
                        }
                        if (data.dataTicket.ticket.status == "Selesai") {
                            let modalContent = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>No. WA : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Sistem : ${data.dataTicket.backoffice.backoffice_name}</p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name}</p>
                                    <p>Staff Support : ${data.dataTicket.ticket.handle.account_name}</p>
                                </div>
                                </div>
                                <div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Nomor COA</th>
                                                <th>Keterangan Nama</th>
                                            </tr>
                                            </thead>
                                            <tbody>`;

                            name.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${no[index]}</td>                        
                                                    <td>${name[index]}</td>
                                                </tr>`;
                            });

                            modalContent += `</tbody>
                                        </table>
                                        </div>
                            </div>`;

                            modalBody.innerHTML = modalContent;
                        }
                        if (data.dataTicket.ticket.status == "Ditolak") {
                            let modalContent = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>No. WA : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Sistem : ${data.dataTicket.backoffice.backoffice_name}</p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name}</p>
                                    <p>Staff Support : - </p>
                                </div>
                                </div>
                                <div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Nomor COA</th>
                                                <th>Keterangan Nama</th>
                                            </tr>
                                            </thead>
                                            <tbody>`;

                            name.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${no[index]}</td>                        
                                                    <td>${name[index]}</td>
                                                </tr>`;
                            });

                            modalContent += `</tbody>
                                        </table>
                                        </div>
                            </div>`;

                            modalBody.innerHTML = modalContent;
                            modalFooter.innerHTML =
                                `<p>Alasan Penolakan : <b>${data.dataTicket.ticket.alasan_pembatalan}</b></p>`;
                        }
                    }
                    if (data.dataTicket.ticket.tipe == "selisih-harga") {
                        const sm = JSON.parse(data.dataTicket.sales_mode);
                        const menu = JSON.parse(data.dataTicket.menu_name);
                        const pricePos = JSON.parse(data.dataTicket.price_pos);
                        const priceSm = JSON.parse(data.dataTicket.price_salesmode);
                        const tax = JSON.parse(data.dataTicket.tax_status);

                        if (data.dataTicket.ticket.status == "Verifikasi") {
                            let modalContent = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>Nama Outlet : ${data.dataTicket.outlet_name}</p>
                                    <p>WA Outlet : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                    <p>Verifikasi : - </p>
                                    <p>Staff Support : - </p>
                                </div>
                                </div>
                                <div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Platform</th>
                                                <th>Menu</th>
                                                <th>Harga ESB</th>
                                                <th>Harga Platform</th>
                                                <th>Pajak</th>
                                            </tr>
                                            </thead>
                                            <tbody>`;

                            sm.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${sm[index]}</td>
                                                    <td>${menu[index]}</td>                        
                                                    <td>${pricePos[index]}</td>
                                                    <td>${priceSm[index]}</td>
                                                    <td><input class="form-check-input" type="checkbox" id="gridCheck2" ${tax[index] === "on" ? 'checked' : ''}  disabled></td>
                                                </tr>`;
                            });

                            modalContent += `</tbody>
                                        </table>
                                        </div>
                            </div>`;

                            modalBody.innerHTML = modalContent;

                            if (
                                "{{ in_array('approve', json_decode(Auth::user()->role->permission->selisih_harga_option)) }}"
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
                            let modalContent = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>Nama Outlet : ${data.dataTicket.outlet_name}</p>
                                    <p>WA Outlet : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name}</p>
                                    <p>Staff Support : - </p>
                                </div>
                                </div>
                                <div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Platform</th>
                                                <th>Menu</th>
                                                <th>Harga ESB</th>
                                                <th>Harga Platform</th>
                                                <th>Pajak</th>
                                            </tr>
                                            </thead>
                                            <tbody>`;

                            sm.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${sm[index]}</td>
                                                    <td>${menu[index]}</td>                        
                                                    <td>${pricePos[index]}</td>
                                                    <td>${priceSm[index]}</td>
                                                    <td><input class="form-check-input" type="checkbox" id="gridCheck2" ${tax[index] === "on" ? 'checked' : ''}  disabled></td>
                                                </tr>`;
                            });

                            modalContent += `</tbody>
                                        </table>
                                        </div>
                            </div>`;

                            modalBody.innerHTML = modalContent;

                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->selisih_harga_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Kerjakan</button>
                                </form>`;
                            }
                        }
                        if (data.dataTicket.ticket.status == "Pengerjaan") {
                            let modalContent = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>Nama Outlet : ${data.dataTicket.outlet_name}</p>
                                    <p>WA Outlet : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name}</p>
                                    <p>Staff Support : ${data.dataTicket.ticket.handle.account_name} </p>
                                </div>
                                </div>
                                <div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Platform</th>
                                                <th>Menu</th>
                                                <th>Harga ESB</th>
                                                <th>Harga Platform</th>
                                                <th>Pajak</th>
                                            </tr>
                                            </thead>
                                            <tbody>`;

                            sm.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${sm[index]}</td>
                                                    <td>${menu[index]}</td>                        
                                                    <td>${pricePos[index]}</td>
                                                    <td>${priceSm[index]}</td>
                                                    <td><input class="form-check-input" type="checkbox" id="gridCheck2" ${tax[index] === "on" ? 'checked' : ''}  disabled></td>
                                                </tr>`;
                            });

                            modalContent += `</tbody>
                                        </table>
                                        </div>
                            </div>`;

                            modalBody.innerHTML = modalContent;

                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->selisih_harga_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Selesai</button>
                                </form>`;
                            }
                        }
                        if (data.dataTicket.ticket.status == "Selesai") {
                            let modalContent = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>Nama Outlet : ${data.dataTicket.outlet_name}</p>
                                    <p>WA Outlet : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name} </p>
                                    <p>Staff Support : ${data.dataTicket.ticket.handle.account_name}</p>
                                </div>
                                </div>
                                <div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Platform</th>
                                                <th>Menu</th>
                                                <th>Harga ESB</th>
                                                <th>Harga Platform</th>
                                                <th>Pajak</th>
                                            </tr>
                                            </thead>
                                            <tbody>`;

                            sm.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${sm[index]}</td>
                                                    <td>${menu[index]}</td>                        
                                                    <td>${pricePos[index]}</td>
                                                    <td>${priceSm[index]}</td>
                                                    <td><input class="form-check-input" type="checkbox" id="gridCheck2" ${tax[index] === "on" ? 'checked' : ''}  disabled></td>
                                                </tr>`;
                            });

                            modalContent += `</tbody>
                                        </table>
                                        </div>
                            </div>`;

                            modalBody.innerHTML = modalContent;
                        }
                        if (data.dataTicket.ticket.status == "Ditolak") {
                            let modalContent = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>Nama Outlet : ${data.dataTicket.outlet_name}</p>
                                    <p>WA Outlet : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name}</p>
                                    <p>Staff Support : - </p>
                                </div>
                                </div>
                                <div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Platform</th>
                                                <th>Menu</th>
                                                <th>Harga ESB</th>
                                                <th>Harga Platform</th>
                                                <th>Pajak</th>
                                            </tr>
                                            </thead>
                                            <tbody>`;

                            sm.forEach((el, index) => {
                                modalContent += `<tr>
                                                    <td>${sm[index]}</td>
                                                    <td>${menu[index]}</td>                        
                                                    <td>${pricePos[index]}</td>
                                                    <td>${priceSm[index]}</td>
                                                    <td><input class="form-check-input" type="checkbox" id="gridCheck2" ${tax[index] === "on" ? 'checked' : ''}  disabled></td>
                                                </tr>`;
                            });

                            modalContent += `</tbody>
                                        </table>
                                        </div>
                            </div>`;

                            modalBody.innerHTML = modalContent;
                            modalFooter.innerHTML =
                                `<p>Alasan Penolakan : <b>${data.dataTicket.ticket.alasan_pembatalan}</b></p>`;
                        }
                    }
                    if (data.dataTicket.ticket.tipe == "void") {
                        const permission =
                            "{{ in_array('update', json_decode(Auth::user()->role->permission->void_option)) }}";

                        if (data.dataTicket.ticket.status == "Verifikasi") {
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Nama Outlet : ${data.dataTicket.outlet_name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>WA Outlet : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                    <p>Verifikasi : - </p>
                                </div>
                                </div>
                                <div>                      
                                    <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Sales Mode</th>
                                            <th>Nomor Transaksi</th>
                                            <th>Alasan Void</th>
                                            <th>PIN Void</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>${data.dataTicket.sales_mode.sales_name}</td>
                                            <td>${data.dataTicket.transaction_no}</td>                        
                                            <td>${data.dataTicket.reason_void}</td>
                                            <td>
                                                <form action="/ticket/update/${data.dataForm}" method="POST" id="voidForm">
                                                @csrf
                                                    <input type="text" class="form-control" disabled>
                                                </form>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </div>
                            </div>`;
                            if (
                                "{{ in_array('approve', json_decode(Auth::user()->role->permission->void_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<button type="submit" class="btn btn-warning" form="voidForm">Verifikasi</button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-penolakan">Tolak</button>`;
                            }
                        }
                        if (data.dataTicket.ticket.status == "Penugasan") {
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Nama Outlet : ${data.dataTicket.outlet_name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>WA Outlet : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name}</p>
                                </div>
                                </div>
                                <div>                      
                                    <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Sales Mode</th>
                                            <th>Nomor Transaksi</th>
                                            <th>Alasan Void</th>
                                            <th>PIN Void</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>${data.dataTicket.sales_mode.sales_name}</td>
                                            <td>${data.dataTicket.transaction_no}</td>                        
                                            <td>${data.dataTicket.reason_void}</td>
                                            <td>
                                                <form action="/ticket/update/${data.dataForm}" method="POST" id="voidForm">
                                                @csrf
                                                    <input type="text" class="form-control" disabled>
                                                </form>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </div>
                            </div>`;
                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->void_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Kerjakan</button>
                                    </form>`;
                            }
                        }
                        if (data.dataTicket.ticket.status == "Pengerjaan") {
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Nama Outlet : ${data.dataTicket.outlet_name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>WA Outlet : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name}</p>
                                </div>
                                </div>
                                <div>                      
                                    <div class="table-responsive">
                                        <form action="/ticket/update/${data.dataForm}" method="POST" id="voidForm">
                                                @csrf
                                        <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Sales Mode</th>
                                            <th>Nomor Transaksi</th>
                                            <th>Alasan Void</th>
                                            <th>PIN Void</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>${data.dataTicket.sales_mode.sales_name}</td>
                                            <td>${data.dataTicket.transaction_no}</td>                        
                                            <td>${data.dataTicket.reason_void}</td>
                                            <td>
                                                <input type="text" class="form-control" name="pin_void" ${ permission ? " " : 'disabled'}>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </form>
                                    </div>
                            </div>`;

                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->void_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<button type="submit" class="btn btn-success" form="voidForm">Selesai</button>`;
                            }
                        }
                        if (data.dataTicket.ticket.status == "Selesai") {
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Nama Outlet : ${data.dataTicket.outlet_name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>WA Outlet : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name}</p>
                                </div>
                                </div>
                                <div>                      
                                    <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Sales Mode</th>
                                            <th>Nomor Transaksi</th>
                                            <th>Alasan Void</th>
                                            <th>PIN Void</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>${data.dataTicket.sales_mode.sales_name}</td>
                                            <td>${data.dataTicket.transaction_no}</td>                        
                                            <td>${data.dataTicket.reason_void}</td>
                                            <td>
                                                <form action="/ticket/update/${data.dataForm}" method="POST" id="voidForm">
                                                @csrf
                                                    <input type="text" class="form-control" name="pin_void" value="${data.dataTicket.pin_void}" disabled>
                                                </form>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </div>
                            </div>`;
                        }
                        if (data.dataTicket.ticket.status == "Ditolak") {
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Nama Outlet : ${data.dataTicket.outlet_name}</p>
                                    <p>Pemohon : ${data.dataTicket.ticket.name}</p>
                                    <p>WA Outlet : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name}</p>
                                </div>
                                </div>
                                <div>                      
                                    <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Sales Mode</th>
                                            <th>Nomor Transaksi</th>
                                            <th>Alasan Void</th>
                                            <th>PIN Void</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>${data.dataTicket.sales_mode.sales_name}</td>
                                            <td>${data.dataTicket.transaction_no}</td>                        
                                            <td>${data.dataTicket.reason_void}</td>
                                            <td>
                                                <form action="/ticket/update/${data.dataForm}" method="POST" id="voidForm">
                                                @csrf
                                                    <input type="text" class="form-control" disabled>
                                                </form>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </div>
                            </div>`;

                            modalFooter.innerHTML =
                                `<p>Alasan Penolakan : <b>${data.dataTicket.ticket.alasan_pembatalan}</b></p>`;
                        }
                    }
                    if (data.dataTicket.ticket.tipe == "product") {

                        if (data.dataTicket.ticket.status == "Verifikasi") {
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                    <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                    <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                    <p>Verifikasi : - </p>
                                    <p>Staff Support : - </p>
                                </div>
                                </div>
                                <div>
                                <div class="py-1">
                                    <p class="h6"><strong>Subjek</strong></p>
                                    <p>${data.dataTicket.ticket.subcategory.name}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>Detail</strong></p>
                                    <p>${data.dataTicket.description}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>File Pendukung</strong></p>
                                    <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                </div>
                            </div>`;

                            if (
                                "{{ in_array('approve', json_decode(Auth::user()->role->permission->product_option)) }}"
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
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                    <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                    <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name} </p>
                                    <p>Staff Support : - </p>
                                </div>
                                </div>
                                <div>
                                <div class="py-1">
                                    <p class="h6"><strong>Subjek</strong></p>
                                    <p>${data.dataTicket.ticket.subcategory.name}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>Detail</strong></p>
                                    <p>${data.dataTicket.description}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>File Pendukung</strong></p>
                                    <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                </div>
                            </div>`;

                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->product_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Kerjakan</button>
                                    </form>`;
                            }

                        }
                        if (data.dataTicket.ticket.status == "Pengerjaan") {
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                    <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                    <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name} </p>
                                    <p>Staff Support : ${data.dataTicket.ticket.handle.account_name} </p>
                                </div>
                                </div>
                                <div>
                                <div class="py-1">
                                    <p class="h6"><strong>Subjek</strong></p>
                                    <p>${data.dataTicket.ticket.subcategory.name}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>Detail</strong></p>
                                    <p>${data.dataTicket.description}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>File Pendukung</strong></p>
                                    <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                </div>
                            </div>`;

                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->product_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Selesai</button>
                                    </form>`;
                            }

                        }
                        if (data.dataTicket.ticket.status == "Selesai") {
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                    <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                    <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name} </p>
                                    <p>Staff Support : ${data.dataTicket.ticket.handle.account_name} </p>
                                </div>
                                </div>
                                <div>
                                <div class="py-1">
                                    <p class="h6"><strong>Subjek</strong></p>
                                    <p>${data.dataTicket.ticket.subcategory.name}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>Detail</strong></p>
                                    <p>${data.dataTicket.description}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>File Pendukung</strong></p>
                                    <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                </div>
                            </div>`;

                        }
                        if (data.dataTicket.ticket.status == "Ditolak") {
                            modalBody.innerHTML = `<div class="row">
                                <div class="col-sm-5">
                                    <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                    <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                    <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                    <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                </div>
                                <div class="col-sm-5">
                                    <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                    <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name} </p>
                                    <p>Staff Support : - </p>
                                </div>
                                </div>
                                <div>
                                <div class="py-1">
                                    <p class="h6"><strong>Subjek</strong></p>
                                    <p>${data.dataTicket.ticket.subcategory.name}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>Detail</strong></p>
                                    <p>${data.dataTicket.description}</p>
                                </div>
                                <div class="py-1">
                                    <p class="h6"><strong>File Pendukung</strong></p>
                                    <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                </div>
                            </div>`;

                            modalFooter.innerHTML =
                                `<p>Alasan Penolakan : <b>${data.dataTicket.ticket.alasan_pembatalan}</b></p>`;

                        }
                    }
                    if (data.dataTicket.ticket.tipe == "supplier") {

                        if (data.dataTicket.ticket.status == "Verifikasi") {
                            modalBody.innerHTML = `<div class="row">
                                                        <div class="col-sm-5">
                                                            <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                                            <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                                            <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                                            <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                                            <p>Bisnis Unit : ${data.dataTicket.business_unit ? data.dataTicket.business_unit.name_bu : "-"} </p>
                                                            <p>Verifikasi : - </p>
                                                            <p>Staff Support : - </p>
                                                        </div>
                                                        </div>
                                                        <div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Subjek</strong></p>
                                                            <p>${data.dataTicket.ticket.subcategory.name}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Detail</strong></p>
                                                            <p>${data.dataTicket.description}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>File Pendukung</strong></p>
                                                            <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                                        </div>
                                                    </div>`;

                            if (
                                "{{ in_array('approve', json_decode(Auth::user()->role->permission->supplier_option)) }}"
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
                            modalBody.innerHTML = `<div class="row">
                                                        <div class="col-sm-5">
                                                            <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                                            <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                                            <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                                            <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                                            <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name} </p>
                                                            <p>Staff Support : - </p>
                                                        </div>
                                                        </div>
                                                        <div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Subjek</strong></p>
                                                            <p>${data.dataTicket.ticket.subcategory.name}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Detail</strong></p>
                                                            <p>${data.dataTicket.description}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>File Pendukung</strong></p>
                                                            <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                                        </div>
                                                    </div>`;

                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->supplier_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Kerjakan</button>
                                    </form>`;
                            }

                        }
                        if (data.dataTicket.ticket.status == "Pengerjaan") {
                            modalBody.innerHTML = `<div class="row">
                                                        <div class="col-sm-5">
                                                            <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                                            <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                                            <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                                            <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                                            <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name} </p>
                                                            <p>Staff Support : ${data.dataTicket.ticket.handle.account_name} </p>
                                                        </div>
                                                        </div>
                                                        <div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Subjek</strong></p>
                                                            <p>${data.dataTicket.ticket.subcategory.name}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Detail</strong></p>
                                                            <p>${data.dataTicket.description}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>File Pendukung</strong></p>
                                                            <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                                        </div>
                                                    </div>`;

                            if (
                                "{{ in_array('update', json_decode(Auth::user()->role->permission->supplier_option)) }}"
                            ) {
                                modalFooter.innerHTML =
                                    `<form action="/ticket/update/${data.dataForm}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Selesai</button>
                                    </form>`;
                            }

                        }
                        if (data.dataTicket.ticket.status == "Selesai") {
                            modalBody.innerHTML = `<div class="row">
                                                        <div class="col-sm-5">
                                                            <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                                            <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                                            <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                                            <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                                            <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name} </p>
                                                            <p>Staff Support : ${data.dataTicket.ticket.handle.account_name} </p>
                                                        </div>
                                                        </div>
                                                        <div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Subjek</strong></p>
                                                            <p>${data.dataTicket.ticket.subcategory.name}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Detail</strong></p>
                                                            <p>${data.dataTicket.description}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>File Pendukung</strong></p>
                                                            <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                                        </div>
                                                    </div>`;

                        }
                        if (data.dataTicket.ticket.status == "Ditolak") {
                            modalBody.innerHTML = `<div class="row">
                                                        <div class="col-sm-5">
                                                            <p>Kategori : ${data.dataTicket.ticket.subcategory.name}</p>
                                                            <p>Divisi : ${data.dataTicket.ticket.division ? data.dataTicket.ticket.division.division_name : "-"}</p>
                                                            <p>Pengguna : ${data.dataTicket.ticket.name}</p>
                                                            <p>Whatsapp : ${data.dataTicket.ticket.whatsapp_number}</p>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <p>Status : ${getBadgeStat(data.dataTicket.ticket.status)}</p>
                                                            <p>Verifikasi : ${data.dataTicket.ticket.approver.account_name} </p>
                                                            <p>Staff Support : - </p>
                                                        </div>
                                                        </div>
                                                        <div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Subjek</strong></p>
                                                            <p>${data.dataTicket.ticket.subcategory.name}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>Detail</strong></p>
                                                            <p>${data.dataTicket.description}</p>
                                                        </div>
                                                        <div class="py-1">
                                                            <p class="h6"><strong>File Pendukung</strong></p>
                                                            <a type="button" class="btn btn-warning" href="{{ asset('storage/${data.dataTicket.attachment_path}') }}" download><i class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                                                        </div>
                                                    </div>`;

                            modalFooter.innerHTML =
                                `<p>Alasan Penolakan : <b>${data.dataTicket.ticket.alasan_pembatalan}</b></p>`;

                        }
                    }
                })
                .catch(error => {
                    alert('Ada kesalahan saat mengambil data:', error); // Handle errors here
                });


        }
    </script>
@endsection
