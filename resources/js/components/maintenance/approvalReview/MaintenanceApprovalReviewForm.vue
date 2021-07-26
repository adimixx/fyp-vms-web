<template>
    <div>
        <FormulateForm v-model="form" @submit="onSubmit" name="form">
            <FormulateInput type="hidden" name="id" v-model="id"/>

            <FormulateInput
                input-class="form-check pl-0"
                type="radio"
                validation="required"
                name="status"
                label="Approval Status"
                :options="statusOptions"
            />

            <FormulateInput
                type="textarea"
                name="status_note"
                label="Review Note"
                validation="optional|max:250"
            />

            <BsSubmitBtn @on-dismiss="onDismiss"></BsSubmitBtn>
        </FormulateForm>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {}
        };
    },
    props: {
        id: Number,
        statusOptions: Array,
        submitUrl: String,
        backUrl: String,
    },
    mounted() {

    },
    methods: {
        onDismiss() {
            window.location.href = this.backUrl;
        },
        async onSubmit(data) {
            try {
                const res = await axios.post(this.submitUrl, data);
                if (res.data.redirect) {
                    window.location.href = res.data.redirect;
                }

                this.$eventBus.$emit(
                    "on-toast",
                    "Maklumat Berjaya Disimpan!",
                    "Maklumat Insentif berjaya disimpan",
                    "success"
                );
            } catch (error) {
                if (error.response) {
                    this.$formulate.handle(
                        {
                            inputErrors: error.response.data.errors,
                            formErrors: error.response.data.message
                        },
                        "form"
                    );
                }
            }
        }
    }
};
</script>

<style></style>
