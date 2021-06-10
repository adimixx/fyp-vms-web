@extends('layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-4">
            <div>
                <h3 class="text-dark mb-0">Edit Maintenance Record</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-12 @isset($maintenance->complaint) col-md-9 @endisset">
                <div class="card shadow mb-4">
                    <div class="card-header fw-bold text-primary">
                        Maintenance Detail
                    </div>
                    <div class="card-body">
                        <maintenance-create :maintenance-id="{{ $maintenance->id }}"
                            complaint-title="{{ $maintenance->name }}"
                            complaint-description="{{ $maintenance->detail }}"
                            :complaint-vehicle-inventory="{{ $maintenance->vehicleInventory->id }}"
                            complaint-vehicle-inventory-name="{{ $maintenance->vehicleInventory->reg_with_name }}"
                            submit-link="{{ route('api.data.maintenance-request.store') }}"
                            :maintenance-type="{{ $maintenance->maintenanceCategory->id }}"
                            maintenance-type-name="{{ $maintenance->maintenanceCategory->name }}"
                            :maintenance-unit="{{ $maintenance->maintenanceUnit->id }}"
                            maintenance-unit-name="{{ $maintenance->maintenanceUnit->name }}" :is-update="true"
                            @activate-alert="activateAlert"
                            maintenance-type-list="{{ route('api.select.maintenance-type') }}"
                            maintenance-unit-list="{{ route('api.select.maintenance-unit') }}"></maintenance-create>
                    </div>
                </div>
            </div>

            @isset($maintenance->complaint)
                <div class="col-12 col-md-3">
                    <div class="shadow card mb-4">
                        <a class="btn btn-link text-start card-header fw-bold text-decoration-none" data-bs-toggle="collapse"
                            aria-expanded="true" aria-controls="collapse-1" href="#collapse-1" role="button">
                            Responded Complaint Information
                        </a>
                        <div class="collapse show" id="collapse-1">
                            <div class="card-body">
                                <div>
                                    <div class="mb-2">
                                        <p class="mb-0 text-disabled">Complaint Title</p>
                                        <h4 class="text-uppercase text-primary mb-0 mt-0 fw-bold">
                                            {{ $maintenance->complaint->name }}</h4>
                                    </div>

                                    <div class="mb-2">
                                        <p class="text-dark">On Vehicle : <span
                                                class="fw-bold">{{ sprintf('%s - %s', $maintenance->complaint->vehicleInventory->reg_no, $maintenance->complaint->vehicleInventory->vehicleCatalog->name) }}</span>
                                        </p>
                                    </div>
                                    <div class="row mt-3 mb-4">
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <p class="text-secondary mb-0">Complaint Description : </p><span
                                                    class="text-uppercase text-dark fw-bold">{{ $maintenance->complaint->detail }}
                                                    KM</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <p class="text-secondary mb-0">Media Attachments : </p>
                                            <Lightbox :media="{{ $maintenance->complaint->media_vue }}"></Lightbox>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endisset

            <div class="col-12">
                <maintenance-quotation-edit
                    datatable-api-url="{{ route('api.datatable.maintenance.quotation', $maintenance->id) }}"
                    vendor-select-url="{{ route('api.select.vendor') }}"
                    status-quotation-select-url="{{ route('api.select.status', 1) }}"
                    quotation-url="{{ route('api.data.maintenance.quotation.index', $maintenance->id) }}"
                    @activate-alert="activateAlert" @activate-toast="activateToast"></maintenance-quotation-edit>
            </div>
        </div>
    </div>
@endsection
