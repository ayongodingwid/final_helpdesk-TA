<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Permintaan IT Asset</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon_.ico') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <link href="{{ asset('assets/css/form.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Header Section -->
    <header>
        <img style="width: 300px;" src="{{ asset('assets/img/akang_logo.jpg') }}" alt="Company Logo">
        <div class="header-title">
            <h1>FORM PERMINTAAN IT ASSET</h1>
        </div>
        {{-- <div class="header-info">
            <table>
                <tr>
                    <td>Nomor</td>
                    <td>:</td>
                    <td>FM-ICT-ICT-001</td>
                </tr>
                <tr>
                    <td>Revisi</td>
                    <td>:</td>
                    <td>00</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>23 November 2022</td>
                </tr>
                <tr>
                    <td>Halaman</td>
                    <td>:</td>
                    <td>1 dari 1</td>
                </tr>
            </table>
        </div> --}}
    </header>

    <!-- Form Details Section -->
    <section class="form-section">
        <table border="1">
            <tr>
                <td style="table-layout: fixed; width: 200px">Nama</td>
                <td style="table-layout: fixed; width: 10px">:</td>
                <td>{{ $req->ticket->name }}</td>
            </tr>
            <tr>
                <td>Tanggal Pengajuan</td>
                <td>:</td>
                <td>{{ $req->created_at->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td>Bisnis Unit</td>
                <td>:</td>
                <td>{{ $req->business_unit->name_bu }}</td>
            </tr>
            {{-- <tr>
                <td>Keperluan Pengajuan</td>
                <td>:</td>
                <td></td>
            </tr> --}}
        </table>
    </section>

    <!-- Asset Request Section -->
    <section class="form-section">
        <table>
            @php
                $asset = json_decode($req->asset_name);
                $qty = json_decode($req->quantity);
                $receiver = json_decode($req->asset_receiver);
                $division = json_decode($req->asset_receiver_position);
                $level = json_decode($req->position);
            @endphp
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama Asset</th>
                    <th>Qty</th>
                    <th>Nama Penerima</th>
                    <th>Departemen / Divisi</th>
                    <th>Jabatan / Level Jabatan</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($asset as $i => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $asset[$i] }}</td>
                        <td>{{ $qty[$i] }}</td>
                        <td>{{ $receiver[$i] }}</td>
                        <td>{{ $division[$i] }}</td>
                        <td>{{ $level[$i] }}</td>
                    </tr>
                @endforeach
                <!-- Additional Rows as Needed -->
            </tbody>
        </table>
    </section>

    <!-- Notes and Specifications -->
    <div class="textarea-group">
        <label for="notes">CATATAN TAMBAHAN:</label>
        <textarea id="notes" readonly>{{ $req->note }}</textarea>
    </div>

    <div class="textarea-group">
        <label for="specifications">SPESIFIKASI:</label>
        <textarea id="specifications" readonly>{{ $req->description }}</textarea>
    </div>

    <!-- Approval Section -->
    <section class="approval-section">
        <table>
            <thead>
                <tr>
                    <th>Diajukan</th>
                    <th>Diketahui</th>
                    <th>Diverifikasi</th>
                    <th>Disetujui</th>
                </tr>
            </thead>
            <tbody>
                <tr class="signatures" style="table-layout: fixed; height: 100px; background-color: white">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="font-weight: bold;">
                    <td style="table-layout: fixed; width: 150px"></td>
                    <td style="table-layout: fixed; width: 150px"></td>
                    <td style="table-layout: fixed; width: 150px">Dimas Ardhi Bangun</td>
                    <td style="table-layout: fixed; width: 150px">Ervina Waty</td>
                </tr>
                <tr style="font-size: 12px;">
                    <td></td>
                    <td></td>
                    <td>Deputy GM Costing &amp; ICT</td>
                    <td>Chief Finance Operations</td>
                </tr>
                <tr style="table-layout: fixed; height: 30px">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </section>
</body>

</html>
