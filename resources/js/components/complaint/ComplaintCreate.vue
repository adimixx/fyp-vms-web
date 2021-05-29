<template>
    <div>
        <div>
            <FormulateForm
                v-model="form"
                @submit="submitForm"
                :errors="inputErrors"
            >
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
                        :options="loadVehicle"
                        ref="vehicleModelSelect"
                    />
                    <FormulateInput
                        type="hidden"
                        name="vehicle"
                        validationName="Vehicle"
                        validation="required"
                        help="Please choose vehicle"
                    />
                </div>

                <transition
                    enter-active-class="animate__animated animate__fadeIn animate__faster"
                    leave-active-class="animate__animated animate__fadeOut animate__faster"
                >
                    <div v-if="form.vehicle != null">
                        <FormulateInput
                            type="text"
                            label="Title"
                            placeholder="Enter complaint name"
                            name="title"
                            validation="required"
                        />

                        <FormulateInput
                            type="textarea"
                            label="Description"
                            placeholder="Describe complain details"
                            name="description"
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
                vehicle: null,
            },
            inputErrors: {}
        };
    },
    methods: {
        loadVehicle: async function(query) {
            var link = `/api/multiselect/vehicle`;
            if (query) {
                link += `?search=${query}`;
            }

            var res = await axios.get(link);
            return res.data;
        },
        async submitForm(data) {
            var link = `/api/complaint`;

            axios
                .post(link, data)
                .then(res => {
                    if (res.status == 201) {
                        window.location.href = "/complaint?success=create";
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
