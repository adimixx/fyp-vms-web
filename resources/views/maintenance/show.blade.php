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
                        <p class="text-dark">On Vehicle : <span
                                class="fw-bold">{{ sprintf('%s - %s', $maintenance->vehicleInventory->reg_no, $maintenance->vehicleInventory->vehicleCatalog->name) }}</span>
                        </p>
                    </div>

                    <div class="mb-4">
                        <span
                            class="badge bg-{{ $maintenance->status->color_class }} text-uppercase">{{ $maintenance->status->name }}</span>
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

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="text-primary m-0 fw-bold">Maintenance Details</h6>
            </div>
            <div class="card-body"></div>
        </div>
    </div>

@endsection
