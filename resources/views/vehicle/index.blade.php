@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <div>
            <h3 class="text-dark mb-0">Registered Vehicle List</h3>
        </div>

        <div class="d-grid gap-2 d-flex justify-content-end">
            <a href="{{ route('vehicle.create') }}" class="text-decoration-none">
                <button class="btn btn-primary text-white"><i class="fas fa-plus"></i> New Vehicle</button>
            </a>
        </div>
    </div>


    <div class="card shadow">
        <div class="card-body">
            <vehicle-datatable route="{{ route('vehicle.index') }}"></vehicle-datatable>
        </div>
    </div>
</div>
@endsection
