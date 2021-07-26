import VueFormulate from "@braid/vue-formulate";
Vue.use(VueFormulate, {
    useInputDecorators: false,
    classes: {
        outer: "mb-3",
        label: "form-label fw-bold",
        element: "mw-100",
        input: "form-control",
        inputHasErrors: "is-invalid",
        errors: "text-danger list-unstyled mt-2",
        help: "form-text",
        groupRepeatable: "row",
        formErrors: "alert alert-danger list-unstyled",
        decorator: "form-check-input"
    },
    locales: {
        en: {
            // required({ name }) {
            //     return `Sila isi ${name}`;
            // },
            // min({ name, args }) {
            //     return `Nilai ${name} mestilah sekurang-kurangnya ${args} `;
            // },
            // after({ name, args }) {
            //     return `${name} mestilah selepas ${args} `;
            // },
            requiredIf: ({ name }) => `${name} is required`
        }
    },
    validationNameStrategy: ["validationName", "label", "name", "type"],
    rules: {
        requiredIf: function(context, formKey, formValue) {
            var a = (context.getFormValues()[formKey] == formValue);
            var b = ((formValue == "undefined" || formValue == "null") && typeof context.getFormValues()[formKey] === "undefined");

            if (a || b) {
                if (context.value.length == 0) {
                    return false;
                }
            }

            return true;
        }
    }
});
