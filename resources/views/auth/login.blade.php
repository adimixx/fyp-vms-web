@extends('layouts.auth')

@section('header')
<h5 class="text-dark">Login</h5>
@endsection

@section('content')
<div>
    <form class="user" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <input type="email"
                class="form-control form-control-user @error('email') is-invalid @enderror"
                aria-describedby="emailHelp"
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
                placeholder="Password" name="password" required
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
@endsection
