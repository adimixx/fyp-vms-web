@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <div>
            <h3 class="text-dark mb-0">Complaint Management</h3>
        </div>

        <div class="d-grid gap-2 d-flex justify-content-end">
            <a href="{{ route('complaint.create') }}" class="text-decoration-none">
                <button class="btn btn-primary text-white"><i class="fas fa-plus"></i> New Complaint</button>
            </a>
        </div>
    </div>


    <div class="card shadow mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="text-primary fw-bold m-0">Pending Complaint</h6>
        </div>
        <div class="card-body">
            <complaint-pending-datatable route="{{ route('complaint.index') }}"></complaint-pending-datatable>
        </div>
    </div>

    <div class="shadow card"><a class="btn btn-link text-start card-header fw-bold text-decoration-none" data-bs-toggle="collapse" aria-expanded="true" aria-controls="collapse-1" href="#collapse-1" role="button">Complaint History</a>
        <div class="collapse" id="collapse-1">
            <div class="card-body">
                <vehicle-datatable route="{{ route('complaint.index') }}"></vehicle-datatable>
            </div>
        </div>
    </div>
</div>

@endsection
