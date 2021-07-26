@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <div>
            <h3 class="text-dark mb-0">Maintenance Management</h3>
        </div>

        <div class="d-grid gap-2 d-flex justify-content-end">
            <a href="{{ route('maintenance.create') }}" class="text-decoration-none">
                <button class="btn btn-primary text-white"><i class="fas fa-plus"></i> New Maintenance</button>
            </a>
        </div>
    </div>

    <div class="card shadow mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="text-primary fw-bold m-0">Pending Review Maintenance</h6>
        </div>
        <div class="card-body">
            <maintenance-datatable route="{{ route('maintenance.approval-review') }}" api-url="{{ route('api.datatable.maintenance.pending-review') }}"></maintenance-datatable>
        </div>
    </div>

    <div class="card shadow mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="text-primary fw-bold m-0">Pending Maintenance</h6>
        </div>
        <div class="card-body">
            <maintenance-datatable route="{{ route('maintenance.index') }}" api-url="{{ route('api.datatable.maintenance.pending') }}"></maintenance-datatable>
        </div>
    </div>

    <div class="shadow card">
        <a class="btn btn-link text-start card-header fw-bold text-decoration-none" data-bs-toggle="collapse" aria-expanded="true" aria-controls="collapse-1" href="#collapse-1" role="button">
            Maintenance History
        </a>
        <div class="collapse show" id="collapse-1">
            <div class="card-body">
                <maintenance-datatable route="{{ route('maintenance.index') }}" api-url="{{ route('api.datatable.maintenance.history') }}"></maintenance-datatable>
            </div>
        </div>
    </div>
</div>

@endsection
