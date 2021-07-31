@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-4">
            <div>
                <h3 class="text-dark mb-0">Maintenance Management</h3>
            </div>
            @can('maintenance:crud')
                <div class="d-grid gap-2 d-flex justify-content-end">
                    <a href="{{ route('maintenance.create') }}" class="text-decoration-none">
                        <button class="btn btn-primary text-white"><i class="fas fa-plus"></i> New Maintenance</button>
                    </a>
                </div>
            @endcan
        </div>

        <div>

            <ul class="nav nav-tabs" role="tablist">
                @isset($pendingCount)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending"
                            type="button" role="tab" aria-controls="pending" aria-selected="true">
                            Pending
                            @if ($pendingCount > 0)
                                <span
                                    class="badge bg-{{ $pendingStatus->color_class }} text-dark">{{ $pendingCount }}</span>
                            @endif

                        </button>
                    </li>
                @endisset

                @isset($pendingApprovalCount)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if (empty($pendingCount)) active @endif" id="pending-review-tab" data-bs-toggle="tab" data-bs-target="#pending-review"
                            type="button" role="tab" aria-controls="pending-review" aria-selected="false">Pending
                            Review
                            @if ($pendingApprovalCount > 0)
                                <span
                                    class="badge bg-{{ $pendingApprovalStatus->color_class }}">{{ $pendingApprovalCount }}</span>
                            @endif
                        </button>
                    </li>
                @endisset

                @isset($approvedCount)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button"
                            role="tab" aria-controls="approved" aria-selected="false">Approved
                            @if ($approvedCount > 0)
                                <span class="badge bg-{{ $approvedStatus->color_class }}">{{ $approvedCount }}</span>
                            @endif
                        </button>
                    </li>
                @endisset

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button"
                        role="tab" aria-controls="history" aria-selected="false">History</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                @isset($pendingCount)
                    <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                        <div class="card shadow mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="text-primary fw-bold m-0">Pending Maintenance</h6>
                            </div>
                            <div class="card-body">
                                <maintenance-datatable route="{{ route('maintenance.index') }}"
                                    api-url="{{ route('api.datatable.maintenance.pending') }}"></maintenance-datatable>
                            </div>
                        </div>
                    </div>
                @endisset

                @isset($pendingApprovalCount)
                    <div class="tab-pane fade @if (empty($pendingCount)) show active @endif" id="pending-review" role="tabpanel" aria-labelledby="pending-review-tab">
                        <div class="card shadow mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="text-primary fw-bold m-0">Pending Review Maintenance</h6>
                            </div>
                            <div class="card-body">
                                <maintenance-datatable route="{{ route('maintenance.approval-review') }}"
                                    api-url="{{ route('api.datatable.maintenance.pending-review') }}">
                                </maintenance-datatable>
                            </div>
                        </div>
                    </div>
                @endisset

                @isset($approvedCount)
                    <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                        <div class="card shadow mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="text-primary fw-bold m-0">Approved Maintenance</h6>
                            </div>
                            <div class="card-body">
                                <maintenance-datatable route="{{ route('maintenance.index') }}"
                                    api-url="{{ route('api.datatable.maintenance.approved') }}"></maintenance-datatable>
                            </div>
                        </div>
                    </div>
                @endisset

                <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                    <div class="shadow card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="text-primary fw-bold m-0"> Maintenance History
                            </h6>
                        </div>
                        <div class="card-body">
                            <maintenance-datatable route="{{ route('maintenance.index') }}"
                                api-url="{{ route('api.datatable.maintenance.history') }}"></maintenance-datatable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
