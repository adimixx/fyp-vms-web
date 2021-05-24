<template>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <legend>Maklumat Kenderaan</legend>

                <FormulateForm
                    v-model="form"
                    @submit="submitForm"
                    :errors="inputErrors"
                >
                    <div class="mb-3">
                        <label class="form-label">Jenis Kenderaan</label>
                        <Multiselect
                            v-model="form.vehicleCategory"
                            :options="loadVehicleCategory"
                            @change="vehicleCategoryChanged"
                        />
                        <FormulateInput
                            type="hidden"
                            name="vehicleCategory"
                            validationName="Jenis Kenderaan"
                            validation="required"
                            help="Sila pilih jenis kenderaan"
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
                                    >Model Kenderaan</label
                                >
                                <a
                                    href="#"
                                    class="text-end"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalNewVehicleModel"
                                    >Daftar Model Kenderaan Baru</a
                                >
                            </div>
                            <Multiselect
                                v-model="form.vehicleModel"
                                placeholder="Pilih Model Kenderaan"
                                noOptionsText="Model Kenderaan tidak didaftarkan. Sila Daftar Model Kenderaan"
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
                                validationName="Model Kenderaan"
                                validation="required"
                                help="Sila pilih model kenderaan"
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
                                label="Tarikh Terima"
                                name="dateReceived"
                                validation="required"
                            />

                            <FormulateInput
                                type="text"
                                label="No Pendaftaran Kenderaan"
                                placeholder="contoh: UTEM001"
                                name="regNo"
                                validation="required"
                            />

                            <FormulateInput
                                name="mileage"
                                label="Mileage Terkini"
                                placeholder="Mileage dalam unit Kilometer (KM)"
                                type="number"
                                step="0.01"
                                min="0.01"
                                validation="number|min:0.00"
                            />

                            <div class="mb-4">
                                <label class="form-label fw-bold"
                                    >Maklumat Servis Seterusnya</label
                                >
                                <div class="row">
                                    <div class="col">
                                        <FormulateInput
                                            name="nextServiceMileage"
                                            label="Mileage Servis"
                                            type="number"
                                            step="0.01"
                                            placeholder="Mileage dalam unit Kilometer (KM)"
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
                                            label="Tarikh Servis"
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
                                    value="Simpan Maklumat Kenderaan"
                                    class="btn btn-primary text-white"
                                    id="btn-submit"
                                />
                            </div>
                        </div>
                    </transition>
                </FormulateForm>
            </div>
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
                            Tambah Model Kenderaan Baru
                        </h5>
                    </div>
                    <div class="modal-body">
                        <FormulateForm
                            v-model="vehicleModelNew"
                            @submit="submitNewVehicleModel"
                        >
                            <FormulateInput
                                type="text"
                                label="Jenama Kenderaan"
                                placeholder="contoh: PROTON"
                                name="brand"
                                validation="required"
                            />

                            <FormulateInput
                                type="text"
                                label="Model Kenderaan"
                                placeholder="contoh: PREVE"
                                name="model"
                                validation="required"
                            />

                            <FormulateInput
                                type="text"
                                name="variant"
                                label="Varian Kenderaan"
                                placeholder="contoh: 1.5"
                            />

                            <FormulateInput
                                type="number"
                                min="1000"
                                name="year"
                                label="Tahun Keluaran Kenderaan"
                                placeholder="contoh: 2020"
                                validation="number|min:1000"
                            />

                            <div class="text-center">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal"
                                >
                                    Batal
                                </button>
                                <input
                                    type="submit"
                                    class="btn btn-primary text-white"
                                    value="Simpan"
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
    mounted() {
        this.loadVehicleCategory();
    },
    methods: {
        loadVehicleCategory: async function() {
            var res = await axios.get("/api/vehicle_category");
            return res.data.map(item => {
                const cont = {};
                cont.value = item.id;
                cont.label = item.name;
                return cont;
            });
        },
        loadVehicleModels: async function(query) {
            if (this.form.vehicleCategory) {
                var link = `/api/vehicle_category/${this.form.vehicleCategory}/catalog`;
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
            var link = `/api/vehicle_category/${this.form.vehicleCategory}/catalog`;
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
            var link = `/api/vehicle_category/${this.form.vehicleCategory}/catalog/${this.form.vehicleModel}/inventory`;

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
