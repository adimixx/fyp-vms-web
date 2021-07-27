@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div>
                <h3 class="text-dark mb-0">Finalize Maintenance</h3>
                <p class="text-secondary">Please review the maintenance details</p>
            </div>
            <div>

            </div>
        </div>

        <div class="row">
            <div class="col">
                <div>
                    <h6 class="text-primary mb-3 fw-bold">Maintenance Request Details</h6>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div>
                                <div class="mb-2">
                                    <p class="mb-0 text-disabled">Maintenance Title</p>
                                    <h4 class="text-uppercase text-primary mb-0 mt-0 fw-bold">{{ $maintenance->name }}
                                    </h4>
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
                                                class="text-dark fw-bold">{{ $maintenance->detail }}</span>
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
                            <h6 class="text-primary m-0 fw-bold">Selected Quotation</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <h5 class="text-uppercase text-primary mb-0 fw-bold">
                                    {{ $quoteSelected->maintenanceVendor->name }}
                                </h5>
                                <span
                                    class="badge bg-{{ $quoteSelected->status->color_class }} text-uppercase">{{ $quoteSelected->status->name }}</span>
                            </div>

                            <div>
                                <div class="d-flex d-flex-row mb-2">
                                    <div class="mr-auto">
                                        <p class="fw-bold">Quote Details</p>
                                    </div>
                                    <div class="text-right mr-3">
                                        <span class="text-black">Request Date</span>
                                        <p class="fw-bold">
                                            {{ $quoteSelected->date_request }}
                                        </p>
                                    </div>
                                    <div class="text-right mr-3">
                                        <span class="text-black">Quote Date</span>
                                        <p class="fw-bold">
                                            {{ $quoteSelected->date_invoice ?? '-' }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-black">Total Cost</span>
                                        <p class="fw-bold">
                                            RM {{ number_format($quoteSelected->cost_total / 100, 2) ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                <v-client-table :data="{{ $quoteSelected->maintenanceQuotationItem }}"
                                    :columns="['item','quantity','price','subtotal']" :options="{filterable: false}">
                                    <template v-slot:price="props">
                                        <span>@{{ (props . row . price) | currencyWithRM }}</span>
                                    </template>

                                    <template v-slot:subtotal="props">
                                        <span>@{{ (props . row . subtotal) | currencyWithRM }}</span>
                                    </template>
                                </v-client-table>
                            </div>


                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="text-primary m-0 fw-bold my-auto">Rejected Quotations</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="accordion">
                                @foreach ($quote as $qt)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-{{ $loop->iteration }}"
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
                                        <div id="panelsStayOpen-{{ $loop->iteration }}"
                                            class="accordion-collapse collapse show">
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
                </div>
            </div>

            <div class="col-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="text-primary m-0 fw-bold">Maintenance Finalization Submission</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <p class="text-secondary"><span class="fw-bold">Alert :</span> Finalizing maintenance will set status to <span
                                class="badge bg-{{ $completedStatus->color_class }} text-white text-uppercase">{{ $completedStatus->name }}</span>. Please ensure all information are
                                reviewed before submission</p>
                        </div>

                        <maintenance-finalize-form :id="{{ $maintenance->id }}" submit-url="{{ route('api.data.maintenance-request.finalize') }}"></maintenance-finalize-form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
