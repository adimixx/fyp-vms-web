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
    </div>
</template>

<script>
export default {
    data() {
        return {
            userData: null,
            showUserForm: false,
            date: null
        };
    },
    props: {
        dtUrl: String,
        rolesList: Array,
        userPostUrl: String
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
        }
    }
};
</script>

<style></style>
