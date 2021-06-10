<template>
    <!-- Modal -->
    <div
        class="modal fade"
        ref="userEditModel"
        tabindex="-1"
        aria-hidden="true"
    >
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
                        name="user_create_edit"
                    >
                        <FormulateInput type="hidden" name="id" />

                        <FormulateInput
                            type="text"
                            label="Staff No"
                            name="staff_no"
                            placeholder="eg: 01234"
                            validation="required:trim"
                        />

                        <FormulateInput
                            type="text"
                            label="NRIC"
                            name="nric"
                            placeholder="eg: 910607089238"
                            validation="required:trim|min:12,length,max:12,length|number"
                        />

                        <FormulateInput
                            input-class="input"
                            type="checkbox"
                            label="User Roles"
                            name="roles"
                            :options="rolesList"
                            validation="required"
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
                            label="Name"
                            name="name"
                            validation="optional:trim"
                            placeholder="eg: John Doe"
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
            header: "Register New User",
            modal: null,
            form: {}
        };
    },
    props: {
        userData: Object,
        rolesList: Array,
        postUrl: String
    },
    mounted() {
        if (this.userData != null) {
            this.header = "Edit User";
            this.form = this.userData;
        }

        this.modal = new Modal(this.$refs.userEditModel, {
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
                if (data.id) {
                    this.$emit(
                        "activate-toast",
                        "Success!",
                        "User information have been saved",
                        "success"
                    );
                } else {
                    this.$emit(
                        "activate-toast",
                        "User Created",
                        "User can register their account with Staff No and NRIC provided",
                        "info"
                    );
                }

                this.hide(true);
            } catch (error) {
                if (error.response) {
                    this.$formulate.handle(
                        {
                            inputErrors: error.response.data.errors,
                            formErrors: error.response.data.message
                        },
                        "user_create_edit"
                    );
                }
            }
        }
    }
};
</script>

<style></style>
