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
                columns: ["name", "email", "staff_no", "roles", "actions"],
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
        date: Number
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
        }
    }
};
</script>

<style></style>
