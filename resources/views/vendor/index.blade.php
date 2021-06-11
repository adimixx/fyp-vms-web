@extends('layouts.app')

@section('content')
    <vendor-index dt-url="{{ route('api.datatable.maintenance-vendor') }}"
        post-url="{{ route('api.data.maintenance-vendor.store') }}" @activate-toast="activateToast"></vendor-index>
@endsection
