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
                    @edit-quotation="onEditQuotation"
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
            :data="quotationFormData"
        ></maintenance-quotation-form-modal>
    </div>
</template>

<script>
export default {
    props: {
        datatableApiUrl: String,
        vendorSelectUrl: String,
        statusQuotationSelectUrl: String,
        quotationUrl: String
    },
    data() {
        return {
            showFormModal: false,
            quotationFormData: {},
            date: 0
        };
    },
    methods: {
        onNewQuotation() {
            this.showFormModal = true;
            this.quotationFormData = null;
        },
        async onEditQuotation(data) {
            try {
                const url = `${this.quotationUrl}/${data.id}`;
                const res = await axios.get(url);

                this.quotationFormData = {
                    quotation: res.data.id,
                    vendor: res.data.maintenance_vendor.id,
                    date_request: res.data.date_request,
                    status: res.data.status.sequence,
                    date_invoice: res.data.date_invoice,
                    particulars: res.data.maintenance_quotation_item.map(x => ({
                        id: x.id,
                        item: x.item,
                        quantity: x.quantity,
                        price: (x.price / 100).toFixed(2)
                    }))
                };
                this.showFormModal = true;
            } catch (error) {
                console.log(error);
                console.log(error.response);
            }
        },
        activateAlert(bold, normal, color) {
            this.$emit("activate-alert", bold, normal, color);
        },
        onDismissModal(dataChange) {
            this.showFormModal = false;
            if (dataChange) {
                this.date = Date.now();
            }
        }
    }
};
</script>

<style></style>
