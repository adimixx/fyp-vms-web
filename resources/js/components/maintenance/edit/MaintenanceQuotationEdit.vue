<template>
    <div>
        <div class="card shadow mb-4">
            <div
                class="card-header fw-bold text-primary d-flex justify-content-between"
            >
                <span>Quotation</span>
                <button class="btn btn-secondary" @click="onNewQuotation">
                    <i class="fas fa-money-check-alt"></i> New Quotation
                </button>
            </div>
            <div class="card-body">
                <maintenance-quotation-datatable
                    :api-url="datatableApiUrl"
                    :date="date"
                ></maintenance-quotation-datatable>
            </div>
        </div>
        <maintenance-quotation-form-modal
            :vendor-select-url="vendorSelectUrl"
            :status-quotation-select-url="statusQuotationSelectUrl"
            v-if="showFormModal == true"
            :show-modal="showFormModal"
            @dismiss-modal="onDismissModal"
            @activate-alert="activateAlert"
            :quotation-url="quotationUrl"
        ></maintenance-quotation-form-modal>
    </div>
</template>

<script>
export default {
    props: {
        datatableApiUrl: String,
        vendorSelectUrl: String,
        statusQuotationSelectUrl: String,
        quotationUrl: String,
    },
    data() {
        return {
            showFormModal: false,
            date: 0
        };
    },
    methods: {
        onNewQuotation() {
            this.showFormModal = true;
        },
        activateAlert(bold, normal, color) {
            this.$emit("activate-alert", bold, normal, color);
        },
        onDismissModal(dataChange) {
            this.showFormModal = false;
            if (dataChange){
                this.date = Date.now();
            }
        }
    }
};
</script>

<style></style>
