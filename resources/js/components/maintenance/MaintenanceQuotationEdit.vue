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
                ></maintenance-quotation-datatable>
            </div>
        </div>
        <maintenance-quotation-form-modal
            :vendor-select-url="vendorSelectUrl"
            :status-quotation-select-url="statusQuotationSelectUrl"
            v-if="showFormModal == true"
            :show-modal="showFormModal"
            @dismiss-modal="showFormModal = false"
        ></maintenance-quotation-form-modal>
    </div>
</template>

<script>
export default {
    props: {
        datatableApiUrl: String,
        vendorSelectUrl: String,
        statusQuotationSelectUrl: String
    },
    data() {
        return {
            showFormModal: false
        };
    },
    methods: {
        onNewQuotation() {
            this.showFormModal = true;
        }
    }
};
</script>

<style></style>
