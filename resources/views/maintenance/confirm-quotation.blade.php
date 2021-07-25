@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div>
                <h3 class="text-dark mb-0">Confirm Quotation</h3>
                <p class="text-capitalize text-secondary">Maintenance Management</p>
            </div>
            <div>
                <a href="{{ route('maintenance.show', $maintenance->id) }}" class="text-decoration-none">
                    <button class="btn btn-primary"><i class="fas fa-info-circle"></i> Back to Maintenance Details</button>
                </a>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div>
                    <div class="mb-2">
                        <p class="mb-0 text-disabled">Maintenance Name: </p>
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

                    @isset($maintenance->code)
                        <div class="mb-2">
                            <p class="text-dark mb-0">Unit Code :
                            </p>
                            <span class="text-uppercase fw-bold">{{ $maintenance->code }}</span>
                        </div>
                    @endisset
                </div>
                <hr>
                <maintenance-confirm-quotation-form @isset($approvedQuote) :approved-quote="{{ $approvedQuote }}" @endisset
                    quotation-select-url="{{ route('api.select.maintenance.confirm-quotation', $maintenance->id) }}"
                    submit-url="{{ route('api.data.maintenance.quotation.confirm', $maintenance->id) }}"
                    back-url="{{ route('maintenance.show', $maintenance->id) }}">
                </maintenance-confirm-quotation-form>
            </div>
        </div>

        @isset($quote)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="text-primary m-0 fw-bold my-auto">Quotation Provided</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="accordion">
                        @foreach ($quote as $qt)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-{{ $loop->iteration }}"
                                        aria-expanded="true" class="accordion-button" type="button">
                                        <div class="mr-auto">
                                            <span class="text-right mb-2">Quotation {{ $loop->iteration }}</span>
                                            <h5 class="text-uppercase text-primary mb-0 fw-bold">
                                                {{ $qt->maintenanceVendor->name }}
                                            </h5>
                                            <span
                                                class="badge bg-{{ $qt->status->color_class }} text-uppercase">{{ $qt->status->name }}</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-{{ $loop->iteration }}" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <div class="d-flex d-flex-row mb-2">
                                            <div class="mr-auto">
                                                <p class="fw-bold">Quote Details</p>
                                            </div>
                                            <div class="text-right mr-3">
                                                <span class="text-black">Request Date</span>
                                                <p class="fw-bold">
                                                    {{ $qt->date_request }}
                                                </p>
                                            </div>
                                            <div class="text-right mr-3">
                                                <span class="text-black">Quote Date</span>
                                                <p class="fw-bold">
                                                    {{ $qt->date_invoice ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-black">Total Cost</span>
                                                <p class="fw-bold">
                                                    RM {{ number_format($qt->cost_total / 100, 2) ?? '-' }}
                                                </p>
                                            </div>
                                        </div>

                                        @if ($qt->status->name == 'quoted')
                                            <v-client-table :data="{{ $qt->maintenanceQuotationItem }}"
                                                :columns="['item','quantity','price','subtotal']"
                                                :options="{filterable: false}">
                                                <template v-slot:price="props">
                                                    <span>@{{ (props . row . price) | currencyWithRM }}</span>
                                                </template>

                                                <template v-slot:subtotal="props">
                                                    <span>@{{ (props . row . subtotal) | currencyWithRM }}</span>
                                                </template>
                                            </v-client-table>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endisset





    </div>

@endsection
