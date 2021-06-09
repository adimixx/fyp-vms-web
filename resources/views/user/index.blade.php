@extends('layouts.app')

@section('content')
    <user-index dt-url="{{ route('api.datatable.user') }}" :roles-list="{{ $rolesList }}"
        user-post-url="{{ route('api.data.user.store') }}" @activate-toast="activateToast"></user-index>
@endsection
