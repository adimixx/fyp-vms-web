<template>
    <div>
        <FormulateForm v-model="form" @submit="onSubmit" name="form">
            <FormulateInput type="hidden" name="id" v-model="id" />

            <FormulateInput
                type="textarea"
                name="finalize_note"
                label="Notes"
                validation="optional|max:250"
            />

            <div class="mb-3">
                <label for="file" class="form-label fw-bold">Attachment</label>
                <BsFilePond max-file-size="3MB"></BsFilePond>
            </div>

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
        submitUrl: String,
        backUrl: String
    },
    mounted() {},
    methods: {
        onDismiss() {
            window.location.href = this.backUrl;
        },
        async onSubmit(data) {
            try {
                const res = await axios.post(this.submitUrl, data, {});
                console.log(res);

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
