@extends('layouts.auth')

@section('content')
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
                                    <div class="text-center">
                                        <p class="text-dark mb-0 fw-bold">VMS UTeM</p>
                                        <h4 class="text-dark mb-4">One Step Closer!</h4>
                                    </div>

                                    @if (session('status') == 'verification-link-sent')
                                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                                            Email has been sent
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    <div class="mb-4 text-center">
                                        <i class="fas fa-envelope fa-6x mb-3 text-primary"></i>
                                        <p>We have sent an email to <span
                                                class="fw-bold text-primary">{{ Auth::user()->email }}</span>. Please
                                            verify your email to continue</p>
                                    </div>



                                    <div class="text-center small">
                                        <form method="POST" action="/email/verification-notification">
                                            @csrf
                                            <p class="text-disabled m-0">Did not receive your email? </p>
                                            <input type="submit"
                                                class="btn btn-link p-0 m-0 align-baseline text-primary small"
                                                value="Click here to re-send the email" />
                                        </form>
                                        <hr>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <input type="submit"
                                                class="btn btn-link p-0 m-0 align-baseline text-muted small"
                                                value="Login Page" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
