<template>
    <div class="card shadow mb-4">
        <div
            class="card-header fw-bold text-primary d-flex justify-content-between"
        >
            <span>Quotation</span>
            <button class="btn btn-secondary">
                <i class="fas fa-money-check-alt"></i> New Quotation
            </button>
        </div>
        <div class="card-body">
            <v-server-table
                :url="apiUrl"
                :columns="table.columns"
                :options="table.options"
            >
                <template v-slot:actions="props">
                    <a
                        class="text-decoration-none"
                        :href="route + '/' + props.row.id"
                    >
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                </template>
                <template v-slot:is_approved="props">
                    <span
                        class="badge bg-success text-dark"
                        v-if="props.row.is_approved"
                        >APPROVED VENDOR</span
                    >
                </template>
            </v-server-table>
        </div>
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
        apiUrl: String
    }
};
</script>

<style></style>
