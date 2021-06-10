@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h3 class="text-dark mb-0">Complaint Details</h3>
        <p class="text-capitalize text-secondary">Complaint Management</p>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div>
                    <div class="row mb-4">
                        <div class="col-md-6 col-12">
                            <div class="mb-2">
                                <p class="mb-0 text-disabled">Complaint Title</p>
                                <h4 class="text-uppercase text-primary mb-0 mt-0 fw-bold">{{ $complaint->name }}</h4>
                            </div>

                            <div class="mb-2">
                                <p class="text-dark">On Vehicle : <span
                                        class="fw-bold">{{ sprintf('%s - %s', $complaint->vehicleInventory->reg_no, $complaint->vehicleInventory->vehicleCatalog->name) }}</span>
                                </p>
                            </div>

                            <div class="mb-4">
                                <span
                                    class="badge bg-{{ $complaint->status->color_class }} text-uppercase">{{ $complaint->status->name }}</span>
                            </div>

                            <div class="mb-2">
                                <p class="text-secondary mb-0">Complaint Description : </p><span
                                    class="text-uppercase text-dark fw-bold">{{ $complaint->detail }} KM</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <p class="text-secondary mb-0">Media Attachments : </p>
                            <Lightbox :media="{{ $complaint->media_vue }}"></Lightbox>
                        </div>
                    </div>

                    @if ($complaint->status->name == 'pending' && Auth::user()->hasRole('admin'))
                        <div>
                            <a href="{{ route('complaint.maintenance.create', $complaint->id) }}"
                                class="text-decoration-none">
                                <button class="btn btn-primary">Resolve Issue</button>
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
