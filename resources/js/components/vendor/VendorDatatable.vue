<template>
    <v-server-table
        :url="dtUrl"
        :columns="table.columns"
        :options="table.options"
        ref="userDt"
    >
        <template v-slot:actions="props">
            <a class="text-decoration-none" @click="edit(props.row)">
                <i class="far fa-eye"></i>
            </a>
            <a
                class="text-decoration-none text-danger"
                @click="onDelete(props.row)"
                v-if="userId != props.row.id"
            >
                <i class="fas fa-trash"></i>
            </a>
        </template>
    </v-server-table>
</template>

<script>
export default {
    data() {
        return {
            table: {
                columns: [
                    "name",
                    "pending_quotation",
                    "approved_quotation",
                    "rejected_quotation",
                    "actions"
                ],
                options: {
                }
            }
        };
    },
    props: {
        dtUrl: String,
        date: Number,
        userId: Number
    },
    watch: {
        date(val) {
            this.refreshTable();
        }
    },
    methods: {
        refreshTable() {
            this.$refs.userDt.refresh();
        },
        edit(user) {
            this.$emit("on-edit", user);
        },
        password(user) {
            this.$emit("on-password", user);
        },
        role(user) {
            this.$emit("on-role", user);
        },
        onDelete(user) {
            this.$emit("on-delete", user);
        }
    }
};
</script>

<style></style>
