@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div>
                <h3 class="text-dark mb-0">Maintenance Details</h3>
                <p class="text-capitalize text-secondary">Maintenance Management</p>
            </div>
            @if ($maintenance->status->name == 'pending')
                <div>
                    <a href="{{ route('maintenance.edit', $maintenance->id) }}" class="text-decoration-none">
                        <button class="btn btn-primary"><i class="fas fa-edit"></i> Edit</button>
                    </a>
                </div>
            @endif
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div>
                    <div class="mb-2">
                        <p class="mb-0 text-disabled">Maintenance Title</p>
                        <h4 class="text-uppercase text-primary mb-0 mt-0 fw-bold">{{ $maintenance->name }}</h4>
                    </div>

                    <div class="mb-2">
                        <p class="text-dark mb-0">On Vehicle :
                        </p>
                        <span
                            class="fw-bold">{{ sprintf('%s - %s', $maintenance->vehicleInventory->reg_no, $maintenance->vehicleInventory->vehicleCatalog->name) }}</span>
                    </div>

                    <div class="mb-2">
                        <p class="text-dark mb-0">Maintenance Category :
                        </p>
                        <span class="fw-bold">{{ $maintenance->maintenanceCategory->name }}</span>
                    </div>

                    <div class="mb-2">
                        <p class="text-dark mb-0">Maintenance Unit :
                        </p>
                        <span
                            class="fw-bold">{{ sprintf('%s (%s)', $maintenance->maintenanceUnit->name, $maintenance->maintenanceUnit->code) }}</span>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex d-flex-row ">
                            <div class="mr-4">
                                <p class="text-dark mb-0">Status :
                                </p>
                                <span
                                    class="badge bg-{{ $maintenance->status->color_class }} text-uppercase">{{ $maintenance->status->name }}</span>
                            </div>

                            @isset($maintenance->code)
                                <div class="mr-4">
                                    <p class="text-dark mb-0">Unit Code :
                                    </p>
                                    <span class="text-uppercase fw-bold">{{ $maintenance->code }}</span>
                                </div>
                            @endisset

                        </div>

                    </div>



                    <div class="row mt-3 mb-4">
                        <div class="col-12">
                            <div class="mb-2">
                                <p class="text-secondary mb-0">Maintenance Description : </p><span
                                    class="text-uppercase text-dark fw-bold">{{ $maintenance->detail }} KM</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <p class="text-secondary mb-0">Media Attachments : </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @isset($maintenanceQuotationSelected)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="text-primary m-0 fw-bold">Selected Quotation</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <p class="mb-0 text-disabled">Vendor Name</p>
                        <h5 class="text-uppercase text-primary mb-0 mt-0 fw-bold">
                            {{ $maintenanceQuotationSelected->maintenanceVendor->name }}
                        </h5>
                    </div>

                    <div class="mb-2">
                        <p class="mb-0 text-disabled">Total Cost <span class="fw-bold">
                                RM {{ number_format($maintenanceQuotationSelected->cost_total / 100, 2) }}
                            </span></p>
                    </div>


                </div>
            </div>
        @endisset

    </div>

@endsection
