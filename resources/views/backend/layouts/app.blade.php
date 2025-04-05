<!DOCTYPE html>
<html lang="en" class="{{ config('app.dark_mode') == 1 ? 'dark' : '' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('backend/assets/img/favicon.png') }}">

    <!-- Fonts and Icons -->
    <link href="{{ asset('backend/assets') }}/css/style.css" rel="stylesheet">
    <link href="{{ asset('backend/assets') }}/css/nucleo-icons.css" rel="stylesheet">
    <link href="{{ asset('backend/assets') }}/css/nucleo-svg.css" rel="stylesheet">

    <script src="{{ asset('backend/assets') }}/js/42d5adcbca.js"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Your custom styles -->
    <link href="{{ asset('backend/assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend/plugins/dropfy/dist/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/dark-mode.css') }}">

    {{-- Select2 --}}
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('backend/plugins/select2/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    {{-- Image link Preview --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

    <!-- Main CSS -->
    <link id="pagestyle" href="{{ asset('backend/assets') }}/css/soft-ui-dashboard.min.css" rel="stylesheet">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        #icon-sidebar {
            max-width: 30px;
            object-fit: cover;
        }

        .sub-sidebar {
            padding-left: 2.5rem;
        }

        /* From Uiverse.io by juanpabl0svn */
        /* The switch - the box around the slider */
        .switch {
            font-size: 17px;
            position: relative;
            display: inline-block;
            width: 3.5em;
            height: 2em;
            cursor: pointer;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            --background: #20262c;
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--background);
            transition: 0.5s;
            border-radius: 30px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 1.4em;
            width: 1.4em;
            border-radius: 50%;
            left: 10%;
            bottom: 15%;
            box-shadow: inset 8px -4px 0px 0px #ececd9, -4px 1px 4px 0px #dadada;
            background: var(--background);
            transition: 0.5s;
        }

        .decoration {
            position: absolute;
            content: "";
            height: 2px;
            width: 2px;
            border-radius: 50%;
            right: 20%;
            top: 15%;
            background: #e5f041e6;
            backdrop-filter: blur(10px);
            transition: all 0.5s;
            box-shadow: -7px 10px 0 #e5f041e6, 8px 15px 0 #e5f041e6, -17px 1px 0 #e5f041e6,
                -20px 10px 0 #e5f041e6, -7px 23px 0 #e5f041e6, -15px 25px 0 #e5f041e6;
        }

        input:checked~.decoration {
            transform: translateX(-20px);
            width: 10px;
            height: 10px;
            background: white;
            box-shadow: -12px 0 0 white, -6px 0 0 1.6px white, 5px 15px 0 1px white,
                1px 17px 0 white, 10px 17px 0 white;
        }

        input:checked+.slider {
            background-color: #5494de;
        }

        input:checked+.slider:before {
            transform: translateX(100%);
            box-shadow: inset 15px -4px 0px 15px #efdf2b, 0 0 10px 0px #efdf2b;
        }

        .select2-container .select2-selection--single {
            height: 39px;
            line-height: 38px;
            padding: 0 12px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 34px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 34px;
        }
    </style>
</head>

<body class="g-sidenav-show {{ config('app.dark_mode') == 1 ? 'dark-mode' : '' }}">
    <!-- Sidebar -->
    @include('backend.partials.sidebar')

    <!-- Main content -->
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 border-radius-xl position-sticky blur shadow-blur mt-4 left-auto top-1 z-index-sticky"
            id="navbarBlur" navbar-scroll="true" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <h6 class="font-weight-bolder mb-0">
                        {{-- @if (Route::is('dashboard')) --}}
                            {{ __('Welcome,') . ' ' . auth()->user()->name }}
                        {{-- @endif --}}
                    </h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group">
                            <label for="switch" class="switch" id="theme-toggle-responsive">
                                <input id="switch" type="checkbox" />
                                <span class="slider"></span>
                                <span class="decoration"></span>
                            </label>
                        </div>
                    </div>
                    <ul class="navbar-nav justify-content-end">
                        <li class="nav-item dropdown d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body font-weight-bold px-0" id="profileDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('uploads/images/defualt.png') }}" alt="profile"
                                    class="avatar avatar-sm rounded-circle me-2">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="">My Profile</a></li>
                                <li><a class="dropdown-item" href="">Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->

        <!-- Content -->
        <div class="container-fluid py-4">
            @yield('content')

            <!-- Footer -->
            <div class=" position-sticky" hidden>
                @include('backend.partials.footer')
            </div>
        </div>
    </main>

    <!-- Core JS Files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"></script>
    <script src="{{ asset('backend/assets/js/theme-toggle.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="{{ asset('backend/assets') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('backend/assets') }}/js/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('backend/assets') }}/js/smooth-scrollbar.min.js"></script>
    <script src="{{ asset('backend/assets') }}/js/fullcalendar.min.js"></script>
    <script src="{{ asset('backend/assets') }}/js/choices.min.js"></script>
    <script src="{{ asset('backend/assets') }}/js/datatables.js"></script>

    <!-- Kanban scripts -->
    <script src="{{ asset('backend/assets') }}/js/dragula.min.js"></script>
    <script src="{{ asset('backend/assets') }}/js/jkanban.js"></script>
    <script src="{{ asset('backend/assets') }}/js/chartjs.min.js"></script>
    <script src="{{ asset('backend/assets') }}/js/threejs.js"></script>
    <script src="{{ asset('backend/assets') }}/js/orbit-controls.js"></script>
    <script src="{{ asset('backend/assets') }}/js/leaflet.js"></script>
    <script src="{{ asset('backend/assets') }}/js/nouislider.min.js"></script>
    <script src="{{ asset('backend/assets') }}/js/sweetalert.min.js"></script>
    <script src="{{ asset('backend/assets') }}/js/sweet-alert.js"></script>
    <script src="{{ asset('backend/plugins/dropfy/dist/js/dropify.min.js') }}"></script>
    {{-- Select2 --}}
    <script src="{{ asset('backend/plugins/select2/select2/js/select2.full.min.js') }}"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- Image link preview --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <script src="{{ asset('backend/assets') }}/js/soft-ui-dashboard.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".flatpickr-date", {
                dateFormat: "Y-m-d",
                allowInput: true,
                altInput: true,
                altFormat: "F j, Y",
                maxDate: new Date(),
            });
        });
    </script>

    <!-- Setup CSRF token for AJAX requests -->

    @stack('scripts')
    <script>
        $(document).ready(function() {
            $('.dropify').dropify({});
        });
        $(document).ready(function() {
            $('.select2').select2({});
        });
        $(document).ready(function() {
            $(document).on('shown.bs.modal', '.modal', function() {
                $(this).find('.select2').select2({
                    dropdownParent: $(this)
                });
            });
        });

        @if (Session::has('msg'))
            @if (Session::get('success') == true || Session::get('success') == 1)
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.success("{{ Session::get('msg') }}");
                // success.play();
            @else
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.error("{{ Session::get('msg') }}");
                // error.play();
            @endif
        @endif

        // Handle validation errors with toastr
        @if ($errors->any())
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("{{ $errors->first() }}");
        @endif

        // Global function to show toast notifications with toastr
        function showToast(message, type = 'success') {
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }

            switch (type) {
                case 'success':
                    toastr.success(message);
                    break;
                case 'error':
                    toastr.error(message);
                    break;
                case 'warning':
                    toastr.warning(message);
                    break;
                case 'info':
                    toastr.info(message);
                    break;
                default:
                    toastr.success(message);
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true
            });
        });
    </script>
</body>

</html>
