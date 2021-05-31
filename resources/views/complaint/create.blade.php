@extends('layouts.app')


@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <div>
            <h3 class="text-dark mb-0">New Complaint</h3>
            <p class="text-muted">Please fill in vehicle complaint</p>
        </div>
    </div>


    <div class="card shadow">
        <div class="card-body">
            <complaint-create submit-link="{{ route('api.data.complaint.store') }}"></complaint-create>
        </div>
    </div>
</div>


@endsection

