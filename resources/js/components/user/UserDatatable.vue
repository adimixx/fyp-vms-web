<template>
    <v-server-table
        :url="dtUrl"
        :columns="table.columns"
        :options="table.options"
        ref="userDt"
    >
        <template v-slot:status="props">
            <span
                :class="
                    `badge bg-${props.row.status.color_class} text-dark text-uppercase mx-1`
                "
                >{{ props.row.status.name }}</span
            >
        </template>
        <template v-slot:actions="props">
            <a class="text-decoration-none" @click="edit(props.row)">
                <i class="far fa-eye"></i>
            </a>
            <a
                class="text-decoration-none text-danger"
                @click="onDelete(props.row)"
                v-if="userId != props.row.id"
            >
                <i class="fas fa-user-times"></i>
            </a>
        </template>
        <template v-slot:roles="props">
            <span
                v-for="item in props.row.roles"
                :key="item.name"
                class="badge bg-secondary text-white text-uppercase mx-1"
                >{{ item.name }}</span
            >
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
                    "email",
                    "staff_no",
                    "roles",
                    "status",
                    "actions"
                ],
                options: {
                    headings: {
                        staff_no: "Staff No"
                    }
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
