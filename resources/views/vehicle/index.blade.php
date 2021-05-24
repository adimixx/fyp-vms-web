@extends('layouts.app')

@section('header')
    <div class="d-flex justify-content-between">
        <div>
            <h4 class="mb-0">
                {{ __('Pengurusan Kenderaan') }}
            </h4>
            <p class="text-muted">Senarai Kenderaan Berdaftar</p>
        </div>

        <div class="d-grid gap-2 d-flex justify-content-end mb-4">
            <a href="{{ route('vehicle.create') }}" class="text-decoration-none">
                <button class="btn btn-primary text-white">Tambah Kenderaan Baru</button>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">

            </div>
        </div>
    </div>
@endsection
