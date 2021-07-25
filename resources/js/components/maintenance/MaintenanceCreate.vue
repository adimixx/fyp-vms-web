<template>
    <div>
        <div>
            <FormulateForm
                v-model="form"
                @submit="submitForm"
                :errors="inputErrors"
            >
                <FormulateInput
                    :v-if="complaint != null"
                    type="hidden"
                    name="complaint"
                />

                <!-- Dropdown select vehicle -->
                <div class="mb-3">
                    <label class="form-label">Vehicle</label>
                    <Multiselect
                        v-model="form.vehicle"
                        placeholder="Choose Vehicle"
                        noOptionsText="Vehicle does not exists"
                        :filterResults="false"
                        :minChars="0"
                        :delay="0"
                        :resolveOnLoad="true"
                        :searchable="true"
                        :options="
                            this.complaintVehicleInventory == null
                                ? loadVehicle
                                : null
                        "
                        ref="vehicleSelect"
                        :disabled="form.complaintVehicleInventory != null"
                    />
                </div>
                <FormulateInput
                    type="hidden"
                    name="vehicle"
                    validationName="Vehicle"
                    validation="required"
                    help="Please choose vehicle"
                    value="complaintVehicleInventory"
                    v-show="form.vehicle == null"
                />

                <!-- Dropdown select maintenance type -->
                <div class="mb-3">
                    <label class="form-label">Maintenance Type</label>
                    <Multiselect
                        v-model="form.maintenanceType"
                        placeholder="Choose Maintenance Type"
                        noOptionsText="Maintenance Type does not exists"
                        :filterResults="false"
                        :minChars="0"
                        :delay="0"
                        :resolveOnLoad="true"
                        :searchable="true"
                        :options="loadMaintenanceType"
                        ref="maintenanceTypeSelect"
                    />
                    <FormulateInput
                        type="hidden"
                        name="maintenanceType"
                        validationName="Maintenance Type"
                        validation="required"
                        help="Please choose Maintenance Type"
                        v-show="form.maintenanceType == null"
                    />
                </div>

                <!-- Dropdown select maintenance unit -->
                <div class="mb-3">
                    <label class="form-label">Maintenance Unit</label>
                    <Multiselect
                        v-model="form.maintenanceUnit"
                        placeholder="Choose Maintenance Unit"
                        noOptionsText="Maintenance UNit does not exists"
                        :filterResults="false"
                        :minChars="0"
                        :delay="0"
                        :resolveOnLoad="true"
                        :searchable="true"
                        :options="loadMaintenanceUnit"
                        ref="maintenanceUnitSelect"
                    />
                    <FormulateInput
                        type="hidden"
                        name="maintenanceUnit"
                        validationName="Maintenance Unit"
                        validation="required"
                        help="Please choose Maintenance Unit"
                        v-show="form.maintenanceUnit == null"
                    />
                </div>

                <transition
                    enter-active-class="animate__animated animate__fadeIn animate__faster"
                    leave-active-class="animate__animated animate__fadeOut animate__faster"
                >
                    <div v-if="form.vehicle != null">
                        <FormulateInput
                            type="text"
                            label="Maintenance Title"
                            placeholder="Enter Maintenance name"
                            name="title"
                            :value="complaintTitle"
                            validation="required|max:50,length"
                        />

                        <FormulateInput
                            type="textarea"
                            label="Maintenance Description"
                            placeholder="Describe Maintenance details"
                            name="description"
                            :value="complaintDescription"
                            validation="required|max:250,length"
                        />

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
    </div>
</template>

<script>
import VueCompositionAPI from "@vue/composition-api";
Vue.use(VueCompositionAPI);
import Multiselect from "@vueform/multiselect/dist/multiselect.vue2.js";

export default {
    components: {
        Multiselect
    },
    data() {
        return {
            form: {
                vehicle: null
            },
            inputErrors: {}
        };
    },
    props: {
        complaintVehicleInventoryName: String,
        complaintVehicleInventory: Number,
        complaint: Number,
        complaintTitle: String,
        complaintDescription: String,
        submitLink: String,
        prefixRedirectLink: String,
        maintenanceType: Number,
        maintenanceTypeName: String,
        maintenanceUnit: Number,
        maintenanceUnitName: String,
        maintenanceTypeList: String,
        maintenanceUnitList: String,
        maintenanceId: 0,
    },
    mounted() {
        if (this.complaint != null) {
            this.form.complaint = this.complaint;
        }

        if (
            this.complaintVehicleInventory != null &&
            this.complaintVehicleInventoryName != null
        ) {
            this.$refs.vehicleSelect.select({
                label: this.complaintVehicleInventoryName,
                value: this.complaintVehicleInventory
            });
        }

        if (this.maintenanceType != null && this.maintenanceTypeName != null) {
            this.$refs.maintenanceTypeSelect.select({
                label: this.maintenanceTypeName,
                value: this.maintenanceType
            });
        }

        if (this.maintenanceUnit != null && this.maintenanceUnitName != null) {
            this.$refs.maintenanceUnitSelect.select({
                label: this.maintenanceUnitName,
                value: this.maintenanceUnit
            });
        }

        if (this.maintenanceId != 0) {
            this.form.id = this.maintenanceId;
        }
    },
    methods: {
        loadVehicle: async function(query) {
            var link = `/backend/multiselect/vehicle`;
            if (query) {
                link += `?search=${query}`;
            }

            var res = await axios.get(link);
            return res.data;
        },
        async loadMaintenanceType(query) {
            var link = this.maintenanceTypeList;
            if (query) {
                link += `?search=${query}`;
            }

            var res = await axios.get(link);
            return res.data;
        },
        async loadMaintenanceUnit(query) {
            var link = this.maintenanceUnitList;
            if (query) {
                link += `?search=${query}`;
            }

            var res = await axios.get(link);
            return res.data;
        },
        async submitForm(data) {
            axios
                .post(this.submitLink, data)
                .then(res => {
                    if (res.status == 201) {
                        //created
                        window.location.href = `${this.prefixRedirectLink}/${res.data.id}/edit`;
                    } else if (res.status == 200) {
                        //updated
                        console.log("updated");

                        this.$emit(
                            "activate-alert",
                            "Success!",
                            "Maintenance Information have been successfully saved.",
                            "success"
                        );
                    }
                })
                .catch(err => {
                    console.log(err);
                    this.inputErrors = err.response.data.errors;
                    console.log(err.response.data);
                });
        }
    }
};
</script>

<style></style>
