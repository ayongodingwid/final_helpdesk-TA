@extends('template.dashboard')

@section('title')
    <div class="pagetitle">
        <h1>Menu & BoM</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Operational</li>
                <li class="breadcrumb-item active">Menu & BoM</li>
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
                        @if (in_array('create', json_decode(Auth::user()->role->permission->menu_bom_option)))
                            <a class="btn btn-primary me-md-2" type="button" href="{{ route('mnb-create') }}">Buat
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
                                    @if (in_array('read', json_decode(Auth::user()->role->permission->menu_bom_option)))
                                        @foreach ($ticket as $item)
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
                                                    ])>{{ $item->ticket->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button type="button" data-modalData="{{ $data }}"
                                                        onclick="modalData(this)" class="btn btn-primary btn-sm me-2"
                                                        data-bs-toggle="modal" data-bs-target="#modalTerkirim">
                                                        <i class="bi bi-info-circle"></i>
                                                    </button>
                                                    </button>
                                                </td>
                                        @endforeach
                                    @endif

                                    </tr>
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
                })
                .catch(error => {
                    alert('Ada kesalahan saat mengambil data:', error); // Handle errors here
                });


        }
    </script>
@endsection
