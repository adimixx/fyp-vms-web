@extends('layouts.auth')

@section('header')
<h5 class="text-dark">Registration</h5>
@endsection

@section('content')
<div>
    <div class="mb-4">
        <user-registration-public verify-user-url="{{ route("api.data.user.verify") }}" submit-url="{{ route("register") }}" email-sent-url="{{ route("verification.notice") }}"></user-registration-public>
    </div>

    <div class="text-center small">
        Alreafy Have Account?
        <a href="{{ route('login') }}">Login</a>
    </div>
</div>
@endsection
