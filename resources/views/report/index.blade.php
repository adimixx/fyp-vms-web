@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0">Report</h3>
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
            <div class="col-lg-7 col-xl-8">
                <div class="card shadow mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="text-primary fw-bold m-0">
                            Vehicle Spending
                        </h6>
                    </div>
                    <div class="card-body">
                        <report-spending-vehicle-datatable api-url="{{ route('api.datatable.report.spending-vehicle') }}"
                            route="{{ route('vehicle.index') }}">
                        </report-spending-vehicle-datatable>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
