<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>VMS UTeM</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ url('images/utem_logo.png') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body id="page-top">
    <div id="app">
        <div id="wrapper">
            <nav class="
                navbar navbar-dark
                align-items-start
                sidebar sidebar-dark
                accordion
                bg-gradient-primary
                p-0
              " style="background: rgb(18, 40, 115)">
                <div class="container-fluid d-flex flex-column p-0">
                    <a class="
                    navbar-brand
                    d-flex
                    justify-content-center
                    align-items-center
                    sidebar-brand
                    m-0
                  " href="{{ url('/') }}">
                        <div class="sidebar-brand-icon">
                        </div>
                        <div class="sidebar-brand-text mx-3">
                            <span>{{ config('app.name', 'Laravel') }}</span>
                        </div>
                    </a>
                    <hr class="sidebar-divider my-0" />
                    <ul class="navbar-nav text-light" id="accordionSidebar">
                        @hasanyrole('admin|management')

                        <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/') }}"><i
                                    class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
                        </li>
                        @endhasanyrole

                        @hasrole('admin')
                        <li class="nav-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('user.index') }}"><i
                                    class="fas fa-user"></i><span>User</span></a>
                        </li>
                        @endhasrole

                        @hasanyrole('admin|staff|management')
                        <li class="nav-item {{ request()->routeIs('complaint.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('complaint.index') }}"><i
                                    class="fas fa-comments"></i><span>Complaints</span></a>
                        </li>
                        @endhasanyrole

                        @hasanyrole('admin|management|committee')
                        <li class="nav-item {{ request()->routeIs('maintenance.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('maintenance.index') }}"><i
                                    class="fas fa-wrench"></i><span>Maintenance</span></a>
                        </li>
                        @endhasanyrole

                        @hasanyrole('admin|management')
                        <li class="nav-item {{ request()->routeIs('vehicle.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('vehicle.index') }}"><i
                                    class="fas fa-car-side"></i><span>Vehicle</span></a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('vendor.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('vendor.index') }}"><i
                                    class="fas fa-cogs"></i><span>Vendor</span></a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('report.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('report.index') }}"><i
                                    class="fas fa-chart-pie"></i><span>Report</span></a>
                        </li>
                        @endhasanyrole



                    </ul>
                    <div class="text-center d-none d-md-inline">
                        <button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button>
                    </div>
                </div>
            </nav>

            <div class="d-flex flex-column" id="content-wrapper">
                <div id="content">
                    <nav class="
                    navbar navbar-light navbar-expand
                    bg-white
                    shadow
                    mb-4
                    topbar
                    static-top
                  ">
                        <div class="container-fluid">
                            <ul class="navbar-nav align-self-center flex-nowrap me-auto">
                                <li class="nav-item no-arrow mr-auto mt-3">
                                    {{-- <ol class="breadcrumb bg-transparent">
                                <li class="breadcrumb-item"><a href="#"><span>Home</span></a></li>
                                <li class="breadcrumb-item"><a href="#"><span>Library</span></a></li>
                                <li class="breadcrumb-item"><a href="#"><span>Data</span></a></li>
                            </ol> --}}
                                    {{-- {{ Breadcrumbs::render(Request::route()->getName()) }} --}}

                                </li>
                            </ul>
                            <ul class="navbar-nav flex-nowrap ms-auto">
                                <li class="nav-item dropdown no-arrow">
                                    <div class="nav-item dropdown no-arrow">
                                        <a class="dropdown-toggle nav-link" aria-expanded="false"
                                            data-bs-toggle="dropdown" href="#"><span
                                                class="d-none d-lg-inline me-2 text-gray-600 small">{{ Auth::user()->name }}</span></a>
                                        <div class="
                              dropdown-menu
                              shadow
                              dropdown-menu-end
                              animated--grow-in
                            ">
                                            <a class="dropdown-item" href="#"><i
                                                    class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a><a
                                                class="dropdown-item" href="#"><i
                                                    class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Settings</a><a
                                                class="dropdown-item" href="#"><i
                                                    class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Activity
                                                log</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                                                   document.getElementById('logout-form').submit();"><i class="
                                  fas
                                  fa-sign-out-alt fa-sm fa-fw
                                  me-2
                                  text-gray-400
                                "></i>&nbsp;Logout</a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>

                    <main>
                        <div class="container-fluid mb-3">
                            @if (session('date') != null)
                                <bs-alert bold-msg="{{ session('boldMsg') }}" msg="{{ session('msg') }}"
                                    class-color="{{ session('classColor') }}" :date="{{ session('date') }}"
                                    :init-visible="true"></bs-alert>
                            @endisset
                            <bs-alert :bold-msg="alert.boldMsg" :msg="alert.msg" :class-color="alert.classColor"
                                :date="alert.date"></bs-alert>
                            <bs-toast :bold-msg="toast.boldMsg" :msg="toast.msg" :class-color="toast.classColor"
                                v-if="toast.show" @dismiss-toast="dismissToast"></bs-toast>
                    </div>

                    @yield('content')
                </main>
            </div>

            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright">
                        <span>Copyright ?? Adi Iman 2021</span>
                    </div>
                </div>
            </footer>
        </div>

        <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
</div>
</body>

</html>
