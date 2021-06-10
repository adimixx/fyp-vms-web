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
                                        <h4 class="text-dark mb-4">Register New Account</h4>
                                    </div>

                                    <div class="mb-4">
                                        <user-registration-public verify-user-url="{{ route("api.data.user.verify") }}" submit-url="{{ route("register") }}" email-sent-url="{{ route("verification.notice") }}"></user-registration-public>
                                    </div>

                                    <div class="text-center small">
                                        Alreafy Have Account?
                                        <a href="{{ route('login') }}">Login</a>
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
