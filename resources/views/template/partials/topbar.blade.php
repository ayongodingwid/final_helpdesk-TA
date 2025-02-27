<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('assets/img/android-chrome-192x192.png') }}" alt="">
            <span class="d-none d-lg-block">ICT Helpdesk</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <form action="/read-notif" method="post" id="notifForm">@csrf <input type="hidden" id="notifData"
                    name="data"></form>
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" id="notifNum">
                    <i class="bi bi-bell"></i>
                </a><!-- End Notification Icon -->
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications"
                    style="max-height: 400px;overflow: auto;" id="notif">
                    <li class="dropdown-header">
                        Tidak ada notifikasi
                        {{-- <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">Liat Semua</span></a> --}}
                    </li>

                    {{-- <li class="notification-item" style="width: 300px;" onclick="notifClick([2,23])">
                        <i class="bi bi-exclamation-circle text-warning"></i>
                        <div>
                            <h4>Tiket</h4>
                            <p>notification.message</p>
                            <p>$oment</p>
                        </div>
                    </li>` --}}
                </ul><!-- End Notification Dropdown Items -->

            </li><!-- End Notification Nav -->

            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->account_name }}</span>
                </a><!-- End Profile Iamge Icon -->
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->account_name }}</h6>
                        <span>{{ Auth::user()->role->name_role }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header>
