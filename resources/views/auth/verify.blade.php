@extends('layouts.auth')

@section('header')
    <h5 class="text-dark">Email Verification</h5>
@endsection

@section('content')
    <div>
        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                Email has been sent
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="mb-4 text-center">
            <i class="fas fa-envelope fa-6x mb-3 text-primary"></i>
            <p>We have sent an email to <span class="fw-bold text-primary">{{ Auth::user()->email }}</span>. Please
                verify your email to continue</p>
        </div>



        <div class="text-center small">
            <form method="POST" action="/email/verification-notification">
                @csrf
                <p class="text-disabled m-0">Did not receive your email? </p>
                <input type="submit" class="btn btn-link p-0 m-0 align-baseline text-primary small"
                    value="Click here to re-send the email" />
            </form>
            <hr>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <input type="submit" class="btn btn-link p-0 m-0 align-baseline text-muted small" value="Login Page" />
            </form>
        </div>
    </div>
@endsection
