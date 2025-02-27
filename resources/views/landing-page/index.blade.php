<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>ICT Helpdesk - Halo Selamat Datang</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon-16x16.png') }}" rel="icon">
    <link href="{{ 'assets/img/apple-touch-icon.png' }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: QuickStart
  * Template URL: https://bootstrapmade.com/quickstart-bootstrap-startup-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    <main>

        <header id="header" class="header d-flex align-items-center fixed-top">
            <div class="container-fluid container-xl position-relative d-flex align-items-center">

                <a href="{{ route('landing-page') }}" class="logo d-flex align-items-center me-auto">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="">
                    <h1 class="sitename">ICT Helpdesk</h1>
                </a>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="#hero" class="active">Beranda</a></li>
                        <li><a href="#tiket">Buat Tiket</a></li>
                        <li><a href="#features">FAQ</a></li>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>

                <a class="btn-getstarted" href="{{ route('login') }}">Masuk</a>

            </div>
        </header>

        <main class="main">

            <!-- Hero Section -->
            <section id="hero" class="hero section">
                <div class="hero-bg">
                    <img src="{{ asset('assets/img/hero-bg-light.webp') }}" alt="">
                </div>
                <div class="container">
                    <div class="row gy-5">
                        <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center"
                            data-aos="zoom-out">
                            <form action="{{ route('landing-search') }}" method="post">
                                @csrf
                                <h1>Selamat datang di <br><span>ICT Helpdesk</span></h1>
                                <p>Untuk melihat progres perbaikan kamu bisa cek disini</p>
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Error !</strong> {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <input type="text" class="form-control form-control-lg"
                                        id="exampleFormControlInput1" placeholder="Ketikan nomor tiket disini"
                                        name="code" required>
                                </div>
                                <div class="d-flex">
                                    <button type="submit" class="btn-get-started">Cek Progres</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="200">
                            <img src="{{ asset('assets/img/hero-img.png') }}" class="img-fluid animated"
                                alt="">
                        </div>
                    </div>
                </div>

            </section>
            <!-- /Hero Section -->

            <!-- Features Details Section -->
            <section id="tiket" class="features-details section">

                <div class="container">

                    <div class="row gy-4 justify-content-between features-item center">

                        <div class="" data-aos="fade-up" data-aos-delay="200">
                            <div class="content text-center">
                                <h3>Perangkat kamu bermasalah?</h3>
                                <p>
                                    Untuk memlakukan permintaan cek dan perbaikan, kamu bisa langsung buat tiket
                                    permintaan
                                    disini dan nanti tim ICT akan kontak kamu kembali
                                </p>
                                <a href="{{ route('landing-create') }}" class="btn more-btn">Buat Tiket</a>
                            </div>
                        </div>

                    </div>
                </div>

            </section><!-- /Features Details Section -->

            <!-- Faq Section -->
            <section id="features" class="faq section">

                <!-- Section Title -->
                <div class="container section-title" data-aos="fade-up">
                    <h2>Pertanyaan yang Sering Diajukan</h2>
                </div><!-- End Section Title -->

                <div class="container">

                    <div class="row justify-content-center">

                        <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">

                            <div class="faq-container">

                                @if ($faqs->count() > 0)
                                    @foreach ($faqs as $faq)
                                        <div class="faq-item @if ($loop->iteration == '1') faq-active @endif">
                                            <h3>{{ $faq->title }}</h3>
                                            <div class="faq-content text">
                                                <p>{{ $faq->detail }}</p>
                                            </div>
                                            <i class="faq-toggle bi bi-chevron-right"></i>
                                        </div><!-- End Faq item-->
                                    @endforeach
                                @endif

                            </div>

                        </div><!-- End Faq Column-->

                    </div>

                </div>

            </section><!-- /Faq Section -->

        </main>

        <footer id="footer" class="footer position-relative light-background">

            <div class="container copyright text-center mt-4">
                <p>© <span>Copyright</span> <strong class="px-1 sitename">QuickStart</strong><span>All Rights
                        Reserved</span></p>
                <div class="credits">
                    <!-- All the links in the footer should remain intact. -->
                    <!-- You can delete the links only if you've purchased the pro version. -->
                    <!-- Licensing information: https://bootstrapmade.com/license/ -->
                    <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                    Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                </div>
            </div>

        </footer>

    </main>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
