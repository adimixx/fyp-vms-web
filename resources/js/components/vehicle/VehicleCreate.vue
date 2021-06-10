<template>
    <div>
            <div>
                <FormulateForm
                    v-model="form"
                    @submit="submitForm"
                    :errors="inputErrors"
                >
                    <div class="mb-3">
                        <label class="form-label">Vehicle Type</label>
                        <Multiselect
                            v-model="form.vehicleCategory"
                            :options="loadVehicleCategory"
                            @change="vehicleCategoryChanged"
                        />
                        <FormulateInput
                            type="hidden"
                            name="vehicleCategory"
                            validationName="Vehicle Type"
                            validation="required"
                            help="Please choose vehicle type"
                        />
                    </div>

                    <transition
                        enter-active-class="animate__animated animate__fadeIn animate__faster"
                        leave-active-class="animate__animated animate__fadeOut animate__faster"
                    >
                        <!-- Dropdown select catalog -->
                        <div class="mb-3" v-if="form.vehicleCategory != null">
                            <div class="text-between">
                                <label class="form-label"
                                    >Vehicle Model</label
                                >
                                <a
                                    href="#"
                                    class="text-end"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalNewVehicleModel"
                                    >Register new model</a
                                >
                            </div>
                            <Multiselect
                                v-model="form.vehicleModel"
                                placeholder="Pilih Model Kenderaan"
                                noOptionsText="Model is not registered. Please register new model"
                                :filterResults="false"
                                :minChars="0"
                                :delay="0"
                                :resolveOnLoad="true"
                                :searchable="true"
                                :options="loadVehicleModels"
                                ref="vehicleModelSelect"
                            />
                            <FormulateInput
                                type="hidden"
                                name="vehicleModel"
                                validationName="Vehicle Model"
                                validation="required"
                                help="Please choose vehicle model"
                            />
                        </div>
                    </transition>

                    <transition
                        enter-active-class="animate__animated animate__fadeIn animate__faster"
                        leave-active-class="animate__animated animate__fadeOut animate__faster"
                    >
                        <div v-if="form.vehicleModel != null">
                            <FormulateInput
                                type="date"
                                label="Date Received"
                                name="dateReceived"
                                validation="required"
                            />

                            <FormulateInput
                                type="text"
                                label="Vehicle Registration Number"
                                placeholder="contoh: UTEM001"
                                name="regNo"
                                validation="required"
                            />

                            <FormulateInput
                                name="mileage"
                                label="Current Mileage"
                                placeholder="Mileage in KM"
                                type="number"
                                step="0.01"
                                min="0.01"
                                validation="number|min:0.00"
                            />

                            <div class="mb-4">
                                <label class="form-label fw-bold"
                                    >Next Service Information</label
                                >
                                <div class="row">
                                    <div class="col">
                                        <FormulateInput
                                            name="nextServiceMileage"
                                            label="Service Mileage"
                                            type="number"
                                            step="0.01"
                                            placeholder="Mileage in KM"
                                            min="0.01"
                                            :validation="[
                                                ['required'],
                                                ['number'][('min', '0.01')],
                                                ['min', Number(form.mileage) + 0.01]
                                            ]"
                                        />
                                    </div>
                                    <div class="col">
                                        <FormulateInput
                                            name="nextServiceDate"
                                            label="Service Date"
                                            type="date"
                                            :validation="[
                                                ['required'],
                                                ['after', form.dateReceived]
                                            ]"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-3 mt-4 mb-3">
                                <input
                                    type="submit"
                                    value="Save"
                                    class="btn btn-primary text-white"
                                    id="btn-submit"
                                />
                            </div>
                        </div>
                    </transition>
                </FormulateForm>
            </div>

        <!-- Modal -->
        <div
            class="modal fade"
            id="modalNewVehicleModel"
            data-bs-backdrop="static"
            data-bs-keyboard="false"
            tabindex="-1"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Register New Vehicle Model
                        </h5>
                    </div>
                    <div class="modal-body">
                        <FormulateForm
                            v-model="vehicleModelNew"
                            @submit="submitNewVehicleModel"
                        >
                            <FormulateInput
                                type="text"
                                label="Brand"
                                placeholder="example: PROTON"
                                name="brand"
                                validation="required"
                            />

                            <FormulateInput
                                type="text"
                                label="Model"
                                placeholder="example: PREVE"
                                name="model"
                                validation="required"
                            />

                            <FormulateInput
                                type="text"
                                name="variant"
                                label="Variant"
                                placeholder="example: 1.5"
                            />

                            <FormulateInput
                                type="number"
                                min="1000"
                                name="year"
                                label="Production Year"
                                placeholder="example: 2020"
                                validation="number|min:1000"
                            />

                            <div class="text-center">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal"
                                >
                                    Cancel
                                </button>
                                <input
                                    type="submit"
                                    class="btn btn-primary text-white"
                                    value="Save"
                                />
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
    data() {
        return {
            form: {
                vehicleCategory: null,
                vehicleModel: null,
                dateReceived: null,
                regNo: null,
                mileage: 0,
                nextServiceMileage: null,
                nextServiceDate: null
            },
            vehicleModelNew: {
                value: null,
                brand: "",
                model: "",
                variant: "",
                year: ""
            },
            inputErrors: {}
        };
    },
    props: {
        vehicleCategoryList: String,
        vehicleModelList: String,

    },
    methods: {
        loadVehicleCategory: async function() {
            var res = await axios.get(this.vehicleCategoryList);
            return res.data;
        },
        loadVehicleModels: async function(query) {
            if (this.form.vehicleCategory) {
                var link = `${this.vehicleModelList}/${this.form.vehicleCategory}`;
                if (query) {
                    link += `?search=${query}`;
                }

                var res = await axios.get(link);
                return res.data;
            }
            return null;
        },
        vehicleCategoryChanged(value) {
            this.form.vehicleCategory = value;

            if (this.$refs.vehicleModelSelect != undefined) {
                this.$refs.vehicleModelSelect.clear();
                this.$refs.vehicleModelSelect.refreshOptions();
            }
        },
        async submitNewVehicleModel(data) {
            var link = `/backend/vehicle_category/${this.form.vehicleCategory}/catalog`;
            var res = await axios.post(link, data);

            if (res) {
                this.$refs.vehicleModelSelect.clear();
                this.$refs.vehicleModelSelect.refreshOptions();
                this.$refs.vehicleModelSelect.select({
                    label: res.data.name,
                    value: res.data.id
                });
                var modalNewVehicleModelEl = document.getElementById(
                    "modalNewVehicleModel"
                );
                var modal = Modal.getInstance(modalNewVehicleModelEl);
                modal.hide();
            }
        },
        async submitForm(data) {
            var link = `/backend/vehicle_category/${this.form.vehicleCategory}/catalog/${this.form.vehicleModel}/inventory`;

            axios
                .post(link, data)
                .then(res => {
                    if (res.status == 201) {
                        window.location.href = '/vehicle?success=create';
                    }
                })
                .catch(err => {
                    this.inputErrors = err.response.data.errors;
                    console.log(err.response.data);
                });
        }
    }
};
</script>

<style></style>
