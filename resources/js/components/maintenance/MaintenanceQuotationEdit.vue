<template>
    <div>
        <div class="card shadow mb-4">
            <div
                class="card-header fw-bold text-primary d-flex justify-content-between"
            >
                <span>Quotation</span>
                <button class="btn btn-secondary" @click="onNewQuotation">
                    <i class="fas fa-money-check-alt"></i> New Quotation
                </button>
            </div>
            <div class="card-body">
                <maintenance-quotation-datatable
                    :api-url="datatableApiUrl"
                ></maintenance-quotation-datatable>
            </div>
        </div>

        <!-- Modal -->
        <div
            class="modal fade"
            id="modalQuotationModal"
            tabindex="-1"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ quotationModalContent.title }}
                        </h5>
                    </div>
                    <div class="modal-body">
                        <FormulateForm
                            v-model="quotationForm"
                            @submit="onSubmitQuotation"
                        >
                            <div class="mb-3">
                                <label class="form-label">Vendor</label>
                                <Multiselect
                                    v-model="quotationForm.vendor"
                                    :options="loadVendorList"
                                    ref="quotationSelect"
                                    noOptionsText="Vendor is not registered. Please register vendor"
                                    :filterResults="false"
                                    :minChars="0"
                                    :delay="0"
                                    :resolveOnLoad="true"
                                    :searchable="true"
                                />
                                <FormulateInput
                                    type="hidden"
                                    name="vendor"
                                    validationName="Vendor"
                                    validation="required"
                                    help="Please choose vendor"
                                />
                            </div>

                            <FormulateInput
                                type="number"
                                name="cost_total"
                                validationName="Cost Total"
                                validation="required|min:0.01"
                                help="Please Enter Cost Total (in RM)"
                                placeholder="eg: RM1234.56"
                                label="Cost Total"
                            />

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <Multiselect
                                    v-model="quotationForm.status"
                                    :options="loadStatusQuotationList"
                                    ref="quotationStatusSelect"
                                />
                                <FormulateInput
                                    type="hidden"
                                    name="status"
                                    validationName="Status"
                                    validation="required"
                                    help="Please choose status"
                                />
                            </div>

                            <div>
                                <FormulateInput
                                    type="group"
                                    name="particulars"
                                    :repeatable="true"
                                    label="Quotation List"
                                    add-label="+ Add particular"
                                    validation="required"
                                >
                                    <template v-slot:addmore="{ addMore }">
                                        <div class="d-flex justify-content-end">
                                            <a
                                                class="btn btn-outline-primary"
                                                @click="addMore"
                                            >
                                                <i class="fas fa-plus"></i> Add
                                                Items
                                            </a>
                                        </div>
                                    </template>
                                    <template v-slot:remove="{ removeItem }">
                                        <div class="col-1 order-last">
                                            <a
                                                class="btn btn-outline-danger"
                                                @click="removeItem"
                                            >
                                                <i
                                                    class="fas fa-minus-circle"
                                                ></i>
                                            </a>
                                        </div>
                                    </template>

                                    <template #help>
                                        <div class="row">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="fw-bold"
                                                            >Detail</label
                                                        >
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="fw-bold">
                                                            Price Per Quantity
                                                            (RM)
                                                        </label>
                                                    </div>
                                                    <div class="col-1">
                                                        <label class="fw-bold">
                                                            Quantity
                                                        </label>
                                                    </div>
                                                    <div class="col-2">
                                                        <label class="fw-bold">
                                                            Total (RM)
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-1"></div>
                                        </div>
                                    </template>

                                    <div class="col">
                                        <div class="row">
                                            <div class="col-6">
                                                <FormulateInput
                                                    type="text"
                                                    validationName="Detail"
                                                    validation="required"
                                                    name="particulars"
                                                />
                                            </div>
                                            <div class="col-3">
                                                <FormulateInput
                                                    type="number"
                                                    name="price"
                                                    validationName="Price"
                                                    step="0.01"
                                                    validation="required|min:0.01"
                                                />
                                            </div>
                                            <div class="col-1">
                                                <FormulateInput
                                                    type="number"
                                                    validationName="Quantity"
                                                    validation="required|min:1"
                                                    name="quantity"
                                                />
                                            </div>
                                            <div class="col-2">
                                                <FormulateInput
                                                    type="disabled"
                                                    name="total"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </FormulateInput>
                            </div>

                            <div
                                class="d-grid gap-2 col-12 col-md-8 offset-md-2"
                            >
                                <input
                                    type="submit"
                                    class="btn btn-primary text-white"
                                    value="Save"
                                />
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    @click="onDismissModal"
                                >
                                    Cancel
                                </button>
                            </div>
                        </FormulateForm>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueCompositionAPI from "@vue/composition-api";
Vue.use(VueCompositionAPI);
import Multiselect from "@vueform/multiselect/dist/multiselect.vue2.js";
import { Modal } from "bootstrap";

export default {
    components: {
        Multiselect
    },
    props: {
        datatableApiUrl: String,
        vendorSelectUrl: String,
        statusQuotationSelectUrl: String
    },
    data() {
        return {
            modalQuotationModal: null,
            quotationModalContent: {
                title: null
            },
            quotationForm: {}
        };
    },
    mounted() {
        this.modalQuotationModal = new Modal(
            document.getElementById("modalQuotationModal"),
            {
                keyboard: false,
                backdrop: "static"
            }
        );
    },
    methods: {
        onNewQuotation() {
            this.modalQuotationModal.show();
            this.quotationModalContent.title = "New Quotation";
        },
        onSubmitQuotation() {},
        onDismissModal() {
            this.modalQuotationModal.hide();
        },
        async loadVendorList(query) {
            var link = this.vendorSelectUrl;
            if (query) {
                link += `?search=${query}`;
            }

            var res = await axios.get(link);
            return res.data;
        },
        async loadStatusQuotationList() {
            var link = this.statusQuotationSelectUrl;
            var res = await axios.get(link);
            return res.data;
        }
    }
};
</script>

<style></style>
