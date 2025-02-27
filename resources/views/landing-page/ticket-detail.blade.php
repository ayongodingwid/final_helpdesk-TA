@extends('template.landing')

@section('content')
    <!-- header tiket -->
    <div class="card">
        <div class="card-body">
            <div class="py-4">
                <p class="h5"><strong>No. Tiket: {{ $ticket->ticket_number }}</strong></p>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <p>Kategori : {{ $ticket->subcategory->name }}</p>
                    <p>Divisi : {{ $ticket->division ? $ticket->division->division_name : '-' }}</p>
                    <p>Pengguna : {{ $ticket->name }}</p>
                </div>
                <div class="col-lg-5">
                    <p>Status : <span @class([
                        'badge',
                        'bg-info text-dark ' => $ticket->status == 'Terkirim',
                        'bg-warning text-dark' => $ticket->status == 'Verifikasi',
                        'bg-info-light text-dark' => $ticket->status == 'Penugasan',
                        'bg-primary' => $ticket->status == 'Pengerjaan',
                        'text-bg-success' => $ticket->status == 'Selesai',
                        'text-bg-danger' => $ticket->status == 'Ditolak',
                    ])>{{ $ticket->status }}</span></p>
                    <p>Disetujui : {{ $ticket->approver ? $ticket->approver->account_name : '-' }}</p>
                    <p>Teknisi : {{ $ticket->handle ? $ticket->handle->account_name : '-' }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- close header tiket -->

    <div class="card">
        <div class="card-body p-5">
            <div class="py-1">
                <p class="h6"><strong>Permintaan Perbaikan</strong></p>
                <p>{{ $ticket->subcategory->name }}</p>
            </div>
            <div class="py-1">
                <p class="h6"><strong>Detail</strong></p>
                <p>{{ $ticket->problemHandlings->description }}</p>
            </div>
            <div class="py-1">
                <p class="h6"><strong>Laporan Perbaikan</strong></p>
                <p>{{ $ticket->problemHandlings->laporan_perbaikan ? $ticket->problemHandlings->laporan_perbaikan : ' -' }}
                </p>
            </div>
        </div>
    </div>
    <a href="javascript:history.back()" class="btn btn-dark">Kembali</a>
@endsection
