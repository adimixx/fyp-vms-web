@extends('layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-4">
            <div>
                <h3 class="text-dark mb-0">New Maintenance Records</h3>
                <p class="text-muted">Please fill in vehicle information</p>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-header fw-bold text-primary">
                        Maintenance Form
                    </div>
                    <div class="card-body">
                        <maintenance-create @isset($complaint) :complaint="{{ $complaint->id }}"
                                complaint-title="{{ $complaint->name }}" complaint-description="{{ $complaint->detail }}"
                                :complaint-vehicle-inventory="{{ $complaint->vehicleInventory->id }}"
                            complaint-vehicle-inventory-name="{{ $complaint->vehicleInventory->reg_with_name }}" @endisset
                            submit-link="{{ route('api.data.maintenance-request.store') }}"
                            prefix-redirect-link="{{ route('maintenance.index') }}"
                            maintenance-type-list="{{ route('api.select.maintenance-type') }}"
                            maintenance-unit-list="{{ route('api.select.maintenance-unit') }}"></maintenance-create>
                    </div>
                </div>
            </div>

            @isset($complaint)
                <div class="col-12 col-md-3">
                    <div class="shadow card mb-4">
                        <a class="btn btn-link text-start card-header fw-bold text-decoration-none" data-bs-toggle="collapse"
                            aria-expanded="true" aria-controls="collapse-1" href="#collapse-1" role="button">
                            Selected Complaint Information
                        </a>
                        <div class="collapse show" id="collapse-1">
                            <div class="card-body">
                                <div>
                                    <div class="mb-2">
                                        <p class="mb-0 text-disabled">Complaint Title</p>
                                        <h4 class="text-uppercase text-primary mb-0 mt-0 fw-bold">{{ $complaint->name }}</h4>
                                    </div>

                                    <div class="mb-2">
                                        <p class="text-dark">On Vehicle : <span
                                                class="fw-bold">{{ sprintf('%s - %s', $complaint->vehicleInventory->reg_no, $complaint->vehicleInventory->vehicleCatalog->name) }}</span>
                                        </p>
                                    </div>
                                    <div class="row mt-3 mb-4">
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <p class="text-secondary mb-0">Complaint Description : </p><span
                                                    class="text-uppercase text-dark fw-bold">{{ $complaint->detail }}
                                                    KM</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <p class="text-secondary mb-0">Media Attachments : </p>
                                            <Lightbox :media="{{ $complaint->media_vue }}"></Lightbox>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endisset
        </div>





    </div>


@endsection
