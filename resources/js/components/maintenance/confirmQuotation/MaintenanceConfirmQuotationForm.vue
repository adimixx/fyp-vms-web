<template>
    <div>
        <div>
            <p class="mb-0">
                Please select the desired quotation to be confirmed
            </p>
            <p class="text-secondary fst-italic">
                <span class="fw-bold">Note:</span> Only quoatations with
                "quoted" status will be listed
            </p>
        </div>

        <FormulateForm v-model="form" @submit="onSubmit" name="form">
            <bs-select-server
                class="flex-fill mr-2"
                :url="quotationSelectUrl"
                form-label="Quotation"
                form-help="Please select the desired quotation"
                form-validation="required"
                form-validation-name="Quotation"
                form-name="quotation"
            ></bs-select-server>

            <BsSubmitBtn @on-dismiss="onDismiss"></BsSubmitBtn>
        </FormulateForm>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {},
            statusSelect: []
        };
    },
    props: {
        quotationSelectUrl: String,
        submitUrl: String,
        data: Object
    },
    mounted() {},
    methods: {
        onDismiss() {},
        async onSubmit(data) {
            try {
                const res = await axios.post(this.submitUrl, data);
                if (res.data.redirect){
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
