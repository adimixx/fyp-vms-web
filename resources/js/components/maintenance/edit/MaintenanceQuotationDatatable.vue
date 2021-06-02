<template>
    <v-server-table
        :url="apiUrl"
        :columns="table.columns"
        :options="table.options"
        ref="maintenanceQuotationDt"
    >
        <template v-slot:actions="props">
            <a class="text-decoration-none" :href="route + '/' + props.row.id">
                <i class="fas fa-pencil-alt"></i>
            </a>
        </template>
        <template v-slot:is_approved="props">
            <span
                :class="`badge bg-${props.row.status_class} text-uppercase`"
                >{{ props.row.status_name }}</span
            >
        </template>
    </v-server-table>
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
        date(val){
            this.refreshTable();
        }
    },
    methods: {
        refreshTable() {
            this.$refs.maintenanceQuotationDt.refresh();
        }
    }
};
</script>

<style></style>
