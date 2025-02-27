@extends('template.landing')

@section('content')
    <div class="card mb-3">
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mt-lg-4 text-center">
                    <thead>
                        <tr>
                            <th scope="col">Nomor tiket</th>
                            <th scope="col">Nama Pengguna</th>
                            <th scope="col">Divisi</th>
                            <th scope="col">Problem</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($tickets->count() > 0)
                            @foreach ($tickets as $item)
                                @php
                                    $id = Crypt::encrypt($item->id);
                                @endphp
                                <tr>
                                    <th scope="row">{{ $item->ticket_number }}</th>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->division ? $item->division->division_name : '-' }}</td>
                                    <td>{{ $item->subcategory->name }}</td>
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
                                        <a href="{{ route('landing-detail', $id) }}"
                                            class="btn btn-primary rounded-pill btn-sm "><i
                                                class="bi bi-info-circle me-2"></i> Cek Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">
                                    <p class="text-muted">Tiket tidak ditemukan.</p>
                                </td>

                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <a href="javascript:history.back()" class="btn btn-light"><i class="ri ri-arrow-left-s-fill"> </i>Kembali</a>
            <!-- End Table with hoverable rows -->

        </div>
    </div>
@endsection
