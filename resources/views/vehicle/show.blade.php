@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h3 class="text-dark mb-0">Vehicle Information</h3>
        <p class="text-capitalize text-secondary">Vehicle Management</p>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <img class="img-fluid" style="max-height: 300px;"
                            src="https://s1.cdn.autoevolution.com/images/gallery/PROTON-Perdana-5957_22.jpeg" />

                        <div class="text-center">
                            {!! QrCode::size(100)->generate(Request::url()) !!}
                        </div>
                    </div>
                    <div class="col">
                        <div></div>
                        <div class="my-4">
                            <p class="mb-0">{{ $vehicle->vehicleCatalog->vehicleCategory->name }}</p>
                            <h1 class="text-uppercase text-primary mb-0 mt-0 fw-bold">{{ $vehicle->reg_no }}</h1>
                            <p class="text-dark">{{ $vehicle->vehicleCatalog->name }}</p>

                            <span
                                class="badge bg-{{ $vehicle->status->color_class }} text-uppercase">{{ $vehicle->status->name }}</span>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <p class="text-secondary mb-0">Current Mileage : </p><span
                                    class="text-uppercase text-dark fw-bold">{{ $vehicle->mileage }} KM</span>
                            </div>
                            <div class="col-6">
                                <p class="text-secondary mb-0">Last Service Date : </p><span
                                    class="text-uppercase text-dark fw-bold">{{ $vehicle->last_service_date ?? '-' }}</span>
                            </div>
                            <div class="col-6">
                                <p class="text-secondary mb-0">Next Service Mileage: </p><span
                                    class="text-uppercase text-dark fw-bold">{{ $vehicle->next_service_mileage }}
                                    KM</span>
                            </div>
                            <div class="col-6">
                                <p class="text-secondary mb-0">Next Service Date : </p><span
                                    class="text-uppercase text-dark fw-bold">{{ $vehicle->next_service_date }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="text-primary m-0 fw-bold">Maintenance History</h6>
            </div>
            <div class="card-body"></div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="text-primary m-0 fw-bold">Complaints</h6>
            </div>
            <div class="card-body"></div>
        </div>
    </div>

@endsection
