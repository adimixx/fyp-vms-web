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
                                        <h4 class="text-dark mb-4">VMS UTeM</h4>
                                    </div>
                                    <form class="user" method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="mb-3">
                                            <input type="email"
                                                class="form-control form-control-user @error('email') is-invalid @enderror"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." name="email"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus />

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                        <div class="mb-3">
                                            <input type="password"
                                                class="form-control form-control-user  @error('password') is-invalid @enderror"
                                                id="exampleInputPassword" placeholder="Password" name="password" required
                                                autocomplete="current-password" />
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox small">
                                                <div class="form-check"><input type="checkbox"
                                                        class="form-check-input custom-control-input "
                                                        id="formCheck-1" /><label
                                                        class="form-check-label custom-control-label" for="formCheck-1"
                                                        {{ old('remember') ? 'checked' : '' }}>Remember Me</label></div>
                                            </div>
                                        </div><button class="btn btn-primary d-block btn-user w-100 text-white"
                                            type="submit">Login</button>
                                        <hr />
                                    </form>
                                    <div class="text-center"><a class="small"
                                        href="{{ route('register') }}">Register new Account</a></div>
                                    <div class="text-center"><a class="small"
                                            href="{{ route('password.request') }}">Forgot
                                            Password?</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
