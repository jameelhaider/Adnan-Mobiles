<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('admin_title')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('uploads/c2.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />


    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('newdash/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('newdash/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('newdash/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />

    {{-- //js pdf + js img --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>


    <link rel="stylesheet" href="{{ asset('newdash/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('newdash/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('newdash/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('newdash/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('newdash/assets/js/config.js') }}"></script>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    {{-- mask the field --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>





    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        .menu-item.active.badge {
            border: 2px solid rgb(255, 255, 255);
        }
    </style>

</head>

<body>


    <style>
        .loader-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #75060d;
            ;
            border-radius: 50%;
            width: 170px;
            height: 170px;
            animation: spin 1s linear infinite;
        }

        .loader-wrapper img {
            position: absolute;
            z-index: 1;
            height: 140px;
            width: auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Hide loader after animation ends */
        .loader-wrapper.hidden {
            display: none;
        }
    </style>

    <div class="loader-wrapper" id="loader">
        <img src="{{ asset('uploads/c2.png') }}" alt="Loader Image">
        <div class="loader"></div>
    </div>


    <script>
        // Wait for the window to load fully
        window.addEventListener("load", () => {
            setTimeout(() => {
                const loader = document.getElementById("loader");
                if (loader) {
                    loader.classList.add("hidden");
                }
            }, 600); // Display loader for at least 2 seconds
        });
    </script>





    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ url('/admin') }}" target="_BLANK" class="app-brand-link">

                        <img src="{{ asset('uploads/c2.png') }}" height="35px" width="35px" alt="">
                        <span class="fw-bolder ms-2 small text-dark">Adnan Mobiles</span>
                    </a>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item {{ Request::is('admin') ? 'active' : '' }}">
                        <a href="{{ url('/admin') }}"
                            class="menu-link {{ !Request::is('admin') ? 'text-dark' : '' }}">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>



                    <!-- Stocks -->
                    <li
                        class="menu-header small text-uppercase fw-bold {{ Request::is('admin/stocks*') ? '' : 'text-dark' }}">
                        <span class="menu-header-text">Stocks</span>
                    </li>
                    <li
                        class="menu-item {{ Request::is('admin/stocks') || Request::is('admin/stocks/create') ? 'active' : '' }}">
                        <a href="{{ url('admin/stocks') }}"
                            class="menu-link {{ Request::is('admin/stocks*') ? '' : 'text-dark' }} d-flex align-items-center">
                            <i class="menu-icon tf-icons bx bx-box"></i>
                            <div data-i18n="Tables">Stocks</div>
                        </a>
                    </li>


                    <!-- Stocks -->
                    <li
                        class="menu-header small text-uppercase fw-bold {{ Request::is('admin/invoices*') ? '' : 'text-dark' }}">
                        <span class="menu-header-text">Invoices</span>
                    </li>



                    @if (Auth::user()->email !== 'husnainbutt047@gmail.com')
                        <li class="menu-item {{ Request::is('admin/invoices/make') ? 'active' : '' }}">
                            <a href="{{ url('admin/invoices/make') }}"
                                class="menu-link {{ Request::is('admin/invoices/make*') ? '' : 'text-dark' }} d-flex align-items-center">
                                <i class="menu-icon tf-icons bx bx-edit"></i>
                                <div data-i18n="Tables">Make Invoice</div>
                            </a>
                        </li>
                    @endif


                    <li class="menu-item {{ Request::is('admin/invoices/list') ? 'active' : '' }}">
                        <a href="{{ url('admin/invoices/list') }}"
                            class="menu-link {{ Request::is('admin/invoices/list*') ? '' : 'text-dark' }} d-flex align-items-center">
                            <i class="menu-icon tf-icons bx bx-receipt"></i>
                            <div data-i18n="Tables">List Invoices</div>
                        </a>
                    </li>




                      <!-- Stocks -->
                    <li
                        class="menu-header small text-uppercase fw-bold {{ Request::is('admin/sale-history') ? '' : 'text-dark' }}">
                        <span class="menu-header-text">History</span>
                    </li>
                        <li class="menu-item {{ Request::is('admin/sale-history') ? 'active' : '' }}">
                            <a href="{{ url('admin/sale-history') }}"
                                class="menu-link {{ Request::is('admin/sale-history*') ? '' : 'text-dark' }} d-flex align-items-center">
                                <i class="menu-icon tf-icons bx bx-history"></i>
                                <div data-i18n="Tables">Sale History</div>
                            </a>
                        </li>


                    <li class="menu-item {{ Request::is('admin/return-history') ? 'active' : '' }}">
                        <a href="{{ url('admin/return-history') }}"
                            class="menu-link {{ Request::is('admin/return-history*') ? '' : 'text-dark' }} d-flex align-items-center">
                            <i class="menu-icon tf-icons bx bx-undo"></i>
                            <div data-i18n="Tables">Return History</div>
                        </a>
                    </li>










                    <li class="menu-header small text-uppercase text-dark fw-bold"><span
                            class="menu-header-text">Actions</span></li>
                    <div class="px-3">
                        <a href="{{ route('export.database') }}" class="btn btn-primary w-100">
                            Export Back Up
                        </a>
                        <a href="{{ route('send.database.backup') }}" class="btn btn-primary w-100 mt-2">
                            Send Backup To Mail
                        </a>


                        <a href="{{ url('/logout') }}" class="btn btn-primary w-100 mt-2 mb-4">Log Out</a>
                    </div>


                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                {{-- <i class="bx bx-mobile fs-4 lh-0"></i> --}}
                                {{-- <input type="text" class="form-control border-0 shadow-none"
                                    placeholder="Search..." aria-label="Search..." /> --}}


                                <h3 class="fw-normal text-dark mt-3 animated-underline animate-on-load">
                                    ADNAN MOBILES | INVENTORY MANAGEMENT SYSTEM
                                </h3>

                                <style>
                                    /* Load Animation */
                                    .animate-on-load {
                                        opacity: 0;
                                        transform: translateY(20px);
                                        animation: slideUpFade 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;

                                    }

                                    @keyframes slideUpFade {
                                        to {
                                            opacity: 1;
                                            transform: translateY(0);
                                        }
                                    }

                                    /* Hover Underline Animation */
                                    .animated-underline {
                                        position: relative;
                                        display: inline-block;
                                        font-family: Georgia, 'Times New Roman', Times, serif;
                                        word-spacing: 6px;
                                        letter-spacing: 1px;
                                        cursor: pointer;
                                    }

                                    .animated-underline::after {
                                        content: "";
                                        position: absolute;
                                        left: 0;
                                        bottom: -6px;
                                        width: 100%;
                                        height: 3px;
                                        background-color: #75070e;
                                        transform: scaleX(0);
                                        transform-origin: left;
                                        transition: transform 0.8s ease-in-out;
                                    }

                                    .animated-underline:hover::after {
                                        transform: scaleX(1);
                                    }
                                </style>


                            </div>
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('uploads/c2.png') }}" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ asset('uploads/c2.png') }}" alt
                                                            class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span
                                                        class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                                                    <small class="text-muted">Admin</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ url('admin/change-password') }}">
                                            <i class="bx bx-key me-2"></i>
                                            <span class="align-middle">Change Password</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/logout') }}">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="py-2 px-0">
                        @include('alert')
                        @yield('content2')
                    </div>

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div
                            class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                © Adnan Mobiles
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                , Developed By
                                <a href="https://wa.link/ehud9w" target="_blank"
                                    class="footer-link fw-bolder text-dark">JH
                                    Developers</a>
                            </div>
                            <div>


                                <div class="d-none d-lg-block">
                                    <a href="{{ url('/admin') }}" class="footer-link me-4">Dashboard</a>

                                    <a href="{{ url('admin/invoice/make') }}" class="footer-link me-4">Make
                                        Sale Invoice</a>
                                    <a href="{{ url('admin/invoices') }}" class="footer-link me-4">List Sale
                                        Invoices</a>

                                    <a href="{{ url('admin/change-password') }}" class="footer-link me-4">Change
                                        Password</a>
                                </div>

                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('newdash/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('newdash/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('newdash/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('newdash/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('newdash/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('newdash/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('newdash/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('newdash/assets/js/dashboards-analytics.js') }}"></script>


    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>
