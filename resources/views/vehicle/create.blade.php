@extends('layouts.app')


@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <div>
            <h3 class="text-dark mb-0">New Vehicle</h3>
            <p class="text-muted">Please fill in vehicle information</p>
        </div>
    </div>


    <div class="card shadow">
        <div class="card-body">
            <vehicle-create></vehicle-create>
        </div>
    </div>
</div>


@endsection

