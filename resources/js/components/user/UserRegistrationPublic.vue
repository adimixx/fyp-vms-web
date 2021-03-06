<template>
    <div>
        <transition
            enter-active-class="animate__animated animate__fadeIn animate__faster"
            leave-active-class="animate__animated animate__fadeOut animate__faster"
            mode="out-in"
        >
            <div v-if="!showRegisterForm">
                <p class="text-secondary text-start">
                    Please verify your staff identity to register
                </p>

                <FormulateForm
                    v-model="verifyUserData"
                    @submit="submitVerifyUser"
                    name="user_verify"
                    class="user"
                >
                    <FormulateInput
                        :disabled="loading"
                        input-class="form-control form-control-user"
                        type="text"
                        label="Staff No"
                        name="staff_no"
                        validationName="Staff Number"
                        placeholder="eg: 01234"
                        validation="required:trim"
                    />

                    <FormulateInput
                        :disabled="loading"
                        input-class="form-control form-control-user"
                        type="text"
                        label="NRIC"
                        name="nric"
                        placeholder="eg: 910607089238"
                        validation="required:trim|min:12,length,max:12,length|number"
                    />

                    <button
                        class="btn btn-primary d-block btn-user w-100 text-white"
                        :disabled="loading"
                    >
                        <div
                            v-if="loading"
                            class="spinner-border spinner-border-sm"
                            role="status"
                        ></div>
                        <span v-else>Verify</span>
                    </button>
                </FormulateForm>
            </div>

            <FormulateForm
                v-model="registerUser"
                @submit="submitRegisterUser"
                v-if="showRegisterForm"
                name="user_register"
                class="user"
            >
                <FormulateInput type="hidden" name="id" validation="required" />

                <FormulateInput
                    type="text"
                    readonly
                    label="Staff No"
                    name="staff_no"
                    validation="required:trim"
                    input-class="form-control form-control-user"
                />

                <FormulateInput
                    type="text"
                    readonly
                    label="NRIC"
                    name="nric"
                    validation="required:trim"
                    input-class="form-control form-control-user"
                    :disabled="loading"
                />

                <FormulateInput
                    type="email"
                    label="Email Address"
                    name="email"
                    placeholder="eg: john@vms.psm"
                    validation="required|email"
                    help="Enter your Email Address"
                    input-class="form-control form-control-user"
                    :disabled="loading"
                />

                <FormulateInput
                    type="password"
                    label="Password"
                    name="password"
                    validation="required|min:8,length"
                    help="Password must be minimum 8 characters"
                    input-class="form-control form-control-user"
                    :disabled="loading"
                />

                <FormulateInput
                    type="password"
                    label="Confirm Password"
                    name="password_confirm"
                    validation="required|confirm"
                    input-class="form-control form-control-user"
                    :disabled="loading"
                />

                <button
                    class="btn btn-primary d-block btn-user w-100 text-white"
                    :disabled="loading"
                >
                    <div
                        v-if="loading"
                        class="spinner-border spinner-border-sm"
                        role="status"
                    ></div>
                    <span v-else>Register</span>
                </button>
            </FormulateForm>
        </transition>
    </div>
</template>

<script>
export default {
    data() {
        return {
            verifyUserData: null,
            registerUser: null,
            showRegisterForm: false,
            loading: false
        };
    },
    props: {
        verifyUserUrl: String,
        submitUrl: String,
        emailSentUrl: String
    },
    methods: {
        async submitVerifyUser(data) {
            this.loading = true;
            try {
                var res = await axios.post(this.verifyUserUrl, data);
                this.registerUser = res.data;
                this.showRegisterForm = true;
            } catch (error) {
                if (error.response) {
                    this.$formulate.handle(
                        {
                            inputErrors: error.response.data.errors,
                            formErrors: error.response.data.message
                        },
                        "user_verify"
                    );
                }
            } finally {
                this.loading = false;
            }
        },
        async submitRegisterUser(data) {
            this.loading = true;
            try {
                data.password_confirmation = data.password_confirm;
                var res = await axios.post(this.submitUrl, data);
                window.location.href = this.emailSentUrl;
            } catch (error) {
                if (error.response) {
                    this.$formulate.handle(
                        {
                            inputErrors: error.response.data.errors,
                            formErrors: error.response.data.message
                        },
                        "user_register"
                    );
                }
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>

<style></style>
