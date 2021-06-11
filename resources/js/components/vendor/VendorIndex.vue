<template>
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-4">
            <div>
                <h3 class="text-dark mb-0">Vendor Management</h3>
            </div>

            <div class="d-grid gap-2 d-flex justify-content-end">
                <a @click="onCreate" class="text-decoration-none">
                    <button class="btn btn-primary text-white">
                        <i class="fas fa-plus"></i> New Vendor
                    </button>
                </a>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <vendor-datatable
                    :dt-url="dtUrl"
                    @on-edit="onEdit"
                    @on-delete="onDelete"
                    :date="date"
                ></vendor-datatable>
            </div>
        </div>

        <vendor-edit-modal
            v-if="showForm"
            :form-data="formData"
            @on-hide="onHideModal"
            :post-url="postUrl"
            @activate-toast="onActivateToast"
        ></vendor-edit-modal>

        <bs-delete-modal
            :url="deleteUrl"
            v-if="showDeleteModal"
            @dismiss-modal="onDismissDeleteModal"
            @activate-toast="onActivateToast"
        >
            <template v-slot:content>
                <div class="text-center">
                    <p class="mb-0 text-primary fw-bold">
                        {{ deleteData.name }}
                    </p>
                </div>
            </template>
        </bs-delete-modal>
    </div>
</template>

<script>
export default {
    data() {
        return {
            formData: null,
            showForm: false,
            deleteUrl: null,
            date: null,
            showDeleteModal: false,
            deleteData: null
        };
    },
    props: {
        dtUrl: String,
        postUrl: String
    },
    mounted() {
        console.log(this.dtUrl);
    },
    methods: {
        onEdit(data) {
            this.formData = data;
            this.showForm = true;
        },
        onCreate() {
            this.showForm = true;
        },
        onDelete() {
            this.showForm = true;
        },
        onHideModal(updated) {
            this.showForm = false;
            this.formData = null;
            if (updated) {
                this.date = Date.now();
            }
        },
        onActivateToast(boldMsg, msg, classColor) {
            this.$emit("activate-toast", boldMsg, msg, classColor);
        },
        onDelete(data) {
            this.deleteUrl = `${this.postUrl}/${data.id}`;
            this.showDeleteModal = true;
            this.deleteData = data;
        },
        onDismissDeleteModal(dataChange) {
            this.showDeleteModal = false;
            this.deleteData = null;
            if (dataChange) {
                this.date = Date.now();
            }
        }
    }
};
</script>

<style></style>
