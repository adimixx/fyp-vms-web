<template>
    <div>
        <v-server-table
            :url="apiUrl"
            :columns="table.columns"
            :options="table.options"
            ref="maintenanceQuotationDt"
        >
            <template v-slot:actions="props">
                <div class="d-flex justify-content-evenly">
                    <a
                        class="text-decoration-none"
                        @click="onEditQuotation(props.row)"
                    >
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a
                        class="text-decoration-none text-danger"
                        @click="onDeleteQuotation(props.row)"
                    >
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </div>
            </template>
            <template v-slot:is_approved="props">
                <span
                    :class="`badge bg-${props.row.status_class} text-uppercase`"
                    >{{ props.row.status_name }}</span
                >
            </template>
            <template v-slot:cost_total="props">
                <span v-if="props.row.cost_total" class="text-center"
                    >RM {{ (props.row.cost_total / 100).toFixed(2) }}</span
                >
                <span v-else> - </span>
            </template>
        </v-server-table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            table: {
                columns: ["vendor", "cost_total", "is_approved", "actions"],
                options: {
                    headings: {
                        vendor: "Vendor Name",
                        cost_total: "Total Cost (RM)",
                        is_approved: "Status"
                    }
                }
            }
        };
    },
    props: {
        route: String,
        apiUrl: String,
        date: Number
    },
    watch: {
        date(val) {
            this.refreshTable();
        }
    },
    methods: {
        refreshTable() {
            this.$refs.maintenanceQuotationDt.refresh();
        },
        onEditQuotation(data) {
            this.$emit("edit-quotation", data);
        },
        onDeleteQuotation(data) {
            this.$emit("delete-quotation", data);
        }
    }
};
</script>

<style></style>
