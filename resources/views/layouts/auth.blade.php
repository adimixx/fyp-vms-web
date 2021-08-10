<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div id="app">
        <main>
            <div class="py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-9 col-lg-12 col-xl-10">
                            <div class="card shadow-lg o-hidden border-0 my-5">
                                <div class="card-body p-0">
                                    <div class="row">
                                        <div class="col-lg-6 d-none d-lg-flex">
                                            <div class="flex-grow-1 bg-login-image"></div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="p-5">
                                                <div class="mb-5 mt-4">
                                                    <div class="d-flex">
                                                        <span class="auth-icon mr-2">
                                                        </span>
                                                        <div>
                                                            <h4 class="text-dark mb-0 fw-bold">VMS UTeM</h4>
                                                            <span class="text-secondary fs-6">Vehicle Management System</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="text-start mb-4">
                                                    @yield('header')
                                                </div>

                                                <div class="my-2">
                                                    @yield('content')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>

</html>
