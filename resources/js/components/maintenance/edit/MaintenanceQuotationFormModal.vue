<template>
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
                        {{ title }}
                    </h5>
                </div>
                <div class="modal-body">
                    <FormulateForm v-model="form" @submit="onSubmit">
                        <div class="mb-3">
                            <label class="form-label">Vendor</label>
                            <Multiselect
                                v-model="form.vendor"
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

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <Multiselect
                                v-model="form.status"
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

                        <div class="mb-3" v-show="form.status == 2">
                            <FormulateInput
                                type="group"
                                name="particulars"
                                :repeatable="true"
                                label="Quotation List"
                                validation="requiredIf:status,2"
                            >
                                <template v-slot:addmore="{ addMore }">
                                    <div class="d-flex justify-content-end">
                                        <div class="d-block">
                                            <p>
                                                Total :
                                                <span
                                                    class="fw-bold text-primary"
                                                >
                                                    {{ subtotalQuotation }}
                                                </span>
                                            </p>
                                            <a
                                                class="btn btn-outline-primary"
                                                @click="addMore"
                                            >
                                                <i class="fas fa-plus"></i>
                                                Add Items
                                            </a>
                                        </div>
                                    </div>
                                </template>
                                <template v-slot:remove="{ removeItem }">
                                    <div class="col-1 order-last">
                                        <a
                                            class="btn btn-outline-danger"
                                            @click="removeItem"
                                        >
                                            <i class="fas fa-minus-circle"></i>
                                        </a>
                                    </div>
                                </template>

                                <template #help>
                                    <div class="row bg-primary text-light mb-3">
                                        <div class="col">
                                            <div class="row color-dark">
                                                <div class="col-6">
                                                    <label class="fw-bold"
                                                        >Item</label
                                                    >
                                                </div>
                                                <div class="col-3">
                                                    <label class="fw-bold">
                                                        Qty Price
                                                    </label>
                                                </div>
                                                <div class="col-2">
                                                    <label class="fw-bold">
                                                        Quantity
                                                    </label>
                                                </div>
                                                <div class="col-1">
                                                    <label class="fw-bold">
                                                        Subtotal
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-1"></div>
                                    </div>
                                </template>

                                <template #default="{index}">
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
                                                    min="0.01"
                                                />
                                            </div>
                                            <div class="col-2">
                                                <FormulateInput
                                                    type="number"
                                                    validationName="Quantity"
                                                    validation="required|min:1"
                                                    name="quantity"
                                                    min="1"
                                                />
                                            </div>
                                            <div class="col-1">
                                                <span>
                                                    {{
                                                        calculateSubtotal(
                                                            form.particulars[
                                                                index
                                                            ]
                                                        )
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </FormulateInput>
                        </div>

                        <div class="row">
                            <div class="col d-grid">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    @click="onDismissModal"
                                >
                                    Cancel
                                </button>
                            </div>
                            <div class="col d-grid">
                                <input
                                    type="submit"
                                    class="btn btn-primary text-white"
                                    value="Save"
                                />
                            </div>
                        </div>
                    </FormulateForm>
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
    data() {
        return {
            modal: null,
            title: "",
            form: {
                vendor: "",
                status: "",
                particulars: []
            }
        };
    },
    props: {
        showModal: Boolean,
        data: Object,
        statusQuotationSelectUrl: String,
        vendorSelectUrl: String
    },
    mounted() {
        this.modalQuotationModal = new Modal(
            document.getElementById("modalQuotationModal"),
            {
                keyboard: false,
                backdrop: "static"
            }
        );
        this.modalQuotationModal.show();
    },
    watch: {
        showModal(val) {
            if (val) {
                this.modalQuotationModal.show();
            } else this.modalQuotationModal.hide();
        }
    },
    computed: {
        subtotalQuotation: function() {
            const sum = this.form.particulars
                .map(x => {
                    if (isNaN(x.price)) {
                        return 0;
                    }
                    return (
                        Number(x.price) * (isNaN(x.quantity) ? 1 : x.quantity)
                    ).toFixed(2);
                })
                .reduce((y, z) => Number(y) + Number(z), 0);

            if (isNaN(sum)) {
                return "-";
            }
            return "RM" + Number(sum).toFixed(2);
        }
    },
    methods: {
        onDismissModal() {
            this.modalQuotationModal.hide();
            this.$emit("dismiss-modal");
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
        },
        calculateSubtotal(obj) {
            var price = null;

            if (obj) {
                if (obj.price && Number(obj.price) > 0) {
                    price = Number(obj.price);
                    if (obj.quantity && Number(obj.quantity) > 0) {
                        price *= Number(obj.quantity);
                    }
                    return "RM" + price.toFixed(2);
                }
            }
            return null;
        },
        onSubmit(data) {
            console.log(data);
        }
    }
};
</script>

<style></style>
