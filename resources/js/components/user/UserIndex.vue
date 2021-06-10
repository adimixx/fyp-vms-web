<template>
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-4">
            <div>
                <h3 class="text-dark mb-0">User Management</h3>
            </div>

            <div class="d-grid gap-2 d-flex justify-content-end">
                <a @click="onCreateUser" class="text-decoration-none">
                    <button class="btn btn-primary text-white">
                        <i class="fas fa-plus"></i> New User
                    </button>
                </a>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <user-datatable
                    :dt-url="dtUrl"
                    @on-edit="onEditUser"
                    @on-delete="onDelete"
                    :date="date"
                    :userId="userId"
                ></user-datatable>
            </div>
        </div>

        <user-edit-modal
            v-if="showUserForm"
            :user-data="userData"
            @on-hide="onHideModal"
            :roles-list="rolesList"
            :post-url="userPostUrl"
            @activate-toast="onActivateToast"
        ></user-edit-modal>

        <bs-delete-modal
            :url="deleteUrl"
            v-if="showDeleteModal"
            @dismiss-modal="onDismissDeleteModal"
            @activate-toast="onActivateToast"
        >
            <template v-slot:content>
                <div class="text-center">
                    <p class="mb-0 text-secondary">User:</p>
                    <p class="mb-0 text-primary fw-bold">
                        {{ deleteData.name }}
                    </p>
                    <p class="mb-0 text-secondary">
                        Email :
                        <span class= "fw-bold text-primary">
                            {{ deleteData.email }}
                        </span>
                    </p>
                    <p class="mb-0 text-secondary">
                        Staff No :
                        <span class="fw-bold text-primary">
                            {{ deleteData.staff_no }}
                        </span>
                    </p>
                    <p class="mb-0 text-secondary">
                        NRIC :
                        <span class="fw-bold text-primary">
                            {{ deleteData.nric }}
                        </span>
                    </p>
                    <span
                        :class="
                            `badge bg-${deleteData.status.color_class} text-uppercase text-dark`
                        "
                        >{{ deleteData.status.name }}</span
                    >
                </div>
            </template>
        </bs-delete-modal>
    </div>
</template>

<script>
export default {
    data() {
        return {
            userData: null,
            showUserForm: false,
            deleteUrl: null,
            date: null,
            showDeleteModal: false,
            deleteData: null
        };
    },
    props: {
        dtUrl: String,
        rolesList: Array,
        userPostUrl: String,
        userId: Number
    },
    mounted() {
        console.log(this.dtUrl);
    },
    methods: {
        onEditUser(user) {
            this.userData = user;
            this.userData.roles = user.roles.map(x => x.id);
            this.showUserForm = true;
        },
        onCreateUser() {
            this.showUserForm = true;
        },
        onDelete() {
            this.showUserForm = true;
        },
        onHideModal(updated) {
            this.showUserForm = false;
            this.userData = null;
            if (updated) {
                this.date = Date.now();
            }
        },
        onActivateToast(boldMsg, msg, classColor) {
            this.$emit("activate-toast", boldMsg, msg, classColor);
        },
        onDelete(data) {
            this.deleteUrl = `${this.userPostUrl}/${data.id}`;
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
