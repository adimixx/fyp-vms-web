<template>
    <!-- Modal -->
    <div class="modal fade" ref="editModel" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ header }}
                    </h5>
                </div>
                <div class="modal-body">
                    <FormulateForm
                        v-model="form"
                        @submit="submit"
                        name="create_edit"
                    >
                        <FormulateInput type="hidden" name="id" />

                        <FormulateInput
                            type="text"
                            label="Vendor Name"
                            name="name"
                            placeholder="eg: Syarikat ABC Sdn. Bhd."
                            validation="required:trim"
                        />

                        <FormulateInput
                            type="textarea"
                            label="Address"
                            name="address"
                            placeholder="eg: 22, Jalan Bestari 1, Durian Tunggal, Melaka"
                            validation="optional|max:255,length"
                            help="Optional"
                        />

                        <FormulateInput
                            type="email"
                            label="Email Address"
                            name="email"
                            placeholder="eg: john@vms.psm"
                            validation="optional|email"
                            help="Optional"
                        />

                        <FormulateInput
                            type="text"
                            label="Phone Number"
                            name="phone"
                            validation="optional|number|min:9,length"
                            placeholder="0123456789"
                            help="Optional"
                        />

                        <div class="text-center">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                @click="hide"
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
</template>

<script>
import { Modal } from "bootstrap";
export default {
    data() {
        return {
            header: "Register New Vendor",
            modal: null,
            form: {}
        };
    },
    props: {
        formData: Object,
        rolesList: Array,
        postUrl: String
    },
    mounted() {
        if (this.formData != null) {
            this.header = "Edit Vendor";
            this.form = this.formData;
        }

        this.modal = new Modal(this.$refs.editModel, {
            keyboard: false,
            backdrop: "static"
        });
        this.modal.show();
    },
    methods: {
        async hide(update = false) {
            await this.modal.hide();
            this.$emit("on-hide", update);
        },
        async submit(data) {
            try {
                var res = await axios.post(this.postUrl, data);
                this.$emit(
                    "activate-toast",
                    "Success!",
                    "Vendor information have been saved",
                    "success"
                );

                this.hide(true);
            } catch (error) {
                if (error.response) {
                    this.$formulate.handle(
                        {
                            inputErrors: error.response.data.errors,
                            formErrors: error.response.data.message
                        },
                        "create_edit"
                    );
                }
            }
        }
    }
};
</script>

<style></style>
