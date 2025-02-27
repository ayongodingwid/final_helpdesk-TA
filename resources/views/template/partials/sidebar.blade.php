<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <!-- <li class="nav-heading">Working Order</li> -->

        <!-- General Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#general-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-front"></i><span>General</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="general-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                @if (Auth::user()->role->permission->daftar_tiket)
                    <li>
                        <a href="{{ route('list-ticket') }}">
                            <i class="bi bi-circle"></i><span>Daftar Tiket</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li><!-- End General Nav -->

        <!-- ict Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#ict-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-slack"></i><span>I C T</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="ict-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                @if (Auth::user()->role->permission->penanganan_masalah)
                    <li>
                        <a href="{{ route('ict-pm') }}">
                            <i class="bi bi-circle"></i><span>Penanganan Masalah</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role->permission->pengajuan_aset)
                    <li>
                        <a href="{{ route('ict-pa') }}">
                            <i class="bi bi-circle"></i><span>Permintaan Aset</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li><!-- End ict Nav -->

        <!-- Operational Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-people"></i><span>Operational</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                @if (Auth::user()->role->permission->menu_bom)
                    <li>
                        <a href="{{ route('menu-bom') }}">
                            <i class="bi bi-circle"></i><span>Menu & BOM</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role->permission->program_promo)
                    <li>
                        <a href="{{ route('program-promo') }}">
                            <i class="bi bi-circle"></i><span>Program Promo</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role->permission->diskon)
                    <li>
                        <a href="{{ route('discount') }}">
                            <i class="bi bi-circle"></i><span>Discount</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role->permission->selisih_harga)
                    <li>
                        <a href="{{ route('harga') }}">
                            <i class="bi bi-circle"></i><span>Selisi Harga</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role->permission->void)
                    <li>
                        <a href="{{ route('void') }}">
                            <i class="bi bi-circle"></i><span>Void</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li><!-- End Operational Nav -->

        <!-- F A T Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bx bx-dollar-circle"></i><span>F A T</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                @if (Auth::user()->role->permission->coa)
                    <li>
                        <a href="{{ route('coa') }}">
                            <i class="bi bi-circle"></i><span>COA</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li><!-- End FAT Nav -->

        <!-- Purchasing Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-basket2"></i><span>Purchasing</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                @if (Auth::user()->role->permission->product)
                    <li>
                        <a href="{{ route('product') }}">
                            <i class="bi bi-circle"></i><span>Product</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role->permission->supplier)
                    <li>
                        <a href="{{ route('supplier') }}">
                            <i class="bi bi-circle"></i><span>Supplier</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li><!-- End Purchasing Nav -->

        <!-- Data master Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-stack"></i><span>Master</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                @if (Auth::user()->role->permission->bisnis_unit)
                    <li>
                        <a href="{{ route('bisnis-unit') }}">
                            <i class="bi bi-circle"></i><span>Bisnis Unit</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role->permission->divisi)
                    <li>
                        <a href="{{ route('divisi') }}">
                            <i class="bi bi-circle"></i><span>Divisi</span>
                        </a>
                    </li>
                @endif
                {{-- @if (Auth::user()->role->permission->karyawan)
                    <li>
                        <a href="master-menu/dashboard-employee.html">
                            <i class="bi bi-circle"></i><span>Karyawan</span>
                        </a>
                    </li>
                @endif --}}
                @if (Auth::user()->role->permission->mode_penjualan)
                    <li>
                        <a href="{{ route('sales-mode') }}">
                            <i class="bi bi-circle"></i><span>Mode Penjualan</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role->permission->backoffice)
                    <li>
                        <a href="{{ route('backoffice') }}">
                            <i class="bi bi-circle"></i><span>Sistem Backoffice</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role->permission->aset)
                    <li>
                        <a href="{{ route('asset') }}">
                            <i class="bi bi-circle"></i><span>Aset</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li><!-- End Purchasing Nav -->

        <!-- Data pengaturan Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#pengaturan-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-gear"></i><span>Pengaturan</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="pengaturan-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                @if (Auth::user()->role->permission->ticket_kategori)
                    <li>
                        <a href="{{ route('pengaturan-ticket') }}">
                            <i class="bi bi-circle"></i><span>Tiket Kategori</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role->permission->aset_kategori)
                    <li>
                        <a href="{{ route('pengaturan-aset') }}">
                            <i class="bi bi-circle"></i><span>Aset Kategori</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role->permission->akun_role)
                    <li>
                        <a href="{{ route('akun-role') }}">
                            <i class="bi bi-circle"></i><span>Akun Role</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role->permission->list_akun)
                    <li>
                        <a href="{{ route('list-akun') }}">
                            <i class="bi bi-circle"></i><span>List Akun</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role->permission->faq)
                    <li>
                        <a href="{{ route('faq') }}">
                            <i class="bi bi-circle"></i><span>FaQ</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li><!-- End Purchasing Nav -->

    </ul>

</aside>
