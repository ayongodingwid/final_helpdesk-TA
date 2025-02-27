<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ICT Helpdesk - Home</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon_.ico') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    @include('template.partials.topbar')
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    @include('template.partials.sidebar')
    <!-- End Sidebar-->

    <main id="main" class="main">

        @if (session('berhasil'))
            <section class="section register d-flex flex-column align-items-center justify-content-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Permintaan Berhasil Dibuat</h5>
                                        <p class="text-center small">Berikut nomor tiket anda:</p>
                                    </div>
                                    <div class="col-12">
                                        <h3 class="card-title text-center pb-0 fs-4">{{ session('berhasil') }}</h3>
                                    </div>
                                </div>
                            </div>
                            <a type="button" onclick="location.reload();" class="btn btn-link"><i
                                    class="bi bi-arrow-left me-1"></i>Kembali</a>
                        </div>
                    </div>
                </div>
            </section>
        @else
            @yield('title')
            <!-- End Page Title -->

            @yield('body')
        @endif



    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main-dashb.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/min/moment.min.js"></script>

    {{-- notifikasi --}}
    <script>
        function notifClick(id) {
            document.querySelector("#notifData").value = id;
            document.querySelector("#notifForm").submit();
        }

        function fetchNotifications() {
            let url = "/get-notification";


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

                    // reset
                    document.querySelector("#notifNum").innerHTML = `<i class="bi bi-bell"></i>`;
                    // reset


                    let notif = `<li class="dropdown-header" id="notifHeader"></li>
                                    <li><hr class="dropdown-divider"></li>`;

                    if (Object.keys(data).length > 0) {

                        // notif number
                        const badge = document.createElement('span');
                        badge.classList.add('badge', 'bg-primary', 'badge-number');
                        badge.setAttribute('id', 'notifBadge');
                        badge.textContent = Object.keys(data).length;

                        document.querySelector("#notifNum").appendChild(badge);
                        let notifId = [];

                        // notif
                        data.forEach(function(notification) {

                            notifId.push(notification.id);

                            notif += `<li class="notification-item" style="width: 300px;" onclick="notifClick([${notification.id}, ${notification.ticket_id}])">
                                    <i class="bi bi-exclamation-circle text-warning"></i>
                                    <div>
                                        <h4>Tiket ${notification.ticket.ticket_number}</h4>
                                        <p>${notification.message}</p>
                                        <p>${moment(data.created_at).fromNow()}</p>
                                    </div>
                                </li>`;
                        });


                        document.querySelector("#notif").innerHTML = notif;

                        // notif header
                        document.querySelector("#notifHeader").innerHTML =
                            `Kamu memiliki ${Object.keys(data).length} notifikasi 
                        <form action="/read-all" method="post">
                            @csrf
                            <input type="hidden" name="data" value="${notifId}">
                            <button type="submit" class="badge rounded-pill bg-primary p-2 ms-2 mt-2 border-0">tandai sudah
                                    dibaca semua</button>
                        </form>`;

                    } else {
                        document.querySelector("#notif").innerHTML = notif;

                        // document.querySelector("#notifBadge").remove();
                        // notif header
                        document.querySelector("#notifHeader").innerHTML = `Tidak ada notifikasi`;

                    }

                })
                .catch(error => {
                    // alert('Ada kesalahan saat mengambil data:', error); // Handle errors here
                    // console.log(error);

                });
        }

        fetchNotifications();
        // // Polling setiap 10 detik
        setInterval(fetchNotifications, 2000);
    </script>
    {{-- end notifikasi --}}
    <script>
        const alertBerhasil = document.querySelector('.alert-berhasil');

        if (alertBerhasil.style.display !== 'none') {
            setTimeout(() => {
                alertBerhasil.style.display = 'none';
            }, 5000);
        }

        function addList() {
            const table = document.getElementById("subticket-list");

            // Create a new row element
            const newRow = document.createElement("tr");

            // Create the first cell
            const cell1 = document.createElement("td");
            const input1 = document.createElement("input");
            input1.type = "text";
            input1.className = "form-control";
            input1.setAttribute('name', 'sub[]');
            input1.setAttribute('required', 'true');
            cell1.appendChild(input1);

            // Create the second cell
            const cell2 = document.createElement("td");
            const input2 = document.createElement("input");
            input2.type = "text";
            input2.className = "form-control";
            input2.setAttribute('name', 'subCode[]');
            input1.setAttribute('required', 'true');
            cell2.appendChild(input2);

            // Create the third cell with a remove button
            const cell3 = document.createElement("td");
            const removeButton = document.createElement("button");
            removeButton.className = "btn btn-danger btn-sm remove-row";
            removeButton.setAttribute('type', 'button');
            removeButton.setAttribute('onclick', 'deleteList(event)');
            removeButton.innerHTML = '<i class="bi bi-x-circle"></i>';
            cell3.appendChild(removeButton);

            // Append the cells to the row
            newRow.appendChild(cell1);
            newRow.appendChild(cell2);
            newRow.appendChild(cell3);

            // Append the row to the table
            table.appendChild(newRow);
        }

        function deleteList(e) {
            var row = e.target.closest('tr');
            row.remove();
        }
    </script>


    @yield('script')

</body>

</html>
