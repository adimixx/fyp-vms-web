@extends('layouts.app')

@section('header')
    <div class="d-flex justify-content-between">
        <div>
            <h4 class="mb-0">
                {{ __('Pengurusan Kenderaan') }}
            </h4>
            <p class="text-muted">Tambah Kenderaan Baru</p>
        </div>
    </div>
@endsection

@section('content')
    <vehicle-create></vehicle-create>
@endsection

