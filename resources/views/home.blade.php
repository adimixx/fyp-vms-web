@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0">Dashboard</h3>
        </div>
        <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-primary py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                                    <span>Vehicles Registered</span>
                                </div>
                                <div class="text-dark fw-bold h5 mb-0">
                                    <span>{{ $vehiclesRegistered }}</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-car-side fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-success py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-success fw-bold text-xs mb-1">
                                    <span>unsettled Complaints</span>
                                </div>
                                <div class="text-dark fw-bold h5 mb-0">
                                    <span>{{ $complaintsPending }}</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-info py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-info fw-bold text-xs mb-1">
                                    <span>settled maintenance</span>
                                </div>
                                <div class="row g-0 align-items-center">
                                    <div class="col-auto">
                                        <div class="text-dark fw-bold h5 mb-0 me-3">
                                            <span>{{ $settledMaintenance }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-warning py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-danger fw-bold text-xs mb-1">
                                    <span>Pending maintenance</span>
                                </div>
                                <div class="text-dark fw-bold h5 mb-0">
                                    <span>{{ $pendingMaintenance }}</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-wrench fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 col-xl-8">
                <div class="card shadow mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary fw-bold m-0">
                            Maintenance Spending Overview
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area position-relative">
                            <home-spending-maintenance-category-chart></home-spending-maintenance-category-chart>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-xl-4">
                <div class="card shadow mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary fw-bold m-0">Spending by Vehicle Type</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area position-relative">
                            <home-registered-vehicle-type-chart></home-registered-vehicle-type-chart>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
