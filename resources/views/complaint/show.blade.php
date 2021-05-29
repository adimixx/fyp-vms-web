@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="text-dark mb-0">Complaint Details</h3>
    <p class="text-capitalize text-secondary">Complaint Management</p>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div>
                <div class="mb-2">
                    <p class="mb-0 text-disabled">Complaint Title</p>
                    <h4 class="text-uppercase text-primary mb-0 mt-0 fw-bold">{{ $complaint->name }}</h4>
                </div>

                <div class="mb-2">
                    <p class="text-dark">On Vehicle : <span class="fw-bold">{{ sprintf("%s - %s",$complaint->vehicleInventory->reg_no, $complaint->vehicleInventory->vehicleCatalog->name) }}</span> </p>
                </div>

                <div class="mb-4">
                   @if ($complaint->status == 1)
                   <span class="badge bg-warning text-dark">PENDING</span>
                   @endif
                   @if ($complaint->status == 0)
                   <span class="badge bg-danger">DISMISSED</span>
                   @endif
                   @if ($complaint->status == 2)
                   <span class="badge bg-info">PENDING MAINTENANCE</span>
                   @endif
                   @if ($complaint->status == 3)
                   <span class="badge bg-success">RESOLVED</span>
                   @endif
                </div>

                <div class="row mt-3 mb-4">
                    <div class="col-12">
                        <div class="mb-2">
                            <p class="text-secondary mb-0">Complaint Description : </p><span class="text-uppercase text-dark fw-bold">{{ $complaint->detail }} KM</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="text-secondary mb-0">Media Attachments : </p>
                    </div>
                </div>

                <div>
                    <a href="{{ route('complaint.maintenance.create', $complaint->id) }}" class="text-decoration-none">
                        <button class="btn btn-primary">Resolve Issue</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="text-primary m-0 fw-bold">Maintenance Details</h6>
        </div>
        <div class="card-body"></div>
    </div>
</div>

@endsection
